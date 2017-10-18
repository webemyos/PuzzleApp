<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Mooc\Helper;

use Apps\Mooc\Entity\MoocLesson;
use Apps\Mooc\Entity\MoocMooc;
use Apps\Mooc\Entity\MoocMoocUser;
use Core\App\AppManager;
use Core\Core\Core;
use Core\Dashboard\DashBoard;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use Core\Utility\Format\Format;

class MoocHelper
{
    /*
     *  Get All Mooc 
     */
    public static function GetAll($core)
    {
        $mooc = new MoocMooc($core);

        return $mooc->GetAll();
    }
    
    /*
     * Sauvegarde un Mooc
     */
    public static function SaveMooc($core, $name, $description, $categoryId, $moocId)
    {
        $mooc = new MoocMooc($core);
        
        if($moocId != "")
        {
            $mooc->GetById($moocId);
        }
        
        $mooc->Name->Value = $name;
        $mooc->Code->Value = Format::ReplaceForUrl($name);
        $mooc->Description->Value = $description;
        $mooc->CategoryId->Value = $categoryId;
        $mooc->DateCreated->Value = Date::Now();
        $mooc->UserId->Value = $core->User->IdEntite;
        
        $mooc->Save();
    }
    
    /**
     * Obtient les Mooc créer par l'utilisateur
     * @param type $core
     */
    public static function GetByUser($core, $returnTab= false)
    {
        $mooc = new MoocMooc($core);
        $mooc->AddArgument(new Argument("Apps\Mooc\Entity\MoocMooc", "UserId", EQUAL, $core->User->IdEntite));
        $moocs = $mooc->GetByArg();
        
        if(count($moocs) > 0 || (count($moocs) == 0 && $returnTab == false))
        {
            return $moocs;
        }
        else
        {
            return array();   
        }
    }
    
     /**
     * Obtient les leçons du Mooc
     * @param type $core
     */
    public static function GetLesson($core, $moocId, $returnTab= false, $actif = null)
    {
        $lesForm = array();
    
        $lesson = new MoocLesson($core);
        $lesson->AddArgument(new Argument("Apps\Mooc\Entity\MoocLesson", "MoocId", EQUAL, $moocId));
           
        if($actif != null)
        {
            $lesson->AddArgument(new Argument("Apps\Mooc\Entity\MoocLesson", "Actif", EQUAL, $actif));
        }
         
        $lessons = $lesson->GetByArg();
         
        if(count($lessons) > 0 || (count($lessons) == 0 && $returnTab == false))
        {
            return $lessons;
        }
        else
        {
            return array();   
        }
    }
    
    /*
     * Sauvegarde une lesson
     */
    public static function SaveLesson($core, $name, $video, $description, $content, $lessonId, $moocId, $actif)
    {
        $lesson = new MoocLesson($core);
        
        if($lessonId != "")
        {
            $lesson->GetById($lessonId);
        }
        
        $lesson->Name->Value = $name;
        $lesson->Code->Value = Format::ReplaceForUrl($name);
        $lesson->Video->Value = $video;
        $lesson->Description->Value = $description;
        $lesson->Content->Value = $content;
        $lesson->MoocId->Value = $moocId;
        $lesson->Actif->Value = $actif;
        
        $lesson->Save();
    }
    
    /*
     * Recherche les mooc
     */
    public function Search($core, $categoryId) 
    {
        $mooc = new MoocMooc($core);
        $mooc->AddArgument(new Argument("Apps\Mooc\Entity\MoocMooc", "CategoryId", EQUAL, $categoryId));
        
        return $mooc->GetByArg();
    }
    
    /**
     * Enregistre un formulaire
     * @param type $core
     * @param type $libelle
     * @param type $commentaire
     * @param type $projetId
     */
    public static function SaveQuiz($core, $libelle, $commentaire, $moocId )
    {
        $form = DashBoard::GetApp("Form", $core);
        
        $form->SaveByApp("Mooc", "Apps\Mooc\Entity\MoocMooc", $moocId, $libelle, $commentaire);
    }
    
    /*
     * Sauvegare un mooc pour un utilisateur
     */
    public static function Memorise($core, $userId, $moocId)
    {
        if(!MoocHelper::UserHave($core, $userId, $moocId))
        {
            $moocUser = new MoocMoocUser($core);
            $moocUser->MoocId->Value = $moocId;
            $moocUser->UserId->Value = $userId;
            
            $moocUser->Save();
        }
    }
   
    /*
     * Verifie si l'utilisateur à déjà commencer le Mooc
     */
    public static function UserHave($core, $userId, $moocId)
    {
        $moocUser = new MoocMoocUser($core);
        $moocUser->AddArgument(new Argument("Apps\Mooc\Entity\MoocMoocUser", "UserId", EQUAL, $userId));
        $moocUser->AddArgument(new Argument("Apps\Mooc\Entity\MoocMoocUser", "MoocId", EQUAL, $moocId));
  
        return (count($moocUser->GetByArg())> 0);
    }
    
    /*
     * Récupere les mooc de l utilisateur
     */
    public static function GetStartedByUser($core, $userId)
    {
        $moocUser = new MoocMoocUser($core);
        $moocUser->AddArgument(new Argument("Apps\Mooc\Entity\MoocMoocUser", "UserId", EQUAL, $userId));
        
        return $moocUser->GetByArg();
    }
    
      /**
     * Obtient les images du blog
     * 
     * @param type $core
     * @param type $blogId
     */
    public static function GetImages($moocId)
    { 
        $directory = "Data/Apps/Mooc/". $moocId;
        $nameFile = array();
        $nameFileMini = array();
        
        if ($dh = opendir($directory))
         { $i=0;
         
             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 )
               {
                   $nameFile[$i] = Core::GetPath("/".$directory."/".$file);
                   $nameFileMini[$i] = Core::GetPath("/".$directory."/".$file."_96.jpg");
                   
                   $i++;
               }
             }
         }
         
         return implode("," , $nameFile) . ";".implode(",", $nameFileMini);
    }
    
    /*
     * Ajoute un elemet à une lesson
     */    
    public function AddElement($core, $lessonId, $type, $name)
    {
        switch($type)
        {
            case 0 :
                $eform = AppManager::GetApp("Form");
                $eform->SaveByApp("Mooc", "MoocLesson", $lessonId, $name, "" );
            break;
        }
    }
}