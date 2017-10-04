<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File\Module\File;

use Apps\File\Entity\FileFile;
use Apps\File\Helper\FileHelper;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;
use Core\Utility\File\File;
use Core\Control\Image\Image;
use Core\Control\Link\Link;
use Core\Control\Upload\Upload;

 class FileController extends Controller
 {
        /**
         * Constructeur
         */
        function __consrtuct($core="")
        {
              $this->Core = $core;
        }

        /**
         * Creation
         */
        function Create()
        {
        }

        /**
         * Initialisation
         */
        function Init()
        {
        }

        /**
         * Affichage du module
         */
        function Show($all=true)
        {
        }

        /**
         * Ajout de fichier
         */
        function ShowAddFile($folderId)
        {
            $html = "<h4>".$this->Core->GetCode("File.Upload")."</h4>";

            //UploadAjax 
            $tbFile = new Upload("File", $folderId, "FileAction.RefreshFolder()", "SaveFile", "FileUpload");
            $html .= $tbFile->Show();

            return $html;
        }

        /**
        * Popin de partage de fichier
        */
       function ShowShareFile($folderId)
       {
           $html ="";

           //Recherche d'utilisateur
           $tbContact = new AutoCompleteBox("tbContact", $this->Core);
           $tbContact->PlaceHolder = $this->Core->GetCode("SearchUser");
           $tbContact->Entity = "User";
           $tbContact->Methode = "SearchUser";
           $tbContact->Parameter = "AddAction=FileAction.SelectUserFile(".$folderId.")";

           $html .= $tbContact->Show();

           $html .= $this->GetUser($folderId);

           return $html;
       }

       /**
        * Obtient les utilisateurs d'un dossier
        */
       function GetUser($folderId)
       {
           $html = "<div id='dvFolderUserShared'>";

           $users = FileHelper::GetUser($this->Core, $folderId);

           if(count($users) > 0)
           {
               $eprofil = DashBoardManager::GetApp("Profil", $this->Core);

               foreach($users as $user)
               {
                   $html .= "<span>" .$eprofil->GetProfil($user->User->Value);

                   //Bouton de suppression
                    $html .= "<i class='icon-remove' id='".$user->IdEntite."' title='".$this->Core->GetCode("File.RemoveUser")."' onclick='FileAction.RemoveUser(this)'  >&nbsp</i>";
                    $html .=  "</span>";
               }
           }
           else
           {
               $html .= $this->Core->GetCode("File.NoPartage");
           }

           $html .= "</div>";

           return $html;
       }

       /**
        * Affiche un apercu des fichiers dans le dossier 
        * et les programme pouvant les ouvrir
        * @param type $fileId
        */
       function OpenFile($fileId)
       { 
           $html = "";


           //Recuperation du fichier
           $file = new FileFile($this->Core);
           $file->GetById(Request::GetPost("FileId"));

             //Recuperation du repertoire source
           $directory = $this->Core->GetUserDirectory($file->Folder->Value->UserId->Value);

           //Lien direct
           $link = new Link($this->Core->GetCode("Download"), $directory. "/". $file->Folder->Value->Location->Value."/". $file->Name->Value);
           $link->AddAttribute("target", "_blank");

           $html .= "<h4>".$this->Core->GetCode("File.Telechargement")."</h4>";
           $html .= $link->Show();


           switch(FileHelper::GetType($file->Name->Value))
           {
               case FileHelper::TEXT :
                  //
                  $html .= "<h4>".$this->Core->GetCode("File.Apercu")."</h4>";

                   $txt = File::GetFileContent($directory. "/". $file->Folder->Value->Location->Value."/". $file->Name->Value, $replace);

                   $html .= $txt;
                   break;
               case FileHelper::IMAGE :

                   //
                  $html .= "<h4>".$this->Core->GetCode("File.Apercu")."</h4>";

                   $img = new Image($directory. "/". $file->Folder->Value->Location->Value."/". $file->Name->Value);

                   $html .= $img->Show();

                  break;
           }

           return $html;
       }
         
 }?>