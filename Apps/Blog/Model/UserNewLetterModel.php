<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Blog\Model;

use Apps\Blog\Helper\BlogHelper;
use Core\Core\Request;
use Core\Model\Model;

class UserNewLetterModel extends Model
{
    /*
     * Constructeur
     */
    public function __construct($core)
    {
       $this->Core = $core;
        
       $entityName = "Apps\Blog\Entity\BlogUserNewLetter";
       $this->Entity = new $entityName($core);
    }
        
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("BlogId"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        //Get The Defaul blog
        $blog = BlogHelper::GetDefault($this->Core);
        
        $this->Entity->BlogId->Value = $blog->IdEntite;
       
        if(Request::GetPost("Email"))
        {
            parent::updated();
        }
    }
}
