<?php 
/*
*Description de l'entite
*/
namespace Apps\Ressource\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;


class EeRessourceRessource extends Entity  
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
        $this->TableName="EeRessourceRessource"; 
        $this->Alias = "EeRessourceRessource"; 

        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias); 

        $this->Title = new Property("Title", "Title", TEXTBOX,  true, $this->Alias); 
        $this->Description = new Property("Description", "Description", TEXTBOX,  true, $this->Alias); 
        $this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  true, $this->Alias); 
        $this->Link = new Property("Link", "Link", TEXTBOX,  true, $this->Alias); 

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l entit� 
        $this->Create(); 
    }
  }