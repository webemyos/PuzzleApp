<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class BlogUserNewLetter extends Entity  
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="BlogUserNewLetter"; 
		$this->Alias = "BlogUserNewLetter"; 

		$this->BlogId = new Property("BlogId", "BlogId", NUMERICBOX,  true, $this->Alias); 
		$this->Email = new Property("Email", "Email", EMAILBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>