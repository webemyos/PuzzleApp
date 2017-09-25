<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Front\Model;

use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CategoryHelper;

class BlogModel
{
    protected $Core;
    
    function __construct($core)
    {
        $this->Core = $core;
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