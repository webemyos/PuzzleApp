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

class DownloaderRessourceContact extends Entity
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="DownloaderRessourceContact";
		$this->Alias = "DownloaderRessourceContact";

		$this->RessourceId = new Property("RessourceId", "RessourceId", NUMERICBOX,  true, $this->Alias);
		$this->Email = new Property("Email", "Email", TEXTBOX,  true, $this->Alias);

		//Creation de l entité
		$this->Create();
	}
}
?>
