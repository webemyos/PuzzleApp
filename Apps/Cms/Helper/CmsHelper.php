<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Cms\Helper;

use Apps\Cms\Entity\CmsCms;
use Core\Entity\Entity\Argument;

class CmsHelper
{
    /**
     * Crée un nouveau cms
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $name, $description, $appName, $entityName, $entityId)
    {
        if(!self::Exist($core, $name))
        {
            $cms = new CmsCms($core);
            $cms->UserId->Value = $core->User->IdEntite;
            $cms->Name->Value = $name;
            $cms->Description->Value = $description;
           
            $cms->AppName->Value = $appName;
            $cms->EntityName->Value = $entityName;
            $cms->EntityId->Value = $entityId;
            
            $cms->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Met a jour le cms
     */
    public static function Update($core, $cmsId, $name, $description)
    {
         if(!self::Exist($core, $name))
        {
            $cms = new CmsCms($core);
            $cms->GetById($cmsId);
            
            $cms->Name->Value = $name;
            $cms->Description->Value = $description;
 //           $cms->Actif->Value = "0";
   //         $cms->Style->Value = 1;

            $cms->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Verifie si un cms existe avec le meme non
     */
    public static function Exist($core, $name)
    {
        $cms = new CmsCms($core);
        $cms->AddArgument(new Argument("Apps\Cms\Entity\CmsCms", "Name", EQUAL, $name));
        $cmss = $cms->GetByArg();
        
        return (count($cmss) > 0) ;
    }
    
    /**
     * Obtient les images du cms
     * 
     * @param type $core
     * @param type $cmsId
     */
    public static function GetImages($core, $cmsId)
    { 
        $directory = "Data/Apps/Cms/". $cmsId;
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
      
         return implode("," , $nameFile) . ";".implode(",", $nameFileMini);
    }
    
    /**
     * Obtizent les cms d'une App
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $cms = new CmsCms($core);
        
        $cms->AddArgument(new Argument("Apps\Cms\Entity\CmsCms","AppName", EQUAL, $appName));
        $cms->AddArgument(new Argument("Apps\Cms\Entity\CmsCms","EntityName", EQUAL, $entityName));
        $cms->AddArgument(new Argument("Apps\Cms\Entity\CmsCms","EntityId", EQUAL, $entityId));
        
        return $cms->GetByArg();
    }
}
