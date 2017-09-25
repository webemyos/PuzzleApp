<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EmailBox;

use Core\Control\IControl;
use Core\Control\Control;

use Core\Utility\Format\Format;

class EmailBox extends Control implements IControl
{
    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.1.0";

        $this->Id=$name;
        $this->Name=$name;
        $this->Type="email";
        $this->RegExp="'^([a-zA-Z0-9].+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,4})$'";
        //$this->RegExp="'^[a-z0-9-+_](\.?[a-z0-9-+_])*@[a-z0-9-+_](\.?[a-z0-9-+_])*\.[a-z]{2,4}$'i";
        $this->MessageErreur="Email invalide";
        $this->CssClass="form-control";

    }
}
?>