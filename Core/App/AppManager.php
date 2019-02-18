<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Core\App;

use Core\Core\Core;
use Apps\EeApp\EeApp;

class AppManager
{
    /*
     * Container of app
     */
    private static $Apps;
    
    /*
    * Défine if te system use à app or one page on site base
    *
    */
   public static function IsApp($core, $appName)
   {
       $eapp = new EeApp();
       $apps = $eapp->GetAll();
       $appsName = array();

       foreach($apps as $app)
       {
            $appsName[] = $app->Name->Value;
       }
       return (in_array($appName, $appsName));
   }
   
   /**
    * Get the App in the Container 
    * or instancie à new 
    * @param type $app
    */
   public static function GetApp($appName)
   {
       foreach(AppManager::$Apps as $key => $value)
       {
           if($key == $appName)
           {
               return $value;
           }
       }
       
       //App not found
       $path = "\\Apps\\".$appName . "\\".$appName;
       $app = new $path(Core::GetInstance());
       
       AppManager::$Apps[$appName] = $app;
       
       return $app;
   }
}

