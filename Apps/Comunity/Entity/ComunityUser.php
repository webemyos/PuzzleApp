<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class ComunityUser extends Entity  
{
    //Entite liés
    protected $Comunity;
    protected $User;

    //Constructeur
    function ComunityUser($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ComunityUser"; 
        $this->Alias = "ComunityUser"; 

        $this->ComunityId = new Property("ComunityId", "ComunityId", NUMERICBOX,  true, $this->Alias); 
        $this->Comunity = new EntityProperty("ComunityComunity", "ComunityId");

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");

        //Creation de l entité 
        $this->Create(); 
    }
}
?>