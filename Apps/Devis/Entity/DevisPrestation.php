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

class DevisPrestation extends Entity  
{
    //Entité liée
    protected $Category;
    
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisPrestation"; 
        $this->Alias = "DevisPrestation"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("Apps\Devis\Entity\DevisPrestationCategory", "CategoryId");
        $this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>