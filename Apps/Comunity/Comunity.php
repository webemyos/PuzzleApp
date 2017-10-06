<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity;

use Apps\Blog\Module\Comment\CommentController;
use Apps\Comunity\Entity\ComunityMessage;
use Apps\Comunity\Helper\CommentHelper;
use Apps\Comunity\Helper\ComunityHelper;
use Apps\Comunity\Module\Comment\PostController;
use Apps\Comunity\Module\Comunity\ComunityController;
use Apps\Comunity\Module\Publication\WallController;
use Apps\Forum\Helper\MessageHelper;
use Core\App\Application;
use Core\Control\Image\Image;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;
use Core\Utility\File\File;

class Comunity extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'DashBoardManager';
	public $Version = '1.0.0';
        public static $Directory = "Apps/Comunity";

	/**
	 * Constructeur
	 * */
	 function Comunity($core)
	 {
	 	parent::__construct($core, "Comunity");
	 	$this->Core = $core;
    	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "Comunity", "Comunity");
	 	echo $textControl;
	 }
        
        /**
         * Charge le mur de l'utilisateur
         */
        public function LoadMyWall($show = true)
        {
            $wallController = new WallController($this->Core);
            
            if($show)
            {
                echo $wallController->LoadMyWall();
            }
            else
            {
                return $wallController->LoadMyWall();
            }
        }
        
        /**
         * Charge la liste des comunautés de l'utilisateur
         */
        public function LoadMyComunity()
        {
            $comunityController = new ComunityController($this->Core);
            echo $comunityController->LoadMyComunity();
        }
        
        /**
         * Charge la liste des comunautés
         */
        public function LoadComunity()
        {
            $comunityController = new ComunityController($this->Core);
            echo $comunityController->Load();
        }
        
                /**
         * Ajoute une app à l'utilisateur
         */
        public function Add()
        {
            $comunityId = Request::GetPost("comunityId");
            
            if(ComunityHelper::Add($this->Core, $comunityId ))
            {
                echo $this->Core->GetCode("Comunity.ComunityAdded");
            }
            else
            {
                echo $this->Core->GetCode("Comunity.ErrorAdded");
            }
        }
        
              /**
         * Supprime une app au bureau
         */
        public function Remove()
        {
            $comunityId = Request::GetPost("comunityId");
            
            ComunityHelper::Remove($this->Core, $comunityId);
        }
        
        /**
         * Publie un message
         */
        public function PublishMessage()
        {
           $idMEssage = MessageHelper::Publish($this->Core, 
                                  Request::GetPost("message"),
                                  Request::GetPost("comunityId")); 
          
           //Affiche le message posté
          $postController = new PostController($this->Core);
          
          //App Prpfil
          $Profil = DashBoardManager::GetApp("Profil", $this->Core);
            
          echo $postController->ShowMessage($idMEssage, null, $Profil);
        }
        
        /**
         * Modifie un message
         */
        public function UpdateMessage()
        {
            MessageHelper::UpdateMessage($this->Core, Request::GetPost("messageId"), Request::GetPost("message"));
        }
        
        /**
         * Supprilme un message
         */
        public function RemoveMessage()
        {
            MessageHelper::RemoveMessage($this->Core, Request::GetPost("messageId"));
        }
        
        /**
         * Ajoute un commentaire
         */
        public function AddComment()
        {
           $idComment = MessageHelper::AddComment($this->Core, Request::GetPost("messageId"), Request::GetPost("comment")); 
          
           //Recuperation du message
           $message = new ComunityMessage($this->Core);
           $message->GetById(Request::GetPost("messageId"));
                   
           //Envoie une notification
           if($message->UserId->Value !=  $this->Core->User->IdEntite)
           {
                $Notify = DashBoardManager::GetApp("Notify", $this->Core);
                $Notify->AddNotify($this->Core->User->IdEntite, $this->Core->GetCode("Notify.CommentAdded"), $message->UserId->Value,
                                "Comunity", $message->IdEntite,  $this->Core->GetCode("Notify.EmailSubjectCommentAdded"),  Request::GetPost("comment"));
           }
           
          //Affiche le message posté
          $postController = new PostController($this->Core);
          
          //App Prpfil
          $Profil = DashBoardManager::GetApp("Profil", $this->Core);
            
          echo $postController->ShowComment($idComment, null, $Profil);
        }
        
        /**
         * Supprime un commentaire
         */
        public function RemoveComment()
        {
            MessageHelper::RemoveComment($this->Core, Request::GetPost("commentId"));
        }
        
        /**
         * Met a jour un commentaire
         */
        public function UpdateComment()
        {
            MessageHelper::UpdateComment($this->Core, Request::GetPost("commentId"), Request::GetPost("comment"));
        }
        
         /**
         * Upload un document
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
               // $urlDirectory =  "Data/Apps/Comunity/"."".;
                
            	if(file_exists("Data"))
        	{
                    //Repertoire
                    $directory = "Data/Apps/Comunity/";
           	}
           	else
           	{
                    //Repertoire
                    $directory = "../Data/Apps/Comunity/";
           	}
           
           
            //Creation du repertoire de l'espace
            $directory = $directory."".$this->Core->User->IdEntite;
            
            File::CreateDirectory($directory);
        
         
           switch($action)
           {
               case "AddImage":
                
                    //Sauvegarde
                    move_uploaded_file($tmpFileName, $directory."/tmp.png");
                break;
           }
        }
        
        /**
         * Obtient la dernier image uploadé
         */
        function GetLastUpload()
        {
            	if(file_exists("Data"))
        	{
                    //Repertoire
                    $directory = "Data/Apps/Comunity/";
           	}
           	else
           	{
                    //Repertoire
                    $directory = "../Data/Apps/Comunity/";
           	}
        
                $directory = $directory."".$this->Core->User->IdEntite;
        
                $img= new Image($directory."/tmp.png?r=".rand(0, 1000));
                
                echo $img->Show();
        }
        
        /**
         * Module permettant de laisse un commentaire sur une entité
         * @param type $app
         * @param type $entityName
         * @param type $entityId
         */
        function GetCommentController($app, $entityName, $entityId, $showAddController = true)
        {
            $commentController = new CommentController($this->Core);
            return $commentController->Load($app, $entityName, $entityId, $showAddController);
        }
        
        /**
         * Ajoute un commentaire pour une app
         */
        function AddCommentApp()
        {
            $appName = Request::GetPost("AppName");
            $entityName = Request::GetPost("EntityName");
            $entityId = Request::GetPost("EntityId");
            $comment = Request::GetPost("tbComment");
            $name = Request::GetPost("tbName");
            $email = Request::GetPost("tbEmail");
            
            if($appName != "" && $entityName != "" && $entityId != "")
            {
                CommentHelper::AddCommentApp($this->Core, 
                                             $appName, 
                                             $entityName, 
                                             $entityId, 
                                             $comment, 
                                             $name,
                                             $email);
                
                echo "<span class='success'>".$this->Core->GetCode("Comment.CommentAdded")."</span>";
                echo $this->GetCommentController($appName, $entityName, $entityId, false);
            }
            else
            {
            
                echo $this->GetCommentController($appName, $entityName, $entityId);
            }
        }
        
        /*
         * Obtient les comentaires sur une entite d'un app
         */
        function GetCommentByApp($appName, $EntityName, $entityId)
        {
            return CommentHelper::GetByApp($this->Core, $appName, $EntityName, $entityId);
        }
        
        /*
         * Publie/Depublie un commentaire
         */
        function PublishComment($commentId, $state)
        {
           return CommentHelper::Publish($this->Core, $commentId, $state);
        }
        
        /**
         * Affichage du dernier message de communaute de l'user
         */
        function GetInfo()
        {
            $html = "qui pourrait maider";
            return $html;
        }
        
           /**
        *  Affiche les informations publiques
        **/               
       public function GetInfoPublic()
       {                                    
         //Charge le mur d'une commuaut au hazard afin de faire participer les gens
          return $this->LoadMyWall(false);
       }
}
?>