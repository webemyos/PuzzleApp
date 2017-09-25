<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Action;

class Action
{
	//Propri�te
	protected $Action;
	protected $Arg;

	//Constructeur
	function __construct($fonction,$arg="")
	{
		//Version
		$this->Version = "2.0.0.0";

		$this->Action=$fonction;
		$this->Arg=$arg;
	}

	//Enregistrement de l'action � effectuer
	function DoAction()
	{
		return "this.form.Action.value = '$this->Action' ; this.form.submit()";
	}
}
?>