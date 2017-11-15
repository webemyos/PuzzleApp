<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Membre;

use Apps\Base\Module\Front\FrontController;
use Apps\Membre\Module\DashBoard\DashBoardController;
use Core\Core\Core;

class Membre 
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
        //Use The Principalemaster view 
        $frontController = new FrontController($this->Core);
        return $frontController->GetMasterView();
    }
    
    /*
     * Dashboard page
     */
    public function Membre()
    {
       $this->Core->MasterView->Set("Title", "Membre");
         
       $dashboardController = new DashBoardController($this->Core);
       return $dashboardController->Index();
    }
}
