<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Task\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class TaskGroup extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="TaskGroup"; 
        $this->Alias = "TaskGroup"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>