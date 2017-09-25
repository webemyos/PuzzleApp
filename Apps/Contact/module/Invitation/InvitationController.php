<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Module\Invitation;

use Apps\Contact\Helper\InvitationHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Control\TextArea\TextArea;
use Core\Control\TextBox\TextBox;


 class InvitationController extends Controller
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
     * Affichage du module
     */
    function Show($all=true)
    {
    }

  /*
  * Popin d'envoi d'invitation
  */
   function ShowSend($user)
  {
      $this->SetTemplate(__DIR__ . "/View/ShowSend.tpl");

      //
      $jbInvitation = new Block($this->Core, "jbInvitation");
      $jbInvitation->Frame = false;

      //Sujet
      $tbSubjet = new TextBox("tbSubjet");
      $tbSubjet->Value = $this->Core->GetCode("Contact.SubjetInvitation");
      $jbInvitation->Add($tbSubjet);

      //Message
      $tbMessage = new TextArea("tbMessage");
      $tbMessage->Value = $this->Core->GetCode("Contact.MessageInvitation");
      $jbInvitation->AddNew($tbMessage);

      //Action
      $action = new AjaxAction("Contact", "SendInvitation");
      $action->AddArgument("App", "Contact");
      $action->AddArgument("User", $user);

     //Ajout des controls
      $action->ChangedControl = "jbInvitation";
      $action->AddControl($tbSubjet->Id);
      $action->AddControl($tbMessage->Id);

      //Bouton d'envoi
      $btnSend = new Button(BUTTON);
      $btnSend->Value = $this->Core->GetCode("Send");
      $btnSend->OnClick = $action;

      $jbInvitation->AddNew($btnSend);

      $this->AddParameters(array('!titleInformation' => $this->Core->GetCode("Contact.Invitation"),
                                 '!jbInformation'  =>  $jbInvitation->Show(),
              ));

      return $this->Render();
  }

  /*
  * Charges les invitations
  */
   function Load($type)
  {
      $this->SetTemplate(__DIR__ . "/View/Load.tpl");

      if($type == 1)
      {
          $invitations = InvitationHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
      }
      else
      {
          $invitations = InvitationHelper::GetByUser($this->Core, "", $this->Core->User->IdEntite);
      }

      $lstInvitation = "";

      if(count($invitations) > 0)
      {
          $eeProfil = DashBoardManager::GetApp("Profil", $this->Core);
          $eeNotify = DashBoardManager::GetApp("Notify", $this->Core);

          foreach($invitations as $invitation)
          {
             $lstInvitation .= $this->LoadInvitation($type, $invitation, $eeProfil, $eeNotify);
          }
      }
      else
      {
          $lstInvitation = $this->Core->GetCode("Contact.NoInvitation");
      }

      $this->AddParameters(array('!lstInvitation' => $lstInvitation ));

      return $this->Render();
  }

  /**
   * Charge une inviation avec les
   * @param type $invitationId
   */
  public function LoadInvitation($type, $invitation, $eeProfil, $eeNotify, $showAll = true)
  {
      if($showAll)
      {
       $html = "<div class='invitation' id='dvInvit".$invitation->IdEntite."' >";
      }
      else
      {
          $html = "";

      }
      if($type == 1)
      {
          $html .= $eeProfil->GetProfil($invitation->Contact->Value);
          $html .=  $this->Core->GetCode("Contact.InvitationSended");

          //Affichage des notifications
          $notifys = $eeNotify->GetNotifyApp("Contact", $invitation->IdEntite);
          $i=0;

          if(count($notifys) > 0)
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

              foreach($notifys as $notify)
              {
                  $html .= "<div class='notify $class'>";
                  $html .= "<span class='date'>".$notify->DateCreate->Value."</span>";
                  $html .= "<span class='message'> ".$notify->Code->Value."</span>";
                  $html .= "</div>";
              }
          }
           //Bouton de relance 
          $btnRelance = new Button(BUTTON);
          $btnRelance->Value = $this->Core->GetCode("Contact.RelanceInvitation");
          $btnRelance->OnClick = "ContactAction.RelanceInvitation(".$invitation->IdEntite.")";
          $html .= "<div style='width:100%;text-align:center;'>".$btnRelance->Show()."</div>";
      }
      else
      {   
          $html .= $eeProfil->GetProfil($invitation->User->Value);
          $html .=  $this->Core->GetCode("Contact.InvitationSended");

          // Acceptation
          $btnAccept = new Button(BUTTON);
          $btnAccept->Value = $this->Core->GetCode("Contact.AcceptInvitation");
          $btnAccept->OnClick = "ContactAction.AcceptInvitation(".$invitation->IdEntite.", this)";
          $html .= "<span>".$btnAccept->Show()."</span>";

           // Acceptation
          $btnRefuse = new Button(BUTTON);
          $btnRefuse->CssClass = "btn btn-danger";
          $btnRefuse->Value = $this->Core->GetCode("Contact.RefuseInvitation");
          $btnRefuse->OnClick = "ContactAction.RefuseInvitation(".$invitation->IdEntite.", this)";
          $html .= "<span>".$btnRefuse->Show()."</span>";
      }

       $html .= $showAll?"</div>":"";

       return $html;
  }
}?>