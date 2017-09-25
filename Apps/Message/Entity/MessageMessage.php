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

class MessageMessage extends Entity  
{
    //Entité lié
    protected $User;
    protected $Parent;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core= $core; 
        $this->TableName="MessageMessage"; 
        $this->Alias = "MessageMessage"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");

        $this->ParentId = new Property("ParentId", "ParentId", NUMERICBOX,  false, $this->Alias); 
        $this->Parent = new EntityProperty("Apps\Message\Entity\MessageMessage", "ParentId");

        $this->Subjet = new Property("Subjet", "Subjet", TEXTBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }

    /*
     * Get the image of the app
     */
    function GetImageApp()
    {
        if($this->AppName->Value != "")
        {
            $img = new Image("Apps/".$this->AppName->Value."/images/logo.png");
            $img->Alt = $img->Title = $this->AppName->Value;

            return $img->Show();
        }
    }

    /*
     * Obient le pseudo expediteur
     */
    function GetPseudo()
    {
        $user = new User($this->Core);
        $user->GetById($this->UserId->Value);

        return $user->GetPseudo();
    }

    /*
     * Obtient les email des destinataires
     */
    function GetDestinataire()
    {
        $messageUser = new MessageUser($this->Core);
        $messageUser->AddArgument(new argument("MessageUser", "MessageId", EQUAL, $this->IdEntite));
        $messagesUser = $messageUser->GetByArg();
        $user = array();

        foreach($messagesUser as $messageUser)
        {
            $user[] = $messageUser->User->Value->GetPseudo();
        }

        return implode(";", $user);
    }
}
?>