<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Module\App;

use Apps\EeApp\Entity\EeAppApp;
use Apps\EeApp\Helper\AppHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Controller\Controller;
use Core\View\View;

class AppController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core="")
    {
          $this->Core = $core;
    }

    /**
     * Charges les applications de l'utilisateur
     */
    function LoadMyApp()
    {
      $view = new View(__DIR__ . "/View/LoadMyApps.tpl", $this->Core);

      //Recuperation
      $apps = AppHelper::GetByUser($this->Core, $this->Core->User->IdEntite);

      if(count($apps) > 0)
      {
          $view->AddElement($apps);
      }
      else
      {
          $view->AddElement(array());
      }
      return $view->Render();

    }

    /**
     * Popin d'ajout d'une application
     */
    function ShowAddApp($appId)
    {
        $jbApp = new AjaxFormBlock($this->Core, "jbApp");
        $jbApp->App = "EeApp";
        $jbApp->Action = "SaveApp";

        if($appId != null)
        {
           $app = new EeAppApp($this->Core);
           $app->GetById($appId);


           $jbApp->AddArgument("appId", $appId);
        }

        $jbApp->AddControls(array(
                                      array("Type"=>"EntityListBox", "Name"=> "lstCategory", "Entity"=> "Apps\EeApp\Entity\EeAppCategory", "Libelle" => $this->Core->GetCode("Category") , "Value" => ($appId != "")?$app->CategoryId->Value :""),
                                      array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name") , "Value" => ($appId != "")?$app->Name->Value :""),
                                      array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => ($appId != "")?$app->Description->Value :""),
                                      array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save"), "CssClass" =>"btn btn-primary" ),
                          )
                );

        return $jbApp->Show();
    }

    /**
     * Charge les applications disponibles
     */
    function LoadApps()
    {
      $view = new View(__DIR__ ."/View/LoadApps.tpl", $this->Core);

      //Recuperation
      $apps = AppHelper::GetByParameters($this->Core);
      $view->AddElement($apps);

      return $view->Render();
    }
 }?>
