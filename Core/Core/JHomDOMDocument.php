<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core; 

class JHomDomDocument extends \DOMDocument
{

}
   	//Propriete
 /*	private $File;
 	private $Parser;
 	private $item=array();
 	public $Elements;

 	public static $Last;
 	public static $Tab=array();
 	public static $i;
 	public $Version;

 	//Constructeur
 	function __construct()
 	{
 		//Version
		$this->Version = "2.1.0.0";
  	}

	//Chargement du fichier
	function Load($file)
	{
		//initialisation des variables
		isset(self::$Tab);
		self::$i=0;

		$this->File=$file;
		$this->Parser=xml_parser_create();
		$this->Read();
		$this->Elements=self::$Tab;
	}

	//Lecture du fichier
	function Read()
	{
		//Definition des fonctions appel�es
		 xml_set_element_handler($this->Parser, "JHomDomDocument::Open", "JHomDomDocument::Close");
		 xml_set_character_data_handler($this->Parser, "JHomDomDocument::LoadOccurence");

		 //Ouverture du document
		 $fp = fopen($this->File, "r");
		 if (!$fp)
		 	die("Vous n'avez pas uploader de fichier XML");

		 while( $ligneXML = fgets($fp, 1024))
	 	 {
	 		xml_parse($this->Parser, $ligneXML, feof($fp))
 	 			or
	 				die("Erreur XML");
	 	 }
	 	xml_parser_free($this->Parser);
		fclose($fp);
	}

	//Evenement declench� � l'ouverture d'une balise
	public static function Open($parseur, $nomBalise, $tableauAttributs)
	{
		self::$Last= $nomBalise;
 	}

	//Evenement declench� �	la fermeture d'une balise
	public static function Close($parseur, $nomBalise)
	{
		self::$Last = "";
	}

	//Evenement declench� � la lecture d'une balise
	public static function LoadOccurence($parseur, $texte)
	{
	  if(!empty($texte) && $texte != "<br/>")
		 	{
		 		self::$Tab[self::$i][0]=self::$Last;
			 	self::$Tab[self::$i][1]=$texte;
			 	self::$i++;
			 }
	}

	//Retourne les elements trouv� avec ce nom de balise
	public function GetElementsByTagName($Name)
	{
	    //Chargement des elements
		$this->LoadItem();
		$items=new Items();
		//
		foreach($this->item as $item)
		{
			if($item->nodeName==$Name)
			{
				$items->Add($item);
			}
		}

		 return $items;
	}

	//Charge les items
	private function LoadItem()
	{
		//Parcourr le tableau et creer un item
		foreach(JHomDomDocument::$Tab as $item)
		{
			if(!empty($item[0]))
			{
				$Item=new Item();
				$Item->nodeName = $item[0];
				$Item->nodeValue = $item[1];

				//Ajout dans le tableau d'element
				$this->item[]=$Item;
			}
		}
	}

	//Asseceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
	  $this->$name=$value;
	}
 }

//Element d'un DOM
class Item
{
	//Propri�t�
	private $nodeName;
	private $nodeValue;

	//Constructeur
	function Item()
	{
	}

	//asseceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
	  $this->$name=$value;
	}
}

//Conteneur d'element
class Items
{
	public $element=array();
	private $i;

	//Constructeur
	function Items()
	{
		$this->i=0;
	}

	//Ajout d'un element
	function Add($item)
	{
		$this->element[$this->i]=$item;
		$this->i++;
	}

	//Retourne un item
	function item($i)
	{
		if(isset($this->element[$i]))
	    	return $this->element[$i];
	 	else
	 		return null;
	 }
}

/*
//Test si l'extension Dom est charg�
if(class_exists("DomDocument"))
{
	class JDomDocument extends DomDocument
	{
		public $Version;
		//Constructeur
		function JDomDocument()
		{
			$this->Version= "2.0.0.1";
		}
	}
}
else
{
	class JDomDocument extends JHomDomDocument
	{
		public $Version;
		//Constructeur
		function JDomDocument()
		{
			$this->Version= "2.0.0.1";
		}
	}
}
 * */

 
?>