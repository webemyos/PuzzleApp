<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File\Helper;

use Apps\File\Entity\FileFile;
use Apps\File\Entity\FileShare;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use Core\Utility\File\File;
use Core\Dashboard\DashBoardManager;

class FileHelper
{
    const TEXT = 1;
    const IMAGE = 2;
    
    /*
     * Ajoute un fichier
     */
    public static function Add($core, $name, $folderId)
    {
        $file = new FileFile($core);
        $file->Name->Value = $name;
        $file->UserId->Value = $core->User->IdEntite;
        
        if($folderId !="")
        {
            $file->FolderId->Value = $folderId;
        }
        
        $file->DateCreated->Value = Date::Now();
         
        $file->Save();
    }
    
    /*
     * Récupere les fichiers de l'utilisateur
     */
    function GetByUser($core, $parentId)
    {
        $file = new FileFile($core);
        
        if($parentId == null)
        {
            $file->AddArgument(new Argument("FileFile", "FolderId", ISNULL, ""));
            $file->AddArgument(new Argument("FileFile", "UserId", EQUAL, $core->User->IdEntite));
        }   
        else
        {
            $file->AddArgument(new Argument("FileFile", "FolderId", EQUAL, $parentId));
        }
            
        return $file->GetByArg();
    }
    
    /**
     * Supprime un fichier
     * 
     * @param type $core
     * @param type $fileId
     */
    function Remove($core, $fileId)
    {
        //Recuperation du fichier
        $file = new FileFile($core);
        $file->GetById($fileId);

        //Suppression des partages
        self::RemoveAllUser($core, $fileId);
        
        if($file->FolderId->Value != "")
        {
            $directory = $core->GetUserDirectory($file->Folder->Value->UserId->Value)."/".$file->Folder->Value->Location->Value;
        }
        else
        {
            $directory = $core->GetUserDirectory();
        }
      
        if(File::Delete($file->Name->Value, $directory))
        {
            $file->Delete();
            return true;
        }
        else
        {
            return false;
        }
    }
    
     /**
     * Obtient les utilisateurs
     * @param type $core
     * @param type $fileId
     * @param type $userId
     */
    function GetUser($core, $fileId)
    {
        $fileShare = new FileShare($core);
        $fileShare->AddArgument(new Argument("FileShare","FileId", EQUAL, $fileId));
        
        return $fileShare->GetByArg();
    }
    
    /**
     * Obtient les utilisateurs
     * @param type $core
     * @param type $folderId
     */
    function GetConcatUser($core, $fileId)
    {
        $users = self::GetUser($core, $fileId);
        
        if(count($users) > 0)
        {
            $name = array();
            
            foreach($users as $user)
            {
                $name[] = $user->User->Value->GetPseudo();
            }
            
            return implode(";", $name);
        }   
        else
        {
            return $this->Core->GetCode("File.NoShare");
        }
    }
    
     /**
     * Ajoute un ou plusieurs utilisateur au fichier
     * @param type $core
     * @param type $fileId
     * @param type $userId
     */
    function AddUser($core, $fileId, $userId)
    {
        $users = split(";", $userId);
        
        //Recuperation de l'app Notify
        $eNotify = DashBoardManager::GetApp("Notify", $core);

        foreach($users as $userId)
        {
            if(!self::UserExist($core, $fileId, $userId))
            {

                $share = new FileShare($core);
                $share->FileId->Value = $fileId;
                $share->UserId->Value = $userId;
                $share->Save();

                //Envoi d'une notification
                $subjet = $core->GetCode("File.FileSharedObjet"). " : " . $core->User->GetPseudo();  
                $message = $core->GetCode("eFile.FileSharedMessage");

                $eNotify->AddNotify($core->User->IdEntite, "File.FileShared", $userId,  "File", $fileId, $subjet, $message);

            }
          }
    }
    
    /**
     * Verifie si l'utilisateur a déjà été ajouté
     * @param type $core
     * @param type $fileId
     * @param type $userId
     */
    function UserExist($core, $fileId, $userId)
    {
        $fileShare = new FileShare($core);
        $fileShare->AddArgument(new Argument("FileShare","FolderId", EQUAL, $fileId));
        $fileShare->AddArgument(new Argument("FileShare","UserId", EQUAL, $userId));
        
        return (count($fileShare->GetByArg()) > 0 );
    }
    
    /*
     * Récupere les fichiers partagede l'utilisateur
     */
    function GetSharedByUser($core)
    {
        $file = new FileShare($core);
        $file->AddArgument(new Argument("FileShare", "UserId", EQUAL, $core->User->IdEntite));
        $file->AddArgument(new Argument("FileShare", "FileId", NOTEQUAL, "null"));
            
        return $file->GetByArg();
    }
    
     /**
     * Supprime tout les partages
     */
    function RemoveAllUser($core, $fileId)
    {
        $users = self::GetUser($core, $fileId);
        
        if(count($users) >  0)
        {    
            foreach($users as $user)
            {
                $user->Delete();
            }
        }
    }
    
    /*
     * Obtient le type de fichier
     */
    public static function GetType($fileName)
    {
        $fileInfo = explode(".", $fileName);
        
        if(in_array($fileInfo[1], array("txt", "html", "csv")))
        {
            return self::TEXT;
        }
        
        if(in_array($fileInfo[1], array("jpg", "png", "bmp", "ico", "jpeg")))
        {
            return self::IMAGE;
        }
    }
}


?>

