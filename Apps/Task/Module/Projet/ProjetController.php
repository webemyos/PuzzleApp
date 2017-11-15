<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Module\Projet;

use Apps\Task\Entity\TaskAction;
use Apps\Task\Entity\TaskGroup;
use Apps\Task\Entity\TaskTask;
use Apps\Task\Helper\TaskHelper;
use Core\Control\Button\Button;
use Core\Control\Icone\AddIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ListIcone;
use Core\Control\Libelle\Libelle;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\View\View;

class ProjetController extends Controller
{
    /* Constructeur
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

     function OpenProjet($projetId)
     {
         $view = new View(__DIR__ . "/View/Projet.tpl", $this->Core);

         //Recuperation du projet
         $projet = new TaskGroup($this->Core);
         $projet->GetById($projetId);
         $view->AddElement($projet);

         //Ajout de taches parents
         $view->AddElement(new Libelle($this->GetParent($projet), "parentTask"));

         $btnAddParentTask = new Button(BUTTON, "btnAddParent");
         $btnAddParentTask->Value = $this->Core->GetCode("Task.AddLot");
         $btnAddParentTask->CssClass = "btn btn-info";
         $btnAddParentTask->OnClick = "TaskAction.ShowAddTask(".$projetId.", '', '', 'TaskAction.RefreshParent(".$projetId.")')";

         $view->AddElement($btnAddParentTask);

         return  $view->Render();
     }

     /*
      * Obtient les taches parentes
      */
     function GetParent($projet)
     {
         $projetId = $projet->IdEntite;

         //Recuperation des taches meres
         $tasks = TaskHelper::GetByGroup($this->Core, $projet->IdEntite);

         $html = "<ul>";

         foreach($tasks as $task)
         {
             $editIcone = new EditIcone($this->Core);
             $editIcone->OnClick = "TaskAction.ShowAddTask(".$projetId.", ".$task->IdEntite.", '', 'TaskAction.RefreshParent(".$projetId.")')";

             $html.= "<li><a href='#' onclick='TaskAction.LoadSubTaskTask(".$task->IdEntite.")'>".$task->Title->Value."</a>".$editIcone->Show()."</li>";
         }

         $html .= "</ul>";

         return $html;
     }

     /*
      * Charges les sous taches d'un lot
      */
     function LoadSubTaskTask ($taskId)
     {
         $tasks = TaskHelper::GetByTask($this->Core, $taskId);

         //Bouton d'ajout 
         $btnAddTask = new Button(BUTTON);
         $btnAddTask->Value = $this->Core->GetCode("Task.AddTask");
         $btnAddTask->CssClass = "btn btn-info";
         $btnAddTask->OnClick = "TaskAction.ShowAddSubTask(".$taskId.", '','', 'TaskAction.LoadSubTaskTask(".$taskId.")')";
         $html = $btnAddTask->Show();

         //Création du tableau
         $html .= "<table>";

         //Entete
         $html .= "<tr class='fc-first fc-last'>";
         $html .= "<th class='fc-tue fc-widget-header fc-first fc-last' >".$this->Core->GetCode("Task.Task")."</th>";
         $html .= "<th class='fc-tue fc-widget-header fc-first fc-last'>".$this->Core->GetCode("Task.New")."</th>";
         $html .= "<th class='fc-tue fc-widget-header fc-first fc-last'>".$this->Core->GetCode("Task.Todo")."</th>";
         $html .= "<th class='fc-tue fc-widget-header fc-first fc-last'>".$this->Core->GetCode("Task.Finished")."</th>";
         $html .= "</tr>";

         foreach($tasks as $task)
         {
             $editIcone = new EditIcone($this->Core);
             $editIcone->OnClick = "TaskAction.ShowAddSubTask('', ".$task->IdEntite.", '', 'TaskAction.LoadSubTaskTask(".$taskId.")')";

             $addIcone = new AddIcone($this->Core);
             $addIcone->OnClick = "TaskAction.ShowAddSubTask(".$task->IdEntite.", '', '', 'TaskAction.LoadSubTaskTask(".$taskId.")')";

             $html .= "<tr>";
             $html .= "<td>".$task->Title->Value.$editIcone->Show().$addIcone->Show()."</td>";

             //Affichage des sous taches
             $SubTasks =  TaskHelper::GetByTask($this->Core, $task->IdEntite);

             $New ="";
             $Todo = "";
             $finished = "";

             foreach($SubTasks as $subTask)
             {

                 switch($subTask->StateId->Value)
                 {
                     case TaskTask::NOUVELLE :
                         $New .= $this->RenderTask($subTask); 
                         break;
                     case TaskTask::EN_COURS :
                         $Todo .= $this->RenderTask($subTask);
                         break;
                     case TaskTask::TERMINE :
                         $finished .= $this->RenderTask($subTask);
                         break;
                 }
             }

             $html.= "<td>".$New."</td>";
             $html.= "<td>".$Todo."</td>";
             $html.= "<td>".$finished."</td>";

             $html .= "</tr>";

         }

         $html .= "</table>";

         return $html;
     }

     /*
      * Affiche une tache
      */
     function RenderTask($task)
     {
         $html .= "<div class='subTask'>";
         $html .= "<h6>".$task->Title->Value."</h6>";
         
         $editIcone = new EditIcone();
         $editIcone->OnClick = "TaskAction.ShowAddSubTask('', ".$task->IdEntite.", '', 'TaskAction.RefreshSubTaskTask(".$task->IdEntite.")')";
         $html .= $editIcone->Show();

         $listIcone = new ListIcone();
         $listIcone->OnClick = "TaskAction.ShowListAction(".$task->IdEntite.")";
         $html .= $listIcone->Show();

         $html .= "<p>".$task->Description->Value."</p>";

         //Action
         $action = new TaskAction($this->Core);
         $action->AddArgument(new Argument("Apps\Task\Entity\TaskAction", "TaskId", $task));
         $actions = $action->GetByArg();
         
         if(count($actions) > 0 )
           {
               $html .= "<h6>".$this->Core->GetCode("Actions")."</h6>";
               $html .=  "<ul>";
               
               foreach($actions as $act )
               {
                  if($act->Realised->Value)
                  {
                   $html .= "<li><del>".$act->Libelle->Value."</del></li>"; 
                  }
                  else
                  {
                      $html .= "<li>".$act->Libelle->Value."</li>";
                  }
               }        
               
               $html .=  "</ul>";
           }
           
         $html .= "</div>";

         return $html;
     }
    
}

