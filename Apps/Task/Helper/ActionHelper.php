<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Helper;

use Apps\Task\Entity\TaskAction;
use Core\Entity\Entity\Argument;

class ActionHelper
{
    
    /**
     * Sauvegarde les actions d'un taches
     * @param type $core
     * @param type $taskId
     * @param type $actions
     */
    public static function SaveActions($core, $taskId, $actions)
    {
        //Supprimme les actions avant de les recréer
        self::DeleteActions($core, $taskId);
        
        if($actions != "")
        {
            $actions = explode("!", $actions);
            
            foreach($actions as $action)
            {
                $data = explode(":", $action);
                
                $taskAction = new TaskAction($core);
                $taskAction->TaskId->Value = $taskId; 
                $taskAction->Libelle->Value = $data[1];
                $taskAction->Realised->Value = $data[0];
                
                $taskAction->Save();
            }
        }
    }
    
    /**
     * Supprime toutes les actions d'une tache
     * @param type $core
     * @param type $taskId
     */
    public static function DeleteActions($core, $taskId)
    {
        $action = new TaskAction($core);
        $action->AddArgument(new Argument("TaskAction", "TaskId", EQUAL, $taskId));
        
        $actions = $action->GetByArg();
        
        if(count($actions) > 0 )
        {
            foreach($actions as $action)
            {
                $action->Delete();
            }
        }
    }
    
    /**
     * Retourne les actions d'un taches
     * @param type $core
     * @param type $taskId
     */
    public static function GetByTask($core, $taskId)
    {
        $action = new TaskAction($core);
        $action->AddArgument(new Argument("TaskAction", "TaskId", EQUAL, $taskId ));
        
        return $action->GetByArg();
    }
    
    /*
     * Obtient le nombre d'action réalisé et total
    */
    public static function GetCountAction($core, $taskId)
    {
            $actions = self::GetByTask($core, $taskId);
            
            if(count($actions) > 0)
            {
                $realised =0;
                
                foreach($actions as $action)
                {
                    if($action->Realised->Value == 1)
                    {
                        $realised++;
                    }
                }
                
                return "(".$realised."/".count($actions).")";
            }
            else
            {
                return "(0)";
            }
    }
    
}


