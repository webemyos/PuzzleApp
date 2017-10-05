<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Helper;

use Apps\Forum\Entity\ForumMessage;
use Apps\Forum\Entity\ForumReponse;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;


class MessageHelper
{
    
    /**
     * Obtient tous les messages d'une categories
     * @param type $core
     * @param type $categoryId
     */
    public static function GetByCategory($core, $categoryId)
    {
        $messages = new ForumMessage($core);
        $messages->AddArgument(new Argument("ForumMessage", "CategoryId",EQUAL, $categoryId ));
        $messages->AddOrder("Id");
        
        return $messages->GetByArg();
    }
    
    /**
     * Enregistre une discussion
     * @param type $core
     * @param type $title
     * @param type $message
     */
    public static function Save($core, $categoryId, $title, $text)
    {
        $message = new ForumMessage($core);
        $message->Title->Value = $title;
        $message->Message->Value = $text;
        $message->UserId->Value = $core->User->IdEntite;
        $message->CategoryId->Value = $categoryId;
        $message->DateCreated->Value = Date::Now();
        
        $message->Save();
    }
    
     /**
     * Enregistre une réponse
     * @param type $core
     * @param type $title
     * @param type $message
     */
    public static function SaveReponse($core, $sujetId, $title, $text)
    {
        $message = new ForumReponse($core);
        $message->Message->Value = $text;
        $message->UserId->Value = $core->User->IdEntite;
        $message->MessageId->Value = $sujetId;
        $message->DateCreated->Value = Date::Now();
        
        $message->Save();
    }
    
    /**
     * Obtient le nombre de reponse d'un message
     */
    public static function GetNumberReponse($core, $messageId)
    {
        return count(self::GetReponse($core, $messageId));
    }
    
    /**
     * Obtient les réponses d'un message
     * @param type $core
     * @param type $messageId
     */
    public static function GetReponse($core, $messageId)
    {
        $reponses = new ForumReponse($core);
        $reponses->AddArgument(new Argument("ForumReponse", "MessageId", EQUAL, $messageId ));
        
        $reponses->AddOrder("Id");
        
        return $reponses->GetByArg();
    }
    
    /**
     * Obtient le dernier message de ma catégorie
     * @param type $core
     * @param type $categoryId
     */
    public static function GetLastMessage($core, $categoryId)
    {
        $message = new ForumMessage($core);
        $message->AddArgument(new Argument("ForumMessage", "CategoryId", EQUAL, $categoryId));
        $message->AddOrder("Id");
        
        $messages = $message->GetByArg();
        
        if(count($messages) > 0)
        {
            return $messages[0];
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Obtient la derniere réponse d'un message
     * @param type $core
     * @param type $messageId
     */
    public static function GetLastReponse($core, $messageId)
    {
        $reponse = new ForumReponse($core);
        $reponse->AddArgument(new Argument("ForumReponse", "MessageId", EQUAL, $messageId));
    
        $reponse->AddOrder("Id");
        
        $reponses = $reponse->GetByArg();
        
        if(count($reponses) > 0)
        {
            return $reponses[0];
        }
        else
        {
            return null;
        }
    }
}


