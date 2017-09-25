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

class CommuniqueListMember extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="CommuniqueListMember"; 
        $this->Alias = "CommuniqueListMember"; 

        $this->ListId = new Property("ListId", "ListId", NUMERICBOX,  true, $this->Alias); 
        $this->FirstName = new Property("FirstName", "FirstName", TEXTBOX,  false, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  false, $this->Alias); 
        $this->Email = new Property("Email", "Email", TEXTBOX,  true, $this->Alias); 
        $this->Sexe = new Property("Sexe", "Sexe", NUMERICBOX,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>