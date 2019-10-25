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
use Core\App\Application;

class Membre extends Application
{
     /*
     * Créate de app Base
     */
    public function __construct()
    {
        $this->Core = Core::getInstance();
        parent::__construct($this->Core, "Membre");
    }
    
     /**
     * Set Admin Public
     */
    public function GetRoute()
    {
        $this->Route->SetPublic(array("Membre"));
        return $this->Route;
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
