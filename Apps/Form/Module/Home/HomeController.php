<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Module\Form;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use const BUTTON;

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
          $btnMyForm = new Button(BUTTON);
          $btnMyForm->Value = $this->Core->GetCode("Form.MyForm");
          $btnMyForm->CssClass = "btn btn-info";
          $btnMyForm->OnClick = "FormAction.LoadMyForm();";

           //Fichier Partage
          $btnNewForm = new Button(BUTTON);
          $btnNewForm->Value = $this->Core->GetCode("Form.NewForm");
          $btnNewForm->OnClick = "Form.New();";


          //Passage des parametres à la vue
          $this->AddParameters(array('!titleHome' => $this->Core->GetCode("Form.TitleHome"),
                                      '!messageHome' => $this->Core->GetCode("Form.MessageHome"),
                                      '!btnMyForm' =>  $btnMyForm->Show(),                     
                                      '!btnNewForm' => $btnNewForm->Show(),
                                  ));

          $this->SetTemplate(__DIR__. "/View/Home.tpl");

          return $this->Render();
    }
  
 }?>