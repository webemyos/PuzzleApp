<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Core\App;

use Core\Core\Core;
use Core\Control\Text\Text;
use Core\View\ContentView;
use Apps\Cms\Cms;


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

        //Execute action on app
        if(!$this->IsApp($app))
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

    /*
     * Défine if te system use à app or one page on site base
     *
     */
   public function IsApp($app)
   {
       $apps = array("Blog", "Tutoriel");

       return (in_array($app, $apps));
   }
}
