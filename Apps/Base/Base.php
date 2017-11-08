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
        $frontBlock = new FrontController($this->Core);
        return $frontBlock->GetMasterView();
    }
    
    /*
     * Get the home Page
     */
    public function Index()
    {
        $frontBlock = new FrontController($this->Core);
        return $frontBlock->Index();
    }
    
    /*
     * Connection Module
     */
    public function Login()
    {
       $this->Core->MasterView->Set("Title", $this->Core->GetCode("Login"));
       $this->Core->MasterView->Set("Description", $this->Core->GetCode("ConnetToYourEspace"));
 
        $loginBlock = new LoginController($this->Core);
        return $loginBlock->Index();
    }
    
    /*
     * Connect the use
     */
    public function Connect()
    {
        $loginBlock = new LoginController($this->Core);
        return $loginBlock->Connect();
    }
    
    /*
     * Deconnect L'utilisateur
     */
    public function Disconnect()
    {
        $this->Core->Disconnect();
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
            $frontBlock = new FrontController($this->Core);
            return $frontBlock->contact();
        }
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
            
            $installBlock = new InstallController($this->Core);
            return $installBlock->Success();
        }
        else
        {
            $installBlock = new InstallController($this->Core);
            return $installBlock->Index();
        }
    }
}

