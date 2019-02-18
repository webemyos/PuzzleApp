<?php 
/* 
*Description de l'entite
*/
namespace Apps\Commerce\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

use Core\Control\Image\Image;

class CommerceCommerce extends Entity  
{
        //Constructeur
        function __construct($core)
        {
                //Version
                $this->Version ="2.0.0.0"; 

                //Nom de la table 
                $this->Core=$core; 
                $this->TableName="CommerceCommerce"; 
                $this->Alias = "CommerceCommerce"; 

                $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
                $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
                $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias);
                $this->SmallDescription = new Property("SmallDescription", "SmallDescription", TEXTBOX,  true, $this->Alias); 
                $this->LongDescription = new Property("LongDescription", "LongDescription", TEXTAREA,  true, $this->Alias); 
                //Creation de l entité 
                $this->Create(); 
        }

        /*
        * Retourne l'image
        */
        function GetImage()
        {
                $fileName = "../Data/Apps/Commerce/".$this->IdEntite."/presentation_96.png";
                        
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