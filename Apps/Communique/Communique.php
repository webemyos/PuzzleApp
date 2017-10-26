<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique;

use Apps\Communique\Entity\CommuniqueCommunique;
use Apps\Communique\Helper\CommuniqueHelper;
use Apps\Communique\Helper\ListHelper;
use Apps\Communique\Module\Communique\CommuniqueController;
use Apps\Communique\Module\ListUser\ListUserController;
use Core\App\Application;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Utility\ImageHelper\ImageHelper;

class Communique extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'DashboardManager';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Communique";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
            parent::__construct($core, "Communique");
            $this->Core = $core;
         }

	 /**
	  * Execution de l'application
	  */
	 function Run($core = "", $title = "", $name = "")
	 {
            $html = parent::Run($this->Core, "Communique", "Communique");
            echo $html;
	 }
        
       /**
         * Pop in d'ajout de communique
         */
        function ShowAddCommunique()
        {
            $communiqueController = new CommuniqueController($this->Core);
            echo $communiqueController->ShowAddCommunique(Request::GetPost("AppName"), Request::GetPost("EntityName"), Request::GetPost("EntityId") );
        }
        
        /**
         * Sauvegare le communique de presse
         */
        function SaveCommunique()
        {
            $title = Request::GetPost("tbTitleCommunique");
            
            if($title != "")
            {
                CommuniqueHelper::SaveCommunique($this->Core, Request::GetPost("tbTitleCommunique"), Request::GetPost("CommuniqueId"));
                 echo "<span class='success'>".$this->Core->GetCode("Communique.CommuniqueSaved")."</span>";
            
                $this->ShowAddCommunique();
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Communique.ErrorTitle")."</span>";
            }
        }
        
        /**
         * Charge les communique de presse de l'utilisateur
         */
        function LoadMyCommunique()
        {
            $communiqueController = new CommuniqueController($this->Core);
            echo $communiqueController->LoadMyCommunique();
        }
        
        /**
         * Charge le communique de presse de l'utilisateur
         */
        function LoadCommunique()
        {
            $communiqueController = new CommuniqueController($this->Core);
            echo $communiqueController->LoadCommunique(Request::GetPost("CommuniqueId"));
        }
        
        /**
         * Met a jour le contenu du communique
         */
        function UpdateContent()
        {
            CommuniqueHelper::UpdateContent($this->Core, Request::GetPost("CommuniqueId"), Request::GetPost("Content"));
            echo $this->Core->GetCode("SaveOk");
        }
        
        /**
         * Charge les listes des contacts
         */
        function LoadListContact()
        {
            $listUserController = new ListUserController($this->Core);
            echo $listUserController->GetListUser();
        }
        
        /**
         * Pop in d'ajout de liste 
         */
        function ShowAddList()
        {
            $listUserController = new ListUserController($this->Core);
             echo $listUserController->ShowAddList();
        }
        
        /**
         * Sauvegarde une liste de contact
         */
        function SaveList()
        {
            $name = Request::GetPost("tbNameList");
            
            if($name != "")
            {
                ListHelper::SaveList($this->Core, $name);
                
                echo "<span class='success'>".$this->Core->GetCode("Communique.ListSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Communique.ErrorList")."</span>";
                
                $this->ShowAddList();
            }
        }
        
        /**
         * Charge les membres d'un liste
         */
        function LoadList()
        {
             $listController = new ListUserController($this->Core);
             echo $listController->LoadList(Request::GetPost("ListId"));
        }
        
        /**
         * Ajoute un membre à la liste
         */
        function AddMember()
        {
            $listId = Request::GetPost("ListId");
            
            $name = Request::GetPost("tbNameMember");
            $firstName = Request::GetPost("tbFirstNameMember");
            $email = Request::GetPost("tbEmailMember");
            $sexe  = Request::GetPost("cbSexe")? "1" : "0";
            
            if($email != "")
            {
                //Sauvegarde
                ListHelper::AddMember($this->Core, $listId, $name, $firstName, $email, $sexe);
                
                echo "<span class='success'>".$this->Core->GetCode("Communique.MemberAdd")."</span>";  
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Communique.Error")."</span>";    
            }
            
            $this->LoadList();
        }
        
        /**
         * Supprimer un membre d'une liste
         */
        function DeleteMember()
        {
             ListHelper::DeleteMember($this->Core, Request::GetPost("MemberId"));
        }
        
        /**
         * Envoi le communique de presse au contact de la liste
         */
        function Diffuse()
        {
            $CommuniqueId = Request::GetPost("CommuniqueId");
            $lstList = Request::GetPost("lstList");
            $tbNameExpediteur = Request::GetPost("tbNameExpediteur");
            $tbEmailExpediteur = Request::GetPost("tbEmailExpediteur");
            $tbEmailReply = Request::GetPost("tbEmailReply");
           
            if($lstList != "" && $tbNameExpediteur != "" && $tbEmailExpediteur != "" && $tbEmailReply != "")
            {
                //Diffuse l'email
                CommuniqueHelper::Diffuse($this->Core, $CommuniqueId, $lstList, $tbNameExpediteur, $tbEmailExpediteur, $tbEmailReply);
                
                 echo "<span class='success'>".$this->Core->GetCode("Communique.CommuniqueSended")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Communique.ErrorField")."</span>";
            }

            $communique = new CommuniqueCommunique($this->Core);
            $communique->GetById($CommuniqueId);

            $CommuniqueController = new CommuniqueController($this->Core);
            echo $CommuniqueController->GetTabDiffusion($communique)->Show();
        }

        /*
         * Rafraichit les statistisue d'une campagne
         */
        function RefreshStatistique()
        {
            $comuniqueController = new CommuniqueController($this->Core);
            $communique = new CommuniqueCommunique($this->Core);
            $communique->GetById(Request::GetPost("CommuniqueId"));
            
            echo $comuniqueController->GetTabStatistique($communique)->Show();
        }

        
        /**
         * Obtient les blgo lié a une App
         */
        function GetByApp($appName, $entityName, $entityId)
        {
            return CommuniqueHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
        }
        
        /*
         * Affichage de l'image et tracking
         */
        function Display()
        {
            $campagneId = Request::Get("CampagneId");
            $email = Request::Get("email");
            
            CommuniqueHelper::AddEmailOpen($this->Core, $campagneId, $email);

            //Redirection pour avoid le logo
            header("Location : http://webemyos.com/image.php");
            
            echo "head deja envoyé";
            ///include("image.php");
      }
      
      /**
       * Affiche le detail d'une campagne
       */
      function EditCampagne()
      {
          $communiqueController = new CommuniqueController($this->Core);
          echo $communiqueController->EditCampagne(Request::GetPost("campagneId"));
      }
      
      /**
       * Supprime une campagne
       */
      function RemoveCampagne()
      {
          CommuniqueHelper::RemoveCampagne($this->Core, Request::GetPost("campagneId"));
      }
      
      /**
         * Obtient les images du blogs
         * format niormal et mini
         */
        function GetImages()
        {
            echo CommuniqueHelper::GetImages($this->Core, Request::GetPost("CommuniqueId"));
        }
        
         /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "Data/Apps/Communique";
           File::CreateDirectory($directory);
           File::CreateDirectory($directory.'/'.$idElement);
               
           switch($action)
           {
           
               case "UploadImageCommunique" :
                 //Sauvegarde
                 move_uploaded_file($tmpFileName, $directory.'/'.$idElement."/".$fileName);

                 //renommage du fichier
                 $fileNameMini = str_replace(".png","", $fileName);
                 $fileNameMini = str_replace(".jpg","", $fileNameMini);
                 $fileNameMini = str_replace(".jpeg","", $fileNameMini);
                 $fileNameMini = str_replace(".ico","", $fileNameMini);
                            
                 //Crée un miniature
                 $image = new ImageHelper();
                 $image->load($directory.'/'.$idElement."/".$fileName);
                 $image->fctredimimage(96, 0,$directory.'/'.$idElement."/".$fileNameMini."_96.png");
                 break;
           }
           
      
        }
       
        /*
         * Desabonne un utilisateur 
         * D'une liste de diffusion
         */
        function Desabonnement()
        {
            ListHelper::DesabonneMember($this->Core, Request::Get("ListId"), Request::Get("email"));
        }
        
        /*
         * Syncrhonise
         */
        function Synchronise()
        {
            echo ListHelper::Synchronise($this->Core, Request::GetPost("listId"));
        }
}
?>