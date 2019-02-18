<?php 
/* 
*Description de l'entite
*/
class EeCommerceSeanceVente extends JHomEntity  
{
    //Constructeur
    function EeCommerceSeanceVente($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeCommerceSeanceVente"; 
        $this->Alias = "EeCommerceSeanceVente"; 

        $this->CommerceId = new Property("CommerceId", "CommerceId", NUMERICBOX,  true, $this->Alias); 
        $this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  false, $this->Alias); 
        $this->DateStart = new Property("DateStart", "DateStart", DATETIMEBOX,  false, $this->Alias); 
        $this->DateEnd = new Property("DateEnd", "DateEnd", DATETIMEBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
