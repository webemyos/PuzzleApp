<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Feedback\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
use Core\Control\EntityGrid\EntityGrid;
use Core\Control\EntityGrid\EntityColumn;
use Core\Control\EntityGrid\EntityIconColumn;
use Core\Control\Grid\IconColumn;
use Apps\Feedback\Entity\FeedbackFeedback;

/*
 * 
 */
 class HomeController extends Controller
 {
    /**
     * Constructeur
     */
    function _construct($core="")
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
         return $this->Index();
    }
    
    /*
    * Get the home page
    */
   function Index()
   {
       $view = new View(__DIR__."/View/index.tpl", $this->Core);

       $gdFeedback = new EntityGrid("gdFeedback", $this->Core);
       $gdFeedback->Entity = "Apps\Feedback\Entity\FeedbackFeedback";
       $gdFeedback->App = "Feedback";
       $gdFeedback->Action = "GetFeedback";
       $gdFeedback->AddOrder("Id desc", false);
       
       $gdFeedback->AddColumn(new EntityColumn("Label", "Label"));
       $gdFeedback->AddColumn(new EntityColumn("DateCreated", "DateCreated"));
       $gdFeedback->AddColumn(new EntityIconColumn("", 
                                               array(array("EditIcone", "FeedbackAction.EditFeedback", "FeedbackAction.EditFeedback"),
                                               )    
                           ));
       
       $view->AddElement($gdFeedback);

       return $view->Render();
   }

   /** Affiche le détail d'un feedback */
   function EditFeedback($feedbackId)
   {
        $view = new View(__DIR__."/View/editFeedback.tpl", $this->Core);

        //Récupération du feedback
        $feedback = new FeedBackFeedback($this->Core);
        $feedback->GetById($feedbackId);

        $view->AddElement($feedback);

        return $view->Render();
   }
          
          /*action*/
 }?>