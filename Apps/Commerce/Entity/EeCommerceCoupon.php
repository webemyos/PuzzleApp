<?php 
/* 
*Description de l'entite
*/
class EeCommerceCoupon extends JHomEntity  
{
	//Constructeur
	function EeCommerceCoupon($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceCoupon"; 
		$this->Alias = "EeCommerceCoupon"; 

		$this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
		$this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  true, $this->Alias); 
		$this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
		$this->Type = new Property("Type", "Type", NUMERICBOX,  true, $this->Alias); 
		$this->Reduction = new Property("Reduction", "Reduction", NUMERICBOX,  true, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>