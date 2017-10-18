<?php


/**
 * Description of PuzzleApp
 *
 * @author jerome
 */

namespace Apps\PuzzleApp;

use Apps\Base\Base;
use Apps\PuzzleApp\Module\Front\FrontController;
use Core\Core\Core;
use Core\Core\Request;
use Core\View\View;

/**
 * Description of Base
 *
 * @author jerome
 */
class PuzzleApp extends Base
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
      $this->Core->MasterView->Set("Title", "Puzzle App |Le framework qui vous permet de tout faire sans coder");
      $this->Core->MasterView->Set("Description", "Vous allez lancer un site, bravo. Mais que vous faut il ? Un Cms, un blog, un site Ecommerce ? Ne cherchez plus avec PuzzleApp vos commencer avec une base simple puis vous ajoutez ce que vous avez besoin au fur et à mesure. PuzzleApp fait à peu prêt tout sauf le café.");

      $frontController = new FrontController($this->Core);
      return $frontController->Index();
   }
   
    /*
    * Get The contact Page
   */
   function Contact()
   {
      $this->Core->MasterView->Set("Title", $this->Core->GetCode("ContactUs"));
      $this->Core->MasterView->Set("Description", "Une question, envie de discuter musique ou nous présenter vos objets connectés, vos instruments ou simplement envie de nous dire un petit mot ? Contactez nous.");
      
      if(Request::IsPost())
      {
        $email = Request::GetPost("tbEmail");
        $name = Request::GetPost("tbName");
        $message = Request::GetPost("tbMessage");
        
        mail("jerome.oliva@gmail.com",
             "Nouveau message du pupitre digital", 
             " Email : ". $email . " Nom :" .$name . "Message : " .$message );
        
        return "<div class='col-md-12' >Merci pour votre message, nous vous répondrons rapidement.</div>";
      }
      else
      {
        return parent::contact();
      }
   }
   
   /*
    * Obtient les News
    */
   function GetNew()
   {
       $this->Core->MasterView = new View(__DIR__."/View/masterNew.tpl");
       echo "<h1>Bienvenue sur le pupitre digital.com.</h1>";
       echo "<p>Merci d'avoir télécharger notre logiciel.<br/>
           Nous sommes en version Beta pour l'instant et sommes conscients qu'il reste des bugs,<br/>
       et des évolutions importantes à réaliser. Merci de nous donner votre avis, améliorations, défauts rencontrér sur 
       <a href='http://lepupitredigital.com' > LePupitredigital.com</a></p>
      ";
       
       
       return false;
   }
}
