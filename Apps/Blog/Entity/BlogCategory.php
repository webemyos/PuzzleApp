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
use Core\Utility\Format\Format;

class BlogCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BlogCategory"; 
        $this->Alias = "BlogCategory"; 

        $this->BlogId = new Property("BlogId", "BlogId", NUMERICBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Get the Name for url
     */
    function GetUrlCode()
    {
        return Format::ReplaceForUrl($this->Code->Value, false);
    }
}
?>