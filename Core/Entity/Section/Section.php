<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Section;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class Section extends Entity
{
	function __construct($core)
	{
            //Version
            $this->Version ="2.0.1.0";

            //Nom de la table
            $this->Core=$core;
            $this->TableName="ee_section";
            $this->Alias = "st" ;

        //proprietes
            $this->Name = new Property("Name","Name",TEXTBOX,false,$this->Alias);
            $this->Directory = new Property("Directory","Directory",TEXTBOX,false,$this->Alias);
            //Creation de l'entit�
            $this->Create();
	}
}
?>