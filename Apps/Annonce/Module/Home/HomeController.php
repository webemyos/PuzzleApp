<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Annonce\Module\Annonce;

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
        $modele = new View(__DIR__. "/View/Home.tpl", $this->Core);
        
          //Bouton pour créer une annonce
          $btnNewAnnonce = new Button(BUTTON, "btnNewAnnonce");
          $btnNewAnnonce->Value = $this->Core->GetCode("Annonce.NewAnnonce");
          $btnNewAnnonce->OnClick = "AnnonceAction.ShowAddAnnonce();";
          $modele->AddElement($btnNewAnnonce);

          //Bouton pour charger les annonces de l'utilisateur
          $btnMyAnnonce = new Button(BUTTON, "btnMyAnnonce");
          $btnMyAnnonce->Value = $this->Core->GetCode("Annonce.MyAnnonce");
          $btnMyAnnonce->CssClass = "btn btn-info";
          $btnMyAnnonce->OnClick = "AnnonceAction.ShowMyAnnonce();";
          $modele->AddElement($btnMyAnnonce);

          //Bouton pour charger toutes les annonces 
          $btnAnnonces = new Button(BUTTON, "btnAnnonces");
          $btnAnnonces->Value = $this->Core->GetCode("Annonce.Annonce");
          $btnAnnonces->CssClass = "btn btn-success";
          $btnAnnonces->OnClick = "AnnonceAction.ShowAnnonces();";
          $modele->AddElement($btnAnnonces);

          return $modele->Render();
     }
          
 }?>