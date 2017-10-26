<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Module\Install;

use Core\Controller\Controller;
use Core\View\View;

/**
 * Install Controller
 *
 * @author jerome
 */
class InstallController extends Controller 
{
     /**
    * Constructeur
    */
   function __construct($core="")
   {
       $this->Core = $core;
   }

   /*
    * Get the home page
    */
   function Index()
   {
       $view = new View(__DIR__."/View/index.tpl", $this->Core);
       return $view->Render();
   }
}
