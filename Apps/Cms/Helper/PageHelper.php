<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Cms\Helper;

use Apps\Cms\Entity\CmsPage;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;

class PageHelper
{
    /**
     * Sauvegarde l'page
     * @param type $core
     * @param type $name
     * @param type $keywork
     * @param type $description
     */
    public static function Save($core, $cmsId, $pageId, $name, $title, $description)
    {
        $page = new CmsPage($core);
        
        if($pageId != "")
        {
            $page->GetById($pageId);
        }
        else
        {
            $page->CmsId->Value = $cmsId;
        }
        
        $page->Name->Value = $name;
        $page->Code->Value = Format::ReplaceForUrl($name);
        $page->Title->Value = $title;
        $page->Description->Value = $description;
                
        $page->Save();
    }
    
    /*
     * Sauvegarde le contenu de l'page
     */
    public static function SaveContent($core, $pageId, $content)
    {
         $page = new CmsPage($core);
         $page->GetById($pageId);
         $page->Content->Value = $content;
         
         $page->Save();
    }
    
    /**
     * Récupere tous les pages d'une catégorie
     * @return type
     */
    public static function GetByCategoryId($core, $categoryId)
    {
        $page = new CmsPage($core);
        $page->AddArgument(new Argument("Apps\Cms\Entity\CmsPage", "CategoryId" ,EQUAL, $categoryId));
      
        $page->AddArgument(new Argument("Apps\Cms\Entity\CmsPage", "Actif" ,EQUAL, 1));
        $page->AddOrder("Id");
        
        
        return $page->GetByArg();
    }
}
