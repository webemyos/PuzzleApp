<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Langs;

use Core\Entity\Entity\Argument;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class Langs extends Entity
{
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_lang";
		$this->Alias = "lg";

	    //proprietes
		$this->Name = new Property("Name","Name",TEXTBOX,true,$this->Alias);
		$this->Code = new Property("Code","Code",TEXTBOX,true,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}

 //Class pour les codes multilangues
class LangsCode extends Entity
{
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_lang_code";
		$this->Alias = "lgcd";

	    //proprietes
		$this->Code = new Property("Code","Code",TEXTBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}

?>
