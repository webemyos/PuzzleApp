<?php

namespace Core\Control\ToolTip;

use Core\Control\Control;
use Core\Control\IControl;
/*
 * Classe de base pour les tooltips
 */

 class ToolTip extends Control implements IControl
{

	private $IdEntity;
	private $Class;
	private $Methode;
	private $Url;

	//Constructeur
	function __construct($class="", $methode="", $idEntity="",$url="")
	{
		//Version
		$this->Version = "2.0.1.1";
		$this->Class=$class;
		$this->Methode = $methode;
		$this->IdEntity = $idEntity;
		$this->Url=$url;
	}

	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		return "var toolTip=new ToolTip(this);toolTip.url ='".$this->Url."';toolTip.data='Type=core&Class=".$this->Class."&App=".$this->Class."&Methode=".$this->Methode."&idEntity=".$this->IdEntity."';toolTip.Open();";
	}

	//Asseceur
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
