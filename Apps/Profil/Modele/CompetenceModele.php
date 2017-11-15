<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Profil\Modele;

use Core\Core\Request;
use Core\Modele\Modele;
use Core\Utility\Format\Format;

class CompetenceModele extends Modele
{
     /*
     * Constructeur
     */
    public function __construct($core, $entityId)
    {
       $this->Core = $core;
        
       $entityName = "Apps\Profil\Entity\ProfilCompetence";
       $this->Entity = new $entityName($core);
       
       if($entityId != "")
       {
           $this->Entity->GetById($entityId);
       }
    }
    
   
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("Code", "CategoryId"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        if(Request::GetPost("Name") != "")
        {
            $this->Entity->Code->Value = Format::ReplaceForUrl(Request::GetPost("Name"));
            parent::updated();
        }
    }
}
