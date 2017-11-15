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
    public function Login()
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Login"));
       $this->Core->MasterView->Set("Description", $this->Core->GetCode("ConnetToYourEspace"));
 
        $loginController = new LoginController($this->Core);
        return $loginController->Index();
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
        if(Request::IsPost())
        {
            //YOUR CODE
        }
        else
        {
            $frontController = new FrontController($this->Core);
            return $frontController->contact();
        }
    }
    
    /*
     * Inscription to the site
     */
    public function singup()
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Login"));
       
       $singUpController = new SingUpController($this->Core);
       return $singUpController->Index();
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

