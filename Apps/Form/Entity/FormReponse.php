<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class FormResponse extends Entity
{
    // Propriété
    protected $Question;

    function __construct($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="FormResponse";
        $this->Alias = "eeFrRe";

        //proprietes
        $this->Value = new Property("Value","Value",TEXTBOX,false,$this->Alias);
        $this->Commentaire = new Property("Commentaire","Commentaire",TEXTAREA,false,$this->Alias);

        //Categorie
        $this->QuestionId = new Property("QuestionId","QuestionId",TEXTBOX,false,$this->Alias);
        $this->Question = new EntityProperty("Apps/Form/Entity/FormQuestion","QuestionId");
        $this->Actif = new Property("Actif","Actif",CHECKBOX,false,$this->Alias);

        $this->Create();
    }
}

