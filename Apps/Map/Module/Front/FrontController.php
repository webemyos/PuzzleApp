<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Map\Module\Front;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

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

       $view->AddElement($hdReseaux);

       return $view->Render();
   }
    
   function GetWidget()
   {
        $view = new View(__DIR__."/View/widget.tpl", $this->Core);
        return $view->Render();
   }
          /*action*/
 }?>