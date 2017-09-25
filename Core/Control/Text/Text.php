<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Text;
use Core\Control\Control;
use Core\Control\IControl;

class Text extends Control implements IControl
{
	/**
	 * Titre
	 * */
	private $Title="";

	/**
	 * Texte affich�
	 * */
	private $Text="";
        
       	/**
	 * Constructeur
	 * */
	public function __construct($name,$div=false, $value)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		$this->Div = $div;
                $this->Text= $value;
	}

	/**
	 * Affiche le controle
	 * */
	function Show()
	{
		//Passage de la valeur dans le champ text pour la compatibilte avec les autres controls
		if(empty($this->Text))
		{
                     $this->Text=$this->Value;
		}

		if($this->Div)
		{
		//Declaration de la balise
		$TextControl ="\n<span ";
		$TextControl .= $this->getProperties();
		$TextControl .=">";

		$TextControl .="<h2>".$this->Title."</h2>";
		$TextControl .=$this->Text;

		$TextControl .="</span>\n";
		}
		else
		{
		  $TextControl=$this->Text;
		}

		return $TextControl;
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
?>