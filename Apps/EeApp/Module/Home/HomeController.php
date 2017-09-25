<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Module\Home;

use Apps\EeApp\EeApp;
use Core\Control\Button\Button;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\View\View;

/**
 * Module d'accueil
 * */
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

        //Bouton mes applications
        $btnMyApp = new Button(BUTTON, "btnMyApp");
        $btnMyApp->Value = $this->Core->GetCode("EeApp.MyApp");
        $btnMyApp->CssClass = "btn btn-info";
        $btnMyApp->OnClick = "EeAppAction.LoadMyApp();";
        $view->AddElement($btnMyApp);

        //Fichier Partage
        $btnShowApp= new Button(BUTTON, "btnShowApp");
        $btnShowApp->Value = $this->Core->GetCode("EeApp.Apps");
        $btnShowApp->CssClass = "btn btn-success";
        $btnShowApp->OnClick = "EeAppAction.LoadApps();";
        $view->AddElement($btnShowApp);

        if(EeApp::IsAdmin($this->Core, "EeApp", $this->Core->User->IdEntite))
        {
            $btnAdmin = new Button(BUTTON, "btnAdmin");
            $btnAdmin->Value = $this->Core->GetCode("EeApp.Admin");
            $btnAdmin->CssClass = "btn btn-danger";
            $btnAdmin->OnClick = "EeAppAction.LoadAdmin();";
            $view->AddElement($btnAdmin);
        }
        else
        {
            $view->AddElement(new Text("btnAdmin"));
        }
   
        return $view->Render();
    }
 }?>