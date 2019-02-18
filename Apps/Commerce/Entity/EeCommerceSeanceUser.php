<?php 
/* 
*Description de l'entite
*/
class EeCommerceSeanceUser extends JHomEntity  
{
	//Constructeur
	function EeCommerceSeanceUser($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceSeanceUser"; 
		$this->Alias = "EeCommerceSeanceUser"; 

		$this->SeanceId = new Property("SeanceId", "SeanceId", NUMERICBOX,  true, $this->Alias); 
		$this->Ip = new Property("Ip", "Ip", TEXTBOX,  true, $this->Alias); 
		$this->Navigateur = new Property("Navigateur", "Navigateur", TEXTBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>