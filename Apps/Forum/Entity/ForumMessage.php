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


class ForumMessage extends Entity  
{
    //Entité lié
    protected $User;
    protected $Category;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ForumMessage"; 
        $this->Alias = "ForumMessage"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("ForumCategory", "CategoryId");    

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>