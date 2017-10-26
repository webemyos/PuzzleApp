<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Message\Helper;

use Apps\Message\Entity\MessageMessage;
use Apps\Message\Entity\MessageUser;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use Core\Dashboard\DashBoardManager;

class MessageHelper
{
    /**
     * Envoi un message à un ou plusieurs destinataire
     * @param type $core
     * @param type $objet
     * @param type $message
     * @param type $usersId
     */
    public static function Send($core, $objet, $text, $usersId, $appName, $entityName, $entityId)
    {
        $message = new MessageMessage($core);
        $message->UserId->Value = $core->User->IdEntite;
        $message->Subjet->Value = $objet;
        $message->Message->Value = $text;
        $message->DateCreated->Value = Date::Now();
        
        $message->AppName->Value = $appName;
        $message->EntityName->Value = $entityName;
        $message->EntityId->Value = $entityId;
        
        $message->Save();
        
        $messageId = $core->Db->GetInsertedId();
        
        //Enregistrements des destinataires
        $userId = explode(";", $usersId);
        
        //Recuperation de l'app Notify
        $eNotify = DashBoardManager::GetApp("Notify", $core);
        
        foreach($userId as $user)
        {
            $messageUser = new MessageUser($core);
            $messageUser->MessageId->Value = $messageId;
            $messageUser->UserId->Value = $user;
            $messageUser->Read->Value = 0;
            $messageUser->Save();
            
            //Envoi d'une notification
            $subjet = $core->GetCode("Message.MessageSendedObjet"). " : ";  
            $message = $core->GetCode("Message.MessageSendedMessage"). " : ". $text;
            
            $eNotify->AddNotify($core->User->IdEntite, "Message.NotifyUserSendYouMessage", $user,  "Message", $messageId, $subjet, $message);
        }
    }
    
    /**
     * Envoi un message à un ou plusieurs destinataire depuis une app
     * @param type $core
     * @param type $objet
     * @param type $message
     * @param type $usersId
     */
    public static function SendByApp($core, $objet, $text, $usersId,  $appName, $entityName, $entityId, $code)
    {
        $message = new MessageMessage($core);
        $message->UserId->Value = $core->User->IdEntite;
        $message->Subjet->Value = $objet;
        $message->Message->Value = $text;
        $message->AppName->Value = $appName;
        $message->EntityName->Value = $entityName;
        $message->EntityId->Value = $entityId;
        
        $message->DateCreated->Value = Date::Now();
        $message->Save();
        
       $messageId = $core->Db->GetInsertedId();
        
        //Recuperation de l'app Notify
        $eNotify = DashBoardManager::GetApp("Notify", $core);
      
        
        foreach($usersId as $user)
        {
            $messageUser = new MessageUser($core);
            $messageUser->MessageId->Value = $messageId;
            $messageUser->UserId->Value = $user;
            $messageUser->Read->Value = 0;
            $messageUser->Save();
            
            //Envoi d'une notification
            $subjet = $core->GetCode("Message.MessageSendedObjet"). " : " . $core->User->GetPseudo();  
            $message = $core->GetCode("Message.MessageSendedMessage"). " : ". $text;
            
            $eNotify->AddNotify($core->User->IdEntite, $code, $user,  $appName, $messageId, $subjet, $message);
        }
    }
    
    /**
     * Obtient les message recu de l'utilisateur
     */
    static function GetInMessage($core, $appName = "", $limit ="" , $all = true )
    {
        $message = new MessageUser($core);
        $message->AddArgument(new Argument("Apps\Message\Entity\MessageUser", "UserId", EQUAL, $core->User->IdEntite ));
        $message->AddOrder("Id");
                
        if($limit != "")
        {
            $message->SetLimit(1, $limit);
        }
       
       if($all == false)
        {
            $message->AddArgument(new Argument("Apps\Message\Entity\MessageUser", "MessageUser.Read", ISNULL, 1 ));
        }
            
        if($appName != "")
        {
            $messageApp = array();
            
            foreach($message->GetByArg() as $message)
            {
                if($message->Message->Value->AppName->Value == $appName)
                {
                   $messageApp[] =  $message;
                }
            }
            
            return $messageApp;
        }
        else
        {
            return $message->GetByArg();
        }
    }
    
    /**
     * Obtient les trois derniers message de mla boite de reception
     */
    public static function GetLastReceived($core)
    {
        return self::GetInMessage($core, "", 3);
    }
    
    /**
     * Obtient le nombre de message recut
     * @param type $core
     */
    static function GetNumberInBox($core, $all = true)
    {
        return count(MessageHelper::GetInMessage($core, "", "",$all));
    }
    
