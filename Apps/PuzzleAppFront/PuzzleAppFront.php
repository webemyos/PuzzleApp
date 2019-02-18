<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\PuzzleAppFront;

use Core\App\Application;
use Apps\PuzzleAppFront\Entity\Member;
 
class PuzzleAppFront extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Webemyos';
	public $Version = '1.0.0';
	public static $Directory = "../Apps/PuzzleAppFront";

	/**
	 * Constructeur
	 * */
	function __construct($core)
	{
		parent::__construct($core, "PuzzleAppFront");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "PuzzleAppFront", "PuzzleAppFront");
	 }

	 function GetMember()
	 {
		$member = new Member($this->Core);
		$entities =  $member->GetAll();
		$json = array();

		foreach($entities as $entite)
		{
			$json[] = $entite->ToArray();
		}

		echo json_encode($json);
    }
}
?>