<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Module\Front;

use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\View\CacheManager;
use Core\Modele\Modele;
use Core\View\View;

/**
 * Front controller
 *
 * @author jerome
 */
class FrontController extends Controller 
{
     /**
    * Constructeur
    */
   function __construct($core="")
   {
       $this->Core = $core;
   }

   /*
    * Get le master view
    */
   function GetMasterView()
   {
      $template = __DIR__."/View/master.tpl";
      $storeTemplate = CacheManager::Find($template);
      
      if($storeTemplate == null)
      {
        $view = new View(__DIR__."/View/master.tpl", $this->Core);

        $view->AddElement(new Text("menu", false, "<ul>Accueil</ul>"));

        //Acces to the administartion
        if($this->Core->IsConnected())
        {
            $html = "<li><a href='Admin'> dashboard</a></li>";
        }

        $view->AddElement(new Text("lkAdmin", false, $html));
        
        CacheManager::Store($template, $view->Render());
      }
      else
      {
          $view = new View($storeTemplate);
      }
      
      return $view;
   }
   
   /*
    * Get the home page
    */
   function Index()
   {
       $view = new View(__DIR__."/View/index.tpl", $this->Core);
       return $view->Render();
   }
   
   /*
    * Get The contact Page
   */
   function Contact()
   {
       $modele = new Modele(__DIR__."/View/contact.tpl", $this->Core);
       
       return $modele->Render();
   }
}
