<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Group;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class Group extends Entity
{
    protected $Section;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="ee_group";
        $this->Alias = "gr";

        //proprietes
        $this->Name = new Property("Name","Name",TEXTBOX,false,$this->Alias);
        $this->SectionId = new Property("SectionId","SectionId",TEXTBOX,false,$this->Alias);
        $this->Section = new EntityProperty("Core\Entity\Section\Section","SectionId");

        //Creation de l'entit�
        $this->Create();
    }
}
?>