<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
use Core\Control\Libelle\Libelle;
use Core\Dashboard\DashBoard;

 class HomeController extends Controller
 {
	  /**
	   * Constructeur
	   */
	  function _construct($core="")
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
            $modele = new View(__DIR__ . "/View/Home.tpl", $this->Core); 


            //Bouton pour recherche un cours
            $btnSearch = new Button(BUTTON);
            $btnSearch->Value = $this->Core->GetCode("Mooc.Search");
            $btnSearch->Id = "btnSearch";
            $btnSearch->OnClick = "MoocAction.LoadSearch();";
            $modele->AddElement($btnSearch);
             
            $btnMyLesson = new Button(BUTTON);
            $btnMyLesson->Id = "btnMyLesson";
            $btnMyLesson->Value = $this->Core->GetCode("Mooc.MyLesson");
            $btnMyLesson->CssClass = "btn btn-info";
            $btnMyLesson->OnClick = "MoocAction.LoadMyLesson();";
            $modele->AddElement($btnMyLesson);
          
            $btnPropose = new Button(BUTTON);
            $btnPropose->Id = "btnPropose";
            $btnPropose->Value = $this->Core->GetCode("Mooc.Propose");
            $btnPropose->CssClass = "btn btn-success";
            $btnPropose->OnClick = "MoocAction.LoadPropose();";
            $modele->AddElement($btnPropose);
          
             //Administration
            if(DashBoard::IsAdmin("Mooc", $this->Core))
            {
              $btnAdmin = new Button(BUTTON);
              $btnAdmin->CssClass = "btn btn-danger";
              $btnAdmin->Id = "btnAdmin";
              $btnAdmin->Value = $this->Core->GetCode("Mooc.Admin");
              $btnAdmin->OnClick = "MoocAction.LoadAdmin()";
              $modele->AddElement($btnAdmin);
          
            }
            else
            {
                $modele->AddElement(new Libelle("","btnAdmin"));
            }
           
            return $modele->Render();
	  }
  }?>