<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Comment;

use Apps\Blog\Helper\CommentHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\TextArea\TextArea;
use Core\Controller\Controller;

class CommentController extends Controller
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
    function Load($articleId, $showAddBlock)
    {
        //App pour recuperer les profils
        $eprofil = Dashboard::GetAppFront("EeProfil");
          
        $html .= "<div><div id='dvComment'>";
        $html .= "<h2>".$this->Core->GetCode("EeComunity.Commentaires")."</h2>";
        if($showAddBlock)
        {
            $html .= $this->GetAddBlock($articleId, $eprofil);
        }
        $html .= $this->GetComment($articleId, $eprofil)."</div></div>";
            
        return $html;
    }
    
    /**
     * Module d'ajout
     * Mode connecté ou non
     */
    function GetAddBlock($articleId, $eprofil)
    {
        $block = new JBlock("jbComment");
        $block->CssClass = "comment";
        $block->Table = false;
        $block->Frame = false;
        
        //Sauvagarde ajax
        $action = new AjaxAction("EeBlog", "AddComment");
        $action->AddArgument("App", "EeBlog");
        $action->AddArgument("ArticleId", $articleId);
       
        $action->ChangedControl = "dvComment";
        
        if(JVar::IsConnected($this->Core))
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
    function GetComment($articleId,$eprofil)
    {
        $comments = CommentHelper::GetByArticle($this->Core, $articleId, 1);
        
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
            return $this->Core->GetCode("EeComunity.NoComment");
        }
    }
}
