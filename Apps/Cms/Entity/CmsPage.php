<?php
/*
*Description de l'entite
*/
namespace Apps\Cms\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class CmsPage extends Entity
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="CmsPage";
        $this->Alias = "CmsPage";

        $this->CmsId = new Property("CmsId", "CmsId", NUMERICBOX,  true, $this->Alias);
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias);
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias);
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias);
        $this->Content = new Property("Content", "Content", TEXTAREA,  false, $this->Alias);

        //Creation de l entité
        $this->Create();
    }
}
?>
