<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Front;

use Apps\Mooc\Entity\MoocLesson;
use Apps\Mooc\Entity\MoocMooc;
use Apps\Mooc\Helper\MoocHelper;
use Core\Controller\Controller;
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
    function Index()
    {
        $view = new View(__DIR__."/View/index.tpl", $this->Core);
        
        $view->AddElement(new ElementView("Mooc", MoocHelper::GetAll($this->Core)));
        
        return $view->Render();
    }
    
    /*
     * Détail of a mooc
     */
    function Mooc($params, $lesson = null)
    {
        $view = new View(__DIR__."/View/mooc.tpl", $this->Core);
        
        //Get The Mooc
        $mooc = new MoocMooc($this->Core);
        $mooc = $mooc->GetByCode($params);
        $view->AddElement(new ElementView("Mooc", $mooc));
        
        //Get The Lesson
        $lessons = MoocHelper::GetLesson($this->Core, $mooc->IdEntite, true, true);
        
        if($lesson == null)
        {
            $view->AddElement(new ElementView("Intro", $lessons[0]));
        }
        else
        {
            $view->AddElement(new ElementView("Intro", $lesson));
        }
        
        $view->AddElement(new ElementView("Lessons", $lessons));
        
        return $view->Render();
    }
    
    /*
     * Détail of a lesson
     */
    function Lesson($params)
    {
        //Get The Lesson
        $lesson = new MoocLesson($this->Core);
        $lesson = $lesson->GetByCode($params);
                
        return $this->Mooc($lesson->Mooc->Value->Code->Value, $lesson);
    }
    
}


