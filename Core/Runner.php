<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

session_start();

use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Control\Upload\Upload;
use Core\Core\Core;
use Core\Core\Request;
use Core\Core\Trace;
use Core\Security\Autorisation;
use Core\View\ElementView;
use Core\View\View;
/**
 * Description of Runner
 *
 * @author jerome
 */
class Runner
{
    /*
     * Start the App
     */
    public static function Run($appName, $config, $debug)
    {
        try 
        {
            $core = Core::getInstance($config, $debug);

            //Extract the route Url
            $route = \Core\Router\Router::ExtractRoute();

            //Get the route
            $app = $route->GetApp();

            //If the App Isn't installed
            if(!$core->IsInstalled())
            {
                //Install action
                $route->setApp("Install");

                $appBase = new \Core\App\App();
                $appBase->Get("Base");
                $appBase->Execute($app, $route);

                return;
            }
 
            $core->Init();

            //Show Uploader
            if(Runner::IsUpload($app))
            {
              if(Request::GetPost("hdPost"))
              {
                Upload::DoUpload(Request::GetPost("hdApp"),
                                 Request::GetPost("hdIdElement"),
                                 $_FILES["fileUpload"]["tmp_name"],
                                 $_FILES["fileUpload"]["name"],
                                 Request::GetPost("hdAction")
                        );
              }
              else
              {
                echo Upload::ShowUploader();
              }
              return ;
            }

            //Run the section
            if (Runner::IsSection($app))
            {
                if (Autorisation::IsAutorized(Core::getInstance()->User, $app))
                {
                    $section = new \Core\App\App();
                    $section->Get($app);
                    $section->Execute($app, $route);
                }
                else
                {
                    $core->Redirect("Login");
                }
            }
            //Run the app base and the app
            else
            {
                //Store the App in the Core
                $core->App = $appName;

                $app = new \Core\App\App();
                $app->Get($appName);
                $app->Execute($app, $route);
            }


            //Debugger
            if($debug)
            {
                echo Runner::ShowDebug() ;
            }
        } 
        catch (Exception $ex) 
        {
            print_r($ex);
            
            $View = new View("../View/Core/Exception/exception.tpl", $core);
            
            if(!$debug)
            {
                $View->AddElement(new ElementView("message", "Ca bug grave"));
            }
            else
            {
                 $View->AddElement(new ElementView("message", $ex->getMessage()));
            }
            
            echo $View->Render();
           
        }
    }

    /*
     * Défine if the systeme use a section
     */

    public static function IsSection($section)
    {
        $sections = array("Admin", "Membre");

        return (in_array($section, $sections));
    }

    /*
    * Définie si c'est l'upload
    */
    public static function IsUpload($section)
    {
      return $section == "upload";
    }
    
    /*
     *  Affiche les infrmations de débuggage
    */
    public static function ShowDebug()
    {  
        $core = Core::getInstance();
    
        $html = "<script type='text/javascript' src='".$core->GetPath("/script.php?s=Dashboard")."' ></script> ";
        $html .= "<div style='width:600px; height:50px; overflow:auto;position:fixed;bottom:0px;right:0px;border:1px solid red;background:grey' >";
        $html .= "<h4>Debugger</h4>";
        
        $tabStrip = new TabStrip("tbDebugger");
        $tabStrip->AddTab("POST",  new Libelle(Runner::GetPost()));
        $tabStrip->AddTab("REQUEST",  new Libelle(Runner::GetSql()));
        
        $html .= $tabStrip->Show();
        $html .= "</div>";
        
        return $html;
    }
    
    /*
     * Get The POst varaiable
     */
    public static function GetPost()
    {
        $html = "";
        
        if(isset($_POST) )
        {
            foreach($_POST as $key=>$value)
            {
                $html .= "<br/>".$key .":".$value;
            }
        }
        return $html;
    }
    
    /*
     * Get The Sql varaiable
     */
    public static function GetSql()
    {
        $html = "";
        
        if(isset(Trace::$Requests) )
        {
            foreach(Trace::$Requests as $key=>$value)
            {
                $html .= "<br/>".$key .":".$value;
            }
        }
        return $html;
    }
}
