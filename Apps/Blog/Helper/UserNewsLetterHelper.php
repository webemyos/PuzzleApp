<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Apps\Blog\Entity\BlogUserNewLetter;
use Core\Entity\Entity\Argument;

class UserNewsLetterHelper
{
    /**
     * Obtient les email des lecteurs d'un blog
     */
    public static function GetByBlog($core, $blogId)
    {
           $user = new BlogUserNewLetter($core);
           $user->AddArgument(new Argument("Apps\Blog\Entity\BlogUserNewLetter", "BlogId", EQUAL, $blogId));
          
           //A Changer sur le serveur pour créer des groupe de 100
           $user->setLimit(1, 100 );

           return $user->GetByArg();
    }
}


?>
