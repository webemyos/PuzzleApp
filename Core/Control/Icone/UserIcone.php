<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

use Core\Control\IControl;
use Core\Control\Control;

/*
* Icone utilisateur
*/
class UserIcone extends Icone
{
    function __construct($core = null)
    {
        $this->CssClass = "fa fa-user";

        if($core != null)
        {
            $this->Title = $core->GetCode("User");
        }
    }
}

