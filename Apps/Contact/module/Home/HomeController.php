<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Module\Home;

use Apps\Contact\Helper\InvitationHelper;
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
      $view = new View(__DIR__ . "/View/HomeBlock.tpl", $this->Core);

      $btnSearch = new Button(BUTTON, "btnSearch");
      $btnSearch->CssClass = "btn btn-primary";
      $btnSearch->Value = $this->Core->GetCode("EeContact.Search");
      $btnSearch->OnClick = "EeContactAction.LoadSearchContact()()";
      $view->AddElement($btnSearch);

      $btnContact = new Button(BUTTON, "btnContact");
      $btnContact->CssClass = "btn btn-info";
      $btnContact->Value = $this->Core->GetCode("EeContact.MyContact");
      $btnContact->OnClick = "EeContactAction.LoadContact()";
      $view->AddElement($btnContact);

      $btnInvitation = new Button(BUTTON, "btnInvitation");
      $btnInvitation->Id = "btnInvitation";
      $btnInvitation->CssClass = "btn btn-success";
      $btnInvitation->Value = $this->Core->GetCode("EeContact.Invitation") . " (".InvitationHelper::GetNumber($this->Core, 0).")";
      $btnInvitation->OnClick = "EeContactAction.LoadInvitation(0)";
      $view->AddElement($btnInvitation);

      $btnMyInvitation = new Button(BUTTON);
      $btnMyInvitation->Id = "btnMyInvitation";
      $btnMyInvitation->CssClass = "btn btn-success";
      $btnMyInvitation->Value = $this->Core->GetCode("EeContact.MyInvitation") . " (".InvitationHelper::GetNumber($this->Core, 1).")";
      $btnMyInvitation->OnClick = "EeContactAction.LoadInvitation(1)";
      $view->AddElement($btnMyInvitation);

      return $view->Render();
    }
 }?>