<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Module\Home;

use Apps\Message\Helper\MessageHelper;
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
        $view = new View(__DIR__ . "/View/Home.tpl", $this->Core);
        
        //Bouton pour créer ajouter une ressource
        $btnNewRessource = new Button(BUTTON, "btnNewRessource");
        $btnNewRessource->Value = $this->Core->GetCode("Downloader.NewRessource");
        $btnNewRessource->CssClass = "btn btn-info";
        $btnNewRessource->OnClick = "DownloaderAction.ShowAddRessource();";
        $view->AddElement($btnNewRessource);
        
        $btnMyRessource = new Button(BUTTON, "btnMyRessource");
        $btnMyRessource->Value = $this->Core->GetCode("Downloader.MyRessource");
        $btnMyRessource->CssClass = "btn btn-success";
        $btnMyRessource->OnClick = "DownloaderAction.LoadMyRessource();";
        $view->AddElement($btnMyRessource);
 
        return $view->Render();
    }
 }?>
