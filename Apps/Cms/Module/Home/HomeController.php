<?php
/**
 * Module d'accueil
 * */
namespace Apps\Cms\Module\Home;

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
        $view = new View(__DIR__ ."/View/Home.tpl", $this->Core);

        //Bouton pour créer un blog
        $btnNewCms = new Button(BUTTON, "btnNewCms");
        $btnNewCms->Value = $this->Core->GetCode("EeCms.NewCms");
        $btnNewCms->CssClass = "btn btn-info";
        $btnNewCms->OnClick = "CmsAction.ShowAddCms();";
        $view->AddElement($btnNewCms);

        $btnMyCms = new Button(BUTTON, "btnMyCms");
        $btnMyCms->Value = $this->Core->GetCode("EeCms.MyCms");
        $btnMyCms->CssClass = "btn btn-success";
        $btnMyCms->OnClick = "CmsAction.LoadMyCms();";
        $view->AddElement($btnMyCms);

        return $view->Render();
    }
 }?>
