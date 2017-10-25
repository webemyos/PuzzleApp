<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

/*
* Icone d'ajout
*/
class AddIcone extends Icone
{
    function __construct($core)
    {
        $this->CssClass = "fa fa-plus";

        if($core != null)
        {
            $this->Title = $core->GetCode("Add");
        }
    }
}
