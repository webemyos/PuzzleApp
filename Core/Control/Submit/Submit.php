<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Submit;

use Core\Core\Request;
use Core\Control\IControl;
use Core\Control\Control;

class Submit extends Control implements IControl
{
    //Constructeur
    function __construct($type, $id ="")
    {
        //Version
        $this->Version ="2.0.0.1";
        $this->AutoCapitalize = 'None';
        $this->AutoCorrect = 'None';
        $this->CssClass = 'btn btn-primary';

        if($id != "")
        {
            $this->Id = $id;
        }

        $this->Type="submit";
    }
}

?>