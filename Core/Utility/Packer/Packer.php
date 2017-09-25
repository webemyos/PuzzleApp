<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Core\Utility\Packer;

class Packer
{
	/**
	 * Compresse les Javascript de base
	 * */
	public static function Script($core)
	{
		$core->GetCode("CompressionScriptStarted");

		//Suppression du fichier
		JFile::Delete('script.js', '../Trunk');

		//Recuperation de tout les scipt js
		$Content = new JHomInclude($core->GetJDirectory().'Include.xml','.js',$core->GetJDirectory(), true);

		Packer::Compress($Content->Content, '../Trunk/script.js');

		//Page du front office
		$content = JFile::GetFileContent('../home.js');
		Packer::Compress($content, '../Trunk/home.js');
		$content = JFile::GetFileContent('../master.js');
		Packer::Compress($content, '../Trunk/master.js');
		$content = JFile::GetFileContent('../developper.js');
		Packer::Compress($content, '../Trunk/developper.js');
		$content = JFile::GetFileContent('../projet.js');
		Packer::Compress($content, '../Trunk/projet.js');
	}

	/**
	 * Compresse les javascript de la partie membre
	 * */
	public static function Eemmys()
	{
		$content = JFile::GetFileContent('../Core/Eemmys.js');
		Packer::Compress($content, '../Trunk/Eemmys.js');

		$content = JFile::GetFileContent('../Core/EeFlashMessage.js');
		Packer::Compress($content, '../Trunk/EeFlashMessage.js');

		$content = JFile::GetFileContent('../Core/EeGame.js');
		Packer::Compress($content, '../Trunk/EeGame.js');

		$content = JFile::GetFileContent('../Core/EemmysApp.js');
		Packer::Compress($content, '../Trunk/EemmysApp.js');

		$content = JFile::GetFileContent('../Core/EemmysWidget.js');
		Packer::Compress($content, '../Trunk/EemmysWidget.js');
	}

	/**
	 * Compresse les javascript des applications
	 * */
	public static function App($core)
	{
		//Recuperation des applications
		$App = new Apps($core);
		$Apps = $App->GetAll();

		foreach($Apps as $app)
		{
			$content = JFile::GetFileContent('../Apps/'.$app->Code->Value.'/'.$app->Code->Value.'.js');
			Packer::Compress($content, '../Trunk/Apps/'.$app->Code->Value.'.js');
		}
	}

	/**
	 * Compmresse les javascript des gadgets
	 * */
	public static function Widget($core)
	{
		//Recuperation des applications
		$Widget = new Widgets($core);
		$Widgets = $Widget->GetAll();

		foreach($Widgets as $widget)
		{
			$content = JFile::GetFileContent('../Widgets/'.$widget->Code->Value.'/'.$widget->Code->Value.'.js');
			Packer::Compress($content, '../Trunk/Widgets/'.$widget->Code->Value.'.js');
		}
	}

	/**
	 * Compresse tout
	 * */
	public static function All()
	{}

	/**
	 * Comrpesse un fichier
	 * */
	public static function Compress($content)
	{
		require_once 'class.JavaScriptPacker.php';

		$script = $content;

		$t1 = microtime(true);

		$packer = new \JavaScriptPacker($script, 'Normal', false, false);
		$packed = $packer->pack();

		$t2 = microtime(true);
		$time = sprintf('%.4f', ($t2 - $t1) );

		return $packed;
	}

}

?>