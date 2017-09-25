<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Module\Home;

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
      $view = new View( __DIR__ ."/View/Home.tpl" ,$this->Core);

      //Bouton pour créer un communique
      $btnNewCommunique = new Button(BUTTON, "btnNewCommunique");
      $btnNewCommunique->Value = $this->Core->GetCode("EeCommunique.NewCommunique");
      $btnNewCommunique->OnClick = "EeCommuniqueAction.ShowAddCommunique();";
      $view->AddElement($btnNewCommunique);

      $btnMyCommunique = new Button(BUTTON, "btnMyCommunique");
      $btnMyCommunique->Value = $this->Core->GetCode("EeCommunique.MyCommunique");
      $btnMyCommunique->CssClass = "btn btn-info";
      $btnMyCommunique->OnClick = "EeCommuniqueAction.LoadMyCommunique();";
      $view->AddElement($btnMyCommunique);

      //Bouton de gestion des contacts
      $btnLstContact = new Button(BUTTON, "btnLstContact");
      $btnLstContact->Id = "btnLstContact";
      $btnLstContact->Value = $this->Core->GetCode("EeCommunique.ListeContact");
      $btnLstContact->CssClass = "btn btn-success";
      $btnLstContact->OnClick = "EeCommuniqueAction.LoadListContact();";
      $view->AddElement($btnLstContact);

      return $view->Render();
    }
 }?>