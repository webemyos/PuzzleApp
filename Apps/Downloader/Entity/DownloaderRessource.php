<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class DownloaderRessource extends Entity
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="DownloaderRessource";
		$this->Alias = "DownloaderRessource";

		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
		$this->Url = new Property("Url", "Url", TEXTAREA,  true, $this->Alias);

		//Partage entre application
		$this->AddSharedProperty();

		//Creation de l entité
		$this->Create();
	}
}
?>
