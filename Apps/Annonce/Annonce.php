<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Annonce;

use Apps\Annonce\Entity\AnnonceAnnonce;
use Apps\Annonce\Entity\AnnonceReponse;
use Apps\Annonce\Helper\AnnonceHelper;
use Apps\Annonce\Module\Annonce\AnnonceController;
use Core\App\Application;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;

class Annonce extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'DashBoardManager';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Annonce";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
	 	parent::__construct($core, "Annonce");
	 	$this->Core = $core;
         }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	echo parent::RunApp($this->Core, "Annonce", "Annonce");
	 }
         
        /**
         * Popin d'ajout d'annonce
         */
        public function ShowAddAnnonce()
        {
            $annonceBlock = new AnnonceController($this->Core);
            echo $annonceBlock->ShowAddAnnonce(Request::GetPost("AnnonceId"));
        }
        
        /**
         * Enregistre l'annonce
         */
        public function SaveAnnonce()
        {
            if(Request::GetPost("tbTitle") && Request::GetPost("tbDescription")  )
            {
                AnnonceHelper::Save($this->Core, Request::GetPost("tbTitle"), Request::GetPost("tbDescription"), Request::GetPost("annonceId"));
                
                echo "<span class='success' >".$this->Core->GetCode("Annonce.AnnonceSaved")."</span>";
            }
            else
            {
                echo  "<span class='error'>".$this->Core->GetCode("Annonce.FieldEmpty"). "</span>";
                $this->ShowAddAnnonce();
            }
        }
        
        /**
         * Affiche les annonce de l'utilisateur
         */
        public function ShowMyAnnonce()
        {
            $annonceBlock = new AnnonceController($this->Core);
            echo $annonceBlock->ShowMyAnnonce();
        }
        
        /*
         * Affiche les annonces
         */
        public function ShowAnnonces()
        {
            $annonceBlock = new AnnonceController($this->Core);
            echo $annonceBlock->ShowAnnonces(Request::GetPost("annonceId"));
        }
        
        /**
         * pop in d'ajout de réponse
         */
        public function ShowAddReponse()
        {
           $annonceBlock = new AnnonceController($this->Core);
           echo $annonceBlock->ShowAddResponse(Request::GetPost("AnnonceId"));
        }
        
        /*
         * Enregistre la réponse
         */
        public function SaveReponse()
        {
            if(Request::GetPost("tbDescription")  )
            {
                AnnonceHelper::SaveReponse($this->Core, Request::GetPost("tbDescription"), Request::GetPost("AnnonceId"));
                
                echo "<span class='success' >".$this->Core->GetCode("Annonce.ReponseSaved")."</span>";
            }
            else
            {
                echo  "<span class='error'>".$this->Core->GetCode("Annonce.FieldEmpty"). "</span>";
                $this->ShowAddReponse();
            }
        }
        
        /**
         * Obtient une annonce
         */
        public function GetAnnonce()
        {
           //Recuperation de l'annonce
           $annonce = new AnnonceAnnonce($this->Core);
           $annonce->GetById(Request::GetPost("AnnonceId"));
            
           //Recuperation via le block
           $annonceBlock = new AnnonceController($this->Core);
           $eeProfil = DashBoardManager::GetApp("EeProfil", $this->Core);
           
           echo $annonceBlock->RenderAnnonce($annonce, $eeProfil, false);
        }
        
        /**
         * Obtient les réponse d'une annonce
         */
        public function GetReponse()
        {
           $annonceBlock = new AnnonceController($this->Core);
           echo $annonceBlock->GetReponse(Request::GetPost("AnnonceId"));
        }
        
        /**
         * Affiche le détail d'une annonce
         */
        public function ShowDetail()
        {
             $annonceBlock = new AnnonceController($this->Core);
           echo $annonceBlock->ShowDetail(Request::GetPost("AnnonceId"));
        }
        
        /**
         * obtient les annonce récents
         */
        public function GetInfo()
        {
           $html ="";
            
            //Obtient les dernière evenements
            $annonces = AnnonceHelper::GetLast($this->Core);
            
            foreach($annonces as $annonce)
            {
                   $html .= "<div class='event'><a href='#' onclick='DashBoardManager.StartApp(\"\",\"Annonce\", ".$annonce->IdEntite.")'>";
                    
                   $html .= "<span class='date'>".$annonce->DateCreated->Value."</span>";
                   $html .= "<span class='text'>".$annonce->Title->Value."</span></a>";
                 
                  $html .= "</div>";
            }
            
            return $html;
        }
        /*
         * Sauvegarde une annonce pour une app
         */
        public function SaveByApp($appName, $entityName,$entityId, $libelle, $commentaire)
        {
            return AnnonceHelper::SaveByApp($this->Core, $appName, $entityName,$entityId, $libelle, $commentaire );
        }
        
        /**
         * Obtient les annonces d'une app
         * @param type $appName
         * @param type $entityName
         * @param type $entityId
         */
        public function GetByApp($appName, $entityName, $entityId)
        {
            return AnnonceHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
        }
        
        /**
         * Affiche le détail d'une annnonce
         */
        function Display($name="")
        {
            $TextControl = "<span class='span2'></span>";
             
            $TextControl .= "<span class='span10'> <h1 class='blueOne span12'>une annonce à retenue votre attention ?</h1>";
            $TextControl .= "<p>Vous pouvez y répondre en créant un compte à l'aide du formulaire ci-contre.</p>";
  		
  		include("Blocks/WRegistrationBlock/WRegistrationBlock.php");
  		
  		//Creation d'un compte
  		$RegistrationBlock = new WRegistrationBlock($this->Core, '', '', false, false, true);
  		$RegistrationBlock->AddPrestataire = true;
  		$RegistrationBlock->IdEntity = $this->IdEntity;
  		
  	
  		//Recuperation du formulaire
  		$anonce = new AnnonceAnnonce($this->Core);
		$anonce->GetById($this->IdEntity);
  		
  		
  		if($anonce->IdEntite != "")
  		{
  			//Info du questionnaire
	  		$TextControl .="<div class='span6' >";
	  		$TextControl .="<h4 class='blueTwo'>Titre de l'annonce : ".$anonce->Title->Value."</i></h4>";
	  		$TextControl .=  $anonce->Description->Value;
	  
	  		//Ajout de la description a la balise mete
	  		$this->Core->Page->Masterpage->AddBlockTemplate("!Description", $anonce->Commentaire->Value);
	  			
	  		$TextControl .="</div>";
                        
                        $TextControl .="<div class='span4' >";
                        $TextControl .= $RegistrationBlock->Show() . "</div>";
	  	}
	  	else
	  	{
	  		$TextControl .= "Cette annonce n'existe pas!";
	  	}
	  
                $TextControl .= "</span>";
                
  		return $TextControl;
        }
        
        /**
         * Affiche le détail d'une réponse
         */
        public function EditReponse()
        {
            $annonceBlock = new AnnonceController($this->Core);
            echo $annonceBlock->GetDetailReponse(Request::GetPost("ReponseId"));
        }
        
        /*
         * Enoi un messae pour une reponse
         */
        public function SendMessage()
        {
            //Recuperation de la téponse
            $reponse = new AnnonceReponse($this->Core);
            $reponse->GetById(Request::GetPost("ReponseId"));
            
            
            $emessage = DashBoardManager::GetApp("EeMessage", $this->Core);
            $emessage->SendByApp(
                                 $this->Core->GetCode("Annonce.SubjetMessageReponseAdded"),
                                 $this->Core->GetCode("Annonce.MessageMessageReponseAdded"),
                                 array($reponse->UserId->Value),
                                 "EeAnnnoncer",
                                 "AnnonceReponse",
                                 $reponse->IdEntite,
                                 "Annonce.ReponseAdded"
                                  );
            
            
            echo "<span class='success'>".$this->Core->GetCode("Annonce.MessageSended")."</span>";
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