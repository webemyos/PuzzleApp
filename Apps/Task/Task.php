<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task;

use Apps\Task\Entity\TaskGroup;
use Apps\Task\Helper\ActionHelper;
use Apps\Task\Helper\GroupHelper;
use Apps\Task\Helper\TaskHelper;
use Apps\Task\Module\Action\ActionController;
use Apps\Task\Module\Group\GroupController;
use Apps\Task\Module\Projet\ProjetController;
use Apps\Task\Module\Task\TaskController;
use Core\App\Application;
use Core\Core\Request;


class Task extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'DashBoardManager';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Task";

    /**
     * Constructeur
     * */
     function Task($core)
     {
            parent::__construct($core, "Task");
            $this->Core = $core;
    }

     /**
      * Execution de l'application
      */
     function Run()
     {
            $textControl = parent::Run($this->Core, "Task", "Task");
            echo $textControl;
     }

    /**
     * Popin d'ajout d'un groupe de tâches
     */
    public function ShowAddGroup()
    {
        $groupController = new GroupController($this->Core);
        echo $groupController->ShowAddGroup(Request::GetPost("GroupId"), Request::GetPost("AppName"), Request::GetPost("EntityName"),Request::GetPost("EntityId") );
    }

    /**
     * Sauvegarde un groupe
     */
    public function SaveGroup()
    {
      $title = Request::GetPost("tbTitle");

      if($title != "")
      {
          GroupHelper::SaveGroupe($this->Core, $title, Request::GetPost("tbDescription"), Request::GetPost("GroupId"),
                                                       Request::GetPost("AppName"), Request::GetPost("EntityName"),
                                  Request::GetPost("EntityId")
                  );

          echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
      }
      else
      {
          echo "<span class='error'>".$this->Core->GetCode("FieldEmpty")."</span>";
          $this->ShowAddGroup();
      }
    }

    /**
     * Charge les groupe de tâches de l'utilisateur
     */
    public function LoadMyGroup()
    {
        $groupController = new GroupController($this->Core);
        echo $groupController->LoadMyGroup();
    }

    /**
     * Charge les tâches d'un groupe 
     */
    public function LoadTask()
    {
        $taskController = new TaskController($this->Core);
        echo $taskController->LoadTask(Request::GetPost("idEntity")?Request::GetPost("idEntity") :Request::GetPost("GroupId"), Request::GetPost("AppName"));
    }

    /**
     * Popin d'ajout de taches
     */
    public function ShowAddTask()
    {
        $taskController = new TaskController($this->Core);
        echo $taskController->ShowAddTask(Request::GetPost("GroupId"), Request::GetPost("TaskId"), "", "" );
    }

    /**
     * Sauvegarde un groupe
     */
    public function SaveTask()
    {
      $title = Request::GetPost("tbTitle");

      if($title != "")
      {
          TaskHelper::SaveTask($this->Core, 
                                  $title,
                                  Request::GetPost("tbDateStart"),
                                  Request::GetPost("tbDateEnd"),
                                  Request::GetPost("tbDescription"),
                                  Request::GetPost("GroupId"),
                                  Request::GetPost("TaskId"),
                                  Request::GetPost("ParentId"),
                                  Request::GetPost("SubTaskId"),
                                  Request::GetPost("lstState")
                  );

          echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
      }
      else
      {
          echo "<span class='error'>".$this->Core->GetCode("FieldEmpty")."</span>";
          $this->ShowAddTask();
      }
    }

    /**
     * Pop in d'ajout de sous taches
     */
    function ShowAddSubTask()
    {
        $taskController = new TaskController($this->Core);
        echo $taskController->ShowAddTask("", "", Request::GetPost("TaskId"), Request::GetPost("SubTaskId")); 
    }

    /*
     * Charge les sous taches
     */
    function LoadSubTask()
    {
         $taskController = new TaskController($this->Core);
         echo $taskController->LoadSubTask(Request::GetPost("TaskId"), Request::GetPost("AppName"));
    }

    /**
     * Supprime une tache
     */
    function DeleteTask()
    {
        TaskHelper::DeleteTask($this->Core, Request::GetPost("TaskId"));
    }

    /**
     * Supprime un groupe
     */
    function DeleteGroup()
    {
        GroupHelper::DeleteGroup($this->Core, Request::GetPost("GroupId"));
    }

    /**
     * Obtient les groupes de taches par App
     */
    function GetGroupByApp($appName, $entityName, $entityId)
    {
        return GroupHelper::GetGroupByApp($this->Core, $appName, $entityName, $entityId);
    }

    /**
     * Ouvre un groupe de tache en pop in
     */
    function OpenTask()
    {
        $groupController = new GroupController($this->Core);
        echo $groupController->Open(Request::GetPost("idEntity")?Request::GetPost("idEntity") :Request::GetPost("groupId"));
    }

    /**
     * Met à jour un élement
     */
    function UpdateElement()
    {
        $action = Request::GetPost("Action");
        $id = Request::GetPost("Id");
        $property = Request::GetPost("Property");
        $value = Request::GetPost("Value");

        switch($action)
        {
            case "UpdateGroupe" :

                GroupHelper::Update($this->Core, $id, $property, $value);
                break;
        }
    }

    /**
     * Liste des actions à réaliser pour un tache
     */
    function ShowListAction()
    {
       $actionController = new ActionController($this->Core);
       echo $actionController->Load(Request::GetPost("subTaskId"));
    }

    /**
     * Sauvagare les actions d'un taches
     */
    function SaveAction()
    {
        ActionHelper::SaveActions($this->Core, Request::GetPost("TaskId"), Request::GetPost("Actions"));

        echo "<span class='success'>".$this->Core->GetCode("success")."</span>";

        //On reaffiche les actions
        $actionController = new ActionController($this->Core);
        echo $actionController->GetActions(Request::GetPost("TaskId"));
    }

    /**
     * Retourne le nombre d'action pour un taches
     */
    function GetCountAction()
    {
        echo ActionHelper::GetCountAction($this->Core, Request::GetPost("TaskId"));
    }

    /*
     * Ouvre un projet
     */
    function OpenProjet()
    {
        $projetController = new ProjetController($this->Core);
        echo $projetController->OpenProjet(Request::GetPost("projetId"));
    }

    /*
     * Obtent la liste des parents
     */   
    function RefreshParent()
    {
        $projetController = new ProjetController($this->Core);
        $projet = new TaskGroup($this->Core);
        $projet->GetById(Request::GetPost("projetId"));

        echo $projetController->GetParent($projet);
    }

    /*
     * Charge le tableau des sous taches
     */
    function LoadSubTaskTask()
    {
        $projetController = new ProjetController($this->Core);
        echo $projetController->LoadSubTaskTask(Request::GetPost("taskId"));
    }
 }
?>