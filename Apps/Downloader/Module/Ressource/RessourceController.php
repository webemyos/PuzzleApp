<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader\Module\Ressource;

use Apps\Downloader\Entity\DownloaderRessource;
use Apps\Downloader\Helper\RessourceHelper;
use Core\Control\Link\Link;
use Core\Control\Upload\Upload;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;

 class RessourceController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
          $this->Core = $core;
    }

    /**
     * Creation
     */
    function Create()
    {
    }

    /**
     * Initialisation
     */
    function Init()
    {
    }

    /**
     * Affichage du module
     */
    function Show($all=true)
    {
    }

    /**
     * Ajout d'une ressources
     */
    function ShowAddRessource()
    {
       //Ajout de la photo de profil
       $uploadAjax = new Upload("Downloader", "", "DownloaderAction.LoadMyRessource()", "UploadRessource", "EeFileUpload");

       return $uploadAjax->Show(true);
    }

    /**
     * Charge les blogs de l'utilisateur
     */
    function LoadMyRessource()
    {
        $html ="<div class='content-panel'>";

        $ressource = new DownloaderRessource($this->Core);
        $ressource->AddArgument(new Argument("Apps\Downloader\Entity\DownloaderRessource", "UserId", EQUAL, $this->Core->User->IdEntite));
        $ressources = $ressource->GetByArg();

        if(count($ressources)> 0)
        {
            //Ligne D'entete
            $html .= "<div class='download'>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("EeRessource.Name")."</b></div>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("EeRessource.NumberContact")."</b></div>";

            $html .= "</div>";

            foreach($ressources as $ressource)
            {
               $html .= "<div class='download'>";
               $html .= "<div> ".$ressource->Url->Value."</div>";

               $number = RessourceHelper::GetNumberEmail($this->Core,$ressource->IdEntite );

               //Lien pour afficher le détail
               $lkDetail = new Link($number, "#");
               $lkDetail->OnClick ="DownloaderAction.LoadContact(".$ressource->IdEntite.")";

               $html .= "<div> ".$lkDetail->Show()."</div>";
               $html .= "</div>";
            }
        }
        else
        {
            $html = $this->Core->GetCode("EeBlog.NoRessource");
        }

        $html .= "</div>";
        return $html;
    }

          /*action*/
 }?>
