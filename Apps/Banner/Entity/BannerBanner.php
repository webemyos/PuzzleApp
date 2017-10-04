<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Banner\Entity;

use Core\Entity\Entity\Entity;

class BannerBanner extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BannerBanner"; 
        $this->Alias = "BannerBanner"; 

        $this->Name = new Property("Name", "Name", TEXTAREA,  true, $this->Alias);
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);

        //Creation de l entité 
        $this->Create(); 
    }
}
?>