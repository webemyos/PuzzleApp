<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;
use Core\Entity\User\User;

class ForumReponse extends Entity  
{
    //Entité lié
    protected $User;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ForumReponse"; 
        $this->Alias = "ForumReponse"; 

        $this->MessageId = new Property("MessageId", "MessageId", NUMERICBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }

        /*
     * Get The user
     */
    function GetUser()
    {
        $user = new User($this->Core);
        $user->GetById($this->UserId->Value);
        return $user->GetPseudo();
    }
}
?>