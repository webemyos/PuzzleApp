<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Agenda\Entity;

class ContactContact extends Entity  
{
    //Const
    const INVITATION = 1;
    const CONTACT = 2;
    const BLOCKED = 3;

    //Propriété
    protected $User;
    protected $Contact;


    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ContactContact"; 
        $this->Alias = "ContactContact"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
        $this->User = new EntityProperty("User", "UserId");

        $this->ContactId = new Property("ContactId", "ContactId", NUMERICBOX,  false, $this->Alias); 
        $this->Contact = new EntityProperty("Core\Entity\Entity\User", "ContactId");

        $this->StateId = new Property("StateId", "StateId", NUMERICBOX,  false, $this->Alias); 

        $this->Name = new Property("Name", "Name", TEXTBOX,  false, $this->Alias); 
        $this->FirstName = new Property("FirstName", "FirstName", TEXTBOX,  false, $this->Alias); 
        $this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias); 
        $this->Phone = new Property("Phone", "Phone", TEXTBOX,  false, $this->Alias); 
        $this->Mobile = new Property("Mobile", "Mobile", TEXTBOX,  false, $this->Alias); 
        $this->Adresse = new Property("Adresse", "Adresse", TEXTAREA,  false, $this->Alias); 


        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entité 
        $this->Create(); 
    }
}
?>