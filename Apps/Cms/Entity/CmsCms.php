<?php
/*
*Description de l'entite
*/
namespace Apps\Cms\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class CmsCms extends Entity
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="CmsCms";
		$this->Alias = "CmsCms";

		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias);
		$this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias);
		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);

                //Partage entre application
		$this->AddSharedProperty();

		//Creation de l entité
		$this->Create();
	}
}
?>
