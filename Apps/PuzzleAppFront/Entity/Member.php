<?php 
/*
* PuzzleApp
* Webemyos
* Jérôme Oliva
* GNU Licence
*/

namespace Apps\PuzzleAppFront\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class Member extends Entity  
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="Member"; 
		$this->Alias = "Member"; 

		$this->Nom = new Property("Nom", "Nom", TEXTAREA,  true, $this->Alias); 
		$this->Prenom = new Property("Prenom", "Prenom", TEXTAREA,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>