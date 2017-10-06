<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class ComunityMessage extends Entity  
{
    /**
     * Type de message
     */
    const TEXT = 1;
    const IMAGE= 2;

    /**
     * Entite liées
     * @param type $core
     */
    protected $User;

    //Constructeur
    function ComunityMessage($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ComunityMessage"; 
        $this->Alias = "ComunityMessage"; 

        $this->ComunityId = new Property("ComunityId", "ComunityId", NUMERICBOX,  true, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");
        $this->Type = new Property("Type", "Type", NUMERICBOX,  true, $this->Alias); 
        $this->Title = new Property("Title", "Title", TEXTBOX,  false, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>