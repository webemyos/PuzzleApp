<?php
/**
 * Module CommerceBlock
 * */
namespace Apps\Commerce\Module\Commerce;

use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\View\View;
use Core\Block\AjaxFormBlock\AjaxFormBlock;

use Apps\Commerce\Helper\CommerceHelper;

 class CommerceController extends Controller
 {
    protected $Commerce;
     
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
     * Pop in d'ajout deun ecommerce
     */
    function ShowAddCommerce()
    {
        $jbCommerce = new AjaxFormBlock($this->Core, "jbCommerce");
        $jbCommerce->App = "Commerce";
        $jbCommerce->Action = "SaveCommerce";
        
        //Ajout des champs
        $jbCommerce->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbNameCommerce", "Libelle" => $this->Core->GetCode("Name") ),
                                      array("Type"=>"TextBox", "Name"=> "tbTitleCommerce", "Libelle" => $this->Core->GetCode("Title") ),
                                      array("Type"=>"TextBox", "Name"=> "tbSmallDescription", "Libelle" => $this->Core->GetCode("SmallDescription")),
                                      array("Type"=>"TextArea", "Name"=> "tbLongDescription", "Libelle" => $this->Core->GetCode("LongDescription")),
                                      array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-success" , "Value" => $this->Core->GetCode("Save")),
                          )
                );
        
        return $jbCommerce->Show();
    }
          
    /**
     * Charge les commerce de l'utilisateur
     * @param type $all
     */
    function LoadMyCommerce($all=false)
    {
        $view = new View(__DIR__ . "/View/LoadMyCommerce.tpl", $this->Core); 
        
        $commerces = CommerceHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
        
        if(count($commerces) > 0)
        {
            $view->AddElement(new Libelle($this->Core->GetCode("Name"), "lbName" ));
            $view->AddElement(new Libelle($this->Core->GetCode("Title", "lbTitle")));
            
            $view->AddElement($commerces);
        
            //Libelle sur les icones
            $view->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Commerce.LoadMyCommerce")));
        }
        else
        {
          $view->AddElement(array());
          $view->AddElement(new Libelle($this->Core->GetCode("", "lbNoCommerce")));
        }
        
        return $view->Render();
    }
          
     /**
	   * Charge un commerce
	   */
	  function LoadCommerce($commerceId, $commerceName)
	  {
              $commerce = new CommerceCommerce($this->Core);
             
              if($commerceId != "")
              {
                $commerce->GetById($commerceId);
              }
              else
              {
                $commerce->GetByName($commerceName);
              }
              
              $tabCommerce = new TabStrip("tabCommerce", "Commerce");
                      
              //Inclue les différents outils
              $tools = array(array("Shop","icon-asterisk"),
                             array("Product", "icon-Book"),
                             array("Sale", "icon-Book"),
                             array("FactureCommande", "icon-Book"),
                             array("Like","icon-asterisk"),
                  );
              
              foreach($tools as $tool)
              {
                $blockName = $tool[0]. "Block";
                  
                  $block = new $blockName($this->Core);
                  $block->Commerce = $commerce;
                  
                  $html = "<div class='row'>";
                  $html .= "<div class='col-md-10'>";
                  $html .= $block->GetTool()->Show();
                  $html .= "</div>";
                  $html .= "<div class='col-md-2'>";
                  $html .= $block->GetHelp();
                  $html .= "</div></div>";
                  $tabCommerce->AddTab("&nbsp;".$tool[0], new Libelle($html), "","", $tool[1]);
              }
              
              return $tabCommerce->Show();
    }
    
     /**
           * Pop in d'ajout d un coupon
           */
          function ShowAddCoupon($couponId)
          {
              $jbCommerce = new AjaxFormBlock($this->Core, "jbCoupon");
              $jbCommerce->App = "Commerce";
              $jbCommerce->Action = "SaveCoupon";
              
              if($couponId != '')
              {
                $coupon = new CommerceCoupon($this->Core);
                $coupon->GetById($couponId);

                $jbCommerce->AddArgument("CouponId", $couponId);
              }

              //Ajout des champs
              $jbCommerce->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbCodeCoupon", "Libelle" => $this->Core->GetCode("Code") , "Value"=> $coupon ? $coupon->Code->Value :''),
                                            array("Type"=>"TextBox", "Name"=> "tbLibelleCoupon", "Libelle" => $this->Core->GetCode("Libelle") , "Value"=> $coupon ? $coupon->Libelle->Value :''),
                                            array("Type"=>"TextBox", "Name"=> "tbDescriptionCoupon", "Libelle" => $this->Core->GetCode("Description"), "Value"=> $coupon ? $coupon->Description->Value :''),
                                            array("Type"=>"TextBox", "Name"=> "tbTypeCoupon", "Libelle" => $this->Core->GetCode("Type"), "Value"=> $coupon ? $coupon->Type->Value :''),
                                            array("Type"=>"TextBox", "Name"=> "tbReduction", "Libelle" => $this->Core->GetCode("Reduction"), "Value"=> $coupon ? $coupon->Reduction->Value :''),
                                            
                                            array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                                )
                      );
              
              return $jbCommerce->Show();
          }
         
          /*action*/
 }?>