<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Script;

use Core\Core\Core;
use Core\Utility\File\File;
use Core\Utility\Packer\Packer;

/**
 * Description of ScriptManager
 *
 * @author jerome
 */
class ScriptManager
{
    /*
     * Get à compressed script
     */
    public static function Get($s)
    {
        $script = CacheManager::Find($s ."js");

        if($script == null)
        {
            switch($s)
            {
               case "Dashboard":
                  $script =  ScriptManager::GetDashBoard();
                  $script = ScriptManager::Minify($script);
               break;
            }
        }

        return $script;
    }

    /*
     * Obtain the dashboard script
     */
    public static function GetDashBoard()
    {
        $scripts  = File::GetFileContent(dirname(__DIR__)."/Dashboard/Dashboard.js");
        $scripts  .= File::GetFileContent(dirname(__DIR__)."/Dashboard/DashboardApp.js");
        $scripts  .= File::GetFileContent(dirname(__DIR__)."/Dashboard/DashboardModule.js");
        $scripts  .= File::GetFileContent(dirname(__DIR__)."/Dashboard/DashboardWidget.js");
        $scripts  .= File::GetFileContent(dirname(__DIR__)."/Core/Request.js");
        $scripts  .= File::GetFileContent(dirname(__DIR__)."/Core/Dom.js");

        return $scripts;
    }

    /*
     * Get Application Script
     */
    public static function GetApp($a, $m, $type)
    {
        //Pour les thémes dont l'asset et dans la base
        if($a== "base" && $type='css')
        {
            header("Content-type: text/css");
            $script  = File::GetFileContent(dirname(dirname(__DIR__)). "/View/Base/asset/bootstrap.css");
            $script  .= File::GetFileContent(dirname(dirname(__DIR__)). "/View/Base/asset/style.css");
            
            return $script;
        }

        $core = Core::GetInstance();
        if($m != "")
        {
           $directory = dirname(dirname(__DIR__)). "/Apps/".$a. "/Module/".$m."/";

           $directory.$m."Controller.".$type;
           $script  = File::GetFileContent( $directory.$m."Controller.".$type);

            //Ajout des vue dans un tableau js
            $ViewsArray = $a . $m . "View";
            $Views = "var ".$ViewsArray . " = new Array();";

            if($dossier = opendir($directory . "View"))
            {
                while(false !== ($fichier = readdir($dossier)))
                {
                    if($fichier != '.' && $fichier != '..' && $fichier != 'index.php')
                    {
                        if (stripos($fichier, '.jtpl') !== FALSE) {
                            
                            $content = File::GetFileContent($directory ."View/" .$fichier);

                            $Views .= $ViewsArray.".push(new Array('" .$fichier. "', '".$content."'));"; 
                        }
                        
                    }
                }

                $script .= "\n\r".  $Views;
            }
        }
        else
        {
            $script  = File::GetFileContent(dirname(dirname(__DIR__)). "/Apps/".$a. "/".$a.".".$type);
        }

        if($type == "js" && $core->Debug === false)
        {
            $script = ScriptManager::Minify($script);
        }
        else if($type == "css")
        {
             header('content-type: text/css');
        }

        return $script;
    }

    /*
     * Get Compressed file for the Js
     */
    public static function GetAllJs()
    {
        $script = CacheManager::Find("script.js");

        if($script == null)
        {
            //List all Js in the Core
            $script = ScriptManager::GetAll();
            $script = ScriptManager::Minify($script);
        }

        return $script;
    }

    /*
     * Find all js in the Core
     */
    public static function GetAll()
    {
        $script ="";

        $folders = array("Action", "Control", "Utility", "Dashboard");
        $scripts = "";

        foreach($folders as $folder)
        {
           if($dossier = opendir(dirname(__DIR__)."/".$folder))
            {
                while(false !== ($fichier = readdir($dossier)))
                {
                    if($fichier != "." && $fichier != ".." && is_dir(dirname(__DIR__)."/".$folder . "/" .$fichier))
                    {
                        if($child = opendir(dirname(__DIR__)."/".$folder."/".$fichier))
                        {
                           while(false !== ($script = readdir($child)))
                            {
                               if( strpos($script, ".js") !== false)
                               {
                                $scripts  .= File::GetFileContent(dirname(__DIR__)."/".$folder."/".$fichier . "/". $script);
                               }
                            }
                        }
                    }
                }
            }
        }

        return $scripts;
    }

    /*
     * Minify the Js
     */
    public static function Minify($content)
    {
        return Packer::Compress($content);
    }
}
