<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Downloader\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;

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
        //Bouton pour créer ajouter une ressource
        $btnNewRessource = new Button(BUTTON);
        $btnNewRessource->Value = $this->Core->GetCode("Downloader.NewRessource");
        $btnNewRessource->CssClass = "btn btn-info";
        $btnNewRessource->OnClick = "DownloaderAction.ShowAddRessource();";

        $btnMyRessource = new Button(BUTTON);
        $btnMyRessource->Value = $this->Core->GetCode("Downloader.MyRessource");
        $btnMyRessource->CssClass = "btn btn-success";
        $btnMyRessource->OnClick = "DownloaderAction.LoadMyRessource();";

        //Passage des parametres à la vue
        $this->AddParameters(array('!titleHome' => $this->Core->GetCode("Downloader.TitleHome"),
                                    '!messageHome' => $this->Core->GetCode("Downloader.MessageHome"),
                                    '!btnNewRessource' =>  $btnNewRessource->Show(),
                                    '!btnMyRessource' => $btnMyRessource->Show(),
                                    ));

        $this->SetTemplate(__DIR__ . "/View/Home.tpl");

        return $this->Render();
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
