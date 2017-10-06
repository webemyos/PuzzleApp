<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

use Core\Core\Config;
use Core\Core\DataBase;
use Core\Core\Request;

use Core\Entity\User\User;

//Inclusion of the class of core
include "Constante.php";

class Core
{
     /**
     *
     * @var SingletonClass
     */
    private static $_instance;
  
    
    //Property
    protected $Include;
    protected $Page;
    protected $Entity;
    protected $JDirectory;
    
    //Accessible property
    public $Config;
    public $User;
    public $App;
    public $Db;
    public $MasterModel;
    public $Debug;
    public $ConfigFile;
    protected $UserGroupe;
    protected $Lang;
    protected $Version;
    protected $DataBaseEnabled;
    
     /**
     * Get the singleton of the core
     *
     * @return SingletonClass
     */
    public static function getInstance($config = "", $debug = false)
    {
        if( true === is_null( self::$_instance ) )
        {
            self::$_instance = new self(true, "","","", $config);
            self::$_instance->Debug =$debug ;
            self::$_instance->ConfigFile =$config ;
        }

        return self::$_instance;
    }
    
    /*
     * Construct the Core
     */
    function __construct($include,$typeDb="",$file="",$directory="",$configFile = "")
    {
        $this->Config = new Config("../". $configFile.".xml");
      }
    
    
    /*
     * Define if the app can run
     */
    public function IsInstalled()
    {
        //Verify the Key Instal in the Config file
        $this->Config = new Config("../". self::$_instance->ConfigFile.".xml");
        return $this->Config->GetKey("INSTALLED") == 1;
    }
    
    /*
     * Init the core
     */
    function init()
    {
      //Version du coeur
      $this->Version ="2.2.0.0";

      try
      {
            $this->Config = new Config("../". self::$_instance->ConfigFile.".xml");
            
            //Repertoire du framework
            $this->JDirectory=$this->Config->GetKey("JDIRECTORY");

             //Connexion à la base de donnée           
             if($this->Config->GetKey("DATABASESERVER") != "")
             {
                $this->DataBaseEnabled = true;
                
                //Data Base
                 $this->Db=new DataBase(
                        $this->Config->GetKey("DATABASESERVER"),
                        $this->Config->GetKey("DATABASENAME"),
                        $this->Config->GetKey("DATABASELOGIN"),
                        $this->Config->GetKey("DATABASEPASS")
                );

                //Gestion des langues
                $this->Lang=new Language($this);

                //Langue par defaut
                if(Request::GetSession("Lang") == "")
                        Request::SetSession("Lang",$this->Config->GetKey("LANG"));
             }
             else
             {
                    $this->DataBaseEnabled=false;
             }
             
                //On charge l'utilisateur quand on inclue les fichiers car les script non pas besoin des Utilisateur connect�
            if(Request::IsConnected($this) && $this->DataBaseEnabled )
            {
                $this->User=new User($this);
                $this->User->GetById(Request::GetUser($this));
            }
        
            }
            catch (Exception  $e)
            {
                echo "ERREUR" . $e->GetMessage();
                Log::Title(CORE,"Erreur",ERR);
                Log::Write(CORE,$e->GetMessage(),ERR);
                throw new Exception($e->GetMessage());
            }
    }

    /*
     * Connect the use
     */
    function Connect($user)
    {
        //Store the user in the session
        Request::Connect($user);
        
        //Update the user
        $this->User = $user;
    }
    
    /*
     * Disconnect the use
     */
    function Disconnect()
    {
        Request::Disconnect($this);
        
        $this->Redirect("index");
    }
    
    /*
     * Défine if the user is connected
     */
    function IsConnected()
    {
        return Request::IsConnected($this);
    }
	 //Verifie les droits utilisateurs
	 private function NeedConnection($Group)
	 {
   	if(!empty($Group))
		{
			if($Group==Request::GetUserGroup($this))
				return true;
			else
				return false;
		}
		else
		{
			return true;
		}
		Log::Write(CORE,"Connection",INFO);
	 }

	 //Retourne le repertoire du coeur
	 function GetJDirectory()
	 {
		return $this->JDirectory;
	 }

	function GetVersion()
	{
		return $this->Version;
	}
	 //Recupere le libelle d'un code dans la langue selectionn�e
	 function GetCode($code)
	 {
	 	if($this->DataBaseEnabled)
	 		return $this->Lang->GetCode($code,$this->GetLang());
	 	else
	 		return $code;
	 }

