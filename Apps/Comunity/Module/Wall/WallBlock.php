<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Publication;

use Apps\Comunity\Module\Comment\PostController;
use Apps\Forum\Helper\MessageHelper;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;

 class WallController extends Controller
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

  /*
  * Module de publication et d'affichage de new 
  */
   function LoadMyWall()
  {
       $this->SetTemplate( __Dir__ . "/View/LoadMyWall.tpl");

       $this->AddParameters(array('!publicationController' => $this->GetPublicationController(),
                                  '!dvMessage' => $this->GetMessage()
                                  ));

      return $this->Render();
  }

  /**
   * Obtient un module de publibacation
   */
  function GetPublicationController()
  {
     $publicationController = new PublicationController($this->Core);
     return $publicationController->Show();
  }

  /**
   * Obtient les messages des communauté de l'utilisateur
   */
  function GetMessage()
  {
      $html="";

      //Recuperation des messages
      $messages = MessageHelper::GetByUser($this->Core);

      //Recuperation de l'app des perofil
      $Profil=DashBoardManager::GetApp("Profil", $this->Core);

      //Module d'affichage des poste
      $postController = new PostController($this->Core);

      if(count($messages) > 0)
      {
          foreach($messages as $message)
          {
              $html .= $postController->ShowMessage("", $message, $Profil);
          }
      }
      else
      {
          $html = $this->Core->GetCode("Comunity.NoMessage");
      }

      return $html;
  }
        
}?>