<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogCategory;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;


class CategoryHelper
{   
    /**
     * Sauvagarde une catégorie
     */
    public static function Save($core, $name, $description, $blogId, $categoryId)
    {
        $category = new BlogCategory($core);
        
        if($categoryId != "")
        {
            $category->GetById($categoryId);
        }
        
        $category->Name->Value = $name;
        $category->Code->Value = Format::ReplaceForUrl($name);
        $category->Description->Value = $description;
        
        if($blogId != "")
        {
            $category->BlogId->Value = $blogId;
        }
        
        $category->Save();   
    }
    
    /**
     * Retourne les catégories d'un blog
     * @param type $core
     * @param type $blogId
     */
    public static function GetByBlog($core, $blogId)
    { 
        $category = new BlogCategory($core);
        $category->AddArgument(new Argument("Apps\Blog\Entity\BlogCategory", "BlogId" ,EQUAL, $blogId));
        
        return $category->GetByArg();
    }
    
    /**
     * Obtient le nombre d'article correspondant
     */
    public static function GetNumberArticle($core, $categoryId)
    {
        $article = new BlogArticle($core);
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "CategoryId" ,EQUAL, $categoryId));
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif" , EQUAL, 1));
        
        return count($article->GetByArg());
    }
    
}


?>
