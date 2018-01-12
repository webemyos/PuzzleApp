<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class BlogBlog extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BlogBlog"; 
        $this->Alias = "BlogBlog"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->Style = new Property("Style", "Style", NUMERICBOX,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>