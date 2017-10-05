<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class PadDocument extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="PadDocument"; 
        $this->Alias = "PadDocument"; 

        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 
        $this->DateModified = new Property("DateModified", "DateModified", DATEBOX,  false, $this->Alias); 
        $this->Content = new Property("Content", "Content", TEXTAREA,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }

    /**
     * Obtient le document formaté
     */
    function GetContent()
    {
        return str_replace("!et!", "&", $this->Content->Value);
    }
}
?>