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

class EeAppUser extends Entity  
{
    protected $App;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeAppUser"; 
        $this->Alias = "EeAppUser"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->AppId = new Property("AppId", "AppId", NUMERICBOX,  true, $this->Alias); 
        $this->App = new EntityProperty("Apps\EeApp\Entity\EeAppApp", "AppId");    

        //Creation de l entité 
        $this->Create(); 
    }
}
?>