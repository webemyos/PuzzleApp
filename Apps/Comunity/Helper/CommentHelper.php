<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Helper;

use Apps\Comunity\Entity\ComunityComment;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;


class CommentHelper
{
    /*
     * Ajoute un commentaire sur une entité d'n app
     */
    public static function AddCommentApp($core, $appName, $entityName, $entityId, $message, $name, $email)
    {
        $comment = new ComunityComment($core);
        $comment->UserId->Value = $core->User->IdEntite;
        $comment->AppName = $appName;
        $comment->EntityName->Value = $entityName;
        $comment->EntityId->Value = $entityId;
        $comment->Message->Value = $message;
        $comment->DateCreated->Value = Date::Now();
        $comment->UserName->Value = $name;
        $comment->Email->Value = $email;
        
        $comment->Save();
    }
    
    /*
     * Obtient les commentaire sur une app
     */
    function GetByApp($core, $appName, $entityName, $entityId, $actif = null)
    {
        $comments = new ComunityComment($core);
        $comments->AddArgument(new Argument("ComunityComment", "AppName", EQUAL, $appName));
        $comments->AddArgument(new Argument("ComunityComment", "EntityName", EQUAL, $entityName));
        $comments->AddArgument(new Argument("ComunityComment", "EntityId", EQUAL, $entityId));
        
        if($actif != null)
        {
            $comments->AddArgument(new Argument("ComunityComment", "Actif", EQUAL, $actif));
        }
        
        return $comments->GetByArg();
    }
    
    /**
     * Publie/ Depuplie un commentaire
     */
    public static function Publish($core, $commentId, $state)
    {
        $comment = new ComunityComment($core);
        $comment->GetById($commentId);
        $comment->Actif->Value = $state;
        $comment->Save();
    }
}
