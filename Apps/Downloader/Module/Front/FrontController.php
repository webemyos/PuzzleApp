<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Module\Front;

use Apps\Downloader\Entity\DownloaderRessource;
use Apps\Downloader\Entity\DownloaderRessourceContact;
use Core\Controller\Controller;
use Core\Core\Core;
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
            //Find the Ressource
            $ressource = new DownloaderRessource($this->Core);
            $ressource = $ressource->GetByCode($params);
            
            if($ressource != false)
            {
                //Save the stat Upload
                $contact = new DownloaderRessourceContact($this->Core);
                $contact->UserId->Value = $this->Core->User->IdEntite;
                $contact->RessourceId->Value = $ressource->IdEntite;
                $contact->Save();
                    
                header("location:". Core::GetPath("/".$ressource->Url->Value));
            }
            else
            {
                $view = new View(__DIR__."/View/unknowRessource.tpl", $this->Core);
                return $view->Render();
            }
        }
        else
        {
           $view = new View(__DIR__."/View/notConnected.tpl", $this->Core);
           return $view->Render();
        }
    }
}
