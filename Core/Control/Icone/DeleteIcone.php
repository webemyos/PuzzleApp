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
* Icone de commentaire
*/
class DeleteIcone extends Icone
{
	function __construct()
	{
		$core = Core::getInstance();

		$this->CssClass = "fa fa-remove";

    if($core != null)
    {
        $this->Title = $core->GetCode("Comment");
    }
	}
}
