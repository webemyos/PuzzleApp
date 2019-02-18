<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\EeXXX;

use Core\App\Application;
 
class EeXXX extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Webemyos';
	public $Version = '1.0.0';
   
	/**
	 * Constructeur
	 * */
	function __construct($core)
	{
		parent::__construct($core, "EeXXX");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "EeXXX", "EeXXX");
	 }
}
?>