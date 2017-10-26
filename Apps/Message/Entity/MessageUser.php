<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Message\Entity;

use Core\Control\Image\Image;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\UserGroupUser;
use Apps\Message\Entity\MessageUser;

class MessageUser extends Entity  
{
    //Entité lié
    protected $User;
    protected $Message;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="MessageUser"; 
        $this->Alias = "MessageUser"; 

        $this->MessageId = new Property("MessageId", "MessageId", NUMERICBOX,  true, $this->Alias);
        $this->Message = new EntityProperty("Apps\Message\Entity\MessageMessage", "MessageId");

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");

        $this->Read = new Property("Read", "Read", NUMERICBOX,  false, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }

    function GetSender()
    {
        return $this->Message->Value->User->Value->GetPseudo();
    }
}
?>