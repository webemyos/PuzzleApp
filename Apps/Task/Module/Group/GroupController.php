<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Module\Group;

use Apps\Task\Entity\TaskGroup;
use Apps\Task\Entity\TaskTask;
use Apps\Task\Helper\GroupHelper;
use Apps\Task\Helper\TaskHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ExpandIcone;
use Core\Control\Icone\ListIcone;
use Core\Control\Icone\ParameterIcone;
use Core\Control\Image\Image;
use Core\Controller\Controller;

class GroupController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core="")
    {
          $this->Core = $core;
    }

    /**
     * Pop in d'ajout de groupe
     */
    function ShowAddGroup($groupId, $appName, $entityName, $entityId)
    {
        $jbGroup = new AjaxFormBlock($this->Core, "jbGroup");
        $jbGroup->App = "Task";
        $jbGroup->Action = "SaveGroup";

        if($groupId != null)
        {
           $group = new TaskGroup($this->Core); 
           $group->GetById($groupId);

           $jbGroup->AddArgument("GroupId", $groupId);
        }

        $jbGroup->AddArgument("AppName", $appName);
        $jbGroup->AddArgument("EntityName", $entityName);
        $jbGroup->AddArgument("EntityId", $entityId);

        $jbGroup->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbTitle", "Libelle" => $this->Core->GetCode("Title") , "Value" => ($groupId != "")?$group->Title->Value :""),
                                      array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => ($groupId != "")?$group->Description->Value :""),
                                      array("Type"=>"Button", "CssClass"=> "btn btn-success", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                          )
                );

        return $jbGroup->Show();
    }

    /**
     * Charge les groupes de tâches de l'utilisateur
     */
    function LoadMyGroup()
    {
       $groups = GroupHelper::GetByUser($this->Core, $this->Core->User->IdEntite);

        $html ="";

        if(count($groups) > 0)
        {
            //Ligne D'entete
            $html .= "<div class='task titleBlue'>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Title")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("App")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Description")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("DateCreated")."</b></div>";
            $html .= "</div>"; 

            $i=0;
            foreach($groups as $groupe)
            {
                       if($i==1)
              {
                   $i=0;
                   $class='lineClair';
               }
               else
               {
                   $i=1;
                   $class='lineFonce';
               }

                $html .= "<div class='task $class'>";

                $html .= "<div class='name'>".$groupe->Title->Value."</div>";

               if($groupe->AppName->Value != "")
               {
                   $img = new Image("../Apps/".$groupe->AppName->Value ."/images/logo.png");
                   $img->Title = $groupe->AppName->Value;

                   $html .= "<div>".$img->Show()."</div>";
               }
               else
               {
                 $html .= "<div></div>";  
               }

               $html .= "<div >".$groupe->Description->Value."</div>";
               $html .= "<div class='date'>".$groupe->DateCreated->Value."</div>";

               //Icone d'action
               $editIcon = new EditIcone($this->Core);
               $editIcon->Title = $this->Core->GetCode("Edit");
               $editIcon->OnClick = "TaskAction.ShowAddGroup(".$groupe->IdEntite.")";
               $html .= "<div >".$editIcon->Show();

               //Gestion des taches
               $expandIcon = new ExpandIcone();
               $expandIcon->Title = $this->Core->GetCode("Open");
               $expandIcon->OnClick = "TaskAction.LoadTask(".$groupe->IdEntite.")";
               $html .= $expandIcon->Show();

               //Vue de la tache dans une popup
               $openIcone = new ParameterIcone();
               $openIcone->Title = $this->Core->GetCode("View");
               $openIcone->OnClick = "TaskAction.OpenTask(".$groupe->IdEntite.")";
               $html .= $openIcone->Show();

               //Vue complete du projet 
               $lisIcone = new ListIcone();
               $lisIcone->Title = $this->Core->GetCode("View");
               $lisIcone->OnClick = "TaskAction.OpenProjet(".$groupe->IdEntite.")";
               $html .= $lisIcone->Show();

               //Suppression
               $deleteIcon = new DeleteIcone();
               $deleteIcon->Title = $this->Core->GetCode("Delete");
               $deleteIcon->OnClick = "TaskAction.DeleteGroup(this, ".$groupe->IdEntite.", 1)";
               $html .= $deleteIcon->Show()."</div>";



               $html .= "</div>";
            }
        }
        else
        {
            return $this->Core->GetCode("Message.NoMessage");
        }

        return $html;
    }

    /**
     * Ouvre un groupe de tâche
     * @param type $groupId
     */
    function Open($groupId)
    {
        //Recuperation du groupe
        $groupe = new TaskGroup($this->Core);
        $groupe->GetById($groupId);

        //Element du groupe
        $html .= "<div style='width:800px'><span><h2 class='editable' id='UpdateGroupe_Title_".$groupe->IdEntite."' >".$groupe->Title->Value."</h2></span>";
        $html .= "<span><p class='textEditable' id='UpdateGroupe_Description_".$groupe->IdEntite."' >".$groupe->Description->Value."</p></span>";

        //Entete selon l'état
        $new = "<div class='group news' ><h6>News</h6>";
        $enCours= "<div class='group encours' ><h6>Encours</h6>";
        $verif= "<div class='group verif' ><h6>Verif</h6>";
        $end= "<div class='group termine' ><h6>End</h6>";

        //Tache 
        $tasks = TaskHelper::GetByGroup($this->Core, $groupId);

        foreach($tasks as $task)
        {
            $htmlTask = "<span class='task' onclick='TaskAction.OpenDetail(this, $task->IdEntite)' >".$task->Title->Value;

            //Ajout des taches filles
            $subTasks = TaskHelper::GetByTask($this->Core, $task->IdEntite);

            $listNew = "<ul>";
            $listEnCour = "<ul>";
            $listVerif = "<ul>";
            $listEnd = "<ul>";
            $htmlSubTask = "";


            if(count($subTasks) > 0)
            {
                //Entete 
                $htmlTask .= "<table class='tabSub' id='tab_$task->IdEntite' style='display:none'>";

                $htmlTask .= "<tr><th>Nouvelle</th><th>En cour</th><th>A verifier</th><th>a terminer</th></tr>";

                $htmlTask .= "<ul>";

                foreach($subTasks as $subTask)
                {
                      $htmlSubTask = "<li class='subtask' >".$subTask->Title->Value.":".$subTask->Description->Value;
                      $htmlSubTask .= "<b onclick='TaskAction.ShowAddSubTask(".$task->IdEntite.",".$subTask->IdEntite.")' >e</b>";
                       $htmlSubTask .= "</li>";

                       switch($subTask->StateId->Value)
                      {
                          case TaskTask::NOUVELLE;
                            $listNew .= $htmlSubTask;
                              break;
                           case TaskTask::EN_COURS;
                            $listEnCour .= $htmlSubTask;
                              break;
                           case TaskTask::A_VERIFIER;
                            $listVerif .= $htmlSubTask;
                              break;
                           case TaskTask::TERMINE;
                            $listEnd .= $htmlSubTask;
                              break;
                      }

                }
               $listNew .= "</ul>";
               $listEnCour .= "</ul>";
               $listVerif .= "</ul>";
               $listEnd .= "</ul>";

               $htmlTask .= "<tr><td>$listNew</td><td>$listEnCour</td><td>$listVerif</td><td>$listEnd</td></tr>";

                $htmlTask .= "</table>";
            }

            $htmlTask .="</span>";

            switch($task->StateId->Value)
            {
                case TaskTask::NOUVELLE;
                  $new .= $htmlTask;
                    break;
                 case TaskTask::EN_COURS;
                  $enCours .= $htmlTask;
                    break;
                 case TaskTask::A_VERIFIER;
                  $verif .= $htmlTask;
                    break;
                 case TaskTask::TERMINE;
                  $end .= $htmlTask;
                    break;
            }

            $htmlTask = "";
              $listNew = "";
              $listEnCour = "";
              $listVerif = "";
              $listEnd = "";
        }

        $new .= "</div>";
        $enCours .= "</div>";
        $verif .= "</div>";
        $end.= "</div>"; 

        $html .= "<div id='lstGroup' >";
        $html .= " <table><tr>";    
        $html .=  "<td>".$new."</td>";      
        $html .=  "<td>".$enCours."</td>" ;     
        $html .=  "<td>".$verif."</td>";      
        $html .=  "<td>".$end."</td>";      
        $html .=   "</tr></table> ";  

        return $html;
    }
}

?>
