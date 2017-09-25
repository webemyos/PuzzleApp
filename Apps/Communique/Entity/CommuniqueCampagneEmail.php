<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class CommuniqueCampagneEmail extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="CommuniqueCampagneEmail"; 
        $this->Alias = "CommuniqueCampagneEmail"; 

        $this->CampagneId = new Property("CampagneId", "CampagneId", NUMERICBOX,  true, $this->Alias); 
        $this->Email = new Property("Email", "Email", TEXTBOX,  true, $this->Alias); 
        $this->DateOpen = new Property("DateOpen", "DateOpen", DATEBOX,  false, $this->Alias); 
        $this->NumberOpen = new Property("NumberOpen", "NumberOpen", NUMERICBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>