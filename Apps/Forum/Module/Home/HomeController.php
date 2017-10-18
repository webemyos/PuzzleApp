<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Home;

use Apps\EeApp\EeApp;
use Core\Control\Button\Button;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\View\View;



 class HomeController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
        $this->Core = $core;
    }

    /**
     * Creation
     */
    function Create()
    {
    }

    /**
     * Initialisation
     */
    function Init()
    {
    }

    /**
     * Affichage du module
     */
    function Show($all=true)
    {
      $modele = new View(__DIR__ . "/View/Home.tpl", $this->Core);

      $btnHome = new Button(BUTTON, "btnHome");
      $btnHome->Value = $this->Core->GetCode("Forum.Home");
      $btnHome->CssClass = "btn btn-info";
      $btnHome->OnClick = "ForumAction.ShowDefaultForum();";
      $modele->AddElement($btnHome);
      
      $btnMyForum = new Button(BUTTON, "btnForum");
      $btnMyForum->Value = $this->Core->GetCode("Forum.MyForum");
      $btnMyForum->CssClass = "btn btn-info";
      $btnMyForum->OnClick = "ForumAction.LoadMyForum();";
      $modele->AddElement($btnMyForum);

      if(EeApp::isAdmin($this->Core, "App", $this->Core->User->IdEntite))
      {
          $btnAdmin = new Button(BUTTON, "btnAdmin");
          $btnAdmin->Value = "App.Admin";
          $btnAdmin->CssClass = "btn btn-danger";
          $btnAdmin->OnClick = "ForumAction.LoadAdmin();";
          $modele->AddElement($btnAdmin);
      }
      else
      {
          $modele->AddElement(new Text("btnAdmin"));
      }

      return $modele->Render();
    }


    /*
    * Affiche la page d'accueil
    */
     function ShowHome()
    {
        $this->SetTemplate(__DIR__. "/View/ShowHome.tpl");
        $this->AddParameters(array("!title" => $this->Core->GetCode("Forum.Title") ));
        return $this->Render();
    }
    
  /*action*/
 }?>