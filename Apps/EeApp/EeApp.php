<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp;

use Apps\EeApp\Helper\AdminHelper;
use Apps\EeApp\Helper\AppHelper;
use Apps\EeApp\Helper\UploadHelper;
use Apps\EeApp\Module\Admin\AdminController;
use Apps\EeApp\Module\App\AppController;
use Core\App\Application;
use Core\Core\Core;
use Core\Core\Request;


class EeApp extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/EeApp";
    public $Context ;

    /**
     * Constructeur
     * */
     function __construct()
     {
        $this->Core = Core::getInstance();
        parent::__construct($this->Core, "EeApp");
     }

     /**
      * Get The Public route
      */
     function GetRoute()
     {
       // $route = new Route();
        $this->Route->SetPublic(array("Show"));
        return $this->Route;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
       //Install EeApp
       if(!AppHelper::IsInstalled($this->Core))
       {
           AppHelper::Install($this->Core);
       }

       echo parent::RunApp($this->Core, "EeApp", "EeApp");
     }

    /**
     * Charge les applications de l'utilisateur
     */
    public function LoadMyApp()
    {
        $appBlock = new AppController($this->Core);
        echo $appBlock->LoadMyApp();
    }

    /**
     * Charge les applications disponibles
     */
    public function LoadApps()
    {
       $appBlock = new AppController($this->Core);
       echo $appBlock->LoadApps();
    }

    /**
     * Ajoute une app à l'utilisateur
     */
    public function Add()
    {
        $appId = Request::GetPost("appId");
        $appName= Request::GetPost("appName");
        $result = AppHelper::Add($this->Core, $appId, $appName );

        if($result === true)
        {
            echo $this->Core->GetCode("EeApp.AppAdded");
        }
        else if($result === false)
        {
            echo $this->Core->GetCode("EeApp.ErrorAdded");
        }
        else
        {
           echo $result;
        }
    }

    /**
     * Supprime une app au bureau
     */
    public function Remove()
    {
        $appId = Request::GetPost("appId");

        AppHelper::Remove($this->Core, $appId);
    }

    /**
     * Obtient toutes les applications Actives
     */
    public function GetActif($limit)
    {
        return AppHelper::GetActif($this->Core, $limit);
    }

    /*
     * Obtient les applications par catégories
     */
    public function GetByCategory($categoryId)
    {
        return AppHelper::GetByCategory($this->Core, $categoryId);
    }

    /**
     * Retourne une application depuis son Id
     * @param type $appId
     */
    public function GetAppById($appId)
    {
        return AppHelper::GetById($this->Core, $appId);
    }

    /**
     * Retourne une application par son nom
     * @param type $name
     */
    public function GetAppByName($name)
    {
        return AppHelper::GetByName($this->Core, $name);
    }

    /**
     * Obtient les categories des applications
     */
    public function GetCategory()
    {
        return AppHelper::GetCategory($this->Core);
    }

    /**
     * Charge la partie administration des applications
     */
    public function LoadAdmin()
    {
        $adminBlock = new AdminController($this->Core);
        echo $adminBlock->LoadApp();
    }

   /**
     * Popin d'ajout d'une application
     */
    public function ShowAddApp()
    {
        $appBlock = new AppController($this->Core);
        echo $appBlock->ShowAddApp(Request::GetPost("appId"));
    }

    /**
     * Sauvegarde une application
     */
    public function SaveApp()
    {
         if(Request::GetPost("tbName") && Request::GetPost("tbDescription")  )
        {
            AppHelper::Save($this->Core, Request::GetPost("tbName"), Request::GetPost("tbDescription"), Request::GetPost("lstCategory"), Request::GetPost("appId"));

            echo "<span class='success' >".$this->Core->GetCode("EeApp.AppSaved")."</span>";
        }
        else
        {
            echo  "<span class='error'>".$this->Core->GetCode("EeApp.FieldEmpty"). "</span>";
            $this->ShowAddApp();
        }
    }

    /*
     * Pop in de gestion des administrateurs des applications
     */
    public function ShowAdmin()
    {
        $adminBlock = new AdminController($this->Core);
        echo $adminBlock->ShowAdmin();
    }

    /**
     * Ajoute un administrateur à une application
     */
    public function AddAdmin()
    {
        AdminHelper::AddAdmin($this->Core, Request::GetPost("appId"), Request::GetPost("contactId"));

        $adminBlock = new AdminController($this->Core);
        echo $adminBlock->GetAdmin();
    }

    /*
     * Supprime un administrateur d'un application
     */
    public function DeleteAdmin()
    {
        AdminHelper::DeleteAdmin($this->Core, Request::GetPost("adminId"));
    }

    /**
     * Défini si un utilisateur est Admin d'une application
     */
    public static function IsAdmin($core, $appName, $userId)
    {
        return AppHelper::IsAdmin($core, $appName, $userId);
    }

    /*
    * Pop in for add APp
    */
    public function ShowUploadApp()
    {
        $adminBlock = new AdminController($this->Core);
        echo $adminBlock->ShowUploadApp();
    }

    /*
    * Pop in for add Language
    */
    public function ShowUploadLanguage()
    {
        $adminBlock = new AdminController($this->Core);
        echo $adminBlock->ShowUploadLanguage();
    }


    /**
     * Ajout une app depuis un zip
     */
    function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
    {
        switch($action)
        {
            case "DoUploadApp" : 
                UploadHelper::DoUploadApp($fileName, $tmpFileName);
            break;
            case "DoUploadLanguage" : 
                UploadHelper::DoUploadLanguage($fileName, $tmpFileName);
            break;
        }
    }
    
    /*
     * Supprime une app
     */
    function RemoveApp()
    {
        AppHelper::RemoveApp($this->Core, Request::GetPost("appId"));
    }

    /**
     * Obtient les App installé
     */
    public function GetAll()
    {
        return AppHelper::GetAll($this->Core);
    }

    public function Show()
    {
        return "Public Root";
    }

    
}
?>
