<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Banner\Module\Home;

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
        //Bouton pour créer un blog
        $btnNewBanner = new Button(BUTTON);
        $btnNewBanner->Value = $this->Core->GetCode("EeBanner.NewBanner");
        $btnNewBanner->OnClick = "EeBannerAction.ShowAddBanner();";

        $btnMyBanner = new Button(BUTTON);
        $btnMyBanner->Value = $this->Core->GetCode("EeBanner.MyBanner");
        $btnMyBanner->CssClass = "btn btn-success";
        $btnMyBanner->OnClick = "EeBannerAction.LoadMyBanner();";


        //Passage des parametres à la vue
        $this->AddParameters(array('!titleHome' => $this->Core->GetCode("EeBanner.TitleHome"),
                                    '!messageHome' => $this->Core->GetCode("EeBanner.MessageHome"),
                                    '!btnNewBanner' =>  $btnNewBanner->Show(),                     
                                    '!btnMyBanner' => $btnMyBanner->Show(),
                                    ));

        $this->SetTemplate(__DIR__ . "/View/HomeController.tpl");

        return $this->Render();
    }

    /*action*/
 }?>