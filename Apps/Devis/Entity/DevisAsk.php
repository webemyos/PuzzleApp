<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Devis\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class DevisAsk extends Entity  
{
    protected $Prestation;
    
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisAsk"; 
        $this->Alias = "DevisAsk"; 

        $this->PrestationId = new Property("PrestationId", "PrestationId", NUMERICBOX,  true, $this->Alias); 
        $this->Prestation = new EntityProperty("Apps\Devis\Entity\DevisPrestation", "PrestationId");
        $this->Name = new Property("Name", "Name", TEXTBOX,  false, $this->Alias); 
        $this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias); 
        $this->Phone = new Property("Phone", "Phone", TEXTBOX,  false, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>