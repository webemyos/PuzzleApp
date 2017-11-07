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
use Core\Core\Request;
use Core\View\View;


class FrontController extends Controller
{
    /*
     * DownLoad à file
     */
    public function DownLoad($params)
    {
        //Find the Ressource
        $ressource = new DownloaderRessource($this->Core);
        $ressource = $ressource->GetByCode($params);
        
        if($ressource != false)
        {
            if($this->Core->isConnected() || Request::GetPost("email") || Request::GetSession("downloader.email"))
            {
                //Save the stat Upload
                $contact = new DownloaderRessourceContact($this->Core);
                
                if($this->Core->isConnected())
                {
                    $contact->UserId->Value = $this->Core->User->IdEntite;
                }
                else if(Request::GetSession("downloader.email"))
                {
                    $contact->Email->Value = Request::GetSession("downloader.email");
                }
                else
                {
                    $contact->Email->Value = Request::GetPost("email"); 
                    Request::SetSession("downloader.email", Request::GetPost("email"));
                }
                $contact->RessourceId->Value = $ressource->IdEntite;
                $contact->Save();

                header("location:". Core::GetPath("/".$ressource->Url->Value));
            }
            else
            {
               $view = new View(__DIR__."/View/notConnected.tpl", $this->Core);
               $view->AddElement($ressource);

               return $view->Render();
            }
        }
        else
        {
            $view = new View(__DIR__."/View/unknowRessource.tpl", $this->Core);

            return $view->Render();
        }
    }
}
