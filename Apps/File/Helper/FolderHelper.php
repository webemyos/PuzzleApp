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

class FolderHelper
{
    /**
     * Créer un nouveau dossier
     */
    public static function CreateFolder($core, $name, $folderId, $appName, $entityName, $entityId)
    {
        //Recuperation du parent 
        if($folderId != "")
        {
            $parentFolder = new FileFolder($core);
            $parentFolder->GetById($folderId);
            
            //Todo faire un boucle pour reconstituer l'url
            $directory = $core->GetUserDirectory()."/".$parentFolder->Location->Value;
        }
        else
        {
            $directory = $core->GetUserDirectory();
            
            //Creation du repertoire racine si il n'existe pas
            File::CreateDirectory($directory);
        }
        
       //Creation du dossier
       if( File::CreateDirectory($directory ."/" . $name))
       {
            //Enregistrement en base
            $folder = new FileFolder($core);
            $folder->UserId->Value = $core->User->IdEntite;
            $folder->Name->Value = $name;
            $folder->DateCreated->Value = Date::Now();
            
            $folder->AppName->Value = $appName;
            $folder->EntityName->Value = $entityName;
            $folder->EntityId->Value = $entityId;
            
            if($folderId != "")
            {
               $folder->ParentId->Value =  $folderId;
               $folder->Location->Value = $parentFolder->Location->Value. "/".$name;
            }
            else
            {
               $folder->Location->Value = $name; 
            }
            
            $folder->Save();

            return true;
       }
       else
       {
         return false;  
       }
    }
    
    /*
     * Récupere les dossier de l'utilisateur
     */
    function GetByUser($core, $parentId)
    {
        $folder = new FileFolder($core);
        
        if($parentId == null)
        {
            $folder->AddArgument(new Argument("FileFolder", "ParentId", ISNULL, ""));
            $folder->AddArgument(new Argument("FileFolder", "UserId", EQUAL, $core->User->IdEntite));
        }   
        else
        {
            $folder->AddArgument(new Argument("FileFolder", "ParentId", EQUAL, $parentId));
        }
            
        return $folder->GetByArg();
    }
    
    /**
     * Supprime un dossier
     * 
     * @param type $core
     * @param type $folderId
     */
    function Remove($core, $folderId)
    {
        if(self::IsEmpty($core, $folderId))
        {
            //Suppression des partages
            self::RemoveAllUser($core, $folderId);
                    
            //Recuperation du dossier
            $folder = new FileFolder($core);
            $folder->GetById($folderId);
            
            $directory = $core->GetUserDirectory();
            
            $folder->Delete();
            
            return File::DeleteDirectory($directory. "/".$folder->Location->Value);
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Verifie que kle dossier est vide
     */
    function IsEmpty($core, $folderId)
    {   
        $folders = FolderHelper::GetByUser($this->Core, $folderId);
        $files = FileHelper::GetByUser($this->Core, $folderId);
             
        return ( (count($folders) + count($files)) == 0  );
    }
    
    /**
     * Ajoute un ou plusieurs utilisateur au dossier
     * @param type $core
     * @param type $folderId
     * @param type $userId
     */
    function AddUser($core, $folderId, $userId)
    {
        $users = split(";", $userId);
        
        //Recuperation de l'app Notify
        $eNotify = DashboardManager::GetApp("Notify", $core);

        foreach($users as $userId)
        {
            if(!self::UserExist($core, $folderId, $userId))
            {
                $share = new FileShare($core);
                $share->FolderId->Value = $folderId;
                $share->UserId->Value = $userId;
                $share->Save();

                //Envoi d'une notification
                $subjet = $core->GetCode("File.FolderSharedObjet"). " : " . $core->User->GetPseudo();  
                $message = $core->GetCode("eFile.FolderSharedMessage");

                $eNotify->AddNotify($core->User->IdEntite, "File.FolderShared", $userId,  "File", $folderId, $subjet, $message);
            }
        }
    }
    
    /**
     * Verifie si l'utilisateur a déjà été ajouté
     * @param type $core
     * @param type $folderId
     * @param type $userId
     */
    function UserExist($core, $folderId, $userId)
    {
        $fileShare = new FileShare($core);
        $fileShare->AddArgument(new Argument("FileShare","FolderId", EQUAL, $folderId));
        $fileShare->AddArgument(new Argument("FileShare","UserId", EQUAL, $userId));
        
        return (count($fileShare->GetByArg()) > 0 );
    }
    
    /**
     * Obtient les utilisateurs
     * @param type $core
     * @param type $folderId
     * @param type $userId
     */
    function GetUser($core, $folderId)
    {
        $fileShare = new FileShare($core);
        $fileShare->AddArgument(new Argument("FileShare","FolderId", EQUAL, $folderId));
        
        return $fileShare->GetByArg();
    }

    /**
     * Obtient les utilisateurs
     * @param type $core
     * @param type $folderId
     */
    function GetConcatUser($core, $folderId)
    {
        $users = self::GetUser($core, $folderId);
        
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
     * Supprime un partage
     * 
     * @param type $core
     * @param type $shareId
     */
    function RemoveUser($core, $shareId)
    {
        $fileShare = new FileShare($core);
        $fileShare->GetById($shareId);
        $fileShare->Delete();
        
        return true;
    }
        
    /**
     * Supprime tout les partages
     */
    function RemoveAllUser($core, $folderId)
    {
        $users = self::GetUser($core, $folderId);
        
        if(count($users) >  0)
        {    
            foreach($users as $user)
            {
                $user->Delete();
            }
        }
    }
    
     /*
     * Récupere les dossiers partagé de l'utilisateur
     */
    function GetSharedByUser($core)
    {
        $folder = new FileShare($core);
        $folder->AddArgument(new Argument("FileShare", "UserId", EQUAL, $core->User->IdEntite));
        $folder->AddArgument(new Argument("FileShare", "FolderId", NOTEQUAL, "null"));
        
        return $folder->GetByArg();
    }
    
    /**
     * Défini si un utilisateur à droit d'accès au dossier parent
     */
    public function IsAutorized($core, $folderId)
    {
        $fileShare = new FileShare($core);
        $fileShare->AddArgument(new Argument("FileShare", "UserId", EQUAL, $core->User->IdEntite));
        $fileShare->AddArgument(new Argument("FileShare", "FolderId", EQUAL, $folderId));
  
        return (count($fileShare->GetByArg()) > 0 );
    }
    
    /**
     * Obtient les dossiers de l'app
     */
    public function GetByApp($core, $appName, $entityName, $entityId )
    {
        $folder = new FileFolder($core);
        $folder->AddArgument(new Argument("FileFolder","AppName", EQUAL, $appName));
        $folder->AddArgument(new Argument("FileFolder","EntityName", EQUAL, $entityName));
        $folder->AddArgument(new Argument("FileFolder","EntityId", EQUAL, $entityId));
  
        return $folder->GetByArg();
    }
}

