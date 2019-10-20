<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Feedback;

use Core\Core\Core;
use Apps\Base\Base;
use Core\App\Application;
use Core\Core\Request;
use Apps\Feedback\Module\Home\HomeController;
use Apps\Feedback\Module\Widget\WidgetController;
 
class Feedback extends Base
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
		$this->Core = Core::getInstance();
        parent::__construct($this->Core, "Feedback");
	}

	/**
	 * Execution de l'application
	 */
	function Run()
	{
		echo parent::RunApp($this->Core, "Feedback", "Feedback");
	}

	/**
	 * Widget button FeedBack
	 */
	function GetWidget()
	{
		$widgetController = new WidgetController($this->Core);
		return $widgetController->Index();
	}

	/**
	 * pop in d'ajout de feedback
	 */
	function showAddFeed()
	{
		$widgetController = new WidgetController($this->Core);
		return $widgetController->ShowAddFeed();
	}

	/**
	 * Affiche le détail d'un feedBack
	 */
	function EditFeedback()
	{
		$homeController = new HomeController($this->Core);
		return $homeController->EditFeedback(Request::GetPost("entityId"));
	}

	/**
	 * Obtient les feedBack
	 */
	function GetFeedback()
	{
		$homeController = new HomeController($this->Core);
		return $homeController->Index();
	}
}
?>