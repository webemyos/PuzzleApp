<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader;

use Apps\Downloader\Entity\DownloaderRessource;
use Apps\Downloader\Entity\DownloaderRessourceContact;
use Apps\Downloader\Helper\RessourceHelper;
use Apps\Downloader\Module\Front\FrontController;
use Apps\Downloader\Module\Ressource\RessourceController;
use Core\App\Application;
use Core\Core\Core;
use Core\Core\Request;
use Core\Utility\File\File;


class Downloader extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Downloader";

    /**
     * Constructeur
     * */
    function __construct($core)
    {
        parent::__construct($core, "Downloader");
        $this->Core = $core;
    }

    /*
     * Download a Document
     */
    function Download($params)
    {
        $this->Core->MasterView->Set("Title", "Download");
         
        $frontController = new FrontController($this->Core);
        return $frontController->DownLoad($params);
    }
    
     /**
      * Execution de l'application
      */
    function Run()
    {
       echo parent::Run($this->Core, "Downloader", "Downloader");
    }
     
    /*
     * Pop in d'ajout de ressource
     */
    public function ShowAddRessource()
    {
        $ressourceController = new RessourceController($this->Core);
        echo $ressourceController->ShowAddRessource(Request::GetPost("RessourceId"));
    }

    /*
     * Save the ressource
     */
    public function SaveRessource()
    {
        RessourceHelper::SaveRessource($this->Core,
                                        Request::GetPost("RessourceId"),
                                        Request::GetPost("tbRessourceName"),
                                        Request::GetPost("tbRessourceDescription")    
                );
    }
    
    /**
     * Sauvegare les images de presentation
     */
    function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
    {
      $core = Core::getInstance();

      $directory = "Data/Apps/Downloader";
      //Ajout de l'image dans le repertoire correspondant

      File::CreateDirectory($directory);
      //Add the user Directory
      $directory .= "/" . $core->User->IdEntite;
      File::CreateDirectory($directory);

       switch($action)
       {
           case "UploadRessource":

               $ressource = new DownloaderRessource($core);
               $ressource->GetById($idElement);
               $ressource->Url->Value = $directory."/".$fileName;
               $ressource->Save();

            //Sauvegarde
            move_uploaded_file($tmpFileName, $directory."/".$fileName);

            break;
       }
    }

    /*
     * Charge les ressources de l'utilisater
     */
    function LoadMyRessource()
    {
        $ressourceController = new RessourceController($this->Core);
        echo $ressourceController->LoadMyRessource();
    }

    /**
     * Affiche le lien d'une ressources avec un champ de saisie
     * d'email
     */
    function ShowRessource($ressourceId, $content)
    {
        $html = "<script type ='text/javascript' src='Apps/Downloader/Downloader.js' ></script>";
        $html .= "<span><p style='cursor:pointer' onclick='DownloaderAction.ShowEmailDownload(".$ressourceId.", this)' >".$content."</p><span>";

        return $html;
    }

    /**
     * Sauvegarde l'email pour la ressource
     */
    function SaveEmail()
    {
        //Recuperationde la ressource
        $ressource = new DownloaderRessource($this->Core);
        $ressource->GetById(Request::GetPost("ressourceId"));

        //Enregistrement du contact
        $contact = new DownloaderRessourceContact($this->Core);
        $contact->RessourceId->Value = $ressource->IdEntite;
        $contact->Email->Value =  Request::GetPost("email");
        $contact->Save();

        echo $ressource->Url->Value;
    }

    /**
     * Affiche les contacts de la ressource
     */
    function ShowContact()
    {
        $ressourceController = new RessourceController($this->Core);
        echo $ressourceController->ShowContact(Request::GetPost("RessourceId"));
    }

    /**
    * Obtient le nombre d element
    */
   public function GetNumber($entity)
   {
       $projet = new $entity($this->Core);
       return count($projet->GetAll());
   }
   
   /*
    * Retourne les ressources disponible en téléchargement
    */
   public function GetRessources()
   {
       return RessourceHelper::GetAll($this->Core);
   }
}
?>
