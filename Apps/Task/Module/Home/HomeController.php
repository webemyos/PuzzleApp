<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;


 class HomeController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
        $this->Core = $core;
    }

    /**
     * Affichage du module
     */
    function Show($all=true)
    {
        $view = new View(__DIR__ . "/View/Home.tpl", $this->Core);
        
        //Bouton pour créer un message
        $btnNewGroup = new Button(BUTTON, "btnNewGroup");
        $btnNewGroup->Value = $this->Core->GetCode("Task.NewProjet");
        $btnNewGroup->OnClick = "TaskAction.ShowAddGroup();";
        $btnNewGroup->CssClass = "btn btn-info";
        $view->AddElement($btnNewGroup);
        
        
        $btnMyGroup = new Button(BUTTON, "btnMyGroup");
        $btnMyGroup->Value = $this->Core->GetCode("Task.MyProjet");
        $btnMyGroup->CssClass = "btn btn-info";
        $btnMyGroup->OnClick = "TaskAction.LoadMyGroup();";
        $view->AddElement($btnMyGroup);
        
        return $view->Render();
    }
         
 }?>