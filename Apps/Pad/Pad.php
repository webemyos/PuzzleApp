<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Pad;

use Apps\Downloader\Entity\PadDocument;
use Apps\Pad\Helper\DocumentHelper;
use Apps\Pad\Module\Document\DocumentController;
use Core\App\Application;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Utility\ImageHelper\ImageHelper;

class Pad extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'DashBoardManager';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Pad";

	/**
	 * Constructeur
	 * */
	 function Pad($core)
	 {
	 	parent::__construct($core, "Pad");
	 	$this->Core = $core;
        }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "Pad", "Pad");
	 	echo $textControl;
	 }
         
        /**
         * Pop in d'ajout de doc
         */
        function ShowAddDoc()
        {
            $docBlock = new DocumentController($this->Core);
            echo $docBlock->ShowAddDoc(Request::GetPost("AppName"), Request::GetPost("EntityName"), Request::GetPost("EntityId"));
        }
        
        /**
         * Enregustre le nouveau document
         */
        function SaveDoc()
        {
            $name = Request::GetPost("tbDocName");
            
            if($name != "")
            {
                echo "<span class='success'>".$this->Core->GetCode("Pad.DocCreated")."</span>";
                DocumentHelper::SaveDoc($this->Core, 
                                   $name,
                                   Request::GetPost("AppName"),
                                   Request::GetPost("EntityName"),
                                   Request::GetPost("EntityId"));
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Pad.ErrorName")."</span>";
                $this->ShowAddDoc();
            }
        }
        
        /**
         * Charge les fichiers de l'utilisateur
         */
        function LoadMyDoc()
        {
            $docBlock = new DocumentController($this->Core);
            echo $docBlock->LoadMyDoc();
        }
        
        /*
         * Edite un document
         */
        function EditDocument()
        {
            $docBlock = new DocumentController($this->Core);
            echo $docBlock->EditDocument(Request::GetPost("DocumentId")); 
        }
        
        /**
         * Met à jour le contenu d'un document
         */
        function UpdateContent()
        {
            DocumentHelper::SaveContent($this->Core, Request::GetPost("DocumentId"), Request::GetPost("content"));
            
            echo $this->Core->GetCode("SaveOK");
        }
        
        /**
         * Sauvegare un document pour une APP
         */
        function SaveByApp($name, $appName, $entityName, $entityId)
        {
            return DocumentHelper::SaveByApp($this->Core, $name, $appName, $entityName, $entityId);
        }
        
        /**
         * Obtient les blgo lié a une App
         */
        function GetByApp($appName, $entityName, $entityId)
        {
            return DocumentHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
        }
        
        /**
         * Obtient un document par son identifiant
         */
        function GetDocumentById($documentId)
        {
            $document = new PadDocument($this->Core);
            $document->GetById($documentId);
            
            return $document;
        }
        
         /**
         * Obtient les images du blogs
         * format niormal et mini
         */
        function GetImages()
        {
            echo DocumentHelper::GetImages($this->Core);
        }
        
         /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "../Data/Apps/Pad/";
           
           $idElement = $this->Core->User->IdEntite;
        
           File::CreateDirectory($directory. $idElement);
            //Sauvegarde
            move_uploaded_file($tmpFileName, $directory.$idElement."/".$fileName);

            //Crée un miniature
            $image = new ImageHelper();
            $image->load($directory.$idElement."/".$fileName);
            $image->fctredimimage(48, 0,$directory.$idElement."/".$fileName."_96.jpg");
        }
        
        /*
         * Charge les documents partagé avec moi
         */
        function LoadSharedDoc()
        {
            $docBlock = new DocumentController($this->Core);
            echo $docBlock->LoadSharedDoc();
        }
        
        /*
         * Pop in pour partager un document
         */
        function ShowShareFile()
        {
             $docBlock = new DocumentController($this->Core);
            echo $docBlock->ShowShareFile(Request::GetPost("DocId"));
        }
        
        /**
         * Ajoute un ou plusieurs utilisateur ou dossier
         */
        function AddUserDoc()
        {
            DocumentHelper::AddUser($this->Core, Request::GetPost("DocId"), Request::GetPost("UsersId") );
            
            $docBlock = new DocumentController($this->Core);
            echo $docBlock->GetUser(Request::GetPost("DocId"));
        }
        
        /**
         * Supprime un partage
         */
        public function RemoveUser()
        {
            if (DocumentHelper::RemoveUser($this->Core, Request::GetPost("ShareId")))
            {
                echo "success";
            }
            else
            {
                echo "error";
            }
        }
        
        
}
?>