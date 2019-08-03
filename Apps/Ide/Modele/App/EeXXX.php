<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeXXX;

 
 use Core\Core\Core;
 use Apps\Base\Base;
 
class EeXXX extends Base
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
        $this->Core = Core::getInstance();  
		parent::__construct($this->Core, "EeXXX");
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "EeXXX", "EeXXX");
	 }
     
     /**
	 * Définie les routes publiques
	 */
	function GetRoute($routes ="")
	{
		parent::GetRoute(array());
		return $this->Route;
  	}
}
?>