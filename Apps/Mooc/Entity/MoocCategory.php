<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class MoocCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="MoocCategory"; 
        $this->Alias = "MoocCategory"; 

        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>