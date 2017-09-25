<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader\Helper;

use Apps\Mooc\Entity\MoocCategory;
 
class CategoryHelper
{   
    /**
     * Sauvagarde une catégorie
     */
    public static function Save($core, $name, $description, $categoryId)
    {
        $category = new MoocCategory($core);
        
        if($categoryId != "")
        {
            $category->GetById($categoryId);
        }
        
        $category->Name->Value = $name;
        $category->Description->Value = $description;
        $category->Save();   
    }
}


?>
