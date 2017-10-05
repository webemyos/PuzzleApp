<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class ForumForum extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ForumForum"; 
        $this->Alias = "ForumForum"; 

        $this->Name = new Property("Name", "Name", TEXTAREA,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTBOX,  true, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>