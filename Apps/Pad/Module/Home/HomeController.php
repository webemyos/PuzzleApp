<?php
/*
 * 
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Pad\Module\Home;

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
            //Bouton pour créer un blog
            $btnNewDoc = new Button(BUTTON);
            $btnNewDoc->Value = $this->Core->GetCode("EePad.NewDoc");
            $btnNewDoc->OnClick = "EePadAction.ShowAddDoc();";

            $btnMyDoc = new Button(BUTTON);
            $btnMyDoc->Value = $this->Core->GetCode("EePad.MyDoc");
            $btnMyDoc->CssClass = "btn btn-info";
            $btnMyDoc->OnClick = "EePadAction.LoadMyDoc();";

            $btnMyShareDoc = new Button(BUTTON);
            $btnMyShareDoc->Value = $this->Core->GetCode("EePad.MyShareDoc");
            $btnMyShareDoc->CssClass = "btn btn-success";
            $btnMyShareDoc->OnClick = "EePadAction.LoadSharedDoc();";

            //Passage des parametres à la vue
            $this->AddParameters(array('!titleHome' => $this->Core->GetCode("EePad.TitleHome"),
                                        '!messageHome' => $this->Core->GetCode("EePad.MessageHome"),
                                        '!btnNewDoc' =>  $btnNewDoc->Show(),                     
                                        '!btnMyDoc' => $btnMyDoc->Show(),
                                        '!btnShareDoc' => $btnMyShareDoc->Show()
                                        ));

            $this->SetTemplate(__DIR__. "/View/HomeBlock.tpl");

            return $this->Render();
        }
 }?>