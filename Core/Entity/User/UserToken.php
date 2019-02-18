<?php 
/*
* PuzzleApp
* Webemyos
* Jérôme Oliva
* GNU Licence
*/

namespace Core\Entity\User;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class UserToken extends Entity  
{
	protected $User;

	//Constructeur
	function __construct($core)
	{
		
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="ee_userToken"; 
		$this->Alias = "ee_userToken"; 

		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
		$this->User = new EntityProperty("Core\Entity\User\User", "UserId"); 
		$this->Token = new Property("Token", "Token", TEXTAREA,  true, $this->Alias); 
		$this->Expire = new Property("Expire", "Expire", TEXTBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>