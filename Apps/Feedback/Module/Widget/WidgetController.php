<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Feedback\Module\Widget;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

use Apps\Feedback\Model\FeedbackModel;

/*
 * 
 */
 class WidgetController extends Controller
 {
    /**
     * Constructeur
     */
    function _construct($core="")
    {
          $this->Core = $core;
    }
    
    /**
     * Affiche le widet
     */
    function Index()
    {
        $view = new View(__DIR__."/View/widget.tpl", $this->Core);
        return $view->Render();
    }

    /**
     * Add A feedback
     */
    function ShowAddFeed()
    {
        $view = new View(__DIR__."/View/showAddFeed.tpl", $this->Core);
     
        //Modele pour ajouter un ambassadeur
        //Add Message Modele
        $modele = new FeedbackModel($this->Core, $reseauId);
                        
        // Set modele vith Ajax
        $view->SetModel($modele, true);
        $view->SetApp("Feedback");
        $view->SetClass("Widget");
        $view->SetAction("ShowAddFeed");
       
        return $view->Render();
    }

}