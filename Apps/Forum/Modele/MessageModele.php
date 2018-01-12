<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Forum\Modele;

use Apps\Forum\Entity\ForumCategory;
use Core\Modele\Modele;
use Core\Utility\Date\Date;

class MessageModele extends Modele
{
    /*
     * Category of the message
     */
    private $category;
    
    /*
     * Constructeur
     */
    public function __construct($core)
    {
       $this->Core = $core;
        
       $entityName = "Apps\Forum\Entity\ForumMessage";
       $this->Entity = new $entityName($core);
    }
    
    /*
     * Set The category
     */
    public function SetCategory($category)
    {
       $this->category = $category;
    }
    
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("CategoryId", "UserId", "Core\Entity\User\User", "Apps\Forum\Entity\ForumCategory", "DateCreated"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        $this->Entity->CategoryId->Value = $this->category->IdEntite;
        $this->Entity->UserId->Value = $this->Core->User->IdEntite;
        $this->Entity->DateCreated->Value = Date::Now();
       
        parent::updated();
    }
}
