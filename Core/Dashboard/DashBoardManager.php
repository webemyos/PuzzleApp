<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Dashboard;

use Core\Core\Core;
use Core\Core\Request;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\Button\Button;


/**
 * Description of DashBoardManager
 *
 * @author jerome
 */
class DashBoardManager
{
     /**
   * Obtient le nombre de notification
   * @param type $core
   */
    public static function  GetInfoNotify($core)
    {
        $notify = new \Apps\Notify\Notify();
        return $notify->GetCount(true);
    }

    /*
     * TODO A DEPLACER DANS EEAPP
    * Load app user
    */
   public static function LoadUserApp()
   {
      $core = Core::getInstance();
      $html = "";

       if(Request::GetPost("show") == "")
       {
         $html = "<div id='lstApp'  style='height:200px;overflow:auto;'>";
       }
       //recuperation des app utilisateurs
        $apps = \Apps\EeApp\Helper\AppHelper::GetByUser($core, $core->User->IdEntite);

         if(count($apps)> 0 )
         {
             foreach($apps as $app)
             {
                 $icRemove = new Libelle("<b class='icon-remove' onclick='Dashboard.RemoveAppUser(\"".$app->IdEntite."\", this)'>&nbsp;</b>");
                 $html .= "<div><span onclick=\"Dashboard.StartApp('', '".$app->App->Value->Name->Value."', '')\">".$core->GetCode("Menu_".$app->App->Value->Name->Value).$icRemove->Show()."</span></div>";
             }
         }
         else
         {
             $html .= $core->GetCode("EeApp.NoApp");
         }

         if(Request::GetPost("show") == "")
         {
             $html .= "</div>";

             //Bouton pour ajouter des application
             $btnAddApp = new Button(BUTTON);
             $btnAddApp->Value = $core->GetCode("AddApp");
             $btnAddApp->CssClass = "btn btn-info";
             $btnAddApp->OnClick = "Dashboard.StartApp('','EeApp')";

             $html .= $btnAddApp->Show();

             return $html;
         }
         else
         {
             echo $html;
         }
   }

    /**
    * Obtient le nombre de notification
    * @param type $core
    */
     public static function  GetInfoMessage($core)
     {
         $emessage = self::GetApp("EeMessage" , $core);
         return $emessage->GetCount(false);
     }

     /**
   * Démarre l'application
   * */
  public function StartApp()
  {
    $parametre = explode(":", Request::GetPost("Parameter"));
    $appName = $parametre[1];
    $url = Request::GetPost("Url");

    //Ajout d'une statistique
   // Stat::Add($this->Core, '', $appName);

   /* if($url)
    {
      include("$url/$appName.php");
    }
    else
    {
      include("../Apps/$appName/$appName.php");
    }*/

    $app = new $appName(Core::getInstance());
    $app->Url = $url;

    echo $app->Run();
  }

  /*
  * Get element mutlilangue of a code
  */
  public function GetCode($code)
  {
    $core = Core::getInstance();
    return $core->GetCode($code);
  }

  /*
  * Search users
  */
  public function SearchUser()
  {
    $core = Core::getInstance();
    $user = new \Core\Entity\User\User($core);
    return $user->SearchUser();
  }
  
    /**
   * Instancie et retourne l'application
   */
  public function GetApp($appName, $core)
  {
    $path = "\\Apps\\".$appName ."\\".$appName;
        
    $app = new $path($core);

    return $app;
  }
  
  public function LoadPage()
  {
     print_r($_POST);
  }

}
