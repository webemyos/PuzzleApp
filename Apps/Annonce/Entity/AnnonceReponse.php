<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Annonce\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class AnnonceReponse extends Entity  
{
    //Entité liée
    protected $User;
    protected $Annonce;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeAnnoncerReponse"; 
        $this->Alias = "EeAnnoncerReponse"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");
        $this->AnnonceId = new Property("AnnonceId", "AnnonceId", NUMERICBOX,  true, $this->Alias); 
        $this->Annonce = new EntityProperty("Apps\Annonce\Entity\AnnonceAnnonce", "AnnonceId");
        $this->Reponse = new Property("Reponse", "Reponse", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>