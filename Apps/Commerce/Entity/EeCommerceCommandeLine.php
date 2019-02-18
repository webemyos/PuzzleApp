<?php 
/* 
*Description de l'entite
*/
class EeCommerceCommandeLine extends JHomEntity  
{
        protected $Vente;
        protected $Commande;
    
	//Constructeur
	function EeCommerceCommandeLine($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceCommandeLine"; 
		$this->Alias = "EeCommerceCommandeLine"; 

		$this->CommandeId = new Property("CommandeId", "CommandeId", TEXTBOX,  true, $this->Alias); 
		$this->Commande = new EntityProperty("EeCommerceCommande", "CommandeId");
                
                $this->EntityId = new Property("EntityId", "EntityId", TEXTBOX,  true, $this->Alias); 
		$this->Vente = new EntityProperty("EeCommerceVente", "EntityId");
                $this->Price = new Property("Price", "Price", TEXTBOX,  false, $this->Alias); 
		$this->Quantite = new Property("Quantite", "Quantite", NUMERICBOX,  false, $this->Alias); 
		$this->StateId = new Property("StateId", "StateId", NUMERICBOX,  false, $this->Alias); 
                $this->PricePort = new Property("PricePort", "PricePort", TEXTBOX,  false, $this->Alias); 
		$this->ReferenceId = new Property("ReferenceId", "ReferenceId", NUMERICBOX,  false, $this->Alias); 
                
		//Creation de l entité 
		$this->Create(); 
	}
        
        /*
         * Obtient le total de la ligne
         */
        public function GetTotal()
        {
            return  $this->Price->Value + $this->PricePort->Value;
        }
        
        /*
         * Obtient l'image de la ligne
         */
        public function GetImage()
        {
            $image = new Image($this->Vente->Value->Product->Value->ImageDefault->Value);
            
            return $image->Show();
        }
        
        /*
         * Obtient l'icone de suppression pour les commandes
         * En état de brouillon
         */
        function GetRemove()
        {
            $html = "";
            
            $commande = new EeCommerceCommande($this->Core);
            $commande->GetById($this->CommandeId->Value);
            
            //Choix des options
            $productId = $this->Vente->Value->ProductId->Value;
            $references = ProductHelper::GetReference($this->Core, $productId);
            
            if(count($references) > 0)
            {
                $html .= "<div class='reference'>";
                $html .= "<h4 class='borderbottom'>".$this->Core->GetCode("Reference")."</h4>";
                
                foreach($references as $reference)
                {
                    $radio = new RadioButton($productId);
                    $radio->OnClick = "VenteGivreeAction.SelectReference(".$this->IdEntite.", ".$reference->IdEntite.")";
                    
                    if($this->ReferenceId->Value == $reference->IdEntite)
                    {
                      $radio->Checked = true;  
                    }
                    
                    $html .= $reference->Libelle->Value . $radio->Show();
                }
                
                $html .= "</div>";
            }
            
            if($commande->StateId->Value == EeCommerceCommande::BROUILLON)
            {
                 $html .=  "<i class='fa fa-times' title='".$this->Core->GetCode("RemoveProduct")."' onclick='VenteGivreeAction.RemoveProduct(this, ".$this->IdEntite.")'>&nbsp</i>";
            }
            else
            {
                switch($this->StateId->Value)
                {
                    case EeCommerceBonCommande::ATRAITER :
                         $html .= $this->Core->GetCode("EeCommerce.WaitValidationFournisseur");
                        break;
                    case EeCommerceBonCommande::VALIDE :
                         $html .= $this->Core->GetCode("EeCommerce.WaitExpeditionFournisseur");
                        break;
                    case EeCommerceBonCommande::EXPEDIE :
                         $html .= $this->Core->GetCode("EeCommerce.ExpeditionFournisseur");
                        break;
                }
            }
            
            return  $html;
        }
}
?>