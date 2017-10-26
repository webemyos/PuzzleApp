<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Module\Front;

use Core\Controller\Controller;
use Core\View\View;


class FrontController extends Controller
{
    /*
     * DownLoad à file
     */
    public function DownLoad($params)
    {
        if($this->Core->isConnected())
        {
            echo "Connected";
        }
        else
        {
           $view = new View(__DIR__."/View/notConnected.tpl", $this->Core);
           return $view->Render();
        }
    }
}
