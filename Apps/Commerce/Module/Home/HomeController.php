<?php
/**
 * Module d'accueil
 * */
namespace Apps\Commerce\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\View\View;

 class HomeController extends Controller
 {
	  /**
	   * Constructeur
	   */
	  function __contruct($core="")
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
         * Affichage de l'accueil depuis le modele
         */
    function Show()
    {
        $modele = new View(__DIR__ . "/View/Home.tpl", $this->Core); 
        
        //Bouton pour créer un ecommerce
        $btnNewCommerce = new Button(BUTTON);
        $btnNewCommerce->Id = "btnNewCommerce";
        $btnNewCommerce->CssClass = "btn btn-success";
        $btnNewCommerce->Value = $this->Core->GetCode("Commerce.NewCommerce");
        $btnNewCommerce->OnClick = "CommerceAction.ShowAddCommerce();";
        $modele->AddElement($btnNewCommerce);
        
        //Mes commerce
        $btnMyCommerce = new Button(BUTTON);
        $btnMyCommerce->Id = "btnMyCommerce";
        $btnMyCommerce->Value = $this->Core->GetCode("Commerce.MyCommerce");
        $btnMyCommerce->CssClass = "btn btn-info";
        $btnMyCommerce->OnClick = "CommerceAction.LoadMyCommerce();";
        $modele->AddElement($btnMyCommerce);
        
        return $modele->Render();
    }
    
    
    /**
     * Obtient le slider de présentation
     */
    function GetBanner()
    {
        $ebanner = Eemmys::GetApp("EeBanner", $this->Core);
        return $ebanner->GetBanner("Webemyos");
    }
 }?>