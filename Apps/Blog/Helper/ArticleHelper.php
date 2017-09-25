<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogCategory;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use Core\Utility\Format\Format;


class ArticleHelper
{
    /**
     * Sauvegarde l'article
     * @param type $core
     * @param type $name
     * @param type $keywork
     * @param type $description
     */
    public static function Save($core, $blogId, $articleId, $name, $keywork, $description, $categoryId, $actif)
    {
        $article = new BlogArticle($core);

        if($articleId != "")
        {
            $article->GetById($articleId);
        }
        else
        {
            $article->BlogId->Value = $blogId;
        }

        $article->UserId->Value = $core->User->IdEntite;
        $article->Name->Value = $name;
        $article->Code->Value = Format::ReplaceForUrl($name);
        $article->KeyWork->Value = $keywork;
        $article->Description->Value = $description;
        $article->Actif->Value = "0";
        $article->DateCreated->Value = Date::Now();
        $article->CategoryId->Value = $categoryId;
        $article->Actif->Value = $actif;


        $article->Save();
    }

    /*
     * Sauvegarde le contenu de l'article
     */
    public static function SaveContent($core, $articleId, $content)
    {
         $article = new BlogArticle($core);
         $article->GetById($articleId);
         $article->Content->Value = str_replace( "Data/", $core->GetPath()."/Data/",  $content);

         $article->Save();
    }

    /**
     * Récupere tous les articles d'une catégorie
     * @return type
     */
    public static function GetByCategoryId($core, $categoryId)
    {
        $article = new BlogArticle($core);
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "CategoryId" ,EQUAL, $categoryId));

        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif" ,EQUAL, 1));
        $article->AddOrder("Id");


        return $article->GetByArg();
    }

    /**
     * Récupere tous les articles d'une catégorie
     * @return type
     */
    public static function GetByCategoryName($core, $category)
    {
        //Formattage
        $category = str_replace("_"," ", $category);

        //Recuperation de la catégorie
        $categorie = new BlogCategory($core);
        $categorie->GetByName($category);

        $article = new BlogArticle($core);
        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "CategoryId" ,EQUAL, $categorie->IdEntite));

        $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif" ,EQUAL, 1));
        $article->AddOrder("Id");


        return $article->GetByArg();
    }

    /**
     * Retourne les trois dernier articles de la mème categorie
     */
    function GetSimilare($core, $article)
    {
        $articles = new BlogArticle($core);
        $articles->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Actif", EQUAL, 1));
        $articles->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "CategoryId", EQUAL, $article->CategoryId->Value));

        $articles->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Id", NOTEQUAL, $article->IdEntite));
        $articles->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "Id", LESS, $article->IdEntite));

        $articles->AddOrder(Id);
        $articles->SetLimit(1,3);
        return $articles->GetByArg();
    }
}
