<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Devis\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class DevisDevisLine extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisDevisLine"; 
        $this->Alias = "DevisDevisLine"; 

        $this->DevisId = new Property("DevisId", "DevisId", NUMERICBOX,  true, $this->Alias); 
        $this->Prestation = new Property("Prestation", "Prestation", TEXTAREA,  true, $this->Alias); 
        $this->Quantity = new Property("Quantity", "Quantity", NUMERICBOX,  true, $this->Alias); 
        $this->Price = new Property("Price", "Price", TEXTBOX,  true, $this->Alias); 
        $this->Total = new Property("Total", "Total", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>