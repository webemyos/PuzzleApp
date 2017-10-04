<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Banner\Helper;



class ContentHelper
{
    /**
     * Sauvegarde l'content
     * @param type $core
     * @param type $name
     * @param type $keywork
     * @param type $description
     */
    public static function Save($core, $bannerId, $contentId, $name, $actif)
    {
        $content = new BannerContent($core);
        
        if($contentId != "")
        {
            $content->GetById($contentId);
        }
        else
        {
            $content->BannerId->Value = $bannerId;
        }
        
        $content->Name->Value = $name;
        $content->Actif->Value = $actif;
                
        $content->Save();
    }
    
    /*
     * Sauvegarde le contenu de l'content
     */
    public static function SaveContent($core, $contentId, $text)
    {
         $content = new BannerContent($core);
         $content->GetById($contentId);
         $content->Content->Value = $text;
         
         $content->Save();
    }
}
