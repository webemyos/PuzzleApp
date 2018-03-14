<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Blog\Model;

use Core\Core\Request;
use Core\Model\Model;

class CommentModel extends Model
{
    /*
     * Constructeur
     */
    public function __construct($core, $articleId = "")
    {
       $this->Core = $core;
        
       $entityName = "Apps\Blog\Entity\BlogComment";
       $this->Entity = new $entityName($core);
       $this->Entity->ArticleId->Value = $articleId;
    }
    
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("ArticleId", "UserId", "User", "DateCreated", "Actif"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        //Get The Defaul blog
        $this->Entity->UserId->Value = $this->Core->User->IdEntite;
        $this->Entity->Actif->Value = false;
        
        if(Request::GetPost("Message"))
        {
            parent::Updated();
        }
    }
}
