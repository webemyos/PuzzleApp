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

class ReponseModele extends Modele
{
    private $sujetId;
    
   /*
     * Constructeur
     */
    public function __construct($core)
    {
       $this->Core = $core;
        
       $entityName = "Apps\Forum\Entity\ForumReponse";
       $this->Entity = new $entityName($core);
    }
    
    /*
     * Set The category
     */
    public function SetSujetId($sujetId)
    {
       $this->sujetId = $sujetId;
    }
    
    /*
     * Prepare the form
     */
    public function Prepare()
    {
       $this->Exclude(array("MessageId", "UserId", "DateCreated"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        $this->Entity->MessageId->Value = $this->sujetId;
        $this->Entity->UserId->Value = $this->Core->User->IdEntite;
        $this->Entity->DateCreated->Value = Date::Now();
       
        parent::updated();
    }
}
