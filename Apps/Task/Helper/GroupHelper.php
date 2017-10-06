<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Helper;

use Apps\Task\Entity\TaskGroup;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use  Apps\Task\Helper\TaskHelper;



class GroupHelper
{
    /**
     * Sauvegarde un groupe de tache
     * @param type $core
     * @param type $title
     * @param type $description
     */
    public static function SaveGroupe($core, $title, $description, $groupId, $appName, $entityName, $entityId)
    {
        $group = new TaskGroup($core);
        
        if($groupId != "")
        {
           $group->GetById($groupId);
        }
        
        $group->UserId->Value = $core->User->IdEntite;
        $group->Title->Value = $title;
        $group->Description->Value = $description;
        $group->Actif->Value = 1;
        $group->DateCreated->Value = Date::Now();
        
        $group->AppName->Value = $appName;
        $group->EntityName->Value = $entityName;
        $group->EntityId->Value = $entityId;
                
        $group->Save();
    }
    
    /**
     * Obtient les groupe sde taches de l'utilisateur
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId)
    {
         $group = new TaskGroup($core);
         $group->AddArgument(new Argument("TaskGroup", "UserId", EQUAL, $userId));
         
         $group->AddOrder("Id");
                 
         return $group->GetByArg();
    }
    
    /**
     * Supprime un groupe
     */
    public static function DeleteGroup($core, $groupId)
    {
        //Supprilme les taches associées
        $tasks = TaskHelper::GetByGroup($core, $groupId);
        
        foreach($tasks as $task)
        {
            TaskHelper::DeleteTask($core, $task->IdEntite);
        }
        
        $group = new TaskGroup($core);
        $group->GetById($groupId);
        
        $group->Delete();
    }
    
    /**
     * Obtient les groupe de tache par App
     */
    public static function GetGroupByApp($core, $appName, $entityName, $entityId)
    {
        $group = new TaskGroup($core);
        
        $group->AddArgument(new Argument("TaskGroup","AppName", EQUAL, $appName));
        $group->AddArgument(new Argument("TaskGroup","EntityName", EQUAL, $entityName));
        $group->AddArgument(new Argument("TaskGroup","EntityId", EQUAL, $entityId));
        
        return $group->GetByArg();
    }
    
    /*
     * Met à jour un groupe de tache
     */
    public static function Update($core, $id, $property, $value)
    {
          $group = new TaskGroup($core);
          $group->GetById($id);
          $group->$property->Value = $value;
          $group->Save();
    }
    
            
}


?>
