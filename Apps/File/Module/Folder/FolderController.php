<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File\Module\Folder;

use Apps\File\Entity\FileFolder;
use Apps\File\Helper\FileHelper;
use Apps\File\Helper\FolderHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Control\Image\Image;


 class FolderConroller extends Controller
 {
        /**
         * Constructeur
         */
        function _construct($core="")
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
         * Création d'un repertoire
         */
        function ShowCreateFolder($folderId, $appName, $entityName, $entityId)
        {
            $jbFolder = new AjaxFormBlock($this->Core, "jbFolder");

            $jbFolder->App = "File";
            $jbFolder->Action = "SaveFolder";
            $jbFolder->AddArgument("FolderId", $folderId);

            $jbFolder->AddArgument("AppName", $appName);
            $jbFolder->AddArgument("EntityName", $entityName);
            $jbFolder->AddArgument("EntityId", $entityId);

            $jbFolder->AddControls(array(
                                       array("Type"=>"TextBox", "Name"=>"tbName", "Libelle"=> $this->Core->GetCode("Name")),
                                       array("Type"=>"Button","CssClass"=>"btn btn-primary", "Name"=>"BtnSave", "Value"=>$this->Core->GetCode("Enregister"))   
             ));

             return $jbFolder->Show();
       }

       /**
        * Popin de partage de fichier
        */
       function ShowShareFolder($folderId)
       {
           $html ="";

           //Recherche d'utilisateur
           $tbContact = new AutoCompleteBox("tbContact", $this->Core);
           $tbContact->PlaceHolder = $this->Core->GetCode("SearchUser");
           $tbContact->Entity = "User";
           $tbContact->Methode = "SearchUser";
           $tbContact->Parameter = "AddAction=FileAction.SelectUser(".$folderId.")";

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

           $users = FolderHelper::GetUser($this->Core, $folderId);

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
        * Charge les dossiers et fichiers de l'utilisateur
        */
       function LoadMyFile($folderId = null, $showDirectory, $showAddButton="", $action="")
       {
           $html = "<div class='content-panel'>";

           //Recuperation des dossiers et fichiers
           $folders = FolderHelper::GetByUser($this->Core, $folderId);
           $files = FileHelper::GetByUser($this->Core, $folderId);

           if(count($folders) > 0 || count($files) > 0 )
           {
              //Entete
            /*  $html .= "<div class='headFolder titleBlue'  >";
              $html .= "<b class='blueTree'>&nbsp;</b>" ;
              $html .= "<span class='blueTree name' ><b>".$this->Core->GetCode("Name")."</b></span>" ;
              $html .= "<span class='blueTree'><b>".$this->Core->GetCode("DateCreated")."</b></span>" ;
              $html .= "<span class='blueTree'><b>".$this->Core->GetCode("DateModified")."</b></span>" ;
              $html .= "<span class='blueTree'><b>".$this->Core->GetCode("Users")."</b></span>" ;
              $html .= "</span>";  
              $html .= "</div>" ;*/
           }

           //Retour répertoire parent
           if($folderId != null)
           {
               //Recuperation du dossier
              $folder = new FileFolder($this->Core);
              $folder->GetById($folderId);

               //Si je suis le propriétaire du dossier 
               if(    ($folder->ParentId->Value == "" &&  $folder->UserId->Value == $this->Core->User->IdEntite )
                   ||  $folder->Parent->Value->UserId->Value == $this->Core->User->IdEntite 
                   || FolderHelper::IsAutorized($this->Core, $folder->ParentId->Value)   
               )
               {
                   //On affiche le repertoire parent
                 if($showDirectory)
                 {
                   $html .= "<div class='folder'  >";
                   $html .= "<i class='icon-folder-close blueOne'>&nbsp;</i>" ;
                   $html .= "<span class='blueOne name' id='".$folder->ParentId->Value."' >...</span>" ;
                 }
               }
               else
               {  
                  if($showDirectory)
                 {
                  //Retour à la racine des dossier partage
                   $html .= "<div class='folder'  >";
                  $html .= "<i class='icon-folder-close blueOne'>&nbsp;</i>" ;
                  $html .= "<span class='blueOne'  onclick= 'FileAction.LoadSharedFile()' >...</span>" ;
                 }
               }
           }


           //Ajout des dossier
           if(count($folders) > 0 && $showDirectory)
           {
               $i=0;

               foreach($folders as $folder)
               {
                  $html .= "<div class='folder'  >";
                  $html .= "<i class='icon-folder-close blueOne'>&nbsp;</i>" ;
                  $html .= "<span class='blueOne name' id='".$folder->IdEntite."' >".$folder->Name->Value."</span>" ;

                  //Dossier d'application
                  if($folder->AppName->Value != "")
                  {
                      $img = new Image("../Apps/".$folder->AppName->Value."/Images/logo.png");
                      $img->Title->Value = $img;
                      $html .= "<span >".$img->Show()."</span>" ;
                  }
                  else
                  {
                      $html .= "<span ></span>" ;
                  }

                  $html .= "<span class='date'>".$folder->DateCreated->Value."</span>" ;
                  $html .= "<span class='date'>".$folder->DateModified->Value."</span>" ;

                  //Partagé avec
                  $html .= "<span class='date'>".FolderHelper::GetConcatUser($this->Core, $folder->IdEntite) ."</span>" ;

                  //Bouton d'action
                  if($folder->UserId->Value == $this->Core->User->IdEntite)
                  {
                      $html .= "<span class='action'>";
                      $html .= "<i class='icon-share' id='".$folder->IdEntite."' title='".$this->Core->GetCode('File.Share')."' onClick='FileAction.ShareFolder(this)' >&nbsp</i>" ;
                      $html .= "<i class='icon-remove' id='".$folder->IdEntite."' title='".$this->Core->GetCode('File.Remove')."' onClick='FileAction.RemoveFolder(this)' >&nbsp</i></span>" ;
                  }

                  $html .= "</div>" ;
               }
           }

           //Ajout de fichier
           if($showAddButton)
           {
               $btnAdd = new Button(BUTTON);
               $btnAdd->Value = $this->Core->GetCode("AddFile");
               $btnAdd->OnClick = $action;
               $html .= "<div>".$btnAdd->Show()."</div>";
           }

           //Ajout des fichier
           if(count($files) > 0)
           {
               foreach($files as $file)
               {
                   if($i==1)
                  {
                       $i=0;
                       $class='lineClair';
                   }
                   else
                   {
                       $i=1;
                       $class='lineFonce';
                   }
                  $html .= "<div class='file $class' >";
                  $html .= "<i class='icon-file blueTree'>&nbsp;</i>" ;
                  $html .= "<span class='blueOne name' id='".$file->IdEntite."' >".$file->Name->Value."</span>" ;

                  //Fichier d'application
                  if($file->AppName->Value != "")
                  {
                      $img = new Image("../Apps/".$file->AppName->Value."/Images/logo.png");
                      $img->Title->Value = $img;
                      $html .= "<span >".$img->Show()."</span>" ;
                  }
                  else
                  {
                      $html .= "<span ></span>" ;
                  }

                  $html .= "<span class='date'>".$file->DateCreated->Value."</span>" ;
                  $html .= "<span class='date'>".$file->DateModified->Value."</span>" ;

                  //Partagé avec
                  $html .= "<span class='date'>".FileHelper::GetConcatUser($this->Core, $file->IdEntite) ."</span>" ;

                  if($file->UserId->Value == $this->Core->User->IdEntite)
                  {
                      $html .= "<span class='action'><i class='icon-share' id='".$file->IdEntite."' title='".$this->Core->GetCode('File.Share')."' onClick='FileAction.ShareFile(this)' >&nbsp</i>" ;
                      $html .= "<i class='icon-remove' id='".$file->IdEntite."' title='".$this->Core->GetCode('File.Remove')."' onClick='FileAction.RemoveFile(this)' >&nbsp</i></span>" ;
                  }

                  $html .= "</div>" ;
               }
           }

           $html .= "</div>";

           if($html != "<div class='content-panel'>")
           {
               return $html;
           }
           else
           {
               return "File.NoFolder";
           }
       }

       /**
        * Charge les dossiers et ficheirs partagé de l'utilisateur
        */
       function LoadSharedFile()
       {
           $folders = FolderHelper::GetSharedByUser($this->Core);
           $files = FileHelper::GetSharedByUser($this->Core);

           if(count($folders) > 0 || count($files) > 0 )
           {
              //Entete
             /* $html .= "<div class='headFolder titleBlue'  >";
              $html .= "<b class='blueTree'>&nbsp;</b>" ;
              $html .= "<span class='name' ><b>".$this->Core->GetCode("Name")."</b></span>" ;
              $html .= "<span ><b>".$this->Core->GetCode("DateCreated")."</b></span>" ;
              $html .= "<span ><b>".$this->Core->GetCode("DateModified")."</b></span>" ;
              $html .= "<span ><b>".$this->Core->GetCode("Propritaire")."</b></span>" ;
              $html .= "</span>";  
              $html .= "</div>" ;*/
           }

           //Ajout des dossier
           if(count($folders) > 0)
           {
               $i=0;
               foreach($folders as $folder)
               {
                    if($i==1)
                  {
                       $i=0;
                       $class='lineClair';
                   }
                   else
                   {
                       $i=1;
                       $class='lineFonce';
                   }

                  $html .= "<div class='folder $class'  >";
                  $html .= "<i class='icon-folder-close blueOne'>&nbsp;</i>" ;
                  $html .= "<span class='blueOne name' id='".$folder->FolderId->Value."' >".$folder->Folder->Value->Name->Value."</span>" ;

                   if($folder->AppName->Value != "")
                  {
                      $img = new Image("../Apps/".$folder->AppName->Value."/Images/logo.png");
                      $img->Title->Value = $img;
                      $html .= "<span >".$img->Show()."</span>" ;
                  }
                  else
                  {
                      $html .= "<span ></span>" ;
                  }
                  $html .= "<span class='date'>".$folder->Folder->Value->DateCreated->Value."</span>" ;
                  $html .= "<span class='date'>".$folder->Folder->Value->DateModified->Value."</span>" ;
                  $html .= "<span class='date'>".$folder->Folder->Value->User->Value->GetPseudo()."</span>" ;

                  $html .= "</div>" ;
               }
           }

           //Ajout des fichier
           if(count($files) > 0)
           {
               foreach($files as $file)
               {
                   if($i==1)
                  {
                       $i=0;
                       $class='lineClair';
                   }
                   else
                   {
                       $i=1;
                       $class='lineFonce';
                   }
                  $html .= "<div class='file' >";
                  $html .= "<i class='icon-file blueTree'>&nbsp;</i>" ;
                  $html .= "<span class='blueOne name' id='".$file->IdEntite."' >".$file->File->Value->Name->Value."</span>" ;

                  //Fichier d'application
                  if($file->AppName->Value != "")
                  {
                      $img = new Image("../Apps/".$file->AppName->Value."/Images/logo.png");
                      $img->Title->Value = $img;
                      $html .= "<span >".$img->Show()."</span>" ;
                  }
                  else
                  {
                      $html .= "<span ></span>" ;
                  }

                  $html .= "<span class='date'>".$file->File->Value->DateCreated->Value."</span>" ;
                  $html .= "<span class='date'>".$file->File->Value->DateModified->Value."</span>" ;
                  $html .= "<span class='date'>".$file->File->Value->User->Value->GetPseudo()."</span>" ;
                  $html .= "</div>" ;
               }
           }

           if($html != "")
           {
               return $html;
           }
           else
           {
               return "File.NoFolder";
           }
       }
        
 }?>