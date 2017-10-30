<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class FormResponseUser extends Entity
{
    // Propriété
    protected $Response;

    function __construct($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="FormResponseUser";
        $this->Alias = "eeFrRe";

        //proprietes
        $this->Value = new Property("Value", "Value",TEXTAREA,false,$this->Alias);

        //Categorie
        $this->QuestionId = new Property("QuestionId","QuestionId",TEXTBOX,false,$this->Alias);
        $this->ResponseId = new Property("ResponseId","ResponseId",TEXTBOX,false,$this->Alias);
        $this->Response = new EntityProperty("Apps/Form/Entity/FormResponse","ResponseId");
        $this->UserId = new Property("UserId","UserId",TEXTBOX,false,$this->Alias);
        $this->AdresseIp = new Property("AdresseIp","AdresseIp",TEXTBOX,false,$this->Alias);

        $this->Create();
    }
}