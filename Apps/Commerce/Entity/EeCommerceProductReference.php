<?php 
/* 
*Description de l'entite
*/
class EeCommerceProductReference extends JHomEntity  
{
	//Constructeur
	function EeCommerceProductReference($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceProductReference"; 
		$this->Alias = "EeCommerceProductReference"; 

		$this->ProductId = new Property("ProductId", "ProductId", NUMERICBOX,  true, $this->Alias); 
		$this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
		$this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  true, $this->Alias); 
		$this->Quantity = new Property("Quantity", "Quantity", NUMERICBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>