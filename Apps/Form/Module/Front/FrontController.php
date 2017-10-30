<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Module\Front;

use Apps\Form\Entity\FormForm;
use Apps\Form\Helper\FormHelper;
use Apps\Form\Helper\QuestionHelper;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\View\ElementView;
use Core\View\View;


class FrontController extends Controller
{
    
    function __construct($core = "")
    {
        parent::__construct($core);
    }
    
    /*
     * Show All Mooc
     */
    function Index($params)
    {
        if(Request::GetPost() != null)
        {   
            FormHelper::SaveReponseUser($this->Core, Request::GetPost());
            
            $view = new View(__DIR__."/View/valid.tpl", $this->Core);
        }
        else
        {
            $view = new View(__DIR__."/View/index.tpl", $this->Core);

            //Get the Form
            $form = new FormForm($this->Core);
            $form = $form->GetByCode($params);

            $view->AddElement(new ElementView("Form", $form));

            //Get the question
            $view->AddElement(new ElementView("Questions", QuestionHelper::GetByForm($this->Core, $form)));
        }
        
        return $view->Render();

    }
}
