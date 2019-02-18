<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\Devis\Module\Home;

use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
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
              $view = new View(__DIR__ . "/View/Home.tpl", $this->Core); 
              
              //Bouton pour créer un ecommerce
              $btnNewProjet = new Button(BUTTON, "btnNewProjet");
              $btnNewProjet->Value = $this->Core->GetCode("Projet.NewProjet");
              $btnNewProjet->CssClass = "btn btn-info";
              $btnNewProjet->OnClick = "DevisAction.ShowAddProjet();";
              $view->AddElement($btnNewProjet);
              
              //Bouton pour afficher les projet de devis
              $btnProjet = new Button(BUTTON, "btnProjet");
              $btnProjet->Value = $this->Core->GetCode("Devis.Projet");
              $btnProjet->CssClass = "btn btn-success";
              $btnProjet->OnClick = "DevisAction.LoadMyProjet();";
              $view->AddElement($btnProjet);
              
              //Texte de presentation
              $view->AddElement(new Libelle($this->Core->GetCode("Devis.TitleHome"), "titleHome"));
              $view->AddElement(new Libelle($this->Core->GetCode("Devis.MessageHome"),"messageHome"));
              
              return $view->Render();
	  }
 }?>