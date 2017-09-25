<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\TextBox;

use Core\Control\IControl;
use Core\Control\Control;

class TextBox extends Control implements IControl
{
    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.0.0";

        $this->Id=$name;
        $this->Name=$name;
        $this->Type="text";
        $this->CssClass="form-control";
    }
}
?>