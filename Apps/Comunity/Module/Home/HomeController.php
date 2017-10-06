<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Home;

use Core\Control\Button\Button;
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
       $view = new View(__DIR__ . "/View/HomeBlock.tpl", $this->Core);

      //Mur utilistauer
      $btnMyWall = new Button(BUTTON, "btnMyWall");
      $btnMyWall->Value = $this->Core->GetCode("EeComunity.MyWall");
      $btnMyWall->CssClass = "btn btn-info";
      $btnMyWall->OnClick = "EeComunityAction.LoadMyWall();";
      $view->AddElement($btnMyWall);

      //Communauté de l'utilisateur
      $btnMyComunity= new Button(BUTTON, "btnMyComunity");
      $btnMyComunity->Value = $this->Core->GetCode("EeComunity.MyComunity");
      $btnMyComunity->CssClass = "btn btn-success";
      $btnMyComunity->OnClick = "EeComunityAction.LoadMyComunity();";
      $view->AddElement($btnMyComunity);

      //Annuaire des communautés
      $btnComunity= new Button(BUTTON, "btnComunity");
      $btnComunity->Value = $this->Core->GetCode("EeComunity.Comunity");
      $btnComunity->CssClass = "btn btn-success";
      $btnComunity->OnClick = "EeComunityAction.LoadComunity();";
      $view->AddElement($btnComunity);

      return $view->Render();
   }
 }?>