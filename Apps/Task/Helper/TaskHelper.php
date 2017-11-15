<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Helper;

use Apps\Task\Entity\TaskTask;
use Core\Entity\Entity\Argument;


class TaskHelper
{
    
    /**
     * Récupère les tâches parentes d'un groupe
     * @param type $core
     * @param type $groupId
     */
    public static function GetByGroup($core, $groupId)
    {
        $tasks = new TaskTask($core);
        $tasks->AddArgument(new Argument("Apps\Task\Entity\TaskTask","GroupId",  EQUAL, $groupId));
        
        return $tasks->GetByArg();
    }
    
     /**
     * Récupère les sous tâches d'une taches
     * @param type $core
     * @param type $groupId
     */
    public static function GetByTask($core, $taskId)
    {
        $tasks = new TaskTask($core);
        $tasks->AddArgument(new Argument("Apps\Task\Entity\TaskTask","ParentId",  EQUAL, $taskId));
        
        return $tasks->GetByArg();
    }
    
    /**
     * Sauvegarde les tâches
     * 
     * @param type $core
     * @param type $title
     * @param type $dateStart
     * @param type $dateEnd
     * @param type $description
     * @param type $groupId
     */
    public static function SaveTask($core, $title, $dateStart, $dateEnd, $description, $groupId, $taskId, $parentId, $subTaskId, $stateId)
    {
          $task = new TaskTask($core);
          
          if($taskId != "")
          {
            $task->GetById($taskId);  
          }
          if ($subTaskId != "")
          {
             $task->GetById($subTaskId);  
          }
          
          $task->UserId->Value = $core->User->IdEntite;
          
          $task->Title->Value = $title;
          $task->DateStart->Value = $dateStart;
          $task->DateEnd->Value = $dateEnd;
          $task->StateId->Value = $stateId;
          
          $task->Description->Value = $description;
          
          if($parentId != "")
          {
              $task->ParentId->Value = $parentId;
          }
          else
          {
            $task->GroupId->Value = $groupId;
          }
          
          $task->Save("", true);
    }
    
    /**
     * Supprime une tache
     * @param type $core
     * @param type $taskId
     */
    public static function DeleteTask($core, $taskId)
    {
        //Supprimme les actions
        $request = "DELETE FROM TaskAction WHERE TaskId = ".$taskId;
        $request .= " OR TaskId in (SELECT Id FROM TaskTask WHERE Id = $taskId )";
        
        $core->Db->Execute($request);
        
        //Suppression des taches fille
        $request = "DELETE FROM TaskTask WHERE ParentId = ".$taskId;
        $core->Db->Execute($request);
        
        //Suppression de la tâche
        $task = new TaskTask($core); 
        $task->GetById($taskId);  
        $task->Delete();
    }
    
}
?>
