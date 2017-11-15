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

class TaskState extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="TaskState"; 
        $this->Alias = "TaskState"; 

        $this->Libelle = new Property("Libelle", "Libelle", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>