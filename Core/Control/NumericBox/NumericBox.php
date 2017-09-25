<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\NumericBox;

use Core\Control\IControl;
use Core\Control\Control;

class NumericBox extends Control implements IControl
{
	//Constructeur
	function __construct($name)
	{
            //Version
            $this->Version ="2.0.0.0";

            $this->Id=$name;
            $this->Name=$name;
            $this->Type="number";
            $this->RegExp="'^[0-9]*$'";
            $this->CssClass="form-control";
	}
}
?>