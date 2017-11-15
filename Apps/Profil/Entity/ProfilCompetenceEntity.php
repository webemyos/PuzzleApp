<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class ProfilCompetenceEntity extends Entity  
{
    //Entity Property
    protected $User;
    protected $Competence;

    //Constructeur
    function ProfilCompetenceEntity($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ProfilCompetenceEntity"; 
        $this->Alias = "ProfilCompetenceEntity"; 

        $this->CompetenceId = new Property("CompetenceId", "CompetenceId", NUMERICBOX,  true, $this->Alias); 
        $this->Competence = new EntityProperty("Apps\Profil\Entity\ProfilCompetence", "CompetenceId"); 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId"); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>