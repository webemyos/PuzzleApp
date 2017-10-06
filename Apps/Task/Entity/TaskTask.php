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

class TaskTask extends Entity  
{
    const NOUVELLE = 1;
    const EN_COURS = 2;
    const A_VERIFIER = 3;
    const TERMINE =4;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="TaskTask"; 
        $this->Alias = "TaskTask"; 

        $this->GroupId = new Property("GroupId", "GroupId", NUMERICBOX,  false, $this->Alias); 
        $this->ParentId = new Property("ParentId", "ParentId", NUMERICBOX,  false, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias);
        $this->StateId = new Property("StateId", "StateId", NUMERICBOX,  true, $this->Alias); 
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
        $this->DateStart = new Property("DateStart", "DateStart", DATEBOX,  false, $this->Alias); 
        $this->DateEnd = new Property("DateEnd", "DateEnd", DATEBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>