     /**
     * Obtient les message envoyé par l'utilisateur
     */
    static function GetOutMessage($core)
    {
        $message = new MessageMessage($core);
        $message->AddArgument(new Argument("Apps\Message\Entity\MessageMessage", "UserId", EQUAL, $core->User->IdEntite ));
        $message->AddOrder("Id");
        
        return $message->GetByArg();
    }
    
    /**
     * Obtient le nombre de message envoyé
     * @param type $core
     */
    static function GetNumberOutBox($core)
    {
       return count(MessageHelper::GetOutMessage($core));
    }
    
    /**
     * Obtient les destinataires d'un message
     * @param type $core
     * @param type $message
     */
    function GetDestinataire($core, $message)
    {
        $messageUser = new MessageUser($core);
        $messageUser->AddArgument(new Argument("Apps\Message\Entity\MessageUser", "MessageId", EQUAL, $message->IdEntite));

        return $messageUser->GetByArg();
    }
    
    /**
     * Recupere les destinataire
     */
    function GetConcatDestinataire($core, $message)
    {
        $users = self::GetDestinataire($core, $message);
        $name = array();
        
        foreach($users as $user)
        {
            $name[] = $user->User->Value->GetPseudo();
        }
        
        return implode(";", $name);
    }
    
    
    /**
     * Définie si l'utilisateur a des message non lu
     * @param type $core
     */
    function HaveMessageNotRead($core)
    {
        $messageUser = new MessageUser($core);
        $messageUser->AddArgument(new Argument("Apps\Message\Entity\MessageUser", "UserId", EQUAL, 1));
        $messageUser->AddArgument(new Argument("Apps\Message\Entity\MessageUser", "Read", NOTEQUAL, 1));
        
        return (count($messageUser->GetByArg()) > 0);
    }
    
    /**
     * Marque le message comme lu
     * @param type $messageId
     */
    function SetRead($core, $messageId)
    {
        $messageUser = new MessageUser($core);
        $messageUser->GetById($messageId);
        $messageUser->Read->Value = 1;
        $messageUser->Save();
    }
    
    /**
     * Envoi une réponse à un message
     */
    public static function AddReponse($core, $messageId, $reponse)
    {
        //Recuperation du message parent
        $messageParent = new MessageMessage($core);
        $messageParent->GetById($messageId);
        
        //TODO
        $reponseMessage = new MessageMessage($core);
        $reponseMessage->ParentId->Value = $messageId;
        $reponseMessage->UserId->Value = $core->User->IdEntite;
        $reponseMessage->Subjet->Value = "Re : ".$messageParent->Subjet->Value;
        
        $reponseMessage->Message->Value = $reponse;
        $reponseMessage->AppName->Value = $messageParent->AppName->Value;
        $reponseMessage->EntityName->Value = $messageParent->EntityName->Value;
        $reponseMessage->EntityId->Value = $messageParent->EntityId->Value;
        
        $reponseMessage->DateCreated->Value = Date::Now();
        $reponseMessage->Save();
        
        //Recuperation de l'id
        $newMessageId = $core->Db->GetInsertedId();
        
        //Envoi au destinataire
        $messageUser = new MessageUser($core);
        $messageUser->MessageId->Value = $newMessageId;
        $messageUser->UserId->Value = $messageParent->UserId->Value;
        $messageUser->Read->Value = 0;
        $messageUser->Save();

        //Recuperation de l'app Notify
        $eNotify = DashBoardManager::GetApp("Notify", $core);
        
        //Envoi d'une notification
        $subjet = $core->GetCode("Message.MessageReponseSendedObjet"). " : " . $core->User->GetPseudo();  
        $message = $core->GetCode("Message.MessageReponseSendedMessage"). " : ". $reponse;

        $eNotify->AddNotify($core->User->IdEntite, "Message.NotifyUserSendYouReponse", $messageParent->UserId->Value,  $messageParent->AppName->Value, $newMessageId, $subjet, $message);

    }
    
        
    /**
     * Retourne les message d'une application
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $message = new MessageMessage($core);
        $message->AddArgument(new Argument("Apps\Message\Entity\MessageMessage", "AppName" ,EQUAL, $appName));
        $message->AddArgument(new Argument("Apps\Message\Entity\MessageMessage", "EntityName" ,EQUAL, $entityName));
        $message->AddArgument(new Argument("Apps\Message\Entity\MessageMessage", "EntityId" ,EQUAL, $entityId));
        
        return $message->GetByArg();
    }
}
