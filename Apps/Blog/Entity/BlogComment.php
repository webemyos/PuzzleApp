<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class BlogComment extends Entity  
{
    protected $User;
    
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="BlogComment"; 
		$this->Alias = "BlogComment"; 

		$this->ArticleId = new Property("ArticleId", "ArticleId", NUMERICBOX,  true, $this->Alias); 
		$this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
		$this->UserName = new Property("UserName", "UserName", TEXTBOX,  false, $this->Alias); 
		$this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias); 
		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 
                $this->User = new EntityProperty("User", "UserId");
                $this->DateCreated =  new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 
                
                $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>