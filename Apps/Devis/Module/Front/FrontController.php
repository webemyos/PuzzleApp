<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Devis\Module\Front;

use Apps\Devis\Entity\DevisPrestationCategory;
use Apps\Devis\Entity\DevisProjet;
use Apps\Devis\Helper\CategoryHelper;
use Apps\Devis\Helper\PrestationHelper;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Core\Core;
use Core\Core\Request;
use Core\View\CacheManager;
use Core\View\ElementView;
use Core\View\View;

/**
 * Front Controller
 *
 * @author jerome
 */
class FrontController extends Controller
{
    function __construct($core = "")
    {
        parent::__construct($core);
     
        $this->Core = Core::getInstance();
        
        $projet = new DevisProjet($this->Core);
        $this->Projet = $projet->GetByLibelle($this->Core->Config->GetKey("DEVIS"));
    }
    
     /*
    * Get le master modele
    */
   function GetMasterView()
   {
      $template = __DIR__."/View/master.tpl";
      $storeTemplate = null; //CacheManager::Find($template);
      
      if($storeTemplate == null)
      {
        $view = new View(__DIR__."/View/master.tpl", $this->Core);
        
        $view->AddElement(new ElementView("Category", CategoryHelper::GetByProjet($this->Core, $this->Projet)));
        
        CacheManager::Store($template, $view->Render());
      }
      else
      {
          $view = new View($storeTemplate);
      }
      
      return $view;
   }
   
    /*
     * Index 
     */
    function Index()
    {
        $masterView = $this->GetMasterView();
        
        //Page View
        $view = new View(__DIR__."/View/index.tpl", $this->Core);
        
        //Render the master modele white the modele
        $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $masterView->Render();
    }
    
    /*
     * Category
     */
    function Category($params)
    {
        $masterView = $this->GetMasterView();
        
        //Page View
        $view = new View(__DIR__."/View/category.tpl", $this->Core);
           
        //Get The prestation
        $view->AddElement(new ElementView("prestas", PrestationHelper::GetByCategory($this->Core, $params)));
        
        //Get the catégory
        $category = new DevisPrestationCategory($this->Core);
        $category = $category->GetByCode($params);
        $view->AddElement($category);
        
        //Render the master modele white the modele
        $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $masterView->Render();
    }
    
    /*
     *  Demande de devis
    */
    function Ask()
    {
        $view = new View(__DIR__."/View/ask.tpl", $this->Core);
        $success = false;
        
        if(Request::GetPost("name") != "")
        {
           $success = true;
           
           //Envoi d'un email a jerome.oliva@gmail.com
           $subject = "Demande de devis sur Webemyos";
           
           $message = "Une demande de devis vient d'étre émise sur Webemyos";
           $message .= "Voici les informations : ";
           
           $message .= "<br/>Nom : ".Request::GetPost("name");
           $message .= "<br/>Email : ".Request::GetPost("email");
           $message .= "<br/>Télephone : ".Request::GetPost("phone");
           $message .= "<br/>Sujet : ".Request::GetPost("subject");
           $message .= "<br/>Message : ".Request::GetPost("message");
           
           mail("jerome.oliva@gmail.com",$subject, $message);
        }
       
        $view->AddElement(new ElementView("success", $success));
                
        return $view->Render();
    }
    
}