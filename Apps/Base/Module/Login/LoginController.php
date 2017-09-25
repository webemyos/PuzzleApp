<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Module\Login;

use Core\Control\Button\Button;
use Core\Control\EmailBox\EmailBox;
use Core\Control\PassWord\PassWord;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Modele\Modele;
use Core\Security\Authentication;

class LoginController extends Controller 
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
        $modele = new Modele(__DIR__."/View/index.tpl", $this->Core);

        //Error
        $modele->AddElement(new Text("error", false, $error));
                
        //Login
        $login = new EmailBox("login");
        $modele->AddElement($login);
        
        //PassWord
        $passBlock = new PassWord("password");
        $modele->AddElement($passBlock);
        
        //BtnConnect
        $btnConnect = new Button(SUBMIT, "btnLogin");
        $btnConnect->Value = $this->Core->GetCode("Connect");
        
        $modele->AddElement($btnConnect);
        
        return $modele->Render();
   }
 
   /**
    * Connect the User
    */   
   public function Connect()
   {
       $verification = Authentication::Connect(Request::GetPost("login"), Request::GetPost("password") );
       
       if($verification === true)
       {
           $section = $this->Core->User->Groupe->Value->Section->Value->Directory->Value;
           $this->Core->Redirect($section);
       }
       else
       {
           return $this->Index($verification); 
       }
   }
}
