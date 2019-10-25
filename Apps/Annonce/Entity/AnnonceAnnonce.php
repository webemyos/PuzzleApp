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


class AnnonceAnnonce extends Entity  
{   
    //Entité liée
    protected $User;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="AnnonceAnnonce"; 
        $this->Alias = "AnnonceAnnonce"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");
        $this->Title = new Property("Title", "Title", TEXTAREA,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }

    /*
     * Obtient le nombre de reponse
     */
    function GetNumberReponse()
    {
        $request = "SELECT count(Id) as nbReponse FROM EeAnnoncerReponse WHERE AnnonceId = ".$this->IdEntite;
        $result = $this->Core->Db->GetLine($request);

        return $result["nbReponse"];
    }
}
?>