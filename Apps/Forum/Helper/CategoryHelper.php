<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Forum\Helper;

use Apps\Forum\Entity\ForumCategory;
use Apps\Forum\Entity\ForumMessage;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;


class CategoryHelper
{   
    /**
     * Sauvagarde une catégorie
     */
    public static function Save($core, $name, $description, $forumId, $categoryId)
    {
        $category = new ForumCategory($core);
        
        if($categoryId != "")
        {
            $category->GetById($categoryId);
        }
        
        $category->Name->Value = $name;
        $category->Code->Value = Format::ReplaceForUrl($name);
        $category->Description->Value = $description;
        $category->ForumId->Value = $forumId;
        $category->Save();   
    }
    
    /**
     * Retourne les catégories d'un forum
     * @param type $core
     * @param type $forumId
     */
    public static function GetByForum($core, $forumId)
    { 
        $category = new ForumCategory($core);
        $category->AddArgument(new Argument("Apps\Forum\Entity\ForumCategory", "ForumId" ,EQUAL, $forumId));
        
        return $category->GetByArg();
    }
    
    /*
     * Supprime une catégorie
     */
    public static function DeleteCategory($core, $categoryId)
    {
        //TODO supprimé les message liées
        
        //Suppression de la categorie
        $categorie = new ForumCategory($core);
        $categorie->GetById($categoryId);
        $categorie->Delete();
    }
    
    /**
     * Obtient le nombre de message d'une categorie
     * @param type $core
     * @param type $category
     */
    public static function GetNumberMessage($core, $category)
    {
       return (count(self::GetMessages($core, $category)));
    }
    
    /*
     * Obtient les message d'une categorie
     */
    public static function GetMessages($core, $category)
    {
        $message = new ForumMessage($core);
        $message->AddArgument(new Argument("Apps\Forum\Entity\ForumMessage", "CategoryId", EQUAL, $category));
        
        return $message->GetByArg();
    }
    
}


?>
