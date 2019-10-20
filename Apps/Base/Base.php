<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base;

use Apps\Base\Helper\InstallHelper;
use Apps\Base\Module\Front\FrontController;
use Apps\Base\Module\Install\InstallController;
use Apps\Base\Module\Login\LoginController;
use Apps\Base\Module\SingUp\SingUpController;
use Core\App\Application;
use Core\Core\Core;
use Core\Core\Request;
use Core\Entity\User\User;
use Apps\Captcha\Captcha;
use Core\Utility\Email\Email;

/**
 * Base of the App
 *
 * @author jerome
 */
class Base extends Application
{
    public $Core;
    
    /*
     * Créate de app Base
     */
    public function __construct()
    {
        $this->Core = Core::getInstance();
        parent::__construct($this->Core, "Base");
    }
    
     /**
      * Get The Public route
      */
      function GetRoute($routes = "")
      {
         if($routes == "")
         {
            $this->Route->SetPublic(array("Install", "Login", "Contact", "Connect", "Disconnect", "Singup", "ForgetPassword" ,"NewPassword" , "SetLang"));
         }
         else
         {
            $this->Route->SetPublic(array_merge($routes, array("Install", "Login", "Contact", "Connect", "Disconnect", "Singup", "ForgetPassword" ,"NewPassword", "SetLang")));
         }

         return $this->Route;
      }

      /**
       * Change la langue
       */
     function SetLang($lang)
     {
        $this->Core->SetLang($lang);
        $this->Core->Redirect($this->Core->GetPath("/"));
     }

    /*
     * Get the master View
     */
    public function GetMasterView()
    {
        $frontController = new FrontController($this->Core);
        return $frontController->GetMasterView();
    }
    
    /*
     * Get the home Page
     */
    public function Index()
    {
        $frontController = new FrontController($this->Core);
        return $frontController->Index();
    }
    
    /*
     * Connection Module
     */
    public function Login($error ="")
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Login"));
       $this->Core->MasterView->Set("Description", $this->Core->GetCode("ConnetToYourEspace"));
 
        $loginController = new LoginController($this->Core);
        return $loginController->Index($error);
    }
    
    /*
     * Connect the use
     */
    public function Connect()
    {
        $loginController = new LoginController($this->Core);
        return $loginController->Connect();
    }
    
    /*
     * Deconnect L'utilisateur
     */
    public function Disconnect()
    {
        $this->Core->Disconnect();
    }
    
    /*
     * Member 
     */
    public function Membre()
    {
    }
    
    /*
     * Get The contact page
     */
    public function Contact()
    {
        $this->Core->MasterView->Set("Title", $this->Core->GetCode("ContactUs"));
        $valid = false;

        if(Request::IsPost())
        {
            if(!Captcha::IsValid())
            {
                $frontController = new FrontController($this->Core);
                return $frontController->contact(false);
            }
            else
            {
                return  $this->ContactAction(Request::GetPost("tbMail"),
                                      Request::GetPost("tbName"),
                                      Request::GetPost("tbMessage")
                                     );
            }
        }
        else
        {
            $frontController = new FrontController($this->Core);
            return $frontController->contact();
        }
    }
    
    /**
     * Send Message to Admin
     */
    public function ContactAction($email, $name, $message)
    {
        $mail = new Email($this->Core);
        $mail->Title = $this->Core->GetCode("Base.NewContactMessageTitle");
        $mail->Body = $this->Core->GetCode("Base.NewContactMessageBody");
        $mail->Body .= $email . "," .$name . ",".$message;

        $admins = $this->Core->GetAdminUser();

        foreach($admins as $admin)
        {
            $mail->Send($admin->Email->Value);
        }

        return $this->Core->GetCode("Base.ContactMessageRecevied");
    }

    /*
     * Inscription to the site
     */
    public function Singup()
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Register"));
       
       $singUpController = new SingUpController($this->Core);
       return $singUpController->Index();
    }

    /**
     * Password gorger
     */
    public function ForgetPassword()
    {
        $this->Core->MasterView->Set("Title", $this->Core->GetCode("ForgetPassword"));
       
        $singUpController = new SingUpController($this->Core);
        return $singUpController->ForgetPassword();
    }

    /**
     * Password gorger
     */
    public function NewPassword($params)
    {
        $this->Core->MasterView->Set("Title", $this->Core->GetCode("NewPassword"));
       
        $singUpController = new SingUpController($this->Core);
        return $singUpController->NewPassword($params);
    }
    /*
     * Module d'installation
     */
    public function Install()
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Install"));
       $this->Core->MasterView->Set("Description", $this->Core->GetCode("InstallSite"));
   
       if(Request::IsPost())
        {
            InstallHelper::Install($this->Core,
                                   Request::GetPost("Serveur"),
                                   Request::GetPost("DataBase"),
                                   Request::GetPost("User"),
                                   Request::GetPost("Password"),
                                   Request::GetPost("Admin"),
                                   Request::GetPost("PassAdmin")
                    );
            
            $installController = new InstallController($this->Core);
            return $installController->Success();
        }
        else
        {
            $installController = new InstallController($this->Core);
            return $installController->Index();
        }
    }
}

