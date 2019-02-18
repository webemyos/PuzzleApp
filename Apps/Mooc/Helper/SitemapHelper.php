<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Helper;

use Apps\Mooc\Entity\MoocCategory;
use Apps\Mooc\Entity\MoocMooc;
use Apps\Mooc\Entity\MoocLesson;


class SitemapHelper
{
    /***
     * Obtient le site map du Forum
     */
    public static function GetSiteMap($core)
    {
        $sitemap .= "<url><loc>$urlBase/Mooc.html</loc></url>";
        $urlBase = $core->GetPath("");

        $category = new MoocCategory($core);
        $categorys = $category->GetAll();
        
        foreach($categorys as $category)
        {	
            $sitemap .= "<url><loc>$urlBase/Mooc/Category/".$category->Code->Value."</loc></url>";
        }
        
        $mooc = new MoocMooc($core);
        $moocs = $mooc->GetAll();

        foreach($moocs as $mooc)
        {	
            $sitemap .= "<url><loc>$urlBase/Mooc/Mooc/".$mooc->Code->Value."</loc></url>";
        }
        
        $moocLesson = new MoocLesson($core);
        $moocLessons = $moocLesson->GetAll();

        foreach($moocLessons as $moocLesson)
        {	
            $sitemap .= "<url><loc>$urlBase/Mooc/Lesson/".$moocLesson->Code->Value."</loc></url>";
        }
        return $sitemap;
    }
} 