<?php 
/*
* PuzzleApp
* Webemyos
* Jérôme Oliva
* GNU Licence
*/

namespace Apps\Avis\Entity;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class AvisAvis extends Entity  
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="AvisAvis"; 
		$this->Alias = "AvisAvis"; 

		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias);
		$this->Avis = new Property("Avis", "Avis", TEXTAREA,  true, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 
		$this->Actif = new Property("Actif", "Actif", CHECKBOX,  false, $this->Alias);

		//Partage entre application 
		$this->AddSharedProperty();

		//Creation de l entité 
		$this->Create(); 
	}
}
?>