<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File;

use Apps\File\Entity\FileFile;
use Apps\File\Entity\FileFolder;
use Apps\File\Helper\FileHelper;
use Apps\File\Helper\FolderHelper;
use Apps\File\Module\File\FileController;
use Apps\File\Module\Folder\FolderConroller ;

use Core\App\Application;
use Core\Core\Request;

class File extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'DashBoardManager';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/File";

    /**
     * Constructeur
     * */
     function File($core)
     {
        parent::__construct($core, "File");
        $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
        $textControl = parent::Run($this->Core, "File", "File");
        echo $textControl;
     }

     
    /**
     * Charge les dossiers et fichier 
     */
    function LoadMyFile()
    {
        $folderController = new FolderController($this->Core);
        echo $folderController->LoadMyFile("", true);
    }

    /*
     * Charge les dossiers et fichiers d'un dossier
     */
    function OpenFolder($folderId = "", $showDirectory = true, $showAdd = false, $action="")
    {
       $folderController = new FolderController($this->Core);

       if( $folderId == "")
       {
           echo $folderController->LoadMyFile(Request::GetPost("FolderId"), $showDirectory, $showAdd); 
       }
       else
       {
           echo $folderController->LoadMyFile($folderId, $showDirectory, $showAdd, $action); 
       }
    }

    /**
     * Popin de création de repertoire
     */
    public function ShowCreateFolder()
    {
        $folderController = new FolderController($this->Core);
        echo $folderController->ShowCreateFolder(Request::GetPost("FolderId"), 
                                            Request::GetPost("AppName"),
                                            Request::GetPost("EntityName"),
                                            Request::GetPost("EntityId")
                                            );
    }

    /**
     * Créer le nouveau dossier
     */
    public function SaveFolder()
    {
        $name = Request::GetPost("tbName");
        $folderId = Request::GetPost("FolderId");

        $appName = Request::GetPost("AppName");
        $entityName = Request::GetPost("EntityName");
        $entityId = Request::GetPost("EntityId");

        if($name != "" )
        {
            if(FolderHelper::CreateFolder($this->Core, $name, $folderId, $appName, $entityName, $entityId ))
            {
                echo "<span class='success'>".$this->Core->GetCode("File.FolderCreated")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("File.FolderExist")."</span>";
                $this->ShowCreateFolder();
            }
        }
        else
        { 
            echo "<span class='error'>".$this->Core->GetCode("File.FolderNameIncorrect")."</span>";
            $this->ShowCreateFolder();
        }
    }

    /**
     * Supprime un dossier
     */
    public function RemoveFolder()
    {
        if (FolderHelper::Remove($this->Core, Request::GetPost("FolderId")))
        {
            echo "success";
        }
        else
        {
            echo "error";
        }
    }

    /**
     * Pop in de partage de dossier
     */
    function ShowShareFolder()
    {
        $folderController = new FolderController($this->Core);
        echo $folderController->ShowShareFolder(Request::GetPost("FolderId"));
    }

    /**
     * Ajoute un ou plusieurs utilisateur ou dossier
     */
    function AddUserFolder()
    {
        FolderHelper::AddUser($this->Core, Request::GetPost("FolderId"), Request::GetPost("UsersId") );

        $folderController = new FolderController($this->Core);
        echo $folderController->GetUser(Request::GetPost("FolderId"));
    }

    /**
     * Supprime un partage
     */
    public function RemoveUser()
    {
        if (FolderHelper::RemoveUser($this->Core, Request::GetPost("ShareId")))
        {
            echo "success";
        }
        else
        {
            echo "error";
        }
    }

    /**
     * Ajoute un ou plusieurs utilisateur au ficheir
     */
    function AddUserFile()
    {
        FileHelper::AddUser($this->Core, Request::GetPost("FileId"), Request::GetPost("UsersId") );

        $fileController = new FileController($this->Core);
        echo $fileController->GetUser(Request::GetPost("FileId"));
    }

    /**
     * Popin d'ajout de fichier
     */
    public function ShowAddFile()
    {
        $fileController = new FileController($this->Core);
        echo $fileController->ShowAddFile(Request::GetPost("FolderId"));
    }

    /**
     * Pop in de partage de fichier
     */
    function ShowShareFile()
    {
        $folderController = new FileController($this->Core);
        echo $folderController->ShowShareFile(Request::GetPost("FileId"));
    }

    /**
     * Sauvegarde les fichiers
     */
    function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
    {
        if($idElement != "")
        {
            //Recuperation du dossier
            $folder = new FileFolder($this->Core);
            $folder->GetById($idElement);

            $directory = $this->Core->GetUserDirectory()."/".$folder->Location->Value;
        }
        else
        {
            //Ajout de l'image dans le repertoire correspondant
            $directory = $this->Core->GetUserDirectory();
        }


       switch($action)
       {
           case "SaveFile":

            if(!file_exists($directory."/".$fileName))
            {
                //Sauvegarde
                move_uploaded_file($tmpFileName, $directory."/".$fileName);

                //Enregistrement en base
                FileHelper::Add($this->Core, $fileName, $idElement);
            }

            break;
       }
    }

    /**
     * Supprime un fichier
     */
    public function RemoveFile()
    {
        if (FileHelper::Remove($this->Core, Request::GetPost("FileId")))
        {
            echo "success";
        }
        else
        {
            echo "error";
        }
    }

    /**
     * Charge les dossiers et fichiers partage de l'utilisateur
     */
    public function LoadSharedFile()
    {
       $folderController = new FolderController($this->Core);
       echo $folderController->LoadSharedFile(); 
    }

    /**
     * 
     */
    public function OpenFile()
    {
        //Recuperation du fichier
      $file = new FileFile($this->Core);
      $file->GetById(Request::GetPost("FileId"));

       $fileController = new FileController($this->Core);
       echo $fileController->OpenFile($file); 
    }

    /**
     * Obtient les dossier lié à l'app
     */
    public function GetFolderByApp($appName, $entityName, $entityId)
    {
        return FolderHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
    }
}
?>