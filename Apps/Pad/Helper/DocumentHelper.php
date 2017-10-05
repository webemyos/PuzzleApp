<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Pad\Helper;

use Apps\Downloader\Entity\PadDocument;
use Apps\Downloader\Entity\PadShare;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;


class DocumentHelper
{
    /**
     * Enregistre le document
     * @param type $core
     * @param type $name
     */
    public static function SaveDoc($core, $name, $appName, $entityName, $entityId)
    {
        $doc = new PadDocument($core);
        $doc->Name->Value = $name;
        $doc->UserId->Value = $core->User->IdEntite;
        $doc->DateCreated->Value = Date::Now();

        $doc->AppName->Value = $appName;
        $doc->EntityName->Value = $entityName;
        $doc->EntityId->Value = $entityId;

        $doc->Save();
    }
    
    /**
     * Met à jour le contenu d'un document
     * @param type $core
     * @param type $documentId
     * @param type $content
     */
    public static function SaveContent($core, $documentId, $content)
    { 
        $doc = new PadDocument($core);
        $doc->GetById($documentId);
        
        $doc->DateModified->Value = Date::Now();
        $doc->Content->Value = $content;
        
        $doc->Save();
    }
    
    /**
     * Sauvegarde un document pour une application
     */
    public static function SaveByApp($core, $name, $appName, $entityName, $entityId)
    {
        $doc = new PadDocument($core);
        $doc->Name->Value = $name;
        $doc->UserId->Value = $core->User->IdEntite;
        $doc->DateCreated->Value = Date::Now();
   
        $doc->AppName->Value = $appName;
        $doc->EntityName->Value = $entityName;
        $doc->EntityId->Value = $entityId;
           
        $doc->Save();
    }
    
    /**
     * Obtient les documents d'une application
     * @param type $core
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
         $doc = new PadDocument($core);
         $doc->AddArgument(new Argument("PadDocument", "AppName", EQUAL, $appName));
         $doc->AddArgument(new Argument("PadDocument", "EntityName", EQUAL, $entityName));
         $doc->AddArgument(new Argument("PadDocument", "EntityId", EQUAL, $entityId));
    
         return $doc->GetByArg();
    }
    
      /**
     * Obtient les images du blog
     * 
     * @param type $core
     * @param type $blogId
     */
    public static function GetImages($core)
    { 
        $directory = "../Data/Apps/Pad/". $core->User->IdEntite;
        $nameFile = array();
        $nameFileMini = array();
        
        if ($dh = opendir($directory))
         { $i=0;
         
             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 )
               {
                   $nameFile[$i] = $directory."/".$file;
                   $nameFileMini[$i] = $directory."/".$file."_96.jpg";
                   
                   $i++;
               }
             }
         }
         
         return implode("," , $nameFile) . ";".implode(",", $nameFileMini);
    }
    
    /*
     * Obtient les document partage de l'utilisateur
     */
    public static function GetSharedDoc($core)
    {
        $shareDoc = new PadShare($core);
        $shareDoc->AddArgument(new Argument("PadShare", "UserId", EQUAL, $core->User->IdEntite));
        $shareDoc = $shareDoc->GetByArg();
        
        $docs = array();
        
        foreach($shareDoc as $share)
        {
            $docs[] = $share->Doc->Value;
        }
    
        return $docs;
    }
    
    /*
     * Obtient les utilisateur d'un doc partagé
     */
    public static function GetUser($core, $docId)
    {
        $docShare = new PadShare($core);
        $docShare->AddArgument(new Argument("PadShare","DocId", EQUAL, $docId));
        
        return $docShare->GetByArg();
    }
    
    /**
     * Ajoute un ou plusieurs utilisateur au docu
     * @param type $core
     * @param type $folderId
     * @param type $userId
     */
    function AddUser($core, $docId, $userId)
    {
        $users = split(";", $userId);
        
        //Recuperation de l'app Notify
        $eNotify = DashBoardManager::GetApp("Notify", $core);

        foreach($users as $userId)
        {
            if(!self::UserExist($core, $docId, $userId))
            {
                $share = new PadShare($core);
                $share->DocId->Value = $docId;
                $share->UserId->Value = $userId;
                $share->Save();

             
                //Envoi d'une notification
                $subjet = $core->GetCode("Pad.PadSharedObjet"). " : " . $core->User->GetPseudo();  
                $message = $core->GetCode("Pad.PadSharedMessage");

                $eNotify->AddNotify($core->User->IdEntite, "Pad.FolderShared", $userId,  "Pad", $docId, $subjet, $message);
            }
        }
    }
    
    /**
     * Verifie si l'utilisateur a déjà été ajouté
     * @param type $core
     * @param type $docId
     * @param type $userId
     */
    function UserExist($core, $docId, $userId)
    {
        $docShare = new PadShare($core);
        $docShare->AddArgument(new Argument("PadShare","DocId", EQUAL, $docId));
        $docShare->AddArgument(new Argument("PadShare","UserId", EQUAL, $userId));
        
        return (count($docShare->GetByArg()) > 0 );
    }
    
     /**
     * Supprime un partage
     * 
     * @param type $core
     * @param type $shareId
     */
    function RemoveUser($core, $shareId)
    {
        $docShare = new PadShare($core);
        $docShare->GetById($shareId);
        $docShare->Delete();
        
        return true;
    }
}

