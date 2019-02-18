<?php 
/* 
*Description de l'entite
*/
class EeCommerceVirement extends JHomEntity  
{
        const CREATE = 1;
        const VALID = 2;
        const ERROR = 3;
    
	//Constructeur
	function EeCommerceVirement($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceVirement"; 
		$this->Alias = "EeCommerceVirement"; 

		$this->CommandeId = new Property("CommandeId", "CommandeId", NUMERICBOX,  true, $this->Alias); 
		$this->FournisseurId = new Property("FournisseurId", "FournisseurId", TEXTBOX,  false, $this->Alias); 
		$this->Montant = new Property("Montant", "Montant", TEXTBOX,  false, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATETIMEBOX,  false, $this->Alias); 
		$this->StateId = new Property("StateId", "StateId", NUMERICBOX,  false, $this->Alias); 
		
		//Creation de l entité 
		$this->Create(); 
	}
}
?>