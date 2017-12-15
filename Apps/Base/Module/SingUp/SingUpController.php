<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Module\SingUp;

use Core\Controller\Controller;
use Core\Core\Request;
use Core\Security\Authentication;
use Core\View\ElementView;
use Core\View\View;


class SingUpController extends Controller
{
    /**
   * Constructeur
   */
   function __construct($core="")
   {
       $this->Core = $core;
   }
   
   /*
    * Connection Module
    */
   function Index($error = "")
   {
        $view = new View(__DIR__."/View/index.tpl", $this->Core);
        $success = false;
        $error = "";
        
        if(Request::isPost())
        {
         $message = Authentication::CreateUser($this->Core,
                                               Request::GetPost("login"),
                                               Request::GetPost("password"), 
                                               Request::GetPost("verif") 
                                            );
         
       
         if($message == "")
         {
             $success = true;
         }
         else
         {
             $error = $message;
         }
        }
       
        $view->AddElement(new ElementView("Success", $success));
        $view->AddElement(new ElementView("error", $error));
      
        return $view->Show();
   }
}
