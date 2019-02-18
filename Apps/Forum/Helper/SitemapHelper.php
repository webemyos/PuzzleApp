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


class SitemapHelper
{
    /***
     * Obtient le site map du Forum
     */
    public static function GetSiteMap($core)
    {
        $sitemap .= "<url><loc>$urlBase/Forum.html</loc></url>";
        $urlBase = $core->GetPath("");

        $category = new ForumCategory($core);
        $categorys = $category->GetAll();
        
        foreach($categorys as $category)
        {	
            $sitemap .= "<url><loc>$urlBase/Forum/Category/".$category->Code->Value."</loc></url>";
        }
        
        $message = new ForumMessage($core);
        $messages = $message->GetAll();

        foreach($messages as $message)
        {	
            $sitemap .= "<url><loc>$urlBase/Forum/Sujet/".$message->Code->Value."</loc></url>";
        }

        return $sitemap;
    }
} 