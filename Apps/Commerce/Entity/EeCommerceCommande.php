<?php 
/* 
*Description de l'entite
*/
class EeCommerceCommande extends JHomEntity  
{
    /*
     * Etat des commandes
     */
    const BROUILLON = 1;
    const VALIDE = 2;
        
        //Entite liée
        protected $AdresseLivraison;
        protected $AdresseFacturation;
        protected $User;

        //Constructeur
	function EeCommerceCommande($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceCommande"; 
		$this->Alias = "EeCommerceCommande"; 

		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 
                $this->User = new EntityProperty("User", "UserId"); 
		
		$this->StateId = new Property("StateId", "StateId", NUMERICBOX,  true, $this->Alias); 
		$this->Numero = new Property("Numero", "Numero", TEXTBOX,  false, $this->Alias); 
	
                $this->AdresseLivraisonId = new Property("AdresseLivraisonId", "AdresseLivraisonId", NUMERICBOX,  false, $this->Alias); 
		$this->AdresseLivraison = new EntityProperty("EeCommerceCommandeAdresse", "AdresseLivraisonId"); 
		$this->AdresseFacturationId = new Property("AdresseFacturationId", "AdresseFacturationId", NUMERICBOX,  false, $this->Alias); 
		$this->AdresseFacturation = new EntityProperty("EeCommerceCommandeAdresse", "AdresseFacturationId"); 
		
                $this->DateCreated = new Property("DateCreated", "DateCreated", DATETIMEBOX,  false, $this->Alias); 
                $this->DateValidation = new Property("DateValidation", "DateValidation", DATETIMEBOX,  false, $this->Alias); 
                $this->DatePrisEnChargePartenaire = new Property("DatePrisEnChargePartenaire", "DatePrisEnChargePartenaire", DATETIMEBOX,  false, $this->Alias); 
                $this->DateExpeditionPartenaire = new Property("DateExpeditionPartenaire", "DateExpeditionPartenaire", DATETIMEBOX,  false, $this->Alias); 
                $this->DateLivraisonPrevu = new Property("DateLivraisonPrevu", "DateLivraisonPrevu", DATETIMEBOX,  false, $this->Alias); 
                $this->DateLivraisonReel = new Property("DateLivraisonReel", "DateLivraisonReel", DATETIMEBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
                
        /*
         * Obtient le total de la commande
         */
        function GetTotal()
        {
           return CommandeHelper::GetTotal($this->Core, $this);
        }
        
        /*
         * Obtient l'état de a commande
         */
        function GetState()
        {
            switch($this->StateId->Value)
            {
                case EeCommerceCommande::BROUILLON :
                    return $this->Core->GetCode("EeCommerce.AValider");
                    break;
                
               case  EeCommerceCommande::VALIDE :
                   return $this->Core->GetCode("EeCommerce.EnCours");
                    break;
            }
        }
        
        
}
?>