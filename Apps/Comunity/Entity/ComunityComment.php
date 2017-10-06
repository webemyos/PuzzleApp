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

class ComunityComment extends Entity  
{
    //Entite liées
    protected $User;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ComunityComment"; 
        $this->Alias = "ComunityComment"; 

        $this->MessageId = new Property("MessageId", "MessageId", NUMERICBOX,  false, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");
        $this->TypeId = new Property("TypeId", "TypeId", NUMERICBOX,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  false, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 

        //Commentaire annonyme
        $this->UserName = new Property("UserName", "UserName", TEXTBOX,  false, $this->Alias); 
        $this->Email = new Property("Email", "Email", EMAILBOX,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>