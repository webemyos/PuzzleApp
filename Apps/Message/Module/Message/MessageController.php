<?php
/**
 * Module de gestion des messages
 * */
 class MessageBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function MessageBlock($core="")
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
              $modele = new JModele(EeMessage::$Directory . "/Blocks/MessageBlock/View/ShowSendMessage.tpl", $this->Core); 
       
              $jbMessage = new JBlock($this->Core, "jbMessage");
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
                $tbContact->PlaceHolder = "'".$this->Core->GetCode("EeMessage.SearchUser")."'";
                $tbContact->Entity = "User";
                $tbContact->Methode = "SearchUser";
                $tbContact->Parameter = "AddAction=EeMessageAction.SelectUser()";
                $jbMessage->AddNew($tbContact);
                
                //Utilisateur selectionné
                $dvUser = new Libelle("<div id='dvUser'></div>");
                $jbMessage->AddNew($dvUser);
              }
              
              //objet
              $tbObjet = new TextBox("tbObjet");
              $tbObjet->PlaceHolder = $this->Core->GetCode("EeMessage.Objet");
              $jbMessage->AddNew($tbObjet);
              
              //Message
              $tbMessage = new TextArea("tbTextMessage");
              $tbMessage->PlaceHolder = "'".$this->Core->GetCode("EeMessage.YouMessage")."'";
              $jbMessage->AddNew($tbMessage);
              
              //Bouton d'envoi
              $btnSend = new Button(BUTTON);
              $btnSend->Value = $this->Core->GetCode("EeMessage.Send");
              $btnSend->OnClick = "EeMessageAction.Send('".$AppName."', '".$EntityName."', '".$EntityId."')";
              $jbMessage->AddNew($btnSend, 2, ALIGNCENTER);
              
              $modele->AddElement($jbMessage);
              
              return $modele->Render();
          }
          
          /**
           * Charge le boite de reception
           */
          function LoadInBox($appName)
          {
               $modele = new JModele(EeMessage::$Directory . "/Blocks/MessageBlock/View/LoadInBox.tpl", $this->Core); 
       
                //Recuperation 
                $messages = MessageHelper::GetInMessage($this->Core, $appName);
                
                if(count($messages) > 0)
                {
                    $modele->AddElement($messages);
                }
                else
                {
                    $modele->AddElement(array());
                }
                return $modele->Render();
         }
          
          /**
           * Charge les mesage envoyés
           * @return string
           */
          function LoadOutBox()
          {
                $modele = new JModele(EeMessage::$Directory . "/Blocks/MessageBlock/View/LoadOutBox.tpl", $this->Core); 
       
                //Recuperation 
                $messages = MessageHelper::GetOutMessage($this->Core);
                
                if(count($messages) > 0)
                {
                    $modele->AddElement($messages);
                }
                else
                {
                    $modele->AddElement(array());
                }
                return $modele->Render();
          }
          
          /**
           * Affiche le detail d'un message
           * @param type $messageId
           */
          function ShowDetail($messageId)
          {
              $modele = new JModele(EeMessage::$Directory . "/Blocks/MessageBlock/View/ShowDetail.tpl", $this->Core); 
              
              $message = new EeMessageUser($this->Core);
              $message->GetById($messageId);
              $modele->AddElement($message);
              
              //Bouton d'ajout
              $btnReponse = new Button(BUTTON, "btnReponse");
              $btnReponse->Value = $this->Core->GetCode("EeMessage.AddReponse");
              $btnReponse->OnClick = "EeMessageAction.ShowAddReponse()";
              $modele->AddElement($btnReponse);
             
              $tbReponse = new TextArea("tbReponse");
              $tbReponse->PlaceHolder = "'".$this->Core->GetCode("EeMessage.YourReponse")."'";
              $modele->AddElement($tbReponse);
             
              //Sauvegarde
              $action = new AjaxAction("EeMessage", "AddReponse");
              $action->AddArgument("App", "EeMessage");
              $action->AddArgument("MessageParentId", $message->MessageId->Value);
              
              $action->ChangedControl = "dvReponse";
              $action->AddControl($tbReponse->Id);
              
              $btnSend = new Button(BUTTON, "btnSend");
              $btnSend->Value = $this->Core->GetCode("EeMessage.Reponse");
              $btnSend->OnClick = $action;
              $modele->AddElement($btnSend);
             
              return $modele->Render();
          }
          
          /**
           * Affiche le message envoyé
           */
          function ShowDetailSend($messageId)
          {
              $modele = new JModele(EeMessage::$Directory . "/Blocks/MessageBlock/View/ShowDetailSend.tpl", $this->Core); 
              
              $message = new EeMessageMessage($this->Core);
              $message->GetById($messageId);
              
              $modele->AddElement($message);
              
              return $modele->Render();
          }
          
 }?>