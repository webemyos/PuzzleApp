<?php 
/* 
*Description de l'entite
*/
class EeCommerceProductCategory extends JHomEntity  
{
	//Constructeur
	function EeCommerceProductCategory($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceProductCategory"; 
		$this->Alias = "EeCommerceProductCategory"; 

		$this->CommerceId = new Property("CommerceId", "CommerceId", NUMERICBOX,  true, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>