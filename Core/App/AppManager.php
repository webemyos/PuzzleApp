<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Core\App;

use Core\Core\Core;


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
   public static function IsApp($app)
   {
       //TODO USE A APPMANAGE
       //REFLECHIR COMMENT ON TROUVE LES APPS
       //UTILISER EeAPP ET les app installé
       $apps = array("Blog", "Devis", "Solution","Webemyos", "Tutoriel", "Mooc", "Downloader" );

       return (in_array($app, $apps));
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
               echo "TROUVE";
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

