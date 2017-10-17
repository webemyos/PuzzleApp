<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Helper;

use Apps\Forum\Entity\ForumForum;
use Core\Entity\Entity\Argument;


class ForumHelper
{
    /**
     * Crée un nouveau forum
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $name, $description, $appName, $entityName, $entityId)
    {
        if(!self::Exist($core, $name))
        {
            $forum = new ForumForum($core);
            $forum->UserId->Value = $core->User->IdEntite;
            $forum->Name->Value = $name;
            $forum->Description->Value = $description;
            $forum->Actif->Value = "0";
            $forum->Style->Value = 1;

            $forum->AppName->Value = $appName;
            $forum->EntityName->Value = $entityName;
            $forum->EntityId->Value = $entityId;
            
            $forum->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
     /**
     * Verifie si un forum existe avec le meme non
     */
    public static function Exist($core, $name)
    {
        $forum = new ForumForum($core);
        $forum->AddArgument(new Argument("ForumForum", "Name", EQUAL, $name));
        $forums = $forum->GetByArg();
        
        return (count($forums) > 0) ;
    }
    
    /**
     * Met a jour le forum
     */
    public function Update($core, $forumId, $name, $description)
    {
         if(!self::Exist($core, $name))
        {
            $forum = new ForumForum($core);
            $forum->GetById($forumId);
            
            $forum->Name->Value = $name;
            $forum->Description->Value = $description;
 //           $forum->Actif->Value = "0";
   //         $forum->Style->Value = 1;

            $forum->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
     * Get All Forum
     * 
     */
    public static function GetAll($core)
    {
        $forums = new ForumForum($core);
        return $forums->GetAll();
    }
}