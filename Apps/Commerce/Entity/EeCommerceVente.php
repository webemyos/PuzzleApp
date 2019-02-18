<?php 
/* 
*Description de l'entite
*/
class EeCommerceVente extends JHomEntity  
{
        //Produit lié
        protected $Product;
                
                
	//Constructeur
	function EeCommerceVente($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceVente"; 
		$this->Alias = "EeCommerceVente"; 

		$this->ProductId = new Property("ProductId", "ProductId", NUMERICBOX,  true, $this->Alias); 
		$this->Product = new EntityProperty("EeCommerceProduct", "ProductId");
                
                $this->SeanceId = new Property("SeanceId", "SeanceId", NUMERICBOX,  true, $this->Alias); 
		$this->DateStart = new Property("DateStart", "DateStart", DATETIMEBOX,  false, $this->Alias); 
		$this->DateEnd = new Property("DateEnd", "DateEnd", DATETIMEBOX,  false, $this->Alias); 
		//$this->TimeEnd = new Property("TimeEnd", "TimeEnd", NUMERICBOX,  false, $this->Alias); 
                $this->PriceStart = new Property("PriceStart", "PriceStart", TEXTBOX,  false, $this->Alias); 
		$this->PriceActual = new Property("PriceActual", "PriceActual", TEXTBOX,  false, $this->Alias); 
		$this->PriceMini = new Property("PriceMini", "PriceMini", TEXTBOX,  false, $this->Alias); 
                $this->Line = new Property("Line", "Line", NUMERICBOX,  false, $this->Alias); 
                $this->Position = new Property("Position", "Position", NUMERICBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
}
?>