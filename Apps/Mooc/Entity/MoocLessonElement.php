<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class MoocLessonElement extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="MoocLessonElement"; 
        $this->Alias = "MoocLessonElement"; 

        $this->LessonId = new Property("LessonId", "LessonId", NUMERICBOX,  true, $this->Alias); 
        $this->TypeId = new Property("TypeId", "TypeId", NUMERICBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->Url = new Property("Url", "Url", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>