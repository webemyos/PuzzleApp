<?php 
/* 
*Description de l'entite
*/
class EeCommerceFacture extends JHomEntity  
{
	//Constructeur
	function EeCommerceFacture($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceFacture"; 
		$this->Alias = "EeCommerceFacture"; 

		$this->CommandeId = new Property("CommandeId", "CommandeId", NUMERICBOX,  true, $this->Alias); 
		$this->PriceTotal = new Property("PriceTotal", "PriceTotal", TEXTBOX,  false, $this->Alias); 
		$this->PriceTva = new Property("PriceTva", "PriceTva", TEXTBOX,  false, $this->Alias); 
		$this->Numero = new Property("Numero", "Numero", TEXTBOX,  false, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATETIMEBOX,  false, $this->Alias); 
		$this->StateId = new Property("StateId", "StateId", NUMERICBOX,  false, $this->Alias); 
		$this->File = new Property("File", "File", TEXTAREA,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>