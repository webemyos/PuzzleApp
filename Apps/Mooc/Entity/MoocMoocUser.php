<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use EntityProperty;


class MoocMoocUser extends Entity  
{
    //Proprieté liée
    protected $Mooc;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="MoocMoocUser"; 
        $this->Alias = "MoocMoocUser"; 

        $this->MoocId = new Property("MoocId", "MoocId", NUMERICBOX,  true, $this->Alias); 
        $this->Mooc = new EntityProperty("Apps\Mooc\Entity\MoocMooc", "MoocId");
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
}
?>