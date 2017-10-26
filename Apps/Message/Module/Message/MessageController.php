<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Message\Module\Message;

use Apps\Message\Entity\MessageMessage;
use Apps\Message\Entity\MessageUser;
use Apps\Message\Helper\MessageHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\TextArea\TextArea;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\View\View;

 class MessageController extends Controller
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

    /**
     * Popin d'envoi de message
     */
    function ShowSendMessage($AppName, $EntityName, $EntityId, $userId)
    {
        $view = new View(__DIR__. "/View/ShowSendMessage.tpl", $this->Core); 

        $jbMessage = new Block($this->Core, "jbMessage");
        $jbMessage->Frame = false;
        $jbMessage->Table = true;

        if($userId != "")
        {
         $contact = new User($this->Core);
         $contact->GetById($userId);

          //Utilisateur selectionné
          $dvUser = new Libelle("<div id='dvUser'>
        <span id='$userId' class='userSelected'>
          ".$contact->GetPseudo()."
          </span>

          </div>");
           $jbMessage->AddNew($dvUser);
          }
        else
        {
          //Recherche d'utilisateur
          $tbContact = new AutoCompleteBox("tbContact", $this->Core);
          $tbContact->PlaceHolder = $this->Core->GetCode("Message.SearchUser");
          $tbContact->Entity = "User";
          $tbContact->Methode = "SearchUser";
          $tbContact->Parameter = "AddAction=MessageAction.SelectUser()";
          $jbMessage->AddNew($tbContact);

          //Utilisateur selectionné
          $dvUser = new Libelle("<div id='dvUser'></div>");
          $jbMessage->AddNew($dvUser);
        }

        //objet
        $tbObjet = new TextBox("tbObjet");
        $tbObjet->PlaceHolder = $this->Core->GetCode("Message.Objet");
        $jbMessage->AddNew($tbObjet);

        //Message
        $tbMessage = new TextArea("tbTextMessage");
        $tbMessage->PlaceHolder = $this->Core->GetCode("Message.YouMessage");
        $jbMessage->AddNew($tbMessage);

        //Bouton d'envoi
        $btnSend = new Button(BUTTON);
        $btnSend->Value = $this->Core->GetCode("Message.Send");
        $btnSend->CssClass ="btn btn-success" ;
        $btnSend->OnClick = "MessageAction.Send('".$AppName."', '".$EntityName."', '".$EntityId."')";
        $jbMessage->AddNew($btnSend, 2, ALIGNCENTER);

        $view->AddElement($jbMessage);

        return $view->Render();
    }

    /**
     * Charge le boite de reception
     */
    function LoadInBox($appName)
    {
        $view = new View(__DIR__. "/View/LoadInBox.tpl", $this->Core); 

         //Recuperation 
         $messages = MessageHelper::GetInMessage($this->Core, $appName);

         if(count($messages) > 0)
         {
             $view->AddElement($messages);
         }
         else
         {
             $view->AddElement(array());
         }
         return $view->Render();
   }

    /**
     * Charge les mesage envoyés
     * @return string
     */
    function LoadOutBox()
    {
        $view = new View(__DIR__. "/View/LoadOutBox.tpl", $this->Core); 

        //Recuperation 
        $messages = MessageHelper::GetOutMessage($this->Core);

        if(count($messages) > 0)
        {
            $view->AddElement($messages);
        }
        else
        {
            $view->AddElement(array());
        }
        return $view->Render();
    }

    /**
     * Affiche le detail d'un message
     * @param type $messageId
     */
    function ShowDetail($messageId)
    {
        $view = new View(__DIR__ . "/View/ShowDetail.tpl", $this->Core); 

        $message = new MessageUser($this->Core);
        $message->GetById($messageId);
        $view->AddElement($message);

        //Bouton d'ajout
        $btnReponse = new Button(BUTTON, "btnReponse");
        $btnReponse->CssClass = "btn btn-info";
        $btnReponse->Value = $this->Core->GetCode("Message.AddReponse");
        $btnReponse->OnClick = "MessageAction.ShowAddReponse()";
        $view->AddElement($btnReponse);

        $tbReponse = new TextArea("tbReponse");
        $tbReponse->PlaceHolder = "'".$this->Core->GetCode("Message.YourReponse")."'";
        $view->AddElement($tbReponse);

        //Sauvegarde
        $action = new AjaxAction("Message", "AddReponse");
        $action->AddArgument("App", "Message");
        $action->AddArgument("MessageParentId", $message->MessageId->Value);

        $action->ChangedControl = "dvReponse";
        $action->AddControl($tbReponse->Id);

        $btnSend = new Button(BUTTON, "btnSend");
        $btnSend->Value = $this->Core->GetCode("Message.Reponse");
        $btnSend->CssClass = "btn btn-success";
        $btnSend->OnClick = $action;
        $view->AddElement($btnSend);

        return $view->Render();
    }

    /**
     * Affiche le message envoyé
     */
    function ShowDetailSend($messageId)
    {
        $view = new View(__DIR__. "/View/ShowDetailSend.tpl", $this->Core); 

        $message = new MessageMessage($this->Core);
        $message->GetById($messageId);

        $view->AddElement($message);

        return $view->Render();
    }
          
 }?>