<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact;

class EeContact extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/EeContact";

    /**
     * Constructeur
     * */
     function __construct($core)
     {
        parent::__construct($core, "EeContact");
        $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
        $textControl = parent::Run($this->Core, "EeContact", "EeContact");
        echo $textControl;
     }

    /**
     * Ecran de recherche de contact
     */
    public function LoadSearchContact()
    {
       $contactController = new ContactController($this->Core);
       echo $contactController->LoadSearch();
    }

    /**
     * Recherche des contact
     */
    public function Search()
    {
        $contactController = new ContactController($this->Core);
        echo $contactController->Search();
    }

    /**
     * Pop in d'envoi d'invitation
     */
    public function ShowSendInvitation()
    {
        $invitationController = new InvitationController($this->Core);
        echo $invitationController->ShowSend(Request::GetPost("Users"));
    }

    /**
     * Envoie des invitations
     */
    public function SendInvitation()
    {
        if(InvitationHelper::Send($this->Core, Request::GetPost("tbSubjet"), Request::GetPost("tbMessage"), explode(";",Request::GetPost("User"))))
        {
            echo "<span class='success'>".$this->Core->GetCode("EeContact.InvitationSended")."</span>";
        }
    }

    /**
     * Chagre les invitation
     */
    public function LoadInvitation()
    {
        $invitationController = new InvitationController($this->Core);
        echo $invitationController->Load(Request::GetPost("type"));
    }

    /**
     * relance une invitation
     */
    public function RelanceInvitation()
    {
        $invitationId = Request::GetPost("invitationId");

         //Récupere de l'inviation et des notifications
        $eeProfil = DashBoardManager::GetApp("EeProfil", $this->Core);
        $eeNotify = DashBoardManager::GetApp("EeNotify", $this->Core);

        //Relance
        InvitationHelper::Relance($this->Core, $invitationId, $eeNotify);

        $invitation = new EeContactContact($this->Core);
        $invitation->GetById($invitationId);

        $invitationController = new InvitationController($this->Core);
        echo $invitationController->LoadInvitation(1, $invitation, $eeProfil, $eeNotify, false );
    }

    /**
     * Charge les contact de l'utilisateur
     */
    public function LoadContact()
    {
       $contactController = new ContactController($this->Core);
       echo $contactController->Load();
    }

    /***
     * Pop In d'ajout de contact
     */
    function ShowAddContact()
    {
        $contactController = new ContactController($this->Core);
        echo $contactController->ShowAddContact(Request::GetPost("IdContact"));
     }

     /**
      * Enregistre le contact
      */
     function SaveContact()
     {
         $name = Request::GetPost("Name");
         $firstName = Request::GetPost("FirstName");

         if($name != "" && $firstName != "")
         {
            ContactHelper::Save($this->Core, 
                                $name,
                                $firstName,
                                Request::GetPost("Email"),
                                Request::GetPost("Phone"),
                                Request::GetPost("Mobile"),
                                Request::GetPost("Adresse"),
                                Request::GetPost("IdContact")
                    );

            //Envoi un email d'invitation a découvrir Webemyos
            //TODO faire le lien lorsque la personne s'inscirt
            if(Request::GetPost("Email") != "" && Request::GetPost("cbInvit") == true &&  Request::GetPost("IdContact") == "")
            {
                InvitationHelper::SendEmailInvitation($this->Core, Request::GetPost("Email"));
            }

            echo "<span class='success'>".$this->Core->GetCode("EeContact.UserSaved")."</span>";

         }
         else
         {
             echo "<span class='error'>".$this->Core->GetCode("EeContact.ErrorUser")."</span>";

             $this->ShowAddContact();
         }
     }

     /**
      * Accepte l'invitation
      */
     function AcceptInvitation()
     {
         InvitationHelper::Accept($this->Core, Request::GetPost("invitationId"));
     }

      /**
      * refuse l'invitation
      */
     function RefuseInvitation()
     {
         InvitationHelper::Refuse($this->Core, Request::GetPost("invitationId"));
     }

     /**
      * retourne le nombre d'invitation recu et émise
      */
     function  GetNumberInvitation()
     {
         $html = $this->Core->GetCode("EeContact.Invitation") . " (".InvitationHelper::GetNumber($this->Core, 0).")";
         $html .= ":".$this->Core->GetCode("EeContact.MyInvitation") . " (".InvitationHelper::GetNumber($this->Core, 1).")";
         echo $html;
     }
}
?>