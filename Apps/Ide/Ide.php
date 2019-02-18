<?php

/*
 * Webemyos
 * Jerome Oliva 07/02/2014
 * Application de devellopement des applications
 * */
namespace Apps\Ide;

use Apps\Ide\Helper\DeployHelper;
use Apps\Ide\Helper\DepotHelper;
use Apps\Ide\Helper\EntityHelper;
use Apps\Ide\Helper\InstallHelper;
use Apps\Ide\Helper\LandingPageHelper;
use Apps\Ide\Helper\ProjetHelper;
use Apps\Ide\Module\Depot\DepotController;
use Apps\Ide\Module\Entity\EntityController;
use Apps\Ide\Module\Helper\HelperController;
use Apps\Ide\Module\Module\ModuleController;
use Apps\Ide\Module\Insert\InsertController;
use Apps\Ide\Module\Projet\ProjetController;
use Apps\Ide\Module\Template\TemplateController;
use Apps\Ide\Module\Home\HomeController;
use Apps\Ide\Helper\ElementHelper;
use Core\App\Application;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Core\Request;
use Core\Control\Image\Image;
use Core\Control\Link\Link;

class Ide extends Application
{
	/**
	 * Auteur et version
         * Repertoire des fichiers
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Ide";
        public static $Destination = "../Apps";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
	 	parent::__construct($core, "Ide");
	 	$this->Core = $core;
         }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
            echo parent::RunApp($this->Core, "Ide", "Ide");
         }
         
         /**
          * Charge la page d'accueil
          */
         function LoadHome()
         {
             $homeController = new HomeController($this->Core);
             echo $homeController->Show();
         }
         
         /**
          * Charges les projets utilisateurs
          */
         function LoadUserProjet()
         {
             $homeController = new HomeController($this->Core);
             echo $homeController->GetProjets();
         }
         
         /*
          * Pop in de création de projet
          */
         function ShowCreateNewProjet()
         {
             $projetController = new ProjetController($this->Core);
             echo $projetController->ShowCreateNewProjet();
         }
         
         /**
          * Creation d'un projet
          */       
         function CreateProjet()
         {
             $projetController = new ProjetController($this->Core);
             echo $projetController->CreateProjet(); 
         }
         
         /**
          * Charge le projet avec tout les outils
          * 
          */
         function LoadProjet()
         {
             $projetController = new ProjetController($this->Core);
             echo $projetController->LoadProjet(); 
         }
         
         /**
          * Charge le fichier
          */
         function LoadFile()
         {
             echo ElementHelper::LoadFile($this->Core, Request::GetPost("Projet"), Request::GetPost("Name"), Request::GetPost("Module"), Request::GetPost("Helper"));
         }
         
         /*
          * Sauvegarde les fichier
          */
         function SaveFileProject()
         {
             echo ElementHelper::SaveFile($this->Core, Request::GetPost("Projet"), Request::GetPost("Name"));
         }
         
         /**
          * Popin d'ajout de module
          */
         function ShowAddModule()
         {
            $moduleController = new ModuleController($this->Core);
            echo $moduleController->ShowAddModule();
         }
         
         /**
          * Cree le module
          */
         function AddModule()
         {
            $moduleController = new ModuleController($this->Core);
            echo $moduleController->AddModule();
         }
         
         /**
          * Charge les modules du projet
          */
         function LoadModule()
         {
           echo ElementHelper::GetModule($this->Core, Request::GetPost('Projet'));  
         }
         
         /**
          * Popin d'ajout d'une action à un module
          */
         function ShowAddActionModule()
         {
            $moduleController = new ModuleController($this->Core);
            echo $moduleController->ShowAddActionModule();
         }
         
         /*
          * Ajoute l'action au module
          */
         function AddActionModule()
         {
            $moduleController = new ModuleController($this->Core);
            echo $moduleController->AddActionModule();
         }
         
         /**
          * Popin d'ajout d'entite
          */
         function ShowAddEntity()
         {
            $entityController = new EntityController($this->Core);
            echo $entityController->ShowAddEntity();
         }
         
         /**
          * Creation d'un entite
          */
         function CreateEntity()
         {
             $name = Request::GetPost("Name");
             $shared = Request::GetPost("Shared");
             $projet = Request::GetPost("Projet");
             $fields = Request::GetPost("Fields");
             $keys = Request::GetPost("Keys");
            
             EntityHelper::CreateEntity($this->Core, $name, $shared, $projet, $fields, $keys);
             
             echo "<span class='success' >".$this->Core->GetCode("Ide.EntityCreated")."</span>";
         }

         /**
          * Joue le script d'installation
          */
         function CreateTable()
         {
             EntityHelper::CreateTable($this->Core, Request::GetPost("Projet"));
             
             echo $this->Core->GetCode("SaveOk");
         }
         
         /**
          * Charge les entite
          */
         function LoadEntity()
         {
           echo ElementHelper::GetEntity($this->Core, Request::GetPost('Projet'));  
         }
         
         /**
          * Affiche les donnée de l'entite
          */
         function ShowDataEntity()
         {
            $entityController = new EntityController($this->Core);
            echo $entityController->ShowDataEntity();
         }
         
         /**
          * Supprime une entite
          */
         function DeleteEntity()
         {
             EntityHelper::DeleteEntity($this->Core, Request::GetPost("Projet"), Request::GetPost("Name"));
         }
         
         /**
          * Affiche les templates d'un module
          */
         function ShowTemplate()
         {
            $templateController = new TemplateController($this->Core);
            echo $templateController->Show();
         }
         
         /**
          * Charge le code du template
          */
         function LoadCodeTemplate()
         {
             $templateController = new TemplateController($this->Core);
             echo $templateController->LoadCodeTemplate();
         }
         
         /**
          * Sauvegarde un template
          */
         function SaveTemplate()
         {
             $templateController = new TemplateController($this->Core);
             echo $templateController->SaveTemplate();
         }
         
         /**
          * Popin d'ajout de fonction Js
          */
         function ShowInsertJs()
         {
             $insertController = new InsertController($this->Core);
             echo $insertController->ShowInsertJs();
         }
         
         /**
          * Popin d'ajout de fonction Php
          */
         function ShowInsertPhp()
         {
             $insertController = new InsertController($this->Core);
             echo $insertController->ShowInsertPhp();
         }
         
         /**
          * Récupère les parametres d'une fonction js
          */
         function GetParameterJsFonction()
         {
             $insertController = new InsertController($this->Core);
             echo $insertController->GetParameterJsFonction();
         }
         
         /**
          * Récupère les parametres d'une fonction js
          */
         function GetParameterPhpFonction()
         {
             $insertController = new InsertController($this->Core);
             echo $insertController->GetParameterPhpFonction();
         }
         
         /**
          * Récupère le code d'un template avec les paramètres
          */
         function GetCodeTemplate()
         {
             $insertController = new InsertController($this->Core);
             echo $insertController->GetCodeTemplate();
         }
         
         /**
          * Popin d'ajout d'helper
          */
         function ShowAddHelper()
         {
            $helperController = new HelperController($this->Core);
            echo $helperController->ShowAddHelper();
         }
         
          /**
          * Cree le module
          */
         function AddHelper()
         {
            $helperController = new HelperController($this->Core);
            echo $helperController->AddHelper();
         }
         
         /**
          * Charge les helper
          */
         function LoadHelper()
         {
           echo ElementHelper::GetHelper($this->Core, Request::GetPost('Projet'));  
         }
         
