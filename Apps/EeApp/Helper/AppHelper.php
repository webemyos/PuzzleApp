<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Helper;

use Core\Entity\Entity\Argument;
use Apps\EeApp\Entity\EeAppUser;
use Apps\EeApp\Entity\EeAppApp;
use Apps\EeApp\Entity\EeAppAdmin;
use Core\Utility\File\File;


class AppHelper
{
    /**
     * Obtient les applications utilisateurs
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId)
    {
        $appUser = new EeAppUser($core);
        $appUser->AddArgument(new Argument("Apps\EeApp\Entity\EeAppUser", "UserId", EQUAL, $userId));
        
        return $appUser->GetByArg();
    }
    
    /**
     * Obtient les app selon les critères
     * @param type $core
     */
    public static function GetByParameters($core)
    {
        $app = new EeAppApp($core);
        
        return $app->GetAll();
    }
    
    /**
     * Obtient toutes les app
     * @param type $core
     */
    public static function GetAll($core)
    {
        $app = new EeAppApp($core);
        return $app->GetAll();
    }
    
    /**
     * Ajoute une app à l'utilisateur
     * @param type $core
     * @param type $appId
     */
    public static function Add($core, $appId, $appName)
    {
        $appUser = new EeAppUser($core);
        $appUser->UserId->Value = $core->User->IdEntite;
        
        if($appId != false)
        {
            $appUser->AppId->Value = $appId;
        }
        else
        {
            $app = new EeAppApp($core);
            
            $app->GetByName($appName);
            $appId = $app->IdEntite;
           $appUser->AppId->Value = $app->IdEntite;
        }
        
        if(!AppHelper::UserHave($core, $appId))
        {
            return $appUser->Save();
        }
        else
        {
            return $core->GetCode("EeApp.AppInDesktop");
        }
    }
    
    /**
     * Supprime une app a l'utilisateur
     * @param type $core
     * @param type $appId
     */
    public static function Remove($core, $appId)
    {
        $appUser = new EeAppUser($core);
        $appUser->GetById($appId);
        $appUser->Delete();
    }
    
    /**
     * Verifie si l'utilisateur à l'app
     * @param type $core
     * @param type $appId
     */
    public static function UserHave($core, $appId)
    {
         $appUser = new EeAppUser($core);
         $appUser->AddArgument(new Argument("Apps\EeApp\Entity\EeAppUser", "UserId", EQUAL, $core->User->IdEntite));
         $appUser->AddArgument(new Argument("Apps\EeApp\Entity\EeAppUser", "AppId", EQUAL, $appId));
         
         return (count($appUser->GetByArg()) > 0);
    }
    
    /**
     * Obtient les applications actives
     */
    public static function GetActif($core, $limit)
    {
         $app = new EeAppApp($core);
         $app->AddArgument(new Argument("Apps\EeApp\Entity\EeAppApp", "Actif", EQUAL, "1"));
         
        if($limit != "")
        {
            $app->SetLimit(1, $limit);
        }
         
         return $app->GetByArg();
    }
    
    /**
     * Obtient les applications actives
     */
    public static function GetByCategory($core, $category)
    { 
        //Recuperation de la categorie par son nom
        $appCategory = new EeAppCategory($core);
        $appCategory->GetByName($category);
        
         $app = new EeAppApp($core);
         $app->AddArgument(new Argument("Apps\EeApp\Entity\EeAppApp", "Actif", EQUAL, "1"));
         $app->AddArgument(new Argument("Apps\EeApp\Entity\EeAppApp", "CategoryId", EQUAL, $appCategory->IdEntite));
         
         return $app->GetByArg();
    }
    
    /**
     * Retourne une app depuis son Id
     * @param type $core
     * @param type $id
     */
    public static function GetById($core, $id)
    {
         $app = new EeAppApp($core);
         $app->GetById($id);
         
         return $app;
    }
    
    /**
     * Retourne une app depuis son nom
     * @param type $core
     * @param type $id
     */
    public static function GetByName($core, $name)
    {
         $app = new EeAppApp($core);
         $app->GetByName($name);
         
         return $app;
    }
    
    /**
     * Retourne es catégories des applications
     * @param type $core
     */
    public static function GetCategory($core)
    {
        $category = new EeAppCategory($core);
        return $category->GetAll();
    }
    
    /**
     * Définie si un utilisateur est admin de l'app
     * @param type $core
     * @param type $appName
     * @param type $userId
     */
    public static function IsAdmin($core, $appName, $userId)
    {
        $app = new EeAppApp($core);
        $app->GetByName($appName);
                
        $appAdmin = new EeAppAdmin($core);
        $appAdmin->AddArgument(new Argument("Apps\EeApp\Entity\EeAppAdmin", "AppId",EQUAL, $app->IdEntite));
        $appAdmin->AddArgument(new Argument("Apps\EeApp\Entity\EeAppAdmin", "UserId",EQUAL, $userId));
        
        return (count($appAdmin->GetByArg(true))>0);
    }
    
    /*
     * Défine si EeApp est installé
     */
    public static function IsInstalled($core)
    {
        $EeApp = new EeAppApp($core);
        $app = $EeApp->GetByName("EeApp");
      
        return ($app != false); 
    }
    
    /**
     * Install the App
     * Ad set the first user as a admin
     */
    public static function Install($core)
    {
        $request = File::GetFileContent(__DIR__."\..\Db\install.sql");
        $core->Db->ExecuteMulti($request);
    }
    
    /*
     * Sauvegarde une application
     */
    public static function Save($core, $name, $description, $categoryId, $appId)
    {
         $app = new EeAppApp($core); 
         
         if($appId != "")
         {
             $app->GetById($appId);
         }
         
         $app->Name->Value = $name;
         $app->Description->Value = $description;
         $app->CategoryId->Value = $categoryId;
         $app->Actif->Value = "0";
         $app->Save();
    }
    
    /*
     * Delete the app File And in the DataBase
     */
    public static function RemoveApp($core, $appId)
    {
        //Recuperation de l'app
        $app = new EeAppApp($core);
        $app->GetById($appId);
        $appName = $app->Name->Value;
                
        //Drop table
        echo __DIR__."/../../".$appName."/Db/unInstall.sql";
        
        echo "<br/> Suppression des tables de la base de donnée :";
        echo $request = File::GetFileContent(__DIR__."/../../".$appName."/Db/unInstall.sql");
        $core->Db->ExecuteMulti($request);
      
        File::DeleteDirectory(__DIR__."/../../".$appName);
        
        //Supprimer les utilisateur et les administrateur
        
        //Suppression
        $appName->Delete();
    }
}