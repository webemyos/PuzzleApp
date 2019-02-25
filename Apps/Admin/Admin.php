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
use Core\App\Application;

/**
 * Description of Admin
 *
 * @author OLIVA
 */
class Admin extends Application
{
     /*
     * Créate de app Base
     */
    public function __construct()
    {
        $this->Core = Core::getInstance();
        parent::__construct($this->Core, "Admin");
    }
    
    /**
     * Set Admin Public
     */
    public function GetRoute()
    {
        $this->Route->SetPublic(array("Admin"));
        return $this->Route;
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
