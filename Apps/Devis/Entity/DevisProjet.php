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

class DevisProjet extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisProjet"; 
        $this->Alias = "DevisProjet"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->Libelle = new Property("Libelle", "Libelle", TEXTAREA,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>