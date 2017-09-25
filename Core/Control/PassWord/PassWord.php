<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\PassWord;

use Core\Control\IControl;
use Core\Control\Control;

class PassWord extends Control implements IControl
{
	//Constructeur
	function __construct($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Type="password";
		$this->Name=$name;
                $this->CssClass="form-control";
	}
}
?>