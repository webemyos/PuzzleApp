<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class CommuniqueCommunique extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="CommuniqueCommunique"; 
        $this->Alias = "CommuniqueCommunique"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Text = new Property("Text", "Text", TEXTAREA,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

            //Creation de l entité 
            $this->Create(); 
    }
}
?>