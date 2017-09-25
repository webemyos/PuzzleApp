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

class CommuniqueCampagne extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="CommuniqueCampagne"; 
        $this->Alias = "CommuniqueCampagne"; 

        $this->CommuniqueId = new Property("CommuniqueId", "CommuniqueId", NUMERICBOX,  true, $this->Alias); 
        $this->DateSended = new Property("DateSended", "DateSended", DATEBOX,  true, $this->Alias); 
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  false, $this->Alias); 
        $this->NumberEmailSended = new Property("NumberEmailSended", "NumberEmailSended", NUMERICBOX,  false, $this->Alias); 
        $this->NumberEmailOpen = new Property("NumberEmailOpen", "NumberEmailOpen", NUMERICBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>