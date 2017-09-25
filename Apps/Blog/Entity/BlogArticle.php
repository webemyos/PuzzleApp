<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Entity;

use Core\Control\Image\Image;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;
use Core\Utility\Format\Format;

class BlogArticle extends Entity  
{
    //Entite lié
    protected $Category;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BlogArticle"; 
        $this->Alias = "BlogArticle"; 

        $this->BlogId = new Property("BlogId", "BlogId", NUMERICBOX,  true, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", TEXTBOX,  false, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->KeyWork = new Property("KeyWork", "KeyWork", TEXTAREA,  false, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
        $this->Content = new Property("Content", "Content", TEXTAREA,  false, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("Apps\Blog\Entity\BlogCategory", "CategoryId"); 


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

    /*
     * Get the Image og the article
     */
    function GetImage()
    {
        $fileName = "Data/Apps/Blog/".$this->BlogId->Value. "/".$this->IdEntite. "_96.png";

        if(file_exists($fileName))
        {
            $image = new Image($this->Core->GetPath("/".$fileName));
            $image->Title = $this->Name->Value;

        }
        else
        {
            $image = new Image($this->Core->GetPath("/images/nophoto.png"));
        }

        return $image->Show();
    }
    
    /*
     * Get A small Description
     */
    function GetSmallDescription()
    {
        return Format::Tronquer($this->Description->Value, 250);
    }
}
?>