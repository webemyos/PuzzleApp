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
        //Bouton pour créer un message
        $btnNewGroup = new Button(BUTTON);
        $btnNewGroup->Value = $this->Core->GetCode("EeTask.NewProjet");
        $btnNewGroup->OnClick = "EeTaskAction.ShowAddGroup();";

        $btnMyGroup = new Button(BUTTON);
        $btnMyGroup->Value = $this->Core->GetCode("EeTask.MyProjet");
        $btnMyGroup->CssClass = "btn btn-info";
        $btnMyGroup->OnClick = "EeTaskAction.LoadMyGroup();";

        //Passage des parametres à la vue
        $this->AddParameters(array('!titleHome' => $this->Core->GetCode("EeTask.TitleHome"),
                                    '!messageHome' => $this->Core->GetCode("EeTask.MessageHome"),
                                    '!btnNewProjet' =>  $btnNewGroup->Show(),  
                                    '!btnMyProjet' =>  $btnMyGroup->Show(), 
                                ));

        $this->SetTemplate(__DIR__ . "/View/HomeBlock.tpl");

        return $this->Render();
    }
         
 }?>