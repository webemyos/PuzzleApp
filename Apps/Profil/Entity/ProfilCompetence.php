<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class ProfilCompetence extends Entity  
{
    //Entité liée
    protected $Category;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ProfilCompetence"; 
        $this->Alias = "ProfilCompetence"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("ProfilCompetenceCategory", "CategoryId");
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>