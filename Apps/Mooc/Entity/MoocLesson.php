<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class MoocLesson extends Entity  
{
    //Entité liée
    protected $Mooc;
    
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="MoocLesson"; 
        $this->Alias = "MoocLesson"; 

        $this->MoocId = new Property("MoocId", "MoocId", NUMERICBOX,  true, $this->Alias); 
        $this->Mooc = new EntityProperty("Apps\Mooc\Entity\MoocMooc", "MoocId"); 
        
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->Content = new Property("Content", "Content", TEXTAREA,  false, $this->Alias); 
        $this->Video = new Property("Video", "Video", TEXTBOX,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", CHECKBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>