<?php 

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Entity;

use Apps\Forum\Helper\MessageHelper;
use Core\Control\Link\Link;
use Core\Core\Core;
use Core\Entity\Entity\Argument;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Utility\Format\Format;


class ForumCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ForumCategory"; 
        $this->Alias = "ForumCategory"; 

        $this->ForumId = new Property("ForumId", "ForumId", NUMERICBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTAREA,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Get Number Message
     */
    function GetNumberMessage()
    {
        $messages = new ForumMessage($this->Core);
        $messages->AddArgument(new Argument("Apps\Forum\Entity\ForumMessage", "CategoryId", EQUAL, $this->IdEntite));
        
        return count($messages->GetByArg());
    }
    
    /*
     * Get The Last Message
     */
    function GetLinkLastMessage()
    {
        $message = MessageHelper::GetLastMessage($this->Core, $this->IdEntite);
        
        $lk = new Link($message->Title->Value, $this->Core->GetPath("/Forum/Sujet/".$message->Code->Value));
        
        return $lk->Show();
    }
    
    /*
     * Get The Url
     */
    function GetUrl()
    {
        return $this->Core->GetPath("/Forum/Category/".$this->Code->Value);
    }
}
?>