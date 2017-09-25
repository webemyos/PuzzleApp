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

class EeAppAdmin extends Entity  
{
    protected $User;
    
    //Constructeur
    function __construct($core)
    {
            //Version
            $this->Version ="2.0.0.0"; 

            //Nom de la table 
            $this->Core=$core; 
            $this->TableName="EeAppAdmin"; 
            $this->Alias = "EeAppAdmin"; 

            $this->AppId = new Property("AppId", "AppId", NUMERICBOX,  true, $this->Alias); 
            $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
            $this->User = new EntityProperty("Core\Entity\Entity\User\User", "UserId");  
            //Creation de l entité 
            $this->Create(); 
    }
}
?>