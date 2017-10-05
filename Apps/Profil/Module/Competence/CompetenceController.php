<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Module\Competence;

use Apps\Profil\Helper\CompetenceHelper;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Controller\Controller;


 class CompetenceController extends Controller
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

       /*
      * Charges les compétences de l'utilisateur
      */
       function Load()
      {
              $this->SetTemplate(__DIR__ . "/View/Load.tpl");
              $this->AddParameters(array('!dvCompetenceUser' => $this->GetUserCompetence(),
                                       ));

              return $this->Render();
      }

      /*
       * Obtiens les compétences disponibles
       */        
      function GetCompetence()
      {
          return $this->GetUserCompetence(false);
      }
      /**
       * Compétence de l'utilisateur
       */
      function GetUserCompetence($showUser = true)
      {
          //Recuperation des catégorie
          $categories = CompetenceHelper::GetCategorie($this->Core);

          $html = "<div id='dvCompetenceUser'>";

          foreach($categories as $categorie)
          {
              $html .= "<div class='categorie col-md-4'>";
              $html .= "<div class='titleBlue'>".$categorie->Name->Value."</div>";

              //Recuperation des compétences
              $competences = CompetenceHelper::GetByCategoryByUser($this->Core, $categorie->IdEntite, $this->Core->User->IdEntite);

              $html .= "<ul>";

              foreach($competences as $competence)
              {
                $cbCompetence = new CheckBox($competence["Id"]); 
                if($showUser)
                {
                  $cbCompetence->Checked = $competence["Selected"];
                }

                $html .= "<li>".$cbCompetence->Show()."&nbsp;".$competence["Code"]."</li>";
              }

              $html .= "</ul>";
              $html .= "</div>";
          }

          if($showUser)
          {
              //Enregistrement
              $btnSave = new Button(BUTTON);
              $btnSave->Value = $this->Core->GetCode("Save");
              $btnSave->CssClass = "btn btn-primary";
              $btnSave->OnClick = "ProfilAction.SaveCompetence()";

              $html .= "<div class='alignCenter '>".$btnSave->Show()."</div>";
          }

          $html .= "</div>";
          return $html;
      }
}?>