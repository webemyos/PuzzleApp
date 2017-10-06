<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Helper;

class MessageHelper
{
    /**
     * Publit un message
     * @param type $core
     * @param type $message
     * @param type $comunityId
     */
    public static function Publish($core, $text, $comunityId)
    {
        $message = new ComunityMessage($core);
        $message->UserId->Value = $core->User->IdEntite;
        $message->ComunityId->Value = $comunityId;
        $message->Type->Value = ComunityMessage::TEXT;
        $message->Message->Value = $text;
        $message->DateCreated->Value = Date::Now();
        $message->Save();
        
        return $core->Db->GetInsertedId();
    }
    
    /**
     * Modifie un message
     * @param type $core
     * @param type $messageId
     * @param type $text
     */
    public static function UpdateMessage($core, $messageId, $text)
    {
        $message = new ComunityMessage($core);
        $message->GetById($messageId);
        $message->Message->Value = $text;
        $message->Save();        
    }
    
    /**
     * Supprime un message
     * @param type $core
     * @param type $messageId
     */
    public static function RemoveMessage($core, $messageId)
    {
        //TODO Supprime les commentaires 
        
        //Supprile le message
        $message = new ComunityMessage($core);
        $message->GetById($messageId);
        $message->Delete();
    }
    
    /**
     * Obtient les messages des communauté de l'utilisateur
     */
    public static function GetByUser($core)
    {
        $message = new ComunityMessage($core);
        $message->AddArgument(new Argument("ComunityMessage", "ComunityId", IN, ComunityHelper::GetRequestByUser($core)));
        
        $message->AddOrder("Id");
        $message->SetLimit(1, 3);
          
        return $message->GetByArg();
    }
    
    /**
     * Ajoute un commentaire à un message
     * @param type $core
     * @param type $messageId
     * @param type $comment
     */
    public static function AddComment($core, $messageId, $text)
    {
        $comment = new ComunityComment($core);
        $comment->MessageId->Value = $messageId;
        $comment->Message->Value = $text;
        $comment->UserId->Value = $core->User->IdEntite;
        $comment->TypeId->Value = 1;
        $comment->DateCreated->Value = Date::Now(); 
        
        $comment->Save();
        
        return $core->Db->GetInsertedId();
    }
    
    /**
     * Met a jour un commentaire
     */
    public static function UpdateComment($core, $commentId, $text)
    {
        $comment = new ComunityComment($core);
        $comment->GetById($commentId);
        $comment->Message->Value = $text;
        $comment->Save();
    }
    
    /**
     * Supprime un commentaire
     */
    public static function RemoveComment($core, $commentId)
    {
        $comment = new ComunityComment($core);
        $comment->GetById($commentId);
        
        $comment->Delete();
    }
}
