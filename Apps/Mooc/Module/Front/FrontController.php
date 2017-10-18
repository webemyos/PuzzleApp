<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Front;

use Core\Controller\Controller;
use Core\View\View;


class FrontController extends Controller
{
   
    private $Blog;
    
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
        
        return $view->Render();
    }
}


