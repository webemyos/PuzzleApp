<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Apps\Blog\Entity\BlogCategory;
use Apps\Blog\Entity\BlogArticle;


class SitemapHelper
{
    /***
     * Obtient le site map du blog
     */
    public static function GetSiteMap($core)
    {
        $sitemap .= "<url><loc>$urlBase/Blog.html</loc></url>";
        $urlBase = $core->GetPath("");

        $category = new BlogCategory($core);
        $categorys = $category->GetAll();
        
        foreach($categorys as $category)
        {	
            $sitemap .= "<url><loc>$urlBase/Blog/Category/".$category->Code->Value."</loc></url>";
        }
        
        $article = new BlogArticle($core);
        $articles = $article->GetAll();

        foreach($articles as $article)
        {	
            $sitemap .= "<url><loc>$urlBase/Blog/Article/".$article->Code->Value."</loc></url>";
        }

        return $sitemap;
    }
}