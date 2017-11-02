<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\DateTimeBox;

use Core\Control\IControl;
use Core\Control\Control;

class DateTimeBox extends Control implements IControl
{
    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.0.0";

        $this->Id=$name;
        $this->Name=$name;
       // $this->RegExp="'([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4})'";
        $this->MessageErreur="Date invalide elle doit être au format jj/mm/aaaa";
        $this->Type="time";
        $this->CssClass="form-control";
    }
}
?>