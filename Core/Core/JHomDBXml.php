<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */


class JHomDBXml implements IJHomDb
{
	var $dom;
	var $file;
	var $fileIsLoaded = false;
	private $Directory;

	/*
	 * Constructeur
	 * @param $file nom du fichier de base de donn�e
	 * */
	public function JHomDBXml($file="",$directory="")
	{
		$this->dom = new DomDocument();
		$this->Directory = $directory;

		if($file != "")
		{
			if(@$this->dom->load($file))
				$this->fileIsLoaded = true;
			else
			{
				$fh = fopen($file, 'w') or die("XMLDataStore : impossible de cr�er le fichier XML.");
				fwrite($fh,'<?xml version="1.0" encoding="ISO-8859-1" ?><config LastInsertId="0"></config>');
				fclose($fh);
			}
		}
		$this->file = $file;
	}

	/**
	 * Charge le fichier XML
	 * @param $file Nom du fichier
	 * */
	public function Load($file)
	{
		if(@$this->dom->load($file))
				$this->fileIsLoaded = true;
			else
			{
				$fh = fopen($file, 'w') or die("XMLDataStore : impossible de cr�er le fichier XML.");
				fwrite($fh,'<?xml version="1.0" encoding="ISO-8859-1" ?><config LastInsertId="0"></config>');
				fclose($fh);
			}

		$this->file = $file;
	}

	/*
	 * Recupere un ligne
	 * @param $request requete sql
	 * @param $fields Champs recherch�
	 * @param $tables table contenant les �l�ments
	 * @param $alias Alias de tables
	 * @param $arguments Argument pour filtrer
	 * \return un tableau de valeurs
	 * */
	public function GetLine($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		$this->Load($this->Directory."/Data/".$tables.".xml");

		$domNodeList = $this->dom->getElementsByTagName($tables);

		foreach($domNodeList as $node)
		{
			if($node->getAttribute("Id") == $arguments["Id"])
			{
				$value = array();

				//Enregistrement de l'identifiant
				$value["Id"] = $arguments["Id"];

				foreach($fields as $field)
				{
					$value[$alias."_".$field] = $node->getAttribute($field);
				}
				return $value;
			}
		}

	}

    /*
     * Recupere un noeud par son identifiant
     * @param $tables tables contenant les objets
     * @param $id identifiant recherch�
     * \return le noeud
     * */
	public function GetNodeById($tables,$id)
	{
		$domNodeList = $this->dom->getElementsByTagName($tables);

		foreach($domNodeList as $node)
		{
			if($node->getAttribute("Id") == $id)
			{
				return $node;
			}
		}
	}

	/*
	 * Retourne un tableau de valeur
	 * @param $request requete sql
	 * @param $fields Champs
	 * @param $tables table contenant les donn�es
	 * \return un tableau de valeur
	 * */
	public function GetArray($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		$this->Load($this->Directory."/Data/".$tables.".xml");

		$value = array();

		$domNodeList = $this->dom->getElementsByTagName($tables);

		$i=0;

		foreach($domNodeList as $node)
		{
			$argValide = 0;
			//Filtre sur les arguments
			if($arguments && sizeof($arguments)>0)
			{
				foreach($arguments as $key=>$valu)
				{
					if($node->getAttribute($key) == $valu)
					{
						$argValide++;
					}
				}
				//Si tous les argument correspondent on l'ajoute
				if($argValide == sizeof($arguments))
				{
					$value[$i] = array();

					//Enregistrement de l'identifiant
					$value[$i]["Id"] = $node->getAttribute("Id");

					foreach($fields as $field)
					{
						$value[$i][$alias."_".$field] = $node->getAttribute($field);
					}
					$i++;
				}
			}
			else
			{
				$value[$i] = array();

					//Enregistrement de l'identifiant
					$value[$i]["Id"] = $node->getAttribute("Id");

					foreach($fields as $field)
					{
						$value[$i][$alias."_".$field] = $node->getAttribute($field);
					}
					$i++;
			}
		}
		return $value;
	}

	/*
	 * Recupere un element par son code
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByCode($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		$this->Load($this->Directory."/Data/".$tables.".xml");

		$domNodeList = $this->dom->getElementsByTagName($tables);

		foreach($domNodeList as $node)
		{
			if($node->getAttribute("Code") == $arguments["Code"])
			{
				$value = array();

				//Enregistrement de l'identifiant
				$value["Id"] = $node->getAttribute("Id");

				foreach($fields as $field)
				{
					$value[$alias."_".$field] = $node->getAttribute($field);
				}
				return $value;
			}
		}
	}

 /* Recupere un element par son nom
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByName($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		$this->Load($this->Directory."/Data/".$tables.".xml");

		$domNodeList = $this->dom->getElementsByTagName($tables);

		foreach($domNodeList as $node)
		{
			if($node->getAttribute("Name") == $arguments["Name"])
			{
				$value = array();

				//Enregistrement de l'identifiant
				$value["Id"] = $node->getAttribute("Id");

				foreach($fields as $field)
				{
					$value[$alias."_".$field] = $node->getAttribute($field);
				}
				return $value;
			}
		}
	}

	/*
	 * Execute un requete (Insert ou update un noeud)
	 * @param $request requetes sql
	 * @param $fields Champs recherch�
	 * @param $tables table contenant les �l�ments
	 * @param $alias Alias de tables
	 * @param $arguments Argument pour filtrer
	 * */
	public function Execute($request,$fields="",$tables="",$alias="",$arguments="",$action="Save")
	{
		$this->Load($this->Directory."/Data/".$tables.".xml");

		switch($action)
		{
			case "Save" :
				//TODO � ameliorer
				if(isset($fields["Id"]))
				{
					$node = $this->GetNodeById($tables,$fields["Id"]);

					foreach($fields as $key=>$value)
					{
						$node->setAttribute($key,$value);
					}
				}
				else
				{
					$element = $this->dom->createElement($tables);
					$racine	= $this->dom->documentElement;
					$newElement = $racine->appendChild($element);

					foreach($fields as $key=>$value)
					{
						$newElement->setAttribute($key,$value);
					}
					//Creation de l'identifiant
					$domNodeList = $this->dom->getElementsByTagName("config");
					$element = $domNodeList->item(0);

					$newElement->setAttribute("Id",$element->getAttribute("LastInsertId") + 1);
					//incrementation du dernier identifiant
					$element->setAttribute("LastInsertId",$element->getAttribute("LastInsertId") + 1);
				}
				break;
				case "Delete" :
					$node = $this->GetNodeById($tables,$arguments["Id"]);

					$this->dom->documentElement->RemoveChild($node);
				break;
		}
		$this->Save();
	}

	/*
	 * Retourne le dernier identifiant ins�rer
	 * */
	public function GetInsertedId()
	{
		$domNodeList = $this->dom->getElementsByTagName("config");
		$element = $domNodeList->item(0);

		return $element->getAttribute("LastInsertId");
	}

	public function isLoaded()
	{
		return $this->fileIsLoaded;
	}

	public function getAttributeValue($idElement,$idAttribute)
	{
		$domNodeList = $this->dom->getElementsByTagName($idElement);
		if($domNodeList->length > 0)
		{
			$element = $domNodeList->item(0);

			if ($element->hasAttribute($idAttribute))
			return $element->getAttribute($idAttribute);
		}

		return null;
	}

	public function getElementValue($idElement)
	{
		$values = array();
		$elements = $this->dom->getElementsByTagName($idElement);
		foreach($elements as $element)
		array_push($values, $element->nodeValue);
		return $values;
	}

	public function removeElement($idElement)
	{
		$elements = $this->dom->getElementsByTagName($idElement);
		$racine = $this->dom->documentElement;
		if($elements->length > 0)
		{
			$racine->removeChild($elements->item(0));
			$this->removeElement($idElement);
		}
	}

	public function setElementValue($idElement, $value)
	{
		$exist = false;
		$elements = $this->dom->getElementsByTagName($idElement);
		if($elements->length > 0)
		{
			foreach($elements as $element)
			{
				if(strcmp($element->firstChild->nodeValue, $value)==0)
				$exist = true;
			}
		}

		if(!$exist)
		{
			$element 	= $this->dom->createElement($idElement);
			$textNode 	= $this->dom->createTextNode($value);
			$racine 	= $this->dom->documentElement;
			$racine->appendChild($element);
			$element->appendChild($textNode);
		}
	}

	public function setAttributeValue($idElement, $idAttribute, $value)
	{
		$domNodeList = $this->dom->getElementsByTagName($idElement);
		if($domNodeList->length > 0)
		{
			$element = $domNodeList->item(0);
			$element->setAttribute($idAttribute, $value);
		}
		else
		{
			$element = $this->dom->createElement($idElement);
			$cdata = $this->dom->createTextNode($value);
			$element->appendChild($cdata);

			$racine = $this->dom->documentElement;
			$racine ->appendChild($element);
			$element->setAttribute($idAttribute, $value);
		}
	}

	public function save()
	{
		$this->dom->save($this->file);
	}
}

?>