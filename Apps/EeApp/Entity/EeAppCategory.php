<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class EeAppCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeAppCategory"; 
        $this->Alias = "EeAppCategory"; 

        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>