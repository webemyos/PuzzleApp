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
        $forum->AddArgument(new Argument("Apps\Forum\Entity\ForumForum", "Name", EQUAL, $name));
        $forums = $forum->GetByArg();
        
        return (count($forums) > 0) ;
    }
    
    /**
     * Met a jour le forum
     */
    public static function Update($core, $forumId, $name, $description, $default)
    {
        if($forumId != "" || ($forumId =="" && !self::Exist($core, $name)))
        {
            $forum = new ForumForum($core);
           
            if($default == 1)
            {
                $forum->Update(array("Default"=>0));
            }

            $forum->GetById($forumId);
            
            $forum->Name->Value = $name;
            $forum->Description->Value = $description;
            $forum->Default->Value = $default;
 
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
    
    /*
     * Get The First Forum by user
     */
    public static function GetFirst($core)
    {
        $forum = new ForumForum($core);
        $forums = $forum->GetAll();
          
        return $forums[0];
    }
}