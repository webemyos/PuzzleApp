<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Devis\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class DevisDevis extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="DevisDevis"; 
        $this->Alias = "DevisDevis"; 

        $this->ProjetId = new Property("ProjetId", "ProjetId", NUMERICBOX,  true, $this->Alias); 
        $this->IsModele = new Property("IsModele", "IsModele", NUMERICBOX,  true, $this->Alias); 
        $this->InformationSociete = new Property("InformationSociete", "InformationSociete", TEXTAREA,  true, $this->Alias); 
        $this->InformationClient = new Property("InformationClient", "InformationClient", TEXTAREA,  true, $this->Alias); 
        $this->Number = new Property("Number", "Number", TEXTBOX,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 
        $this->DatePaiment = new Property("DatePaiment", "DatePaiment", DATEBOX,  false, $this->Alias); 
        $this->TypePaiment = new Property("TypePaiment", "TypePaiment", TEXTBOX,  false, $this->Alias); 
        $this->InformationComplementaire = new Property("InformationComplementaire", "InformationComplementaire", TEXTAREA,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }

    function GetDocument()
    {
        $fileName = "../Data/Apps/EeDevis/".$this->IdEntite.".pdf";
        if(file_exists($fileName))
        {
           return "<a href='$fileName' target='_blank'>PDF</a>";
        }
    }
}
?>