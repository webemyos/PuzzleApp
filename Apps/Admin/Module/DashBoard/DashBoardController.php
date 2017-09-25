<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Admin\Module\DashBoard;

use Core\Controller\Controller;
use Core\Core\Core;
use Core\Dashboard\DashBoardManager;
use Core\View\ElementView;
use Core\View\View;

/**
 * Description of FrontBlock
 *
 * @author jerome
 */
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
    * Get le master modele
    */
   function GetMasterView()
   {
      $view = new View(__DIR__."/View/master.tpl", $this->Core );
      
      //Replace All Element in the Template
      //TODO METTRE EN CACHE UNE PARTIE DE ELEMENT
      $view->AddElement(new ElementView("{{infoNotify}}", DashBoardManager::GetInfoNotify($this->Core) ));
      $view->AddElement(new ElementView("{{appUser}}", DashBoardManager::LoadUserApp($this->Core)));
      
     
      return $view;
   }
   
   /*
    * Get the home page
    */
   function Index()
   {
       $view = new View(__DIR__."/View/index.tpl");
       return $view->Render();
   }
}
