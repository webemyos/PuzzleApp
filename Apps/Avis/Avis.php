<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Avis;

use Core\App\Application;
use Core\Core\Request;
use Core\Core\Core;

use Apps\Avis\Module\Front\FrontController;
use Apps\Avis\Module\Admin\AdminController;


class Avis extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Webemyos';
	public $Version = '1.0.0';
   
	/**
	 * Constructeur
	 * */
	function __construct()
	{
		$core = Core::getInstance();
		parent::__construct($core, "Avis");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "Avis", "Avis");
	 }


	/**
	 * Permet de déposer un avis
	 */
	 function Depose()
	 {
	 	$frontController = new FrontController($this->Core);
	 	return $frontController->Depose();
	 }

	/***
	 * Affiche les avis actis
	 * @return bool|mixed|string
	 */
	function ListAvis()
	{
		$frontController = new FrontController($this->Core);
		return $frontController->ListAvis();

	}

	/***
	 * Obtient les avis
	 * @return bool|mixed|string
	 */
	 function GetAvis()
	 {
		 $adminController = new AdminController($this->Core);
		 return $adminController->Index();
	 }

	/**
	 * Edite l'avis
	 */
	 function EditAvis()
	 {
		 $adminController = new AdminController($this->Core);
		 return $adminController->EditAvis(Request::GetPost("entityId"));
	 }

	/***
	 * Retourne une widget listant les avis sur une entité et permattant d'en rajouter
	 */
	 function GetWidget($appName ="", $entityId ="")
	 {
		$frontController = new FrontController($this->Core);
		$html = $frontController->GetWidget($appName, $entityId);

		if(Request::IsPost())
		{
			return $this->Core->GetCode("Avis.AvisSaved");
		}
		else
		{
			return $html;
		}
	 }

	 function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
	 {
		$directory = "Data/Tmp";

		//Sauvegarde
		move_uploaded_file($tmpFileName, $directory."/".$idElement.".jpg");

	 }
}
?>