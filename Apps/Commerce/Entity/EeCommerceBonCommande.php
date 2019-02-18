<?php 
/* 
*Description de l'entite
*/
class EeCommerceBonCommande extends JHomEntity  
{
    
    // Etats des bon de commande
        const ATRAITER = 1 ;
        const VALIDE = 2;
        const EXPEDIE = 3 ;
        
        //Entite liée
        protected $Commande;
                
	//Constructeur
	function EeCommerceBonCommande($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceBonCommande"; 
		$this->Alias = "EeCommerceBonCommande"; 

		$this->CommandeId = new Property("CommandeId", "CommandeId", NUMERICBOX,  true, $this->Alias); 
		$this->Commande = new EntityProperty("EeCommerceCommande", "CommandeId");
                $this->FournisseurId = new Property("FournisseurId", "FournisseurId", NUMERICBOX,  true, $this->Alias); 
		$this->Numero = new Property("Numero", "Numero", TEXTBOX,  true, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATETIMEBOX,  true, $this->Alias); 
		$this->DateValided = new Property("DateValided", "DateValided", DATETIMEBOX,  false, $this->Alias); 
                $this->DateExpedited = new Property("DateExpedited", "DateExpedited", DATETIMEBOX,  false, $this->Alias); 
                $this->StateId = new Property("StateId", "StateId", NUMERICBOX,  false, $this->Alias); 
		$this->File = new Property("File", "File", TEXTBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
        
        /*
         * Obtient le fichier PDf
         */
        function GetFile()
        {
            return str_replace("Data/", "../Data/", $this->File->Value);
        }
        
        /*
         * En fonction de l'état du bon de commande
         * on peut faire plusieur action
         */
        function GetButtonAction()
        {
            if($this->StateId->Value == self::ATRAITER || $this->StateId->Value == self::VALIDE)
            {
                $btnAction = new Button("btnAction");
                
                switch($this->StateId->Value)
                {
                    case self::ATRAITER ;
                        $btnAction->CssClass = "btn btn-warning";
                        $btnAction->Value = $this->Core->GetCode("EeCommerc.ValideCommande");
                    break;
                    case self::VALIDE;
                        $btnAction->CssClass = "btn btn-success";
                        $btnAction->Value = $this->Core->GetCode("EeCommerc.ExpedieCommande");
                        break;
                }

                $btnAction->OnClick = "EeCommercePartenaireAction.UpdateBonCommande(this, ".$this->IdEntite.")"; 
                return $btnAction->Show();
            }
        }
}
?>