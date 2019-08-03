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
use Apps\Captcha\Captcha;
use Core\Entity\User\User;
use Core\Security\TokenManager;
use Core\Utility\Email\Email;
use Core\Control\Link\Link;


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
            if(!Captcha::IsValid())
            {
               $message = $this->Core->GetCode("Captcha.Incorrect");     
            }   
            else
            {
                $message = Authentication::CreateUser($this->Core,
                                               Request::GetPost("login"),
                                               Request::GetPost("password"), 
                                               Request::GetPost("verif") 
                                            );
            }
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

   /**
    * Forget pass
    */
   public function ForgetPassword()
   {
        $view = new View(__DIR__."/View/forgetPassword.tpl", $this->Core);
    
        if(Request::isPost())
        {
            $user = new User($this->Core);
            $user = $user->GetByEmail(Request::GetPost("email"));    

            if($user->IdEntite != "")
            {
                $token = TokenManager::Generate($this->Core, $user->IdEntite);    

                $email = new Email($this->Core);
                $email->Title = $this->Core->GetCode("Base.emailForgetMessageTitle");
                $email->Body = $this->Core->GetCode("Base.emailForgetMessageMessage");
                
                $link = new Link($this->Core->GetCode("Base.emailLink"), $this->Core->GetPath("/NewPassword/".$token));
                $email->Body .= $link->Show();
                $email->Send($user->Email->Value);

 
                $view->AddElement(new ElementView("Message", $this->Core->GetCode("Base.emailForgetSended")));    
            }
            else
            {
                $view->AddElement(new ElementView("Message", $this->Core->GetCode("Base.emailForgetUNknowUser")));
            }
            
            $view->AddElement(new ElementView("Success", true));
        }
        else
        {
            $view->AddElement(new ElementView("Success", false));
        }

        return $view->Render();
   }  
   
   /**
    * Enter new Password
    */
   function NewPassword($params)
   {
       $view = new View(__DIR__."/View/newPassword.tpl", $this->Core);
       $isValid = TokenManager::IsValid($this->Core, $params);

       if($isValid)
       {
            if(Request::isPost())
            {
                   $pass = Request::GetPost("password");
                   $verify = Request::GetPost("verify");

                    if($pass != $verify)
                    {
                        $view->AddElement(new ElementView("Error", $this->Core->GetCode("Base.PassNotEqual")));    
                        $view->AddElement(new ElementView("State", "validToken"));
                    }
                    else
                    {
                        $isValid->User->Value->ChangePassword($pass);
                        
                        $view->AddElement(new ElementView("Error", "")); 
                        $view->AddElement(new ElementView("State", "updated"));   
                    }
            }
            else
            {
                $view->AddElement(new ElementView("State", "validToken"));
                $view->AddElement(new ElementView("Error", ""));    
            }
        }     
       else
       {
           $view->AddElement(new ElementView("State", "invalidToken"));
       }

       return $view->Render();
   }    
}
