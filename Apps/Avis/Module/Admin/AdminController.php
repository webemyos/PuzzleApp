<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Avis\Module\Admin;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
use Core\Control\EntityGrid\EntityGrid;
use Core\Control\EntityGrid\EntityColumn;
use Core\Control\EntityGrid\EntityIconColumn;
use Apps\Avis\Model\AvisModel;

/*
 * 
 */
 class AdminController extends Controller
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
         return $this->Index();
    }
    
    /*
    * Get the home page
    */
   function Index()
   {
       $view = new View(__DIR__."/View/index.tpl", $this->Core);

	   $gdAvis = new EntityGrid("gdAvis", $this->Core);
	   $gdAvis->Entity = "Apps\Avis\Entity\AvisAvis";
	   $gdAvis->App = "Avis";
	   $gdAvis->Action = "GetAvis";

	   $gdAvis->AddColumn(new EntityColumn("Name", "Name"));
	   $gdAvis->AddColumn(new EntityColumn("Email", "Email"));
	   $gdAvis->AddColumn(new EntityColumn("DateCreated", "DateCreated"));
	   $gdAvis->AddColumn(new EntityColumn("Actif", "Actif"));
	   $gdAvis->AddColumn(new EntityIconColumn("",
		   array(array("EditIcone", "Avis.EditTheAvis", "AvisAction.EditAvis"),
		   )
	   ));

	   $view->AddElement($gdAvis);

	   return $view->Render();
   }

	 /**
	  * @param $avisId
	  */
   function EditAvis($avisId)
   {
	   $view = new View(__DIR__."/View/editAvis.tpl", $this->Core);

	   $avisModel = new AvisModel($this->Core, $avisId);
	   $view->SetModel($avisModel, true);
	   $view->SetApp("Avis");
	   $view->SetAction("EditAvis");

	   return $view->Render();
   }
          
          /*action*/
 }?>