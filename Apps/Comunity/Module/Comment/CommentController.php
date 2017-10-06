<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Comment;

use Apps\Comunity\Helper\CommentHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\TextArea\TextArea;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;
use const BUTTON;

class CommentContrller extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core)
    {
        $this->Core = $core;
    }
    
    function Init(){}
    
    function Show(){}
    
    /**
     * Charge les commentaires et la possibilité d'en ajouter
     * @param type $app
     * @param type $entityName
     * @param type $entityId
     * @return string
     */
    function Load($app, $entityName, $entityId, $showAddBlock)
    {
        //App pour recuperer les profils
        $eprofil = DashBoardManager::GetAppFront("Profil");
          
        $html .= "<div><div id='dvComment'>";
        $html .= "<h2>".$this->Core->GetCode("Comunity.Commentaires")."</h2>";
        if($showAddBlock)
        {
            $html .= $this->GetAddBlock($app, $entityName, $entityId, $eprofil);
        }
        $html .= $this->GetComment($app, $entityName, $entityId, $eprofil)."</div></div>";
            
        return $html;
    }
    
    /**
     * Module d'ajout
     * Mode connecté ou non
     */
    function GetAddBlock($app, $entityName, $entityId, $eprofil)
    {
        $block = new Block("jbComment");
        $block->CssClass = "comment";
        $block->Table = false;
        $block->Frame = false;
        
        //Sauvagarde ajax
        $action = new AjaxAction("Comunity", "AddCommentApp");
        $action->AddArgument("App", "Comunity");
        $action->AddArgument("AppName", $app);
        $action->AddArgument("EntityName", $entityName);
        $action->AddArgument("EntityId", $entityId);
       
        $action->ChangedControl = "dvComment";
        
        if(Request::IsConnected($this->Core))
        {
              //Affichage de l'iconde de l'utilisateur connecté
            $block->AddNew(new Libelle($eprofil->GetProfil($this->Core->User)));
        }
        else
        {
            //Nom
            $tbName = new BsTextBox("tbName");
            $tbName->Title = $this->Core->GetCode("Name");
            $block->AddNew($tbName);
            
            //Email
            $tbEmail = new BsEmailBox("tbEmail");
            $tbEmail->Title = $this->Core->GetCode("Email");
            $block->AddNew($tbEmail);
            
            $action->AddControl($tbName->Id);
            $action->AddControl($tbEmail->Id);
        }
        
        //Champ commentaire
        $tbCommentaire = new TextArea("tbComment");
        $tbCommentaire->AddStyle("width","100%");
        $block->AddNew($tbCommentaire);
        $action->AddControl($tbCommentaire->Id);
        
        //Bouton de sauvegarde
        $btnSave = new Button(BUTTON);
        $btnSave->Value = $this->Core->GetCode("Send");
        $btnSave->CssClass = "btn btn-primary";
        $btnSave->OnClick = $action;
        
        $block->AddNew($btnSave);
        
        return $block->Show();
            
    }
    
    /**
     * Recuperation des commentaires
     */
    function GetComment($app, $entityName, $entityId,$eprofil)
    {
        $comments = CommentHelper::GetByApp($this->Core, $app, $entityName, $entityId, 1);
        
        if(count($comments) > 0)
        {
            $html = "";
             
            foreach($comments as $comment)
            {
                $html .= "<div class='comment'>";
                
                if($comment->UserId->Value == "0" || $comment->UserId->Value =="")
                {
                    $html .= "<span class='user'>".$this->Core->GetCode("Name")." : ".$comment->UserName->Value."</span>";
                    $html .= "<p>".$comment->Message->Value."</p>";
                }
                else
                {
                    $html .= "<span class='user'>".$eprofil->GetProfil($comment->User->Value)."</span>";
                    $html .= "<p>".$comment->Message->Value."</p>";
                }
                
                $html .= "</div>";
            }
            
            return $html;
        }
        else
        {
            return $this->Core->GetCode("Comunity.NoComment");
        }
    }
}
