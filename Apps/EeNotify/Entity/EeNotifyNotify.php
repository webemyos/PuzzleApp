<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeNotify\Entity;

use Core\Entity\Entity\Entity;

class EeNotifyNotify extends Entity  
{
    //Entity Property
    protected $User;

    //Constructeur
    function EeNotifyNotify($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeNotifyNotify"; 
        $this->Alias = "EeNotifyNotify"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId"); 

        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
        $this->DateCreate = new Property("DateCreate", "DateCreate", DATEBOX,  true, $this->Alias); 
        $this->DestinataireId = new Property("DestinataireId", "DestinataireId", NUMERICBOX,  false, $this->Alias); 
        $this->View = new Property("View", "View", NUMERICBOX,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>