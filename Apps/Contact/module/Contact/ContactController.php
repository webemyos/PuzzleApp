<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Module\Contact;

use Apps\Agenda\Entity\ContactContact;
use Apps\Contact\Helper\ContactHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;
use Core\View\View;
use Core\Control\Icone\EditIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Control\Text\Text;
use Core\Control\TextBox\TextBox;


 class ContactController extends Controller
 {
    /**
     * Constructeur
     */
    function _construct($core="")
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
     * Affichage du module
     */
    function Show($all=true)
    {
    }

    /*
     * Charge l'écran de recherche
     */
     function LoadSearch()
     {
         //Selection du template
         $this->SetTemplate(__DIR__ . "/View/LoadSearch.tpl");

         //Barre de recheche
         $tbSearch = new TextBox("tbSearch");
         $tbSearch->PlaceHolder = $this->Core->GetCode("Contact.EnterNameEmail");
         $tbSearch->AddStyle ("width", "400px;");

         //recherche
         $btnSearch = new Button(BUTTON); 
         $btnSearch->Value = $this->Core->GetCode("Contact.Search");
         $btnSearch->OnClick = "ContactAction.Search()";

         //Competences utilisateur
         $eprofil = DashBoardManager::GetApp("Profil", $this->Core);

         $tbTypeSearch = new TabStrip("tbTypeSearch", "Contact");
         $tbTypeSearch->AddTab($this->Core->GetCode("Contact.SearchByCompetence"), new Libelle($eprofil->GetCompetence()));
         $tbTypeSearch->AddTab($this->Core->GetCode("Contact.SearchByName"), $tbSearch);

         //Ajout de parametres 
         $this->AddParameters(array('!titleSearch' => $this->Core->GetCode('Contact.titleSearch'),
                                    '!lbInformation' => $this->Core->GetCode('Contact.EnterNameFirstNameEmail'),
                                    '!tbTypeSearch' => $tbTypeSearch->Show(),
                                    '!btnSearch' => $btnSearch->Show()
                 ));

         return $this->Render();
     }

     /**
      * Recherche et affiches les contacts correspondants
      */
     function Search()
     {
         $html = "";

         $contacts = ContactHelper::Search($this->Core, Request::GetPost("tbSearch"), Request::GetPost("competenceId"));

         if($contacts != null)
         {
             //Recuperation de Profil 
             $Profil =  DashBoardManager::GetApp("Profil", $this->Core);

             foreach($contacts as $contact)
             {
                  //Ajout de case a coché pour selectioné le profil
                  $cbSelect = new CheckBox("cb");
                  $cbSelect->Name = $contact->IdEntite;

                  $view = new View(__DIR__ . "/View/DetailContact.tpl", $this->Core);
                  $view->AddElement($contact);
                  $view->AddElement(new Text("profil",false, $Profil->GetProfil($contact, true, true)));
                  $view->AddElement(new Text("cbSelect", false, $cbSelect->Show() ));

                  $html .= $view->Render();
              }

             //Btn d'envoi d'invitation
             $btnSendInvitation = new Button(BUTTON);
             $btnSendInvitation->Value = $this->Core->GetCode("Contact.SendInvitation");
             $btnSendInvitation->OnClick = "ContactAction.ShowSendInvitation()"; 

             $html.= "<div>".$btnSendInvitation->Show()."</div>";

             return $html;
         }
         else
         {
             return "<span class='error'>".$this->Core->GetCode("Contact.NoResult")."</span>";
         }
     }

    /*
    * Charge tous les contacts du membre
    */
    function Load()
    {
        $view = new View(__DIR__ . "/View/Load.tpl", $this->Core);

         //Icon de recherche
        $btnAdd = new Button(BUTTON, "btnAdd");
        $btnAdd->Value = $this->Core->GetCode("Contact.AddContact");
        $btnAdd->OnClick = "ContactAction.ShowAddAction()";
        $view->AddElement($btnAdd);

        //TODO utiliser le foreach des templates
        $view->AddElement(new Text('lstContact', false, $this->GetContact()));

        return $view->Render();
      }

     /**
      * Pop in d'ajout de contact
      */
     function ShowAddContact($contactId)
     {
         $jbContact = new Block($this->Core, "jbContact");
         $jbContact->CssClass = "content-panel";
         $jbContact->Table = true;
         $jbContact->Frame = false;

         //Ajout des champs du contact
         $contact = new ContactContact($this->Core);

         if($contactId != "")
         {
            $contact->GetById($contactId); 
         }    
         $jbContact->AddNew($contact->Name);
         $jbContact->Add($contact->FirstName);
         $jbContact->AddNew($contact->Email);
         $jbContact->AddNew($contact->Phone);
         $jbContact->Add($contact->Mobile);
         $jbContact->AddNew($contact->Adresse, 2);

         //Envoit d'invitation
         $cbInvitation = new CheckBox("cbInvit");
         $cbInvitation->Libelle = "Contact.SendInvitation";
         $cbInvitation->Checked = true;
         $jbContact->AddNew($cbInvitation);

         //Sauvegarde
         $action = new AjaxAction("Contact", "SaveContact");
         $action->AddArgument("App", "Contact");

         //Ajout des controls
         $action->ChangedControl = "jbContact";
         $action->AddArgument("IdContact", $contactId);

         $action->AddControl($contact->Name->Control->Id);
         $action->AddControl($contact->FirstName->Control->Id);
         $action->AddControl($contact->Email->Control->Id);
         $action->AddControl($contact->Phone->Control->Id);
         $action->AddControl($contact->Mobile->Control->Id);
         $action->AddControl($contact->Adresse->Control->Id);
         $action->AddControl($cbInvitation->Id);

         //Bouton d'enregistrement
         $btnSave = new Button(BUTTON);
         $btnSave->Value = "Contact.SaveContact";
         $btnSave->OnClick = $action;

         $jbContact->AddNew($btnSave, 4, ALIGNRIGHT);

         return $jbContact->Show();
     }

     /**
      * Récupére les contacts de l'utilisateur
      */
     function GetContact()
     {
         $html = "";
         $contacts = ContactHelper::GetByUser($this->Core, $this->Core->User->IdEntite);

         if(count($contacts) > 0)
         {
             $Profil = DashBoardManager::GetApp("Profil", $this->Core);


             foreach($contacts as $contact)
             {

                 $html .= "<tr class='userContact'>";

                 if($contact->ContactId->Value != "" && $contact->ContactId->Value != 0 )
                 {
                     $html .= "<td>".$Profil->GetProfil($contact->Contact->Value). "</td>";
                     $html .= "<td>".$contact->Contact->Value->FirstName->Value."</td>";
                     $html .= "<td>".$contact->Contact->Value->Name->Value."</td>";
                     $html .= "<td></td>";

                 }
                 else
                 {
                     $html .= "<td></td>";
                     $html .= "<td>".$contact->FirstName->Value."</td>";
                     $html .= "<td class='name'>".$contact->Name->Value."</td>";

                     //Icone d'edition
                     $icEdite = new EditIcone($this->Core);
                     $icEdite->Title =  $this->Core->GetCode("Edit");
                     $icEdite->OnClick = "ContactAction.EditContact(".$contact->IdEntite.")";

                      $html .= "<td>".$icEdite->Show()."</td>";
                 }

                 $html .= "</tr>";
             }
             return $html;
         }
         else
         {
             return $this->Core->GetCode("Contact.NoContact");
         }
     }
}?>