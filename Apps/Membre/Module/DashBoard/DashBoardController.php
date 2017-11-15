<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Membre\Module\DashBoard;

use Core\Controller\Controller;
use Core\Core\Core;
use Core\View\View;

class DashBoardController extends Controller 
{
      /**
    * Constructeur
    */
   function __construct($core="")
   {
       $this->Core = Core::getInstance();
   }

   /*
    * Home page
     */
    public function Index()
    {
        //Page View
        $view = new View(__DIR__."/View/index.tpl", $this->Core);
        
       //§$view->AddElement(new ElementView("Article", BlogHelper::GetLast($this->Core, $this->Blog)));
        
        //Render the master modele white the modele
       // $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $view->Render();
    }
}
