<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Modele;

use Core\Utility\File\File;
use Core\Core\Core;

/**
 * Description of CacheManager
 *
 * @author jerome
 */
class CacheManager
{
    /*
     * Fin a template
     */
    public static function Find($template)
    {
        $core = Core::GetInstance();
        $lang = $core->GetLang();


        $cacheTemplate = str_replace("Apps", "Cache", $template);
        $cacheTemplate = str_replace("View\\", "View\\".$lang."\\", $cacheTemplate);

        //Search if the Template is rewrite in the APP
        if(file_exists($cacheTemplate) /*&& $core->Debug != true*/)
        {
            return  $cacheTemplate;
        }
        else
        {
            return null;
        }
    }

    /*
     * Store the template in the cache
     */
    public static function Store($template, $content)
    {
        //Recuperation de la langue courante
       $lang = Core::GetInstance()->GetLang();

       $realPath = str_replace("/Web/", "", $_SERVER['CONTEXT_DOCUMENT_ROOT']);
       $realPath = str_replace("/", "\\", $realPath);

       $search = $realPath. "\View";
       $replace = $realPath. "\Cache";

       //Géneration du path
       $cachetemplate = str_replace("Apps", "Cache", $template);
       $cachetemplate = str_replace(lcfirst($search), lcfirst($replace), lcfirst($cachetemplate));
       $cachetemplate = str_replace("View\\", "View\\".$lang."\\", $cachetemplate);


       //Création de l'arborescence et du fichier cache
        File::CreateArboresence($cachetemplate);
        File::SetFileContent($cachetemplate, $content);
    }
}