<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\Link;

 use Core\Control\IControl;
 use Core\Control\Control;

class Link extends Control implements IControl
{
	//Propriete
	private $Link;
	private $Url;
	private $Target;
	private $Alt;
	private $Title;

	//Constructeur
	function __construct($link,$url="")
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Url=$url;
		$this->Link=$link;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<a href='".$this->Url."'";
		$TextControl .= $this->getProperties();
		$TextControl .=($this->Alt !="")? "  alt='".$this->Alt. "'" : "";
		$TextControl .=($this->Title !="")? "  title='".$this->Title. "'" : "";

		if($this->Target)
		{
			$TextControl .= " target='".$this->Target."'";
		}

		$TextControl .=">";

		$TextControl .=$this->Link."</a>";

		return $TextControl ;
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
?>
