<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class FileFile extends Entity  
{
    protected $Folder;
    protected $User;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="FileFile"; 
        $this->Alias = "FileFile"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");

        $this->FolderId = new Property("FolderId", "FolderId", NUMERICBOX,  false, $this->Alias); 
        $this->Folder = new EntityProperty("FileFolder", "FolderId");
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias);
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 
        $this->DateModified = new Property("DateModified", "DateModified", DATEBOX,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>