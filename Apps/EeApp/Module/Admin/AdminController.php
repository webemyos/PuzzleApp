<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Module\Admin;

use AdminHelper;
use Apps\EeApp\Helper\AppHelper;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Upload\Upload;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\View\View;

 class AdminController extends Controller
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
	  }

          /**
           * Charges les applications de l'utilisateur
           */
          function LoadApp()
          {
               $view = new View(__DIR__ ."/View/LoadApps.tpl", $this->Core);

                //Recuperation
                $apps = AppHelper::GetByParameters($this->Core);
                $view->AddElement($apps);

                return $view->Render();
          }

          /**
           * Pop de gestion des administrateurs
           */
          function ShowAdmin()
          {
            $html = "";

            //Recherche d'utilisateur
            $tbContact = new AutoCompleteBox("tbContact", $this->Core);
            $tbContact->PlaceHolder = $this->Core->GetCode("SearchUser");
            $tbContact->Entity = "User";
            $tbContact->Methode = "SearchUser";
            $tbContact->Parameter = "AddAction=EeAppAction.AddAdmin(".Request::GetPost("appId").")";

            $html .= $this->Core->GetCode("Contact"). " " .$tbContact->Show();


            $html .= "<div id='dvAdmin'>";

            $html .= $this->GetAdmin();

            $html .= "</div>";

            return $html;
          }

          /*
           * Obtient les administrateurs d'une application
           */
          function GetAdmin()
          {
            $html = "";

            foreach(AdminHelper::GetUserByApp($this->Core, Request::GetPost("appId")) as $admin)
            {
                $deleteIcone = new DeleteIcone($this->Core);
                $deleteIcone->OnClick = "EeAppAction.DeleteAdmin(".$admin->IdEntite.", this)";

                $html .= "<div class='profil'>".$admin->User->Value->GetPseudo().$deleteIcone->Show()."</div>";
            }

            return $html;
          }

          /*
          * Pop IN d'upload d'app
          */
          function ShowUploadApp()
          {
              $upload = new Upload("EeApp", 0, "EeAppAction.CallBack", "DoUploadApp");

              return $upload->Show();
          }

 }?>
