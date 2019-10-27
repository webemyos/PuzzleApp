<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Entity\BlogUserNewLetter;
use Core\Entity\Entity\Argument;


class BlogHelper
{
    /*
     * @param type $core
     * Get The blog define in the config 
     */
    public static function GetDefault($core)
    {
        $blog = new BlogBlog($core);
        return $blog->GetFirst();
    }
    
    /**
     * Crée un nouveau blog
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $name, $description, $appName, $entityName, $entityId)
    {
        if(!self::Exist($core, $name))
        {
            $blog = new BlogBlog($core);
            $blog->UserId->Value = $core->User->IdEntite;
            $blog->Name->Value = $name;
            $blog->Description->Value = $description;
            $blog->Actif->Value = "0";
            $blog->Style->Value = 1;

            $blog->AppName->Value = $appName;
            $blog->EntityName->Value = $entityName;
            $blog->EntityId->Value = $entityId;

            $blog->Save();

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Met a jour le blog
     */
    public function Update($core, $blogId, $name, $description, $serveurFtp, $login, $passWord)
    {
         if(self::Exist($core, $name))
        {
            $blog = new BlogBlog($core);
            $blog->GetById($blogId);

            $blog->Name->Value = $name;
            $blog->Description->Value = $description;

            $blog->ServeurFtp->Value = $serveurFtp;
            $blog->Login->Value = $login;
            $blog->PassWord->Value = $passWord;

            $blog->Save();

            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Verifie si un blog existe avec le meme non
     */
    public static function Exist($core, $name)
    {
        $blog = new BlogBlog($core);
        $blog->AddArgument(new Argument("Apps\Blog\Entity\BlogBlog", "Name", EQUAL, $name));
        $blogs = $blog->GetByArg();

        return (count($blogs) > 0) ;
    }

    /**
     * Obtient les images du blog
     *
     * @param type $core
     * @param type $blogId
     */
    public static function GetImages($core, $blogId, $concat = true)
    {
        $directory = "Data/Apps/Blog/". $blogId;
        $nameFile = array();
        $nameFileMini = array();


        if ($dh = opendir($directory))
         { $i=0;

             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 )
               {
                   $nameFile[$i] = $directory."/".$file;

                   $fileNameMini =str_replace(".png", "", $file);
                   $fileNameMini =str_replace(".jpg", "", $fileNameMini);
                   $fileNameMini =str_replace(".jpeg", "", $fileNameMini);
                   $fileNameMini =str_replace(".ico", "", $fileNameMini);

                   $nameFileMini[$i] = $directory."/".$fileNameMini."_96.png";

                   $i++;
               }
             }
         }

         if($concat)
         {
            return implode("," , $nameFile) . ";".implode(",", $nameFileMini);
         }
         else
         {
             return array_merge($nameFile, $nameFileMini);
         }
    }

    /**
     * Obtient l'article courant
     * @param type $core
     * @param type $blog
     */
    public static function GetCurrentArticle($core, $blog, $idEntite)
    {
        $article = new BlogArticle($core);

        if($idEntite != "")
        {
            // Recuperation par le code
            $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Code", EQUAL, $idEntite));
            $articles = $article->GetByArg();
            return $articles[0];
        }
        else
        {
            $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "BlogId", EQUAL, $blog->IdEntite));
            $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif", EQUAL, 1));

            $article->AddOrder("Id");
            $article->SetLimit(1, 3);

            $articles = $article->GetByArg();

            return $articles;
        }
    }

        /**
     * Obtient l'article courant
     * @param type $core
     * @param type $blog
     */
    public static function GetLast($core, $blog, $limit = 5)
    {
        $article = new BlogArticle($core);
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "BlogId", EQUAL, $blog->IdEntite));
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif", EQUAL, 1));

        $article->AddOrder("Id desc");
        $article->SetLimit(1, $limit);

        $articles = $article->GetByArg();

        return $articles;
    }

    /**
     * Obtizent les blog d'une App
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $blog = new BlogBlog($core);

        $blog->AddArgument(new Argument("Apps\Blog\Entity\BlogBlog","AppName", EQUAL, $appName));
        $blog->AddArgument(new Argument("Apps\Blog\Entity\BlogBlog","EntityName", EQUAL, $entityName));
        $blog->AddArgument(new Argument("Apps\Blog\Entity\BlogBlog","EntityId", EQUAL, $entityId));

        return $blog->GetByArg();
    }

    /**
     * Sauvegarde un lecteur pour un blog
     * @param type $core
     * @param type $email
     * @param type $blogId
     */
    public static function SaveUserNewLetter($core, $email, $blogId)
    {
        $user = new BlogUserNewLetter($core);
        $user->Email->Value = $email;
        $user->BlogId->Value = $blogId;

        $user->Save();
    }
}
