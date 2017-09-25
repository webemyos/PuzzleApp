<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\CheckBox;

 use Core\Control\IControl;
 use Core\Control\Control;

class CheckBox extends Control implements IControl
{
	private $Checked;
	private $List;

	//Constructeur
	function __construct($name,$list=false)
	{
		//Version
		$this->Version ="2.0.1.1";

		$this->Id=$name;
		$this->Name=$name;
		$this->Type="checkBox";
		$this->List = $list;
	}

	//Affichage du control
	function Show()
	{
		if(!$this->List)
		{
			if($this->Value == 1 || $this->Checked == true)
				$chek = " checked=checked  ";
			else
				$chek="";


			$TextControl  =" \n<input type=".$this->Type."  value='1'" ;
			$TextControl .= $this->getProperties();
			$TextControl .= $chek.">";

			//$TextControl .= $this->Libelle;
		}
		else
		{
			if($this->Checked == true )
				$chek = " checked=checked  ";
			else
				$chek="";


			$TextControl  =" \n<input type=".$this->Type."  value='$this->Value'" ;
			$TextControl .= $this->getProperties();
			$TextControl .= $chek.">";

		//$TextControl .= $this->Libelle;

		}

		return $TextControl;
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
