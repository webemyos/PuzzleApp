<?php
/**
 * Application de gestion des devis
 * */
namespace Apps\Devis;

use Apps\Base\Base;
use Apps\Devis\Entity\DevisPrestationCategory;
use Apps\Devis\Entity\DevisProjet;
use Apps\Devis\Helper\CategoryHelper;
use Apps\Devis\Helper\DevisHelper;
use Apps\Devis\Helper\PrestationHelper;
use Apps\Devis\Helper\ProjetHelper;
use Apps\Devis\Module\Category\CategoryController;
use Apps\Devis\Module\Front\FrontController;
use Apps\Devis\Module\Prestation\PrestationController;
use Apps\Devis\Module\Projet\ProjetController;
use Apps\Devis\Module\Devis\DevisController;

use Core\Core\Core;
use Core\Core\Request;

class Devis extends Base
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Devis";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
            parent::__construct($core, "Devis");
            $this->Core = Core::getInstance();
         }

         /*
          * Home Page Blog
          */
         function Index()
         {
            //Information Page
            $this->Core->MasterView->Set("Title", " Devis");
           
             $frontController = new FrontController($this->Core);
             return $frontController->Index();
         }
         
         /*
          * Category 
          */
         function Category($params)
         {
             $frontController = new FrontController($this->Core);
             return $frontController->Category($params);
         }
         
         /*
          * Demande de devis
          */
         function Ask()
         {
             $frontController = new FrontController($this->Core);
             return $frontController->Ask();
         }
         
         
	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
            echo parent::RunApp($this->Core, "Devis", "Devis");
         }
         
         /**
         * Pop in d'ajout d'un projet
         */
        function ShowAddProjet()
        {
            $projetController = new ProjetController($this->Core);
            echo $projetController->ShowAddProjet();
        }
        
          /**
         * Enregistre un nouveau projet
         */
        function SaveProjet()
        {
            if(Request::GetPost("tbLibelle")!= "" &&   ProjetHelper::Save($this->Core, 
                                                 Request::GetPost("tbLibelle"),
                                                 Request::GetPost("tbDescription")
                                                 
                    ))
            {
                echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.ErrorCreateProjet")."</span>";
                echo $this->ShowAddProjet();
            }
        }
        
       /**
         * Charge les projet de devis de l'utilisateur
         */
        function LoadMyProjet()
        {
            $ProjetController = new ProjetController($this->Core);
            echo $ProjetController->LoadMyProjet();
        }
        
         /**
         * Charge un projet
         */
        function LoadProjet()
        {
           $projetController = new ProjetController($this->Core);
	   echo $projetController->LoadProjet(Request::GetPost("projetId"));
        }
        
        /**
         * Pop in d'ajout de catégorie
         */
        function ShowAddCategory()
        {
            $categoryController = new CategoryController($this->Core);
            echo $categoryController->ShowAddCategory(Request::GetPost("projetId"), Request::GetPost("categoryId"));
        }
        
         /**
         * Sauvegarde une catégorie
         */
        function SaveCategory()
        {
            $libelle = Request::GetPost("tbCategoryLibelle");
            
            if($libelle != "")
            {
                CategoryHelper::Save($this->Core,
                                    $libelle,
                                    Request::GetPost("tbCategoryDescription"),
                                    Request::GetPost("projetId"),
                                    Request::GetPost("categoryId")
                        );
                
                echo "<span class='success'>".$this->Core->GetCode("Devis.CategorySaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.ErrorCategory")."</span>";
                
                $this->ShowAddCategory();
            }
        }
        
        /**
         * Rachaichit Les categories 
         * */
        function RefreshCategory()
        {
            $projet = new DevisProjet($this->Core);
            $projet->GetById(Request::GetPost("projetId"));
            
            $projetController = new ProjetController($this->Core);
            echo $projetController->GetTabPrestation($projet)->Show();
        }
        
        /**
         * Supprime une catégorie
         */
        function DeleteCategory()
        {
            echo CategoryHelper::Delete($this->Core, Request::GetPost("categoryId"));
        }
        
        /**
         * Obtient toutes les applications Actives
         */
        public function GetActif()
        {
            return PrestationHelper::GetActif($this->Core);
        }
       
        /*
         * Obtient les prestations par catégories
         */
        public function GetByCategory($categoryId)
        {
            return PrestationHelper::GetByCategory($this->Core, $categoryId);
        }
        
         /**
         * Obtient les catégories
         */
        public function GetCategory()
        {
            return PrestationHelper::GetCategory($this->Core);
        }
        
         /**
         * Retourne une prestation depuis son Id
         * @param type $prestationId
         */
        public function GetPrestatonById($prestationId)
        {
            return PrestationHelper::GetById($this->Core, $prestationId);
        }
        
        /**
         * Retourne une prestation par son nom
         * @param type $name
         */
        public function GetPrestationByLibelle($libelle)
        {
            return PrestationHelper::GetByLibelle($this->Core, $libelle);
        }
        
        /*
         * Pop in d'ajout de prestation
         */
        public function ShowAddPrestation()
        {
            $prestationController = new PrestationController($this->Core);
            echo $prestationController->ShowAddPrestation(Request::GetPost("categoryId"), Request::GetPost("prestationId"));
        }
        
         /**
         * Sauvegarde une prestation
         */
        function SavePrestation()
        {
            $libelle = Request::GetPost("tbPrestationLibelle");
            
            if($libelle != "")
            {
                PrestationHelper::Save($this->Core,
                                    $libelle,
                                    Request::GetPost("tbPrestationDescription"),
                                    Request::GetPost("categoryId"),
                                    Request::GetPost("prestationId")
                        );
                
                echo "<span class='success'>".$this->Core->GetCode("Devis.PrestationSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.ErrorPrestation")."</span>";
                
                $this->ShowAddPrestation();
            }
        }
        
        /**
         * Rafraichit les prestations d'un catégories
         */
        function RefreshPrestation()
        {
             $projetController = new ProjetController($this->Core);
             $categorie = new DevisPrestationCategory($this->Core);
             $categorie->GetById(Request::GetPost("categoryId"));
             
             echo $projetController->GetPrestation($categorie);
        }
        
        /*
         * Pop in de demande de devis pour une prestation
         */
        function ShowAskDevis()
        {
            $projetController = new ProjetController($this->Core);
            echo $projetController->ShowAskDevis(Request::GetPost("prestationId"))->Show();
        }
        
        /*
         * Sauvegarde la demande de devis
         */
        function SaveAskDevis()
        {
            $email =Request::GetPost("tbEmail");
            $description = Request::GetPost("tbDevisDescription");
           
            if( $email != "" && $description != "")
            {
                ProjetHelper::SaveAskDevis(
                                        $this->Core,
                                        Request::GetPost("prestationId"),
                                        Request::GetPost("tbName"),
                                        Request::GetPost("tbEmail"),
                                        Request::GetPost("tbTelephone"),
                                        Request::GetPost("tbDevisDescription")
                    );
                echo "<span class='success'>".$this->Core->GetCode("Devis.AskSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.AskError")."</span>";
                $this->ShowAskDevis();
            }
        }
        
        /**
         * Edite une demande de devis
         */
        public function EditAsk()
        {
            $projetController = new ProjetController($this->Core);
            echo $projetController->EditAsk(Request::GetPost("askId"));
        }
        
        /*
         * Pop in d'ajout de prestation
         */
        public function ShowAddModele()
        {
            $devisController = new DevisController($this->Core);
            echo $devisController->ShowAddModele(Request::GetPost("projetId"), Request::GetPost("devisId"));
        }
        
                /**
         * Sauvegarde une catégorie
         */
        function SaveModele()
        {
            $name = Request::GetPost("tbNumber");
            
            if($name != "")
            {
                DevisHelper::Save($this->Core,
                                    Request::GetPost("tbNumber"),
                                    Request::GetPost("tbInformationSociete"),
                                    Request::GetPost("tbInformationClient"),
                                    Request::GetPost("tbInformationComplementaire"),
                                    Request::GetPost("projetId"),
                                    Request::GetPost("devisId")
                        );
                
                echo "<span class='success'>".$this->Core->GetCode("Devis.ModeleSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.ErrorModele")."</span>";
                
                $this->ShowAddModele();
            }
        }
        
         /*
         * Pop in d'ajout de devis
         */
        public function ShowAddDevis()
        {
            $devisController = new DevisController($this->Core);
            echo $devisController->ShowAddDevis(Request::GetPost("projetId"), Request::GetPost("devisId"));
        }
        
        /**
         * Sauvegarde un devis
         */
        function SaveDevis()
        {
            $name = Request::GetPost("number");
            
            if($name != "")
            {
                DevisHelper::Save($this->Core,
                                    Request::GetPost("number"),
                                    Request::GetPost("informationSociete"),
                                    Request::GetPost("informationClient"),
                                    Request::GetPost("informationComplementaire"),
                                    Request::GetPost("dateCreated"),
                                    Request::GetPost("datePaiment"),
                                    Request::GetPost("typePaiment"),
                                    Request::GetPost("lines"),
                                    Request::GetPost("projetId"),
                                    Request::GetPost("devisId")
                        );
                
                echo "<span class='success'>".$this->Core->GetCode("Devis.DevisSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Devis.ErrorDevis")."</span>";
                
                //$this->ShowAddDevis();
            }
        }
        
        /*
         * Sauvegarde au format PDF
         */
        function SaveAsPdf()
        {
            DevisHelper::SaveAsPdf($this->Core, Request::GetPost("devisId"), Request::GetPost("content"));
        }
        
         /**
         * Rafrachit un onglet
         */
        function RefreshTab()
        {
           $projet = new DevisProjet($this->Core);
           $projet->GetById(Request::GetPost("ProjetId"));
          
            $block = Request::GetPost("Controller");
            $action = Request::GetPost("Action");
            
            $tool = new $block($this->Core,  $projet);
            echo $tool->$action($projet)->Show(); 
        }
}
?>