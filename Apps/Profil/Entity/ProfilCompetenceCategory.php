<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class ProfilCompetenceCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ProfilCompetenceCategory"; 
        $this->Alias = "ProfilCompetenceCategory"; 

        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>