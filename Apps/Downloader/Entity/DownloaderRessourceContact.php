<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Entity ;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;
use Core\Entity\User\User;


class DownloaderRessourceContact extends Entity
{
    protected $User;
    
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="DownloaderRessourceContact";
        $this->Alias = "DownloaderRessourceContact";

        $this->RessourceId = new Property("RessourceId", "RessourceId", NUMERICBOX,  true, $this->Alias);
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias);
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");
                
        $this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias);

        //Creation de l entité
        $this->Create();
    }
    
    /*
     * Get the User
     */
    function GetUser()
    {
        if($this->UserId->Value != "")
        {
            $user = new User($this->Core);
            $user->GetById($this->UserId->Value);
            
            return $user->GetPseudo();
        }
        else
        {
            return $this->Email->Value;
        }
    }
}
?>
