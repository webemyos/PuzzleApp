<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Feedback\Model;

use Core\Core\Request;
use Core\Model\Model;
use Apps\Coopere\Helper\ReseauHelper;
use Core\Entity\Entity\Property;
use Core\Utility\Date\Date;

class FeedbackModel extends Model
{
    /*
     * Constructeur
     */
    public function __construct($core, $reseauId = "")
    {
       $this->Core = $core;
        
       $entityName = "Apps\Feedback\Entity\FeedbackFeedback";
       $this->Entity = new $entityName($core);
    //   $this->Entity->Title->Control->Value = "dd";
    }
    
    
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("UserId", "Core\Entity\User\User", "StateId", "DateCreated", "AppName", "AppId", "EntityName", "EntityId"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        //Get The Defaul blog
        $this->Entity->UserId->Value = $this->Core->User->IdEntite;
        $this->Entity->StateId->Value = 1;
        $this->Entity->DateCreated->Value = Date::Now();
        
        if(Request::GetPost("Description"))
        {
           parent::Updated();
        }
    }
}
