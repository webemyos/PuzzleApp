<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Module\ListUser;

use Apps\Communique\Entity\CommuniqueListContact;
use Apps\Communique\Entity\CommuniqueListMember;
use Apps\Communique\Helper\ListHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\EmailBox\EmailBox;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ShareIcone;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;

 class ListUserController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
          $this->Core = $core;
    }

    /**
     * Creation
     */
    function Create()
    {
    }

    /**
     * Initialisation
     */
    function Init()
    {
    }

    /**
     * Obtient les liste de l'utilisateur
     */
    function GetListUser()
    {
        $html = "<div class='content-panel'>";

        //Bouton de création de liste
        $btnNewList = new Button(BUTTON);
        $btnNewList->CssClass = "btn btn-info";
        $btnNewList->Value = $this->Core->GetCode("Communique.NewList"); 
        $btnNewList->OnClick = "CommuniqueAction.ShowAddList()";

        $html .= $btnNewList->Show();

        $list = new CommuniqueListContact($this->Core); 
        $list->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueListContact", "UserId", EQUAL, $this->Core->User->IdEntite));
        $lists = $list->GetByArg();

        if(count($lists)> 0)
        {

            //Ligne D'entete
            $html .= "<div class='list titleBlue'>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Name")."</b></div>";
            $html .= "</div>"; 

            $i=0;

            foreach($lists as $list)
            {
              $html .= "<div class='communique'>";

              //Lien pour afficher le détail
              $lkDetail = new EditIcone($this->Core);
              $lkDetail->Tiltle = $this->Core->GetCode("Edit");
              $lkDetail->OnClick ="CommuniqueAction.LoadList(".$list->IdEntite.", this)";

              $html .= "<div class='name'> ".$list->Name->Value ."</div>";
              $html .= "<div> ".ListHelper::GetNumberMember($this->Core, $list->IdEntite)."</div>";
              $html .= "<div> ".$lkDetail->Show() ."</div>";

              //Syncronisation de tous les utilisateurs
              // pour la newletters
                  //Lien pour afficher le détail
            $lkSync = new ShareIcone($this->Core);
            $lkSync->Tiltle = $this->Core->GetCode("Syncrhonise");
            $lkSync->OnClick ="CommuniqueAction.Synchronise(".$list->IdEntite.", this)";
            $html .= "<div> ".$lkSync->Show() ."</div>";
          $html .= "</div>";
            }
        }
        else
        {
            $html .= "<br/>".$this->Core->GetCode("Communique.NoList");
        }

        $html .= "</div>";
        return $html;
    }

    /**
     * Pop in d'ajotu de liste de contact
     */
    function ShowAddList()
    {
        $jbList = new AjaxFormBlock($this->Core, "jbList");
        $jbList->App = "Communique";
        $jbList->Action = "SaveList";

        $jbList->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbNameList", "Libelle" => $this->Core->GetCode("Name")),
                                      array("Type"=>"Button", "CssClass"=>"btn btn-success" ,"Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                          )
                );

        return $jbList->Show();
    }

    /**
     * Charge les memebres d'un liste
     */
    function LoadList($listId)
    {
        $html ="<div id='lstMember'>";

        //Module d'ajout de membre rapide
        $html .= $this->GetAddMemberBlock($listId);
        $html .= $this->GetMembers($listId);

        $html .= "</div>"; 
        return $html;
    }

    /**
     * Module d'ajout de membre rapide
     */
    function GetAddMemberBlock($listId)
    {
        $jbMember = new Block("jbMember");

        //nom
        $tbNameMember = new TextBox("tbNameMember");
        $tbNameMember->PlaceHolder = $this->Core->GetCode("Name");
        $jbMember->Add($tbNameMember);

        //Prenom
        $tbFirstNameMember = new TextBox("tbFirstNameMember");
        $tbFirstNameMember->PlaceHolder = $this->Core->GetCode("FirstName");
        $jbMember->Add($tbFirstNameMember);

        //Prenom
        $tbEmailMember = new EmailBox("tbEmailMember");
        $tbEmailMember->PlaceHolder = $this->Core->GetCode("Email");
        $jbMember->Add($tbEmailMember);

        //Hommme ?
        $cbSexe = new CheckBox('cbSexe');
        $cbSexe->Libelle = $this->Core->GetCode("Man");
        $cbSexe->Value = 1;
        $jbMember->Add($cbSexe);

        //Action
        $action = new AjaxAction("Communique", "AddMember");
        $action->AddArgument("App", "Communique");
        $action->AddArgument("ListId", $listId);
        $action->ChangedControl = "lstMember";

        $action->AddControl($tbNameMember->Id);
        $action->AddControl($tbFirstNameMember->Id);
        $action->AddControl($tbEmailMember->Id);
        $action->AddControl($cbSexe->Id);

                      //Bouton de sauvegarde
        $btnAddMember = new Button(BUTTON);
        $btnAddMember->CssClass = "btn btn-success";
        $btnAddMember->Value = $this->Core->GetCode("Communique.AddMember");
        $btnAddMember->OnClick = $action;
        $jbMember->Add($btnAddMember);

        return $jbMember->Show();
    }

    /**
     * Obtient les memebres de lal liste
     * @param type $listId
     */
    function GetMembers($listId)
    {
        $member = new CommuniqueListMember($this->Core);
        $member->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueListMember", "ListId", EQUAL, $listId));

        $members = $member->GetByArg();

        if(count($members)> 0)
        {
            //Ligne D'entete
            $html .= "<div class='communique titleBlue'>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Name")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.FirstName")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Email")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Actif")."</b></div>";

            $html .= "</div>"; 

            $i=0;
            foreach($members as $member)
            {
               if($i==1)
               {
                   $i=0;
                   $class='lineClair';
               }
               else
               {
                   $i=1;
                   $class='lineFonce';
               }

               $html .= "<div class='communique $class'>";


               $html .= "<div >".$member->Name->Value."</div>";
               $html .= "<div>".$member->FirstName->Value."</div>";
               $html .= "<div>".$member->Email->Value."</div>";
             $html .= "<div>".$member->Actif->Value."</div>";

               //Lien pour supprimer le détail
               $deleteIcone = new DeleteIcone();
               $deleteIcone->Title = $this->Core->GetCode("Delete");
               $deleteIcone->OnClick = "CommuniqueAction.DeleteMember(this, ".$member->IdEntite.")";

               $html .= "<div> ".$deleteIcone->Show() ."</div>";
               $html .= "</div>";
            }
        }
        else
        {
            $html .= "<br/>".$this->Core->GetCode("Communique.NoMember");
        }

        return $html;
    }
          
 }?>