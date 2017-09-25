<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader;

 use Core\Core\Core;
 use Core\App\Application;
 use Core\Core\Request;
 use Core\Utility\File\File;
 use Core\Entity\Entity\Argument;              
 
 use Apps\Downloader\Entity\DownloaderRessource;
 use Apps\Downloader\Entity\DownloaderRessourceContact;
 use Apps\Downloader\Module\Ressource\RessourceController;

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

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "Downloader", "Downloader");
	 	echo $textControl;
	 }
        /*
         * Pop in d'ajout de ressource
         */
        public function ShowAddRessource()
        {
            $ressourceController = new RessourceController($this->Core);
            echo $ressourceController->ShowAddRessource();
        }

                /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
          $core = Core::getInstance();
           
            $directory = "Data/Apps/Downloader/".$core->User->IdEntite;
           //Ajout de l'image dans le repertoire correspondant
       
           File::CreateDirectory($directory);

           switch($action)
           {
               case "UploadRessource":

                   $ressource = new DownloaderRessource($core);
                   $ressource->Url->Value = str_replace("../Data/", "Data/", $directory."/".$fileName);
                   $ressource->UserId->Value = $core->User->IdEntite;
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
           $contact = new DownloaderRessourceContact($this->Core);
           $contact->AddArgument(new Argument("Apps\Downloader\Entity\DownloaderRessourceContact", "RessourceId", EQUAL, Request::GetPost("RessourceId")));

           $contacts = $contact->GetByArg();

           $html = "";

           if(count($contacts) > 0)
           {
               $html .= "<ul style='text-align:left'>";
               foreach($contacts as $contact)
               {
                   $html .= "<li>".$contact->Email->Value."</li>";
               }

               $html .= "</ul>";

               echo $html;
           }
           else
           {
               echo $this->Core->GetCode("Downloader.NoContact");
           }

        }

        /**
        * Obtient le nombre d element
        */
       public function GetNumber($entity)
       {
           $projet = new $entity($this->Core);
           return count($projet->GetAll());
       }
}
?>
