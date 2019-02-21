<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

use Core\Core\Request;

/**
 * Description of Property
 *
 * @author jerome
 */
//Classe de base pour toutes les proprietes
//propriete d'une entite
class Property
{
	//Proprietes
	private $Name;
	private $TableName;
	private $Type;
	private $Obligatory;
	private $Libelle;
	private $ToolTip;
	private $Value;
	private	$Valid=true;
	private $Control;
	private $Alias;
	private $Insert;
	private $Update;

	//Constructeur
	function __construct($name,$tableName,$type,$obligatory,$alias="",$insert=true,$update=true)
	{
		$this->Name =$name;
		$this->Libelle=$name;
		$this->TableName =$tableName;
		$this->Type =$type;
		$this->Obligatory=$obligatory;
		$this->Alias=$alias;
		$this->Insert = $insert;
		$this->Update = $update;
		$this->Init();
	}

	//Initialisation du control afin qu'il soit accessible a l'exterieur
	function Init()
	{
            if($this->Type)
                $this->Control=new $this->Type($this->TableName);
	}

	//Chargement du control et verification
	function Load()
	{
		//Creation du control asscociï¿½
		if($this->Type)
		{
			//Chargement avec les valeur postï¿½ ou les valeur de l'entitï¿½
	 		if(Request::GetPost($this->TableName) !== false)
	 		{
        		$this->Control->Value=Request::GetPost($this->TableName);
	 			$this->Value=Request::GetPost($this->TableName);
			}
	 		else
	 		{
	 			// Dans le cas d'une checbox non cochï¿½ et que c'est une action utilisateur ormis reception de commande la case et initialiser ï¿½ 0
	 			if(get_class($this->Control) == "CheckBox" && Request::GetPost("UserAction") != false)
	 			{
					$this->Control->Value = 0;
					$this->Value=0;
				}
				// Sinon la variable est initialisï¿½e avec la valeur de l'entitï¿½
				else
				{
					$this->Control->Value= $this->Value;
					$this->Value= $this->Value;
			 	}
	 		}
			//Verification
			$Verif=true;

			if(!$this->Control->Verify())
				$Verif=false;

			if($this->Obligatory && $this->Value == ""/*(Request::GetPost($this->TableName)=="")*/)
				{
					$Verif=false;
					$this->Control->Obligatory=false;
				}

			$this->Valid = $Verif;
		}
	}
        
        /*
         * Obtient le nom de la propriété
         */
        function GetName()
        {
            return $this->Name;
        }

	//Verification
	function IsValid()
	{
		$this->Load();
		return $this->Valid;
	}
	//Affichage
 	function Show()
  	{
  		$this->Load();
  	 	return $this->Control->Show();
  	}

	//Assecceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
		 $this->$name=$value;
	}
}