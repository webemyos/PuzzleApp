<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Blog\Model;

use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CategoryHelper;
use Core\Core\Request;
use Core\Model\Model;

class BlogModel extends Model
{
    /*
     * Constructeur
     */
    public function __construct($core, $blogId = "")
    {
       $this->Core = $core;
        
       $entityName = "Apps\Blog\Entity\BlogBlog";
       $this->Entity = new $entityName($core);
       
       if($blogId != "")
       {
           $this->Entity->GetById($blogId);
       }
    }
    
    
    /*
     * Prepare the form
     */
    public function Prepare()
    {
        $this->Exclude(array("UserId", "Style", "AppName" , "AppId", "EntityName", "EntityId", "Actif"));
    }
    
    /*
     * Save/update the entity 
     */
    public function Updated()
    {
        //Get The Defaul blog
        $this->Entity->UserId->Value = $this->Core->User->IdEntite;
        $this->Entity->Actif->Value = 1;
        
        if(Request::GetPost("Name"))
        {
            parent::Updated();
        }
    }
    
     /*
     * Get the category of the blog
     */
    function GetCategoryByBlog($core, $blogId)
    {
        return CategoryHelper::GetByBlog($core, $blogId);
    }
    
    /*
     * Get The Last Article
     */
    function GetLastArticle($core, $blog)
    {
        return BlogHelper::GetLast($core, $blog);
    }
}
