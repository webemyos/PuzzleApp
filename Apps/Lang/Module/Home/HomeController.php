<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Lang\Module\Home;

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
               $view = new View(__DIR__. "/View/HomeBlock.tpl", $this->Core);
               
                return $view->Render();
	  }
 }?>