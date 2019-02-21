<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Avis\Module\Front;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;


use Apps\Avis\Model\AvisModel;
use Apps\Avis\Entity\AvisAvis;

/*
 * 
 */
 class FrontController extends Controller
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
       return $view->Render();
   }

  /**
   * Permet de laisser un avis
   * @return bool|mixed|string
   */
   function Depose()
   {
	   $view = new View(__DIR__."/View/depose.tpl", $this->Core);

	   $avisModel = new AvisModel($this->Core);
	   $view->SetModel($avisModel);

	   return $view->Render();
   }

	 /***
	  * Affiche les avis actifs
	  */
   function ListAvis()
   {
	   $view = new View(__DIR__."/View/listAvis.tpl", $this->Core);

	   $avis = new AvisAvis($this->Core);
	   $avis = $avis->Find("Actif=1");

	   $view->AddElement($avis);

	   return $view->Render();

   }

          
          /*action*/
 }?>