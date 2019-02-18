<?php

/* 
 * Module de gestion de la boutique
 */
class ShopBlock
{
    
    private $Core;
    
    /*
     * Constructeur 
     */
    function ShopBlock($core)
    {
        $this->Core = $core;
    }

    /**
     * Recupere l'outil principal
     * */
    function GetTool()
    {
            $commerce = $this->Commerce;

            //Tab veriticale
            $vTab = new VTab("vTInfo"); 
            $vTab->CssClass = "content";
            $vTab->SelectedIndex = 99;
            $vTab->AddTab($this->Core->GetCode("EeProjet.TitleTabInformation"), $this->GetTabInfo($commerce), false);
            $vTab->AddTab($this->Core->GetCode("EeProjet.TitleTabUser"), $this->GetTabUser(), false);
         
            $vTab->AddTab($this->Core->GetCode("EeProjet.TitleCoupons"), $this->GetTabCoupon(), false);
         
            return $vTab;
   }
  
   /*
    * Obtient les info de base de la boutique
    */
   function GetTabInfo($commerce)
   {
       $jbInfo = new JBlock("jbInfo");
        $jbInfo->Id = "jbInfo";

      $jbInfo->Table = true;
      $jbInfo->Frame = false;

       //Action de sauvegarde
      $action = new AjaxAction("EeCommerce","UpdateCommerce");
      $action->AddArgument("App","EeCommerce");
      $action->AddArgument("idCommerce",$commerce->IdEntite);
      $action->ChangedControl = "lbResult";

      //Ajout des control à sauver
      $action->AddControl($commerce->Name->Control->Id);
      $action->AddControl($commerce->Title->Control->Id);
      $action->AddControl($commerce->SmallDescription->Control->Id);
      $action->AddControl($commerce->LongDescription->Control->Id);

       //Bouton de rafhaichissement
      $refreshIcon = new RefreshIcone($this->Core);
      $refreshIcon->OnClick = "EeCommerceAction.RefreshTab(".$commerce->IdEntite.", 'vTInfo_vtab_0', 'ShopBlock' , 'GetTabInfo');  Eemmys.SetBasicAdvancedText('LongDescription');";

      $saveIcon = new SaveIcone($this->Core);
      $saveIcon->OnClick = $action;

      $jbInfo->AddNew(new Libelle("<div class='tools'>".$saveIcon->Show().$refreshIcon->Show()."</div>"), 4);

      $jbInfo->AddNew(new libelle("<div id='lbResult'></div>"), 4);

      $jbInfo->AddNew($commerce->Name);
      $jbInfo->AddNew($commerce->Title);
      $jbInfo->AddNew($commerce->SmallDescription);
      $jbInfo->AddNew($commerce->LongDescription);

      
      //Bouton de sauvegarde
      $btnSave = new Button(BUTTON);
      $btnSave->CssClass ='btn btn-primary'; 
      $btnSave->Value = $this->Core->GetCode("Save");
      $btnSave->OnClick = $action;

      $jbInfo->AddNew($btnSave, 4, ALIGNRIGHT);

      //Upload ajax d'une image
      $fileName = "../Data/Apps/EeCommerce/".$commerce->IdEntite."/presentation_96.png";

      if(file_exists($fileName))
      {
          $img = new Image($fileName."?rand=".rand(1, 2000));
          $img->Id= "imgCommerce";
          $img->AddStyle("width", "35px");
          $img->Title = "Presentation";
          $jbInfo->AddNew($img);
      }
      else
      {
          $img = new Image("../Images/noimages.png");
           $img->Id= "imgCommerce";
          $img->AddStyle("width", "150px");
          $img->Title = "Presentation";
          $jbInfo->AddNew($img);
      }

      //Changement de l'image
      $inFile = new UploadAjaxFile("EeCommerce", $commerce->IdEntite, "EeCommerceAction.RefreshImage(".$commerce->IdEntite.");", "SaveImage");
      $jbInfo->AddNew($inFile, 2);

      return $jbInfo;
   }
   
   /*
    * Gestion des utilisateurs
    */
   function GetTabUser()
   {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabUser.tpl", $this->Core); 
       
         //Recuperation des formulaire du projet
        $users = new User($this->Core);
       
        $modele->AddElement($users->GetAll());

        return new Libelle($modele->Render());
   }
   
    /*
    * Gestion des utilisateurs
    */
    function GetTabCoupon()
    {
         $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabCoupon.tpl", $this->Core); 
        
          //Recuperation des formulaire du projet
         $coupons = new EeCommerceCoupon($this->Core);
        
         $modele->AddElement($coupons->GetAll());
 
         return new Libelle($modele->Render());
    }

   function GetHelp()
   {
       "Module de gestion de la boutique";
   }
}

