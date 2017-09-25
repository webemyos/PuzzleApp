<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

use Core\Core\Core;

/*
* Icone de parametre
*/
class ParameterIcone extends Icone
{
	function __construct()
	{
		$core = Core::getInstance();

		$this->CssClass = "fa fa-gear";

    if($core != null)
    {
        $this->Title = $core->GetCode("Parameter");
    }
	}
}