         /*
          * Return the complete path
          */
         function GetPath($url)
         {
            if($_SERVER["HTTP_HOST"] == "localhost")
            {
               return "http://".$_SERVER['SERVER_NAME'] .$_SERVER['CONTEXT_PREFIX'] .$url;
            }
            else
            {
               return "http://".$_SERVER['SERVER_NAME'].$url;
            }
         }
	/**
	 * Retourne tous les élements multilingue
	 */
	function GetAllCode()
	{
		return $this->Lang->GetAllCode($this->GetLang());
	}


	 //Recupere la langue selectionn�
	 function GetLang($code="")
	 {
           	//Retourne le code de la langue choisi
	 	if($code =="")
	 	{
                    return Request::GetSession("Lang");
	 	}
	 	//Retourne l'identifiant
	 	else
	 	{
                    $Lang= new Langs($this);
                    $Lang->AddArgument(new Argument("Langs","Code",EQUAL,Request::GetSession("Lang")));
                    $Langs= $Lang->GetByArg();

                    if(sizeof($Langs)>0)
                            return $Langs[0]->IdEntite;
	 	}
	 }

	 //Selectionne la langue du site
	 function SetLang($lang)
	 {
	 	Request::SetSession("Lang",$lang);
	 }

	 //Retourne le skin a utiliser
	 function GetSkin()
	 {
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN")."/style.css";
	 }

	//Retourne le repertoire du skin a utiliser
	function GetDirectorySkin()
	{
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN");
	}

	 //Retourne le skin des popup
	 function GetPopUpSkin()
	 {
		return $this->GetJDirectory()."Skin/".$this->Config->GetKey("SKIN")."/Popup.php";
	 }

	 //Retourne le repertoire des scripts
	 function GetJsScript()
	 {
		return $this->GetJDirectory()."Jscripts/";
	 }

	 //Retourne le nom du site
	 function GetSiteName()
	 {
		return $this->Config->GetKey("SITENAME");
	 }

	//Retourne les actions
	function GetAction()
	{
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Action/Action.xml");

		//Recuperation des elements
		$Action = $Document->GetElementsByTagName("ELEMENT");
		$Actions = array();

		//Ajout
		foreach($Action as $action)
 		{
 			$Actions[] = $action->nodeValue;
 	    }
		return $Actions;
	}

	 //Retourne les control enregistr�
	 function GetControl($DynamicAdd=false)
	 {
	 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Control/Control.xml");

		//Recuperation des elements
		$Control = $Document->GetElementsByTagName("ELEMENT");

		$Controls = array();
		//Ajout
		foreach($Control as $control)
 		{
 			if(is_object($control) and $control->nodeValue != "JHomControl")
			{
				if( ($DynamicAdd &&  $control->getAttribute("DynamicAdd")== "True") || !$DynamicAdd)
          		{
              		$Controls[] = $control->nodeValue;
          		}
          	}

 		}
		return $Controls;
	 }

	 //Retourne les modules enregistr�s
	 function GetModule($DynamicAdd=false)
	 {
			 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Block/Block.xml");

		//Recuperation des elements
		$Module = $Document->GetElementsByTagName("ELEMENT");

		$Modules = array();
		//Ajout
		foreach($Module as $module)
 		{

 			if(is_object($module) and $module->nodeValue != "JHomBlock")
			{
				if( ($DynamicAdd &&  $module->getAttribute("DynamicAdd")== "True") || !$DynamicAdd)
	          		{
	              	  $Modules[] = $module->nodeValue;
              		}
		  	}

 		}
		return $Modules;
	 }

	 //Retourne les outils partie utilisateur
	 function GetTools($DynamicAdd=false)
	 {
			 	//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Block/Block.xml");

		//Recuperation des elements
		$Module = $Document->GetElementsByTagName("ELEMENT");

		$Modules = array();
		//Ajout
		foreach($Module as $module)
 		{
 			if(is_object($module) and $module->nodeValue != "JHomBlock")
			{
				if( ($module->getAttribute("Tool")== "True" && $module->getAttribute("Actif")== "True") )
	          		{
	              	  $Modules[] = $module->nodeValue;
              		}
		  	}
 		}
		return $Modules;
	 }

	 //Retourne les enitit�es enregistr�s
	 function GetEntite()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Entity/Entity.xml");

		//Recuperation des elements
		$Entity = $Document->GetElementsByTagName("ELEMENT");
		$Entitys = array();

		//Ajout
		foreach($Entity as $entity)
 		{
 			if($entity->getAttribute("className") != "")
 			{
 			   $Entitys[] = $entity->getAttribute("className");
 			}
 			else
 			{
    	      $Entitys[] = $entity->nodeValue;
 			}
        }
		return $Entitys;
	 }

	 //Retourne les pages enregistr�s
	 function GetPage()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Page/Page.xml");

		//Recuperation des elements
		$Page = $Document->GetElementsByTagName("ELEMENT");
		$Pages = array();

		//Ajout
		foreach($Page as $page)
 		{
 		      $Pages[] = $page->nodeValue;
        }
		return $Pages;
	 }

	 //Retourne les utilitaires enregistr�s
	 function GetUtility()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Utility/Utility.xml");

		//Recuperation des elements
		$Utility = $Document->GetElementsByTagName("ELEMENT");
		$Utilitys = array();

		//Ajout
		foreach($Utility as $utlity)
 		{
 		      $Utilitys[] = $utlity->nodeValue;
        }
		return $Utilitys;
	 }

        //Retourne les template enregistr�s
        function GetTemplate()
	 {
		//Ouverture du fichier
		$Document=new JDOMDocument();
		$Document->load($this->GetJDirectory()."/Template/Template.xml");

		//Recuperation des elements
		$Template = $Document->GetElementsByTagName("ELEMENT");
		$Templates = array();

		//Ajout
		foreach($Template as $template)
 		{
 		      $Templates[] = $template->nodeValue;
                }
		return $Templates;
	 }
	  //Retourne les utilisateurs admin
	 function GetAdminUser()
	 {
	 	//Recuperation groupeAdmin
	 	$Group = new Group($this);
		$Group->GetByName("Admin");

		$User = new User($this);
	 	$User->AddArgument(new Argument("User","GroupeId",EQUAL,$Group->IdEntite));
	 	$Users = $User->GetByArg();

	 	return $Users;
	 }

	 //Redirection
	 function Redirect($Url)
	 {
	 	if(!headers_sent())
	 		header("Location:$Url");
	 	else
	 		echo "<script type='text/javascript'>window.location.replace('$Url');</script>";
	 }

	/**
	 * Récupere le repertoire utilisateur
	 */
	public function GetUserDirectory($idUser ="")
	{
		if($idUser == "")
		{
			$userId = $_SESSION[md5("Webemyos_User")];
		}
		else
		{
			$userId = $idUser;
		}

		$user = new User($this);
		$user->GetById($userId);

		return "../".$user->Serveur->Value."/User/".md5($userId)."";
	}

	 /*
	  * Recupere l'url de fnd écran utilisateur
	  */
	 public static function GetUserBackGround()
	 {
	 	//Recuperation de l'utilisateur dans la session
		$user = $_SESSION[md5("WebEmyos_User")];
	 	//ouverture du fichier de parametrage
	 	$fileName = "../../../Membre/User/".md5($user)."/Apps/EeParameter.xml";

		//Ouverture du fichier de configuration
		$dom = new DomDocument();
		$dom->Load($fileName);

		$Config = $dom->getElementsByTagName("config");

		if($Config->item(0) != null)
		{
			//Recherche de la cle 2
			if($Config->item(0)->childNodes != null)
			{
				foreach($Config->item(0)->childNodes as $node)
				{
					if($node->getAttribute("key") == 2)
					{
						$value = $node->getAttribute("value");
					}
					if($node->getAttribute("key") == 3)
					{
						if($node->getAttribute("value") == "1")
							$showImage = true;
						else
							$showImage = false;

					}
				}
			}
		}

		if($showImage)
	 		return $value;
	 	else
	 		return '';

	 }

	 /**
	  * Recupere un message de validation OK
	  * */
	 function GetMessageValid($id='')
	 {
	 	if($id != '')
	 	{
	 		$id= "id='".$id."'";
	 	}
	 	return "<span class='FormUserValid' $id>".$this->GetCode("SaveOk")."</span>";
	 }

	 /**
	  * Recupere un message d'erreur'
	  * */
	 function GetMessageError($id='')
	 {
	 	if($id != '')
	 	{
	 		$id= "id='".$id."'";
	 	}
	 	return "<span class='FormUserError'>".$this->GetCode("Error")."</span>";
	 }
}
?>
