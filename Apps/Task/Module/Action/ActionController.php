<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Module\Action;

use Apps\Task\Helper\ActionHelper;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\Icone\DeleteIcone;
use Core\Control\TextArea\TextArea;
use Core\Controller\Controller;


 class ActionController extends Controller
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
    {
    }

    /**
     * Ecran de gestion ds actions à réaliser pour les taches
     */
    function Load($taskId)
    {
        $html ="";

        //bouton d'ajout js d'action
        $btnAddAction = new Button(BUTTON);
        $btnAddAction->CssClass = "btn btn-primary";
        $btnAddAction->Value = $this->Core->GetCode("Task.AddAction");
        $btnAddAction->OnClick = "TaskAction.AddAction();";

        $html .= $btnAddAction->Show();

        $html .= "<div id='lstAction' >".$this->GetActions($taskId)."</div>";

        //Bouton de sauvegarde
        $btnSave = new Button(BUTTON);
        $btnSave->CssClass = "btn btn-success";
        $btnSave->Value = $this->Core->GetCode("Save");
        $btnSave->OnClick = "TaskAction.SaveAction();";
        $html .= $btnSave->Show();

        return $html;
    }

    /*
     * Affiche les actions des taches
     */
    function GetActions($taskId)
    {
        $actions = ActionHelper::GetByTask($this->Core, $taskId);

        if(count($actions) > 0)
        {
          foreach($actions as $action)
          {
              $html .= "<div>";

              //Tache réalisé ou non
              $cbAction = new CheckBox("cb");
              $cbAction->Checked = $action->Realised->Value;
              $html .= $cbAction->Show();

              //Libelle
              $tbLibelle = new TextArea("tbLibelle");
              $tbLibelle->AddStyle("height", "50px");
              $tbLibelle->Value = $action->Libelle->Value;
              $html .= $tbLibelle->Show();

              //Icone de suppression
              $delIcone = new DeleteIcone();
              $delIcone->Title = $this->Core->GetCode("Delete");
              $delIcone->OnClick = "  TaskAction.DeleteResponse(this)";
              $html .= $delIcone->Show();


              $html.= "</div>";
          }
        }

        return $html;
    }
          
 }?>