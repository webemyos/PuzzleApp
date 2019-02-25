<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;

use Apps\Blog\Entity\BlogComment;
use Apps\Blog\Entity\BlogArticle;

class CommentHelper
{
    /*
     * Ajoute un commentaire sur une entité d'n app
     */
    public static function AddComment($core, $code, $message, $name, $email)
    {
        $article = new BlogArticle($core);
        $article = $article->GetByCode($code);
                
        $comment = new BlogComment($core);
        $comment->ArticleId->Value = $article->IdEntite;
        $comment->UserId->Value = $core->User->IdEntite;
        $comment->Message->Value = $message;
        $comment->DateCreated->Value = Date::Now();
        $comment->UserName->Value = $name;
        $comment->Email->Value = $email;
        
        $comment->Save();
    }
    
    /*
     * Obtient le nombre de commentaire
     */
    public static function GetNumber($core, $articleId)
    {
         $comment = new BlogComment($core);
         $comment->AddArgument(new Argument("Apps\Blog\Entity\BlogComment", "ArticleId", EQUAL, $articleId));
         
         return count($comment->GetByArg());
    }
    
    
    /*
     * Obtient les commentaire d'un article
     */
    public static function GetByArticle($core, $articleId, $actif = null)
    {
        $comments = new BlogComment($core);
        $comments->AddArgument(new Argument("Apps\Blog\Entity\BlogComment", "ArticleId", EQUAL, $articleId));
        
        if($actif != null)
        {
            $comments->AddArgument(new Argument("Apps\Blog\Entity\BlogComment", "Actif", EQUAL, $actif));
        }
        
        return $comments->GetByArg();
    }
    
    /**
     * Publie/ Depuplie un commentaire
     */
    public static function Publish($core, $commentId, $state)
    {
        $comment = new BlogComment($core);
        $comment->GetById($commentId);
        $comment->Actif->Value = $state;
        $comment->Save();
    }
}
