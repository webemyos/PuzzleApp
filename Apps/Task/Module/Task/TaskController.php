<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Module\Task;

use Apps\Task\Entity\TaskTask;
use Apps\Task\Helper\ActionHelper;
use Apps\Task\Helper\TaskHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\AddIcone;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ListIcone;
use Core\Control\Icone\ShareIcone;
use Core\Controller\Controller;


class TaskController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core="")
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
    {}

     /**
     * Pop uin d'ajout de taches
     */
    function ShowAddTask($GroupId, $taskId, $parentId, $subTaskId)
    {
        $jbTask = new AjaxFormBlock($this->Core, "jbTask");
        $jbTask->App = "Task";
        $jbTask->Action = "SaveTask";

        //Ajout du group
        $jbTask->AddArgument("GroupId", $GroupId);
        $jbTask->AddArgument("ParentId", $parentId);

        if($taskId != "")
        {
           $task = new TaskTask($this->Core); 
           $task->GetById($taskId);

           $jbTask->AddArgument("TaskId", $taskId);
        }

        if($subTaskId != "")
        {
           $task = new TaskTask($this->Core); 
           $task->GetById($subTaskId);

           $jbTask->AddArgument("SubTaskId", $subTaskId);
        }

        $jbTask->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbTitle", "Libelle" => $this->Core->GetCode("Title") , "Value" => ($taskId != "" || $subTaskId != "" )?$task->Title->Value :""),
                                      array("Type"=>"EntityListBox", "Entity"=> "TaskState" ,"Field"=>"Libelle",  "Name"=> "lstState", "Libelle" => $this->Core->GetCode("State") , "Value" => ($taskId != "" || $subTaskId != "" )?$task->StateId->Value :""),

                                      array("Type"=>"DateBox", "Name"=> "tbDateStart", "Libelle" => $this->Core->GetCode("DateStart") , "Value" => ($taskId != "" || $subTaskId != "")?$task->DateStart->Value :""),
                                      array("Type"=>"DateBox", "Name"=> "tbDateEnd", "Libelle" => $this->Core->GetCode("DateEnd") , "Value" => ($taskId != "" || $subTaskId != "")?$task->DateEnd->Value :""),
                                      array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => ($taskId != "" || $subTaskId != "")?$task->Description->Value :""),
                                      array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                          )
                );

        return $jbTask->Show();
    }

    /**
     * Charge les groupe de tâches de l'utilisateur
     */
    function LoadTask($GroupId, $appName="")
    {
        $tasks = TaskHelper::GetByGroup($this->Core, $GroupId);

        $html ="";

        //Bouton D'ajout de taches parentes
        $btnAddTask = new Button(BUTTON);
        $btnAddTask->Value = $this->Core->GetCode("Task.AddTask");
        $btnAddTask->OnClick = "TaskAction.ShowAddTask(".$GroupId.", '', '".$appName."')";

        $html .= $btnAddTask->Show();

        if(count($tasks) > 0)
        {
            //Ligne D'entete
            $html .= "<div class='task titleBlue'>";
            $html .= "<div ><b>".$this->Core->GetCode("Title")."</b></div>";
            $html .= "<div ><b>".$this->Core->GetCode("Description")."</b></div>";
            $html .= "<div ><b>".$this->Core->GetCode("DateStart")."</b></div>";
            $html .= "<div ><b>".$this->Core->GetCode("DateEnd")."</b></div>";

            $html .= "</div>"; 

            $i=0;
            foreach($tasks as $task)
            {

               switch($task->StateId->Value)
               {
                  case TaskTask::NOUVELLE :
                          $class = "nouvelle"; 
                      break;
                   case TaskTask::EN_COURS :
                          $class = "enCours";
                      break;
                   case TaskTask::A_VERIFIER :
                          $class = "verif";
                      break;
                   case TaskTask::TERMINE :
                          $class = "termine";
                      break;
               }

               $html .= "<div class='task ".$class."'>";


               $html .= "<div class='name'>".$task->Title->Value."</div>";
               $html .= "<div >".substr( $task->Description->Value, 0, 30 ) ."</div>";
               $html .= "<div class='date'>".$task->DateStart->Value."</div>";
               $html .= "<div class='date'>".$task->DateEnd->Value."</div>";

               //Icone d'action
               $editIcon = new EditIcone();
               $editIcon->Title = $this->Core->GetCode("Edit");
               $editIcon->OnClick = "TaskAction.ShowAddTask(".$GroupId.", ".$task->IdEntite.", '".$appName."')";
               $html .= "<div >".$editIcon->Show();

               // Icone d'ajout de sous tache 
               $expandIcon = new AddIcone();
               $expandIcon->Title = $this->Core->GetCode("Task.NewTask");
               $expandIcon->OnClick = "TaskAction.ShowAddSubTask(".$task->IdEntite.", '','".$appName."')";
               $html .= $expandIcon->Show();

               //Suppression
               $deleteIcon = new DeleteIcone();
               $deleteIcon->Title = $this->Core->GetCode("Delete");
               $deleteIcon->OnClick = "TaskAction.DeleteTask(this, ".$task->IdEntite.", 1,  '".$appName."')";
               $html .= "<span >".$deleteIcon->Show()."</div>";

               //liste des sous taches
               $html .= "<div id='dvSubTask_$task->IdEntite'>";

               $html .= $this->LoadSubTask($task->IdEntite, $appName);

               $html .= "</div>";

               $html .= "</div>";
            }
        }
        else
        {
            $html .= "<div>".$this->Core->GetCode("Task.NoTask")."</div>";
        }

        return $html;
    }

    /**
     * Charge les sous tâches
     */
    function LoadSubTask($taskId, $appName)
    {
        $htmlSub = "";

         $subtasks = TaskHelper::GetByTask($this->Core, $taskId);

        if( count($subtasks) >= 1 )
        {
            //Ligne D'entete
            foreach($subtasks as $subtask)
            {
               switch($subtask->StateId->Value)
               {
                  case TaskTask::NOUVELLE :
                          $class = "nouvelle"; 
                      break;
                   case TaskTask::EN_COURS :
                          $class = "enCours";
                      break;
                   case TaskTask::A_VERIFIER :
                          $class = "verif";
                      break;
                   case TaskTask::TERMINE :
                          $class = "termine";
                      break;
               }

               $htmlSub .= "<div class='subTask $class'>";


               $htmlSub .= "<span >".$subtask->Title->Value."</span>";
               $htmlSub .= "<span >".substr( $subtask->Description->Value, 0, 30 ) ."</span>";
               $htmlSub .= "<span class='date'>".$subtask->DateStart->Value."</span>";
               $htmlSub .= "<span class='date'>".$subtask->DateEnd->Value."</span>";

               //Icone d'action
               $editIcon = new ShareIcone();
               $editIcon->Title = $this->Core->GetCode("Edit");
               $editIcon->OnClick = "TaskAction.ShowAddSubTask(".$subtask->ParentId->Value.",". $subtask->IdEntite.", '".$appName."')";
               $htmlSub .= "<span >".$editIcon->Show()."</span>";

               //Icone d'action
               $listIcon = new ListIcone();
               $listIcon->Title = $this->Core->GetCode("TaskAction.ListAction");
               $listIcon->OnClick = "TaskAction.ShowListAction($subtask->IdEntite)";
               $htmlSub .= "<span >".$listIcon->Show() ;
               $htmlSub .= "<span id='spCount_$subtask->IdEntite'>". ActionHelper::GetCountAction($this->Core, $subtask->IdEntite)."</span>";      

              $htmlSub .= "</span>";

               //Suppression
               $deleteIcon = new DeleteIcone();
               $deleteIcon->Title = $this->Core->GetCode("Delete");
               $deleteIcon->OnClick = "TaskAction.DeleteTask(this, ".$subtask->IdEntite.", 0, '".$appName."')";
               $htmlSub .= "<span >".$deleteIcon->Show()."</span>";

               $htmlSub .= "</div>";
            }


            return $htmlSub;
        }
        else
        {
            return $htmlSub;
        }
    }
}

?>
