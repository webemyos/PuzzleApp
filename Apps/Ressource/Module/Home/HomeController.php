<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ressource\Module\Home;

use Core\Control\Button\Button;
use Core\Control\TextBox\TextBox;
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
       $modele = new View( __DIR__ . "/View/HomeBlock.tpl", $this->Core);

       //Champ de recherche
       $tbSearch = new TextBox("tbSearch");
       $tbSearch->PlaceHolder = $this->Core->GetCode("EeRessource.TapYouSearch");
       $modele->AddElement($tbSearch);

      //Bouton pour créer un blog
      $btnSearch = new Button(BUTTON, "btnSearch");
      $btnSearch->Value = $this->Core->GetCode("EeRessource.Search");
      $btnSearch->OnClick = "EeRessourceAction.Search();";
      $modele->AddElement($btnSearch);

      return $modele->Render();
    }
 }?>