<?php
/**
 * Application de gestion du profil utilisateur
 * */

class EeProfil extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/EeProfil";

	/**
	 * Constructeur
	 * */
	 function EeProfil($core)
	 {
	 	parent::__construct($core, "EeProfil");
	 	$this->Core = $core;
                
                //Inclue les modules
                EeProfil::IncludeBlock();
                
                //Inclue les entité
		EeProfil::IncludeEntity();
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "EeProfil", "EeProfil");
	 	echo $textControl;
	 }
         
          /**
          * Inclut les module nescessaires
          */
         public static function IncludeBlock()
         {
               $blocks = array("HomeBlock", "InformationBlock", "CompetenceBlock");
             
               foreach($blocks as $block)
               { 
                    if(!class_exists($block))
                    {
                        include("Blocks/".$block."/".$block.".php");
                    }
              }
                   
                //Inclu les helper
                if(!class_exists("UserHelper"))
                {
                    include("Helper/UserHelper.php");
                    include("Helper/CompetenceHelper.php");
                }
         }
         
         /*
	* Inclue les entite du projet
	*/
	public static function IncludeEntity()
	{	
		$entites = array("EeProfilCompetenceCategory", "EeProfilCompetence", "EeProfilCompetenceEntity");
		
		foreach($entites as $entite)
		{
                    include_once("Entity/".$entite.".php");
		}
	}
        
        /**
         * Charge les information de base du profil
         */
        public function LoadInformation($showAll = true)
        {
            $informationBlock = new InformationBlock($this->Core);
            echo $informationBlock->Load($showAll);
        }
        
        /**
         * Enregistre les informations du profil
         */
        public function SaveInformation()
        {
            //Enregistrement
            echo UserHelper::Save($this->Core,
                                  JVar::GetPost("FirstName"),
                                  JVar::GetPost("Name"),
                                  JVar::GetPost("Description"),
                                  JVar::GetPost("tbCity")
                   );
                    
            $this->LoadInformation(false);
        }
        
        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "../Data/Apps/EeProfil/";
           
           switch($action)
           {
               case "SaveImageProfil":
                               //Sauvegarde
                move_uploaded_file($tmpFileName, $directory."/".$idElement.".jpg");

                //Crée un miniature
                $image = new JImage();
                $image->load($directory."/".$idElement.".jpg");
                $image->fctredimimage(48, 0,$directory."/".$idElement."_96.jpg");

                $this->Core->User->Image->Value = $directory."/".$idElement.".jpg";
                $this->Core->User->Save();
                   break;
           }
        }
        
        /**
         * Charge les compétences du profil
         */
        public function LoadCompetence()
        {
            $competenceBlock = new CompetenceBlock($this->Core);
            echo $competenceBlock->Load();
        }
        
        /*
         * Obtient les competences
         */
        public function GetCompetence()
        {
            $competenceBlock = new CompetenceBlock($this->Core);
            return $competenceBlock->GetCompetence();
        }
        
        //Enregistre les competences
        public function SaveCompetence()
        {
            echo UserHelper::SaveCompetence($this->Core, $this->Core->User->IdEntite, JVar::GetPost("competenceId"));
                    
            echo $this->LoadCompetence();
        }
        
        /**
         * Récupere l'image du profil
         */
        public function GetProfil($user = false, $cssClass = "", $addInvitation = false)
        {
            $html = "<div class='$cssClass'>";
            
            $informationBlock = new InformationBlock($this->Core);
            
            if($user != false)
            {
                $html .= $informationBlock->GetImage($user->IdEntite, true)->Show();
            }
            else
            {
                $html .= $informationBlock->GetImage($this->Core->User->IdEntite, true)->Show();
                $user = $this->Core->User;
            }
            
            $html .= "<div class='member'>".$user->GetPseudo()."</div>";
            $html .= "</div>";
            
            return $html ;
        }
        
        function Display()
        {
            $html = "<h1>".$this->Core->GetCode("EeProfil.DetailProfil")."</h1>";
            
            $user = new User($this->Core);
            $user->GetById($this->IdEntity);
            
            $html .= "<div class='row'><div class='col-md-4'><h2 class='fa fa-user'>&nbsp;".$this->Core->GetCode("EeProfil.Information")."</h2>".$this->GetProfil($user)."</div>";
            
            $competences = CompetenceHelper::GetByUser($this->Core, $this->IdEntity );

           if(count($competences) > 0)
            {
                $html .= "<div class='col-md-8' ><h2 class='fa fa-align-left' >&nbsp;".$this->Core->GetCode("EeProfil.Competence")."</h2>";
           
                $categorie = "";
                        
               // $html .= "<ul>";
           
                foreach($competences as $competence)
                {
                  //  $html .=  $competence->Competence->Value->Category->Value->Name->Value;
                    
                    if($competence["categoryName"] != $categorie)
                    {
                        $categorie = $competence["categoryName"];
                    
                        if($categorie != "")
                             $html .= "</ul>";
                        
                        $html .= "<li><h3 class='width100 titleBlue'>".$categorie .  "</h3><ul><li>" .$competence["CompetenceName"]."</li>";
                    }
                    else
                    {
                       $html .= "<li><span class='width100'></span>".$competence["CompetenceName"]."</li>"; 
                    }
                }
            
                $html .= "</ul></div>";
            $html .= "</div>";
            }
            return $html;
        }

        /**
         * Affiche le détail d'un utilisateur
         */
        public function ShowDetail()
        {
            $html = "<div class='row' >";
           
            $user = new User($this->Core);
            $user->GetById(JVar::GetPost("idEntity"));
            
            $html .= "<div class='col-md-6'>";
            $informationBlock  = new InformationBlock($this->Core);
            $img = $informationBlock->GetImage($user->IdEntite, false, "300px");
            $html.= $img->Show();
            $html.= "</div>";        
            
            //Description
            $html .= "<div class='col-md-5'>";
            $html .= "<h2>".$user->GetPseudo()."</h2>";
            $html .= "<i>".$user->Description->Value."</i>";
           
            //Envoyer un message
            $btnMessage = new Button(BUTTON);
            $btnMessage->CssClass = "btn btn-success";
            $btnMessage->Value = $this->Core->GetCode("SendMessage");
            $btnMessage->OnClick = "Eemmys.ShowContactUser('', ".$user->IdEntite.")";
            $html.= $btnMessage->Show()."<br/><br/>";
            
            //Compétences
            $competences = CompetenceHelper::GetByUser($this->Core, $user->IdEntite );

           if(count($competences) > 0)
            {
                $html .= "<h2 class='fa fa-align-left' >&nbsp;".$this->Core->GetCode("EeProfil.Competence")."</h2>";
           
                $categorie = "";
            
                foreach($competences as $competence)
                {
                    if($competence["categoryName"] != $categorie)
                    {
                        $categorie = $competence["categoryName"];
                    
                        if($categorie != "")
                             $html .= "</ul>";
                        
                        $html .= "<li><b class='titleBlue'>".$categorie .  "</b><ul><li>" .$competence["CompetenceName"]."</li>";
                    }
                    else
                    {
                       $html .= "<li><span class='width100'></span>".$competence["CompetenceName"]."</li>"; 
                    }
                }
            
                $html .= "</ul></div>";
            $html .= "</div>";
            }
            $html .= "</div>";
            
            $html .= "</div>";
            
            echo $html; 
        }
        
}
