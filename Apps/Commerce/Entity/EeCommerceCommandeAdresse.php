<?php 
/* 
*Description de l'entite
*/
class EeCommerceCommandeAdresse extends JHomEntity  
{
     const LIVRAISON = 1;
     const FACTURATION = 2;
        
	//Constructeur
	function EeCommerceCommandeAdresse($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceCommandeAdresse"; 
		$this->Alias = "EeCommerceCommandeAdresse"; 

		$this->TypeId = new Property("TypeId", "TypeId", NUMERICBOX,  true, $this->Alias); 
		$this->CityId = new Property("CityId", "CityId", NUMERICBOX,  false, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Adress = new Property("Adress", "Adress", TEXTBOX,  true, $this->Alias); 
		$this->Complement = new Property("Complement", "Complement", TEXTBOX,  false, $this->Alias); 
		$this->CodePostal = new Property("CodePostal", "CodePostal", TEXTBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>