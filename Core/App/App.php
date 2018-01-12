<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Core\App;

use Apps\Api\Api;
use Apps\Cms\Cms;
use Core\Core\Core;
use Core\View\ContentView;


/**
 * Description of App
 *
 * @author jerome
 */
class App
{
    private $appBase;

    /*
     * Construct
     */
    public function __construct()
    {
    }

    /*
     * Get The App
     */
    public function Get($appName)
    {
        $path = "\\Apps\\".$appName . "\\".$appName;

        $this->appBase = new $path();
    }

    /*
     * Call action of a app
     */
    public function Execute($app, $route)
    {
        $core = Core::getInstance();
        $app = str_replace(".html", "", $route->GetApp());
        $action = $route->GetAction();
        $param = $route->GetParams();

        $core->MasterView = $this->appBase->GetMasterView();

        if($app == "Api")
        {
            $api = new Api($core);
            echo $api->Execute();
            return;
        }
        
        //Execute action on app
        if(!AppManager::IsApp($app))
        {
          if($app == "" || $app == "index" || $app == "Index")
          {
            $core->MasterView->AddElement(new ContentView("content", $this->appBase->Index()));
          }
          else
          {
              if(method_exists($this->appBase, $app))
              {
                $core->MasterView->AddElement(new ContentView("content", $this->appBase->$app()));
              }
              else
              {
                //On recherche la page dans Cms
                $cms = new Cms($core);
                $core->MasterView->AddElement(new ContentView("content", $cms->ShowPage($app)));
              }
          }
        }
        else
        {
            $path = "Apps\\".$app. "\\".$app;
            $apps = new $path($core);

            if($action == "" )
            {
                $core->MasterView->AddElement(new ContentView("content", $apps->Index()));
            }
            else
            {
                $core->MasterView->AddElement(new ContentView("content", $apps->$action($param)));
            }
        }
        echo $core->MasterView->Render();
    }
}
