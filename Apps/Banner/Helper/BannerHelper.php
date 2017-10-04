<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Banner\Helper;


class BannerHelper
{
    /**
     * Crée un nouveau cms
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $name, $appName, $entityName, $entityId)
    {
        if(!self::Exist($core, $name))
        {
            $banner = new BannerBanner($core);
            $banner->UserId->Value = $core->User->IdEntite;
            $banner->Name->Value = $name;
            $banner->Actif->Value = "0";
           
            $banner->AppName->Value = $appName;
            $banner->EntityName->Value = $entityName;
            $banner->EntityId->Value = $entityId;
            
            $banner->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Met a jour le banner
     */
    public function Update($core, $bannerId, $name, $actif)
    {
         if(!self::Exist($core, $name))
        {
            $banner = new BannerBanner($core);
            $banner->GetById($bannerId);
            
            $banner->Name->Value = $name;
            $banner->Actif->Value = $actif;
 
            $banner->Save();
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Verifie si un banner existe avec le meme non
     */
    public static function Exist($core, $name)
    {
        $banner = new BannerBanner($core);
        $banner->AddArgument(new Argument("BannerBanner", "Name", EQUAL, $name));
        $banners = $banner->GetByArg();
        
        return (count($banners) > 0) ;
    }
    
    /**
     * Obtient les images du banner
     * 
     * @param type $core
     * @param type $bannerId
     */
    public static function GetImages($core, $bannerId)
    { 
        $directory = "Data/Apps/Banner/". $bannerId;
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
     * Obtient les banners d'une App
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $banner = new BannerBanner($core);
        
        $banner->AddArgument(new Argument("BannerBanner","AppName", EQUAL, $appName));
        $banner->AddArgument(new Argument("BannerBanner","EntityName", EQUAL, $entityName));
        $banner->AddArgument(new Argument("BannerBanner","EntityId", EQUAL, $entityId));
        
        return $banner->GetByArg();
    }
    
    /**
     * Sauvegarde un lecteur pour un banner 
     * @param type $core
     * @param type $email
     * @param type $bannerId
     */
    public static function SaveUserNewLetter($core, $email, $bannerId)
    {
        $user = new BannerUserNewLetter($core);
        $user->Email->Value = $email;
        $user->BannerId->Value = $bannerId;
        
        $user->Save();
    }
}
