<?php 
/* 
*Description de l'entite
*/
class EeCommerceFournisseur extends JHomEntity  
{
	//Constructeur
	function EeCommerceFournisseur($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceFournisseur"; 
		$this->Alias = "EeCommerceFournisseur"; 

		$this->CommerceId = new Property("CommerceId", "CommerceId", NUMERICBOX,  true, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Contact = new Property("Contact", "Contact", TEXTAREA,  true, $this->Alias); 
		$this->Email = new Property("Email", "Email", TEXTBOX,  true, $this->Alias); 
		$this->Telephone = new Property("Telephone", "Telephone", TEXTBOX,  false, $this->Alias); 
		$this->Adresse = new Property("Adresse", "Adresse", TEXTAREA,  false, $this->Alias); 
                $this->Commission = new Property("Commission", "Commission", TEXTBOX,  false, $this->Alias); 
                $this->StripeId = new Property("StripeId", "StripeId", TEXTBOX,  false, $this->Alias);
                
		//Creation de l entité 
		$this->Create(); 
	}
        
        /*
         * Obtient le nombre de produit par fournisseur
         */
        function GetNumberProduct()
        {
            $product = new EeCommerceProduct($this->Core);
            $product->AddArgument(new Argument("EeCommerceProduct", "FournisseurId", EQUAL, $this->IdEntite));
            
            return count($product->GetByArg());
        }
}
?>