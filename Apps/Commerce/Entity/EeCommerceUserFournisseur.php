<?php 
/* 
* Lien entre un utilisateur et les fournisseur
*/
class EeCommerceUserFournisseur extends JHomEntity  
{
    /*
     * Entité lié
     */
    protected $Fournisseur;
    protected $User;
    
    //Constructeur
    function EeCommerceUserFournisseur($core)
    {
            //Version
            $this->Version ="2.0.0.0"; 

            //Nom de la table 
            $this->Core=$core; 
            $this->TableName="EeCommerceUserFournisseur"; 
            $this->Alias = "EeCommerceUserFournisseur"; 

            $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
            $this->User = new EntityProperty("User", "UserId");
            $this->FournisseurId = new Property("FournisseurId", "FournisseurId", NUMERICBOX,  true, $this->Alias); 
            $this->Fournisseur = new EntityProperty("EeCommerceFournisseur", "FournisseurId");
            
            //Creation de l entité 
            $this->Create(); 
    }
}
?>