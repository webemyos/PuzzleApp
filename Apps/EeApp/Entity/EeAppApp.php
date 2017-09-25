<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

use Core\Control\Image\Image;


class EeAppApp extends Entity  
{
    protected $Category;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeAppApp"; 
        $this->Alias = "EeAppApp"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("Apps\EeApp\Entity\EeAppCategory", "CategoryId");

        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        $this->Actif = new Property("Actif", "Actif", TEXTBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }

    /*
     * Retourne l'image
     */
    function GetImage()
    {
       $fileName = "../Apps/".$this->Name->Value."/Images/logo.png";

        if(!file_exists($fileName))
        {
            $fileName = "../Images/noimages.png";
        }

        $image = new Image($fileName);
        $image->AddStyle("width", "35px");
        $image->Title = "Presentation";

        return $image->Show();
    }
}
?>