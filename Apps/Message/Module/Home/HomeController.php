<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Message\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;
use Apps\Message\Helper\MessageHelper;


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
        $view = new View(__DIR__ . "/View/Home.tpl", $this->Core);

      //Bouton pour créer un message
      $btnNewMessage = new Button(BUTTON, "btnNewMessage");
      $btnNewMessage->Value = $this->Core->GetCode("Message.NewMessage");
      $btnNewMessage->CssClass = "btn btn-info";
      $btnNewMessage->OnClick = "MessageAction.ShowSendMessage();";
      $view->AddElement($btnNewMessage);

      $btnInBox = new Button(BUTTON, "btnInBox");
      $btnInBox->Id = "btnInBox";
      $btnInBox->Value = $this->Core->GetCode("Message.InBox")."(".MessageHelper::GetNumberInBox($this->Core).")";
      $btnInBox->CssClass = "btn btn-info";
      $btnInBox->OnClick = "MessageAction.LoadInBox();";
      $view->AddElement($btnInBox);

      $btnOutBox = new Button(BUTTON, "btnOutBox");
      $btnOutBox->Id = "btnOutBox";
      $btnOutBox->Value = $this->Core->GetCode("Message.OutBox"). "(".MessageHelper::GetNumberOutBox($this->Core).")";
      $btnOutBox->CssClass = "btn btn-success";
      $btnOutBox->OnClick = "MessageAction.LoadOutBox();";
      $view->AddElement($btnOutBox);

      return $view->Render();
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
        $html .= "<li><a href='#' onclick='MessageAction.LoadInBox()'  class='icon-envelope'>&nbsp;".$this->Core->GetCode("Message.InBox")." (<span id='spNbInMessage' class=".$class.">".MessageHelper::GetNumberInBox($this->Core) ."</span>) </a></li>";
        $html .= "<li><a href='#' onclick='MessageAction.LoadOutBox()' class='icon-envelope-alt'>&nbsp".$this->Core->GetCode("Message.OutBox")." (<span id='spNbOutMessage' >".MessageHelper::GetNumberOutBox($this->Core)."</span>)</a></li>";
        $html .= "</ul>";

        return $html;
    }
 }?>