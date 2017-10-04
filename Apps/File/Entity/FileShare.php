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

class FileShare extends Entity  
{
    protected $User;
    protected $Folder;
    protected $File;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="FileShare"; 
        $this->Alias = "FileShare"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");

        $this->FolderId = new Property("FolderId", "FolderId", NUMERICBOX,  false, $this->Alias); 
        $this->Folder = new EntityProperty("FileFolder", "FolderId");

        $this->FileId = new Property("FileId", "FileId", NUMERICBOX,  false, $this->Alias); 
        $this->File = new EntityProperty("FileFile", "FileId");

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>