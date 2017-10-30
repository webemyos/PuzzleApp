<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Search;

use Apps\Mooc\Helper\MoocHelper;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
use Core\Control\EntityListBox\EntityListBox;


 class SearchController extends Controller
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
         $modele = new View(__DIR__ . "/View/show.tpl", $this->Core); 

         //List des catégorie
         $lstCategory = new EntityListBox("lstCategory", $this->Core); 
         $lstCategory->Entity = "Apps\Mooc\Entity\MoocCategory";
         $modele->AddElement($lstCategory);

         //btnSearc 
         $btnSearch = new Button(BUTTON, "btnSearch");
         $btnSearch->Value = $this->Core->GetCode("Search");
         $btnSearch->OnClick = "MoocAction.Search()";
         $btnSearch->CssClass = "btn btn-success";
         $modele->AddElement($btnSearch);

         return $modele->Render();
    }

    /*
     * Recherche les mooc de la catégorie
     */
    function Search($categoryId)
    {
      $modele = new View(__DIR__. "/View/search.tpl", $this->Core); 

      $moocs = MoocHelper::Search($this->Core, $categoryId);

      $modele->AddElement($moocs);
      return $modele->Render();
    }

    /*
     * Charge les Mooc de l'utilisateur
     */
    function LoadMyLesson()
    {
      $modele = new View(__DIR__ . "/View/LoadMyLesson.tpl", $this->Core); 

      $moocs = MoocHelper::GetStartedByUser($this->Core, $this->Core->User->IdEntite);

      if(count($moocs) > 0 )
      {
          $modele->AddElement($moocs);
      }
      else
      {
          $modele->AddElement(array());
      }

      return $modele->Render();
    }
 }
          

