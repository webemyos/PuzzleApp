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


class FormForm extends Entity
{
    // Propriété
    protected $User;

    function __construct($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="FormForm";
        $this->Alias = "eeFr";

        //proprietes
        $this->Libelle = new Property("Libelle","Libelle",TEXTBOX, true,$this->Alias);
        $this->Commentaire = new Property("Commentaire","Commentaire",TEXTAREA,false,$this->Alias);
        $this->Actif = new Property("Actif","Actif",CHECKBOX, false,$this->Alias);

        //Categorie
        $this->UserId = new Property("UserId","UserId",TEXTBOX,false,$this->Alias);
        $this->User = new EntityProperty("Core\Entity\User","UserId");

        $this->AddSharedProperty();

        $this->Create();
    }
}

