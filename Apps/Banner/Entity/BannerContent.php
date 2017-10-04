<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Banner\Entity;

use Core\Entity\Entity\Entity;

class BannerContent extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BannerContent"; 
        $this->Alias = "BannerContent"; 

        $this->BannerId = new Property("BannerId", "BannerId", NUMERICBOX,  false, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Content = new Property("Content", "Content", TEXTAREA,  false, $this->Alias); 
        $this->Actif = new Property("Actif", "Actif", CHECKBOX,  false, $this->Alias); 


        //Creation de l entité 
        $this->Create(); 
    }
}
?>