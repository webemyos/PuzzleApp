<?php

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Module\Home;


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
         * Obtient le menu
         */
        function Show()
        {
            $modele = new View(__DIR__ . "/View/Home.tpl", $this->Core);

            $btnInformation = new Button(BUTTON, "btnInformation");
            $btnInformation->CssClass = "btn btn-success";
            $btnInformation->Value = $this->Core->GetCode("EeProfil.MyInformation");
            $btnInformation->OnClick = "EeProfilAction.LoadInformation()";
            $modele->AddElement($btnInformation);

            $btnCompetence = new Button(BUTTON, "btnCompetence");
            $btnCompetence->CssClass = "btn btn-info";
            $btnCompetence->Value = $this->Core->GetCode("EeProfil.MyCompetence");
            $btnCompetence->OnClick = "EeProfilAction.LoadCompetence()";
            $modele->AddElement($btnCompetence);

            return $modele->Render();
        }
 }?>