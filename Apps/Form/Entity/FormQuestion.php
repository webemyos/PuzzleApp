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

class FormQuestion extends Entity
{
    // Propriété
    protected $Form;

    function FormQuestion($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="FormQuestion";
        $this->Alias = "eeFrQt";

        //proprietes
        $this->Libelle = new Property("Libelle","Libelle",TEXTBOX,false,$this->Alias);
        $this->Commentaire = new Property("Commentaire","Commentaire",TEXTBOX,false,$this->Alias);
        $this->Type = new Property("Type","Type",TEXTBOX, false,$this->Alias);

        //Categorie
        $this->FormId = new Property("FormId","FormId", TEXTBOX,false,$this->Alias);
        $this->Form = new EntityProperty("Apps/Entity/FormForm","FormId");

        $this->Create();
    }
}
