<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Module\Home;

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
    * Obtient le menu
    */
   function Show()
   {
       $modele = new View(__DIR__ . "/View/Home.tpl", $this->Core);

       $btnInformation = new Button(BUTTON, "btnInformation");
       $btnInformation->CssClass = "btn btn-success";
       $btnInformation->Value = $this->Core->GetCode("Profil.MyInformation");
       $btnInformation->OnClick = "ProfilAction.LoadInformation()";
       $modele->AddElement($btnInformation);

       $btnCompetence = new Button(BUTTON, "btnCompetence");
       $btnCompetence->CssClass = "btn btn-info";
       $btnCompetence->Value = $this->Core->GetCode("Profil.MyCompetence");
       $btnCompetence->OnClick = "ProfilAction.LoadCompetence()";
       $modele->AddElement($btnCompetence);

       if(EeApp::isAdmin($this->Core, "Profil", $this->Core->User->IdEntite))
       {
          $btnAdmin = new Button(BUTTON, "btnAdmin");
          $btnAdmin->Value = "App.Admin";
          $btnAdmin->CssClass = "btn btn-danger";
          $btnAdmin->OnClick = "ProfilAction.LoadAdmin();";
          $modele->AddElement($btnAdmin);
       }
       else
       {
          $modele->AddElement(new Text("btnAdmin"));
       }
      
       return $modele->Render();
   }
 }?>