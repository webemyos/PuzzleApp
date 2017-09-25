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
* Icone de partage
*/
class GroupIcone extends Icone
{
	function __construct()
	{
		$core = Core::getInstance();

		$this->CssClass = "fa fa-group";

    if($core != null)
    {
        $this->Title = $core->GetCode("Group");
    }
	}
}