         /**
          * Affiche le détail d'une image
          */
         function ShowImage()
         {
            // $file = "../Data/Apps/Ide/".Request::GetPost("Projet")."/Images/".Request::GetPost("File");
            $file = Ide::$Destination. "/".Request::GetPost("Projet")."/Images/".Request::GetPost("File");
            $image = new Image($file);
            echo $image->Show();
         }
         
        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName)
        {
           //Ajout de l'image dans le repertoire correspondant
           //$directory = "../Data/Apps/Ide/".$idElement."/Images";
           $directory = Ide::$Destination."/".$idElement."/Images";
            //Sauvegarde
            move_uploaded_file($tmpFileName, $directory."/". $fileName);
        }
        
         /**
          * Charge les entite
          */
         function LoadImage()
         {
           echo ElementHelper::GetImage($this->Core, Request::GetPost('Projet'));  
         }
         
         /**
          * Deploit l'application
          */
         function Deploy()
         {
             echo DeployHelper::Deploy($this->Core, Request::GetPost("Projet"));
         }
         
         /**
          * Récupere les informations de l'utilisateur sur l'application
          */
         function GetInfo()
         {
             $projets = ProjetHelper::GetProjet($this->Core);
             
             $html = "<h4>".$this->Core->GetCode("Ide.MyProjet")."</h4>";
             if(count($projets) > 0)
             {   
                 $html .= "<ul class='alignLeft'>";
                     
                 foreach($projets as $projet)
                 {
                     $link = new Link($projet->Name->Value, "#");
                     $link->OnClick = "Eemmys.StartApp('', '".$projet->Name->Value."')";
                     $html .= "<li>".$link->Show()."</li>";
                 }
                 
                 $html .= "</ul>";
             }
            else 
            {
                $html .= $this->Core->GetCode("Ide.NoProjet");
            }
            
            return $html;
         }
         
         /**
          * Obtient les prototype d'un projet
          * @param type $appName
          * @param type $entityName
          * @param type $entityId
          */
         function GetByApp($appName, $entityName, $entityId)
         {
             return ProjetHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
         }
         
         /**
          * Gestion de la landing page personnalisé
          */
         function LoadLandingPage()
         {
             echo LandingPageHelper::LoadLandingPage(Request::GetPost("Projet"));
         }
         
         /*
          * install la base de webemyos
          * Base de donnée
          */
         function InstallWebemyos()
         {
             $serverName = Request::GetPost("tbServerName");
             $login = Request::GetPost("tbLogin");
             $password = Request::GetPost("tbPassWord");
             $dataBaseName = Request::GetPost("tbDataBaseName");
         
             if($serverName != "" && $login != "" && $dataBaseName != "")
             {
                 InstallHelper::InstallWebemyos($this->Core,
                                                $serverName,
                                                $login,
                                                $password,
                                                $dataBaseName
                         );
            
                 echo "<br/><br/><span class='success'>Installation réussie.</span>";
                 
                 echo "<h2>Création de votre compte</h2>";
                 echo $this->GetRegistration();
             }
             else
             {
                 echo "<span class='error'>Vous devez remplir tous les champs</span>";
                 
                 echo $this->GetContent();
             }
         }
         
          /**
         * Obtient le contenu de la page
         */
        function GetContent()
        {
            $jbInstall = new AjaxFormBlock($this->Core, 'jbInstall');
            $jbInstall->App = "Ide";
            $jbInstall->Action = "InstallWebemyos";
              
            // //App liée
            //  $jbBudget->AddArgument("AppName", $appName);
            $jbInstall->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbServerName", "Libelle" => $this->Core->GetCode("ServeurName") ),
                                            array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => $this->Core->GetCode("Login") ),
                                            array("Type"=>"PassWord", "Name"=> "tbPassWord", "Libelle" => $this->Core->GetCode("Password") ),
                                            array("Type"=>"TextBox", "Name"=> "tbDataBaseName", "Libelle" => $this->Core->GetCode("DataBaseName") ),
                                            array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                                )
                      );
              
              return $jbInstall->Show();
        }
        
        /*
         * Permet de se créer un compte
         */
        function GetRegistration()
        {
            $jbUser = new AjaxFormBlock($this->Core, 'jbUser');
            $jbUser->App = "Ide";
            $jbUser->Action = "CreateUser";
              
            // //App liée
            //  $jbBudget->AddArgument("AppName", $appName);
            $jbUser->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => $this->Core->GetCode("Login") ),
                                            array("Type"=>"PassWord", "Name"=> "tbPassWord", "Libelle" => $this->Core->GetCode("Password") ),
                                            array("Type"=>"PassWord", "Name"=> "tbVerify", "Libelle" => $this->Core->GetCode("verify") ),
                                            array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                                )
                      );
              
              return $jbUser->Show();
        }
        
        /*
         * Crée un utilisateur
         */
        function CreateUser()
        {
             $login = Request::GetPost("tbLogin");
             $password = Request::GetPost("tbPassWord");
             $verify = Request::GetPost("tbVerify");
             
             if($login != "")
             {
                 if($password != "")
                 {
                    if($password == $verify)
                    {
                            $user = new User($this->Core);
                            $user->Email->Value = $login;
                            $user->PassWord->Value = $password;
                            $user->GroupeId->Value = 2;
                            $user->Save();
                            
                            //Chargement de l'utilisateur
                            $userId = $this->Core->Db->GetInsertedId();
                           
                            //Connecte l'utilisateur
                            Request::Connect("", 2, $this->Core, $userId);

                            echo "<span class='success'><i class='fa fa-check' >&nbsp;</i>Création du compte réussie</span>";
                            echo "<p><br/>Vous pouvez accèder à l'application en cliquant sur le lien suivant <a href='Membre/'>Accéder a l'application</a></p>";
                    }
                    else
                    {
                       echo "Le mot de passse et la vérification ne sons pas identique";
                       echo $this->GetRegistration();
                    }
                 }
                 else
                 {
                    echo "Vous devez saisir un mot de passe";
                    echo $this->GetRegistration();
                 }
             }
             else
             {
                 echo "Vous devez saisir un login";
                 echo $this->GetRegistration();
             }
        }
        
        /*
         * Pop in d'ajout de dépot
         */
        function ShowAddDepot()
        {
            $depotController = new DepotController($this->Core);
            echo $depotController->ShowAddDepot();
        }
        
        /*
         * Télecharge un dépot
         */
        function UploadDepot()
        {
            DepotHelper::Upload($this->Core, Request::GetPost("depot"));
        }
        
        /*
         * Popin de suprression de Dépôt
         */
        function ShowDeleteDepot()
        {
            $depotController = new DepotController($this->Core);
            echo $depotController->ShowDeleteDepot();
        }
        
        /*
         * Supprime un dépot
         */
        function DeleteDepot()
        {
            DepotHelper::Delete($this->Core, Request::GetPost("depot"));
        }
        
        /**
         * POp in pour commiter un dépot
         */
        function ShowCommitDepot()
        {
            $depotController = new DepotController($this->Core);
            echo $depotController->ShowCommitDepot();
        }
        
         /*
         * Commit un dépot
         */
        function CommitDepot()
        {
            DepotHelper::Commit(Request::GetPost("depot"));
        }
        
}

?>