<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\PuzzleApp\Module\Front;

use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Helper\BlogHelper;
use Apps\Downloader\Downloader;
use Core\App\AppManager;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\View\CacheManager;
use Core\View\ElementView;
use Core\View\View;

/**
 * Description of FrontBlock
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
    * Get le master modele
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

       //Telechargement du programme
       $downloader = new Downloader($this->Core);
       $view->AddElement(new ElementView("{{downloader}}", $downloader->ShowRessource(1, "Je télecharge") ));

       //Dernieres articles de blog
       $blog = new BlogBlog($this->Core);
       $blog= $blog->GetByName($this->Core->Config->GetKey("BLOG"));
       $articles = BlogHelper::GetLast($this->Core, $blog, 3);

       //Add Last artiles of the blog
       $view->AddElement(new ElementView("Articles", $articles));


       return $view->Render();
   }

   /*
    * Get The contact Page
   */
   function Contact()
   {
       $view = new View(__DIR__."/View/contact.tpl", $this->Core);

       return $view->Render();
   }
   
   /*
    * Page de téléchargement du framework
    * et des app
    */
   function Store()
   {
        $view = new View(__DIR__."/View/store.tpl", $this->Core);

        $downloader = AppManager::GetApp("Downloader");
        
        $view->AddElement($downloader->GetRessources());
        
       return $view->Render();
   }

    /**
    * Liste les avis des utilisateurs
    */
    function Temoignages()
    {
         $view = new View(__DIR__."/View/temoignages.tpl", $this->Core);
         return $view->Render();
     }
}
