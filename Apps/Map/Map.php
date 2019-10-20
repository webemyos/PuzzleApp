<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Map;

use Core\App\Application;
use Apps\Map\Module\Front\FrontController;
 
class Map extends Application
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
		parent::__construct($core, "Map");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "Map", "Map");
	 }

	/**
	 * Affiche une carte 
	 * */ 
	function GetWidget()
	{
		$frontController = new FrontController($this->Core);
		return $frontController->GetWidget();
	} 
}
?>