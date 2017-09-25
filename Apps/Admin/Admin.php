<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Admin;

use Apps\Admin\Module\DashBoard\DashBoardController;
use Core\Core\Core;


/**
 * Description of Admin
 *
 * @author OLIVA
 */
class Admin 
{
     /*
     * Créate de app Base
     */
    public function __construct()
    {
        $this->Core = Core::getInstance();
    }
    
    /*
     * Get the master View
     */
    public function GetMasterView()
    {
        $dashBoardController = new DashBoardController();
        return $dashBoardController->GetMasterView();
    }
    
    /*
     * Home page 
     */
    public function Admin()
    {
    }
}
