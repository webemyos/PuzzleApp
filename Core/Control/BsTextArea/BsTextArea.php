<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\BsTextArea;

use Core\Control\Control;
use Core\Control\IControl;
use Core\Core\Request;
 
class BsTextArea extends Control implements IControl
{
	//Proprietes
	private $Title="";
	private $Text="";
        

	//Constructeur
	public function BsTextArea($name, $resize=false)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
 		$this->Name=$name;

 		$this->AutoCapitalize = 'None';
                $this->AutoCorrect = 'None';
                $this->AutoComplete = 'None';

		if($resize==true) $this->AddAttribute("onkeyup","FitToContent(this,500)");
	}

	//Affichage
	function Show()
	{
		//Recuperation d'une eventuelle valeur
		if(Request::GetPost($this->Name))
		{
			$this->Value=Request::GetPost($this->Name);
		}

		//Declaration de la balisepx
                $TextControl = "<div class='global-input-material'>";
		$TextControl .=" <p class='title'>".$this->Title."</p>";
		
                $TextControl .="\n<textArea  " ;
		$TextControl .= $this->getProperties(false);
		$TextControl .=">";

		$TextControl .=$this->Text;
		$TextControl .=$this->Value;
                $TextControl .=  "</textArea>";
                          
               $TextControl .="</div>\n";

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