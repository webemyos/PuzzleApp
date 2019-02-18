<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Sitemap;

use Core\App\Application;
use Apps\EeApp\EeApp;
 
class Sitemap extends Application
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
		parent::__construct($core, "Sitemap");
		$this->Core = $core;
	}

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
		echo parent::RunApp($this->Core, "Sitemap", "Sitemap");
	 }

	 /**
	  * Get The SiteMap of the site
	  */
	 function Execute()
	 {
		$siteMap = "<?xml version='1.0' encoding='utf-8'?>";
		
		$urlBase = $this->Core->GetPath("");
		$siteMap .= "<urlset xmlns='http://www.google.com/schemas/sitemap/0.84'>";
		$siteMap .= "<url><loc>$urlBase/index.html</loc></url>";
		
		$eapp = new EeApp();
		$apps = $eapp->GetAll();

		foreach($apps as $app)
		{
			$appPath = "\\Apps\\".$app->Name->Value . "\\".$app->Name->Value;
			$ap = new $appPath($this->Core);
			$siteMap .= $ap->GetSiteMap();
		}


		$siteMap .= "</urlset>";

		echo $siteMap;
	 }
}
?>