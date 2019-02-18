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

class DevisPrestationCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisPrestationCategory"; 
        $this->Alias = "DevisPrestationCategory"; 

        $this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->ProjetId = new Property("ProjetId", "ProjetId", NUMERICBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>