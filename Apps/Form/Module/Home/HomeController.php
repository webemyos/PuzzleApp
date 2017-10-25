<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Module\Home;

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
        $View = new View( __DIR__ . "/View/Home.tpl", $this->Core);
        
         //Nouveau formulaire
        $btnNewForm = new Button(BUTTON, "btnNewForm");
        $btnNewForm->Value = $this->Core->GetCode("Form.NewForm");
        $btnNewForm->CssClass = "btn btn-warning";
        $btnNewForm->OnClick = "Form.New();";
        $View->AddElement($btnNewForm);
        
        //Bouton pour créer un message
        $btnMyForm = new Button(BUTTON, "btnMyForm");
        $btnMyForm->Value = $this->Core->GetCode("Form.MyForm");
        $btnMyForm->CssClass = "btn btn-info";
        $btnMyForm->OnClick = "FormAction.LoadMyForm();";
        $View->AddElement($btnMyForm);
          
        return $View->Render();
    }
  
 }?>