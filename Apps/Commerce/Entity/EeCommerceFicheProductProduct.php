<?php 
/* 
* Produit contenu dans les fiches
*/
class EeCommerceFicheProductProduct extends JHomEntity  
{
    protected $Product;
    
    //Constructeur
	function EeCommerceFicheProductProduct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceFicheProductProduct"; 
		$this->Alias = "EeCommerceFicheProductProduct"; 

		$this->FicheId = new Property("FicheId", "FicheId", NUMERICBOX,  true, $this->Alias); 
		$this->ProductId = new Property("ProductId", "ProductId", NUMERICBOX,  true, $this->Alias); 
                $this->Product = new EntityProperty("EeCommerceProduct", "ProductId");
		//Creation de l entité 
		$this->Create(); 
	}
}
?>