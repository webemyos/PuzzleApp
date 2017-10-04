<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\File\Module\Folder;

use Apps\Blog\Helper\MessageHelper;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

 class HomeController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
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
      $modele = new View(__DIR__. "/View/HomeBlock.tpl", $this->Core);

        //Bouton pour créer un message
      $btnMyFile = new Button(BUTTON, "btnMyFile");
      $btnMyFile->Value = $this->Core->GetCode("EeFile.MyFile");
      $btnMyFile->CssClass = "btn btn-info";
      $btnMyFile->OnClick = "EeFileAction.LoadMyFile();";
      $modele->AddElement($btnMyFile);

      //Fichier Partage
      $btnSharedFile = new Button(BUTTON, "btnSharedFile");
      $btnSharedFile->Value = $this->Core->GetCode("EeFile.SharedFile");
      $btnSharedFile->CssClass = "btn btn-success";
      $btnSharedFile->OnClick = "EeFileAction.LoadSharedFile();";
      $modele->AddElement($btnSharedFile);

       //Fichier Partage
      $btnNewFolder = new Button(BUTTON, "btnNewFolder");
      $btnNewFolder->Value = $this->Core->GetCode("EeFile.NewFolder");
      $btnNewFolder->OnClick = "EeFileAction.ShowCreateFolder();";
      $modele->AddElement($btnNewFolder); 

       //Fichier Partage
      $btnAddFile = new Button(BUTTON, "btnAddFile");
      $btnAddFile->Value = $this->Core->GetCode("EeFile.AddFile");
      $btnAddFile->OnClick = "EeFileAction.ShowAddFile();";
      $modele->AddElement($btnAddFile);

      return $modele->Render();
    }

    /**
     * Obtient le menu
     */
    function GetMenu()
    {
        if(MessageHelper::HaveMessageNotRead($this->Core))
        {
            $class='MessageNotRead';
        }   
        else
        {
            $class='MessageRead';
        }

        $html = "<ul class='blueOne alignLeft'>";
        $html .= "<li><a href='#' onclick='EeMessageAction.LoadInBox()'  class='icon-envelope'>&nbsp;".$this->Core->GetCode("EeMessage.InBox")." (<span id='spNbInMessage' class=".$class.">".MessageHelper::GetNumberInBox($this->Core) ."</span>) </a></li>";
        $html .= "<li><a href='#' onclick='EeMessageAction.LoadOutBox()' class='icon-envelope-alt'>&nbsp".$this->Core->GetCode("EeMessage.OutBox")." (<span id='spNbOutMessage' >".MessageHelper::GetNumberOutBox($this->Core)."</span>)</a></li>";
        $html .= "</ul>";

        return $html;
    }
 }?>