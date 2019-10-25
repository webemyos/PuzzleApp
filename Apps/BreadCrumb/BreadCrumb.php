<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\BreadCrumb;

use Core\App\Application;
use Apps\BreadCrumb\Module\Front\FrontController;
 
class BreadCrumb extends Application
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
		parent::__construct($core, "BreadCrumb");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "BreadCrumb", "BreadCrumb");
	 }

	 /**
	  * Ajout ajotu depuis les templates
	  */
	 function GetWidget()
	 {
		 $frontController = new FrontController($this->Core);
		 return $frontController->GetWidget();
	 }
}
?>