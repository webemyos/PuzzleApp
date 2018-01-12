<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

 class HomeController extends Controller
 {
    /**
     * Constructeur
     */
    function HomeBlock($core="")
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
        $view = new View(__DIR__ . "/View/home.tpl", $this->Core);

        //Bouton pour créer un blog
        $btnNewBlog = new Button(BUTTON, "btnNewBlog");
        $btnNewBlog->Value = $this->Core->GetCode("Blog.NewBlog");
        $btnNewBlog->CssClass = "btn btn-info";
        $btnNewBlog->OnClick = "BlogAction.ShowAddBlog();";
        $view->AddElement($btnNewBlog);
        
        $btnMyBlog = new Button(BUTTON, "btnMyBlog");
        $btnMyBlog->Value = $this->Core->GetCode("Blog.MyBlog");
        $btnMyBlog->CssClass = "btn btn-success";
        $btnMyBlog->OnClick = "BlogAction.LoadMyBlog();";
        $view->AddElement($btnMyBlog);

        return $view->Render();
    }
 }?>