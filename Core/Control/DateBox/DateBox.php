<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\DateBox;

use Core\Control\IControl;
use Core\Control\Control;


class DateBox extends Control implements IControl
{
    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.0.0";

        $this->Id=$name;
        $this->Name=$name;
        //$this->RegExp="'([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4})'";
        $this->MessageErreur="Date invalide elle doit être au format jj/mm/aaaa";
        $this->Type="date";
        $this->CssClass="dateBox";

        $this->CssClass="form-control";
    }

    function Show()
    {
        $TextControl = parent::show();
        
        return $TextControl;
    }
}
?>