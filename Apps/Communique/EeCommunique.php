<?php
/**
 * Application de gestion des communiqué de presse
 * */

class EeCommunique extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeCommunique";

	/**
	 * Constructeur
	 * */
	 function EeCommunique($core)
	 {
	 	parent::__construct($core, "EeCommunique");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeCommunique::IncludeBlock();
                
                //Inclue les entité
		EeCommunique::IncludeEntity();
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeCommunique", "EeCommunique");
	 	echo $textControl;
	 }
         
          /**
          * Inclut les module nescessaires
          */
         public static function IncludeBlock()
         {
              	if(!class_exists("HomeBlock"))
		{
                    include("Blocks/HomeBlock/HomeBlock.php");
                    include("Blocks/CommuniqueBlock/CommuniqueBlock.php");
                    include("Blocks/ListBlock/ListBlock.php");
                }
                
                //Inclu les helper
                if(!class_exists("CommuniqueHelper"))
                {
                    include("Helper/CommuniqueHelper.php");
                    include("Helper/ListHelper.php");
                    include("Helper/CampagneHelper.php");
                }
         }
         
         /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		$entites = array("EeCommuniqueCommunique", "EeCommuniqueListContact", "EeCommuniqueListMember",
                                 "EeCommuniqueCampagne", "EeCommuniqueCampagneEmail"
                                );
		
		foreach($entites as $entite)
		{
                    include("Entity/".$entite.".php");
		}
	}
        
       /**
         * Pop in d'ajout de communique
         */
        function ShowAddCommunique()
        {
            $communiqueBlock = new CommuniqueBlock($this->Core);
            echo $communiqueBlock->ShowAddCommunique(JVar::GetPost("AppName"), JVar::GetPost("EntityName"), JVar::GetPost("EntityId") );
        }
        
        /**
         * Sauvegare le communique de presse
         */
        function SaveCommunique()
        {
            $title = JVar::GetPost("tbTitleCommunique");
            
            if($title != "")
            {
                CommuniqueHelper::SaveCommunique($this->Core, JVar::GetPost("tbTitleCommunique"), JVar::GetPost("CommuniqueId"));
                 echo "<span class='success'>".$this->Core->GetCode("EeCommunique.CommuniqueSaved")."</span>";
            
                $this->ShowAddCommunique();
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("EeCommunique.ErrorTitle")."</span>";
            }
        }
        
        /**
         * Charge les communique de presse de l'utilisateur
         */
        function LoadMyCommunique()
        {
            $communiqueBlock = new CommuniqueBlock($this->Core);
            echo $communiqueBlock->LoadMyCommunique();
        }
        
        /**
         * Charge le communique de presse de l'utilisateur
         */
        function LoadCommunique()
        {
            $communiqueBlock = new CommuniqueBlock($this->Core);
            echo $communiqueBlock->LoadCommunique(JVar::GetPost("CommuniqueId"));
        }
        
        /**
         * Met a jour le contenu du communique
         */
        function UpdateContent()
        {
            CommuniqueHelper::UpdateContent($this->Core, JVar::GetPost("CommuniqueId"), JVar::GetPost("Content"));
            echo $this->Core->GetCode("SaveOk");
        }
        
        /**
         * Charge les listes des contacts
         */
        function LoadListContact()
        {
            $listBlock = new ListBlock($this->Core);
            echo $listBlock->GetListUser();
        }
        
        /**
         * Pop in d'ajout de liste 
         */
        function ShowAddList()
        {
            $listBlock = new ListBlock($this->Core);
             echo $listBlock->ShowAddList();
        }
        
        /**
         * Sauvegarde une liste de contact
         */
        function SaveList()
        {
            $name = JVar::GetPost("tbNameList");
            
            if($name != "")
            {
                ListHelper::SaveList($this->Core, $name);
                
                echo "<span class='success'>".$this->Core->GetCode("EeCommunique.ListSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("EeCommunique.ErrorList")."</span>";
                
                $this->ShowAddList();
            }
        }
        
        /**
         * Charge les membres d'un liste
         */
        function LoadList()
        {
             $listBlock = new ListBlock($this->Core);
             echo $listBlock->LoadList(JVar::GetPost("ListId"));
        }
        
        /**
         * Ajoute un membre à la liste
         */
        function AddMember()
        {
            $listId = JVar::GetPost("ListId");
            
            $name = JVar::GetPost("tbNameMember");
            $firstName = JVar::GetPost("tbFirstNameMember");
            $email = JVar::GetPost("tbEmailMember");
            $sexe  = JVar::GetPost("cbSexe")? "1" : "0";
            
            if($email != "")
            {
                //Sauvegarde
                ListHelper::AddMember($this->Core, $listId, $name, $firstName, $email, $sexe);
                
                echo "<span class='success'>".$this->Core->GetCode("EeCommunique.MemberAdd")."</span>";  
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("EeCommunique.Error")."</span>";    
            }
            
            $this->LoadList();
        }
        
        /**
         * Supprimer un membre d'une liste
         */
        function DeleteMember()
        {
             ListHelper::DeleteMember($this->Core, JVar::GetPost("MemberId"));
        }
        
        /**
         * Envoi le communique de presse au contact de la liste
         */
        function Diffuse()
        {
            $CommuniqueId = JVar::GetPost("CommuniqueId");
            $lstList = JVar::GetPost("lstList");
            $tbNameExpediteur = JVar::GetPost("tbNameExpediteur");
            $tbEmailExpediteur = JVar::GetPost("tbEmailExpediteur");
            $tbEmailReply = JVar::GetPost("tbEmailReply");
           
            if($lstList != "" && $tbNameExpediteur != "" && $tbEmailExpediteur != "" && $tbEmailReply != "")
            {
                //Diffuse l'email
                CommuniqueHelper::Diffuse($this->Core, $CommuniqueId, $lstList, $tbNameExpediteur, $tbEmailExpediteur, $tbEmailReply);
                
                 echo "<span class='success'>".$this->Core->GetCode("EeCommunique.CommuniqueSended")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("EeCommunique.ErrorField")."</span>";
            }

            $communique = new EeCommuniqueCommunique($this->Core);
            $communique->GetById($CommuniqueId);

            $CommuniqueBlock = new CommuniqueBlock($this->Core);
            echo $CommuniqueBlock->GetTabDiffusion($communique)->Show();
        }

        /*
         * Rafraichit les statistisue d'une campagne
         */
        function RefreshStatistique()
        {
            $comuniqueBlock = new CommuniqueBlock($this->Core);
            $communique = new EeCommuniqueCommunique($this->Core);
            $communique->GetById(JVar::GetPost("CommuniqueId"));
            
            echo $comuniqueBlock->GetTabStatistique($communique)->Show();
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
            $campagneId = JVar::Get("CampagneId");
            $email = JVar::Get("email");
            
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
          $communiqueBlock = new CommuniqueBlock($this->Core);
          echo $communiqueBlock->EditCampagne(JVar::GetPost("campagneId"));
      }
      
      /**
       * Supprime une campagne
       */
      function RemoveCampagne()
      {
          CommuniqueHelper::RemoveCampagne($this->Core, JVar::GetPost("campagneId"));
      }
      
      /**
         * Obtient les images du blogs
         * format niormal et mini
         */
        function GetImages()
        {
            echo CommuniqueHelper::GetImages($this->Core, JVar::GetPost("CommuniqueId"));
        }
        
         /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "../Data/Apps/EeCommunique/";
        
            JFile::CreateDirectory($directory. $idElement);
               
           switch($action)
           {
           
               case "UploadImageCommunique" :
                 //Sauvegarde
                 move_uploaded_file($tmpFileName, $directory.$idElement."/".$fileName);

                 //renommage du fichier
                 $fileNameMini = str_replace(".png","", $fileName);
                 $fileNameMini = str_replace(".jpg","", $fileNameMini);
                 $fileNameMini = str_replace(".jpeg","", $fileNameMini);
                 $fileNameMini = str_replace(".ico","", $fileNameMini);
                            
                 //Crée un miniature
                 $image = new JImage();
                 $image->load($directory.$idElement."/".$fileName);
                 $image->fctredimimage(96, 0,$directory.$idElement."/".$fileNameMini."_96.png");
                 break;
           }
           
      
        }
       
        /*
         * Desabonne un utilisateur 
         * D'une liste de diffusion
         */
        function Desabonnement()
        {
            ListHelper::DesabonneMember($this->Core, JVar::Get("ListId"), JVar::Get("email"));
        }
        
        /*
         * Syncrhonise
         */
        function Synchronise()
        {
            echo ListHelper::Synchronise($this->Core, JVar::GetPost("listId"));
        }
}
?>