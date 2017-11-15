<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Entity;

use Apps\Forum\Helper\MessageHelper;
use Core\Entity\Entity\Argument;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;



class ForumMessage extends Entity  
{
    //Entité lié
    protected $User;
    protected $Category;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ForumMessage"; 
        $this->Alias = "ForumMessage"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  true, $this->Alias); 
        $this->Category = new EntityProperty("Apps\Forum\Entity\ForumCategory", "CategoryId");    

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 
        $this->User = new EntityProperty("Core\Entity\User\User", "UserId");
        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Get The user
     */
    function GetUser()
    {
        return $this->User->GetPseudo();
    }
    
    /*
     * Get Number Reponse
     */
    function GetNumberReponse()
    {
        $reponse = new ForumReponse($this->Core);
        $reponse->AddArgument(new Argument("Apps\Forum\Entity\ForumReponse", "MessageId", EQUAL, $this->IdEntite));
        
        return count($reponse->GetByArg());
    }
    
    /*
     * Get The Las Réponse
     */
    function GetLastReponse()
    {
        $reponse = MessageHelper::GetLastReponse($this->Core, $this->IdEntite);
        
        if($reponse->Message->Value != "")
        {
            return $reponse->Message->Value . "(".$reponse->DateCreated->Value.")";
        }
        else
        {
            return $this->Core->GetCode("Forum.NoReponse");
        }
    }
 }
?>