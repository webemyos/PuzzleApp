<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class IdeProjet extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="IdeProjet"; 
        $this->Alias = "IdeProjet"; 

        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 

        //Ajoute les propriétés de partage entre application
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>