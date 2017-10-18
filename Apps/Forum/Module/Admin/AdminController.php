<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Admin;

use Apps\Forum\Helper\ForumHelper;
use Core\Controller\Controller;
use Core\View\View;

class AdminController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core="")
    {
       $this->Core = $core;
    }
    
    /*
     * Show the Admin 
     */
    function Show()
    {
        $view = new View(__DIR__ ."/View/index.tpl", $this->Core);
        
        //Get The forum
        $view->AddElement(ForumHelper::GetAll($this->Core));
        
        return $view->Render();
    }
}
