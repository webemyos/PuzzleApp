<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Action\UserAction;

use Core\Action\Action;

class UserAction extends Action
{
	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		//Version
		$this->Version = "2.0.0.0";

		return "JUserAction.DoAction('".$this->Action."','".$this->Arg."',this);";
	}
}
?>