<?php 
/* 
*Description de l'entite
*/
class EeCommerceLike extends JHomEntity  
{
        protected $User;
        protected $Product;
    
	//Constructeur
	function EeCommerceLike($core)
	{
            //Version
            $this->Version ="2.0.0.0"; 

            //Nom de la table 
            $this->Core=$core; 
            $this->TableName="EeCommerceLike"; 
            $this->Alias = "EeCommerceLike"; 

            $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
            $this->User = new EntityProperty("User","UserId");

            $this->ProductId = new Property("ProductId", "ProductId", NUMERICBOX,  true, $this->Alias); 
            $this->Product = new EntityProperty("EeCommerceProduct","ProductId");

            //Creation de l entité 
            $this->Create(); 
	}
}
?>