<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Libelle;

use Core\Control\IControl;
use Core\Control\Control;

class Libelle extends Control implements IControl
{
	//Constructeur
	function __construct($text,$name="")
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Text=$text;
		$this->Name = $name;
		$this->Id= $name;
	}

	//Affichage
	function Show()
	{
		if($this->Name)
                {
                    if($this->OnClick != "")
                    {
			$TextControl ="<p id=".$this->Name." onclick='".$this->OnClick."'>".$this->Text."<p>";
                    }
                    else
                    {
			$TextControl ="<p id='".$this->Name."' >".$this->Text."<p>";
                    }
                }
		else
			$TextControl = $this->Text;

		return $TextControl ;
	}
}
?>
