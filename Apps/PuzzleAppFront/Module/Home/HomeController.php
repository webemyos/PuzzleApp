<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\PUzzleAppFront\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

/*
 * 
 */
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
          
          /*action*/
 }?>