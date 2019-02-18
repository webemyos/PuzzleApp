<?php

/* 
 * Module de gestion des catégories, des fournisseurs et des produits
 */
class ProductBlock
{
    private $Core;
    
    /*
     * Constructeur 
     */
    function ProductBlock($core)
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
            $vTab = new VTab("vTProduct"); 
            $vTab->CssClass = "content";
            $vTab->SelectedIndex = 99;
            $vTab->AddTab($this->Core->GetCode("EeCommerce.TitleTabFournisseur"), $this->GetTabFournisseur($commerce), false);
            $vTab->AddTab($this->Core->GetCode("EeCommerce.TitleTabProductCategory"), $this->GetTabProductCategory($commerce), false);
            $vTab->AddTab($this->Core->GetCode("EeCommerce.TitleTabProduct"), $this->GetTabProduct($commerce), false);
            $vTab->AddTab($this->Core->GetCode("EeCommerce.TitleTabFicheProduct"), $this->GetTabFicheProduct($commerce), false);
       
            $vTab->AddTab($this->Core->GetCode("EeCommerce.TitleTabMarque"), $this->GetTabMarque($commerce), false);
          
            return $vTab;
   }
  
   /*
    * Obtient les fournisseurs des produits
    */
   function GetTabFournisseur($commerce)
   {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabFournisseur.tpl", $this->Core); 
       
        $modele->AddElement(new Text("idCommerce", false, $commerce->IdEntite));
       
         //Recuperation des formulaire du projet
        $fournisseur = new EeCommerceFournisseur($this->Core);
        $fournisseur->AddArgument(new Argument("EeCommerceFournisseur", "CommerceId", EQUAL, $commerce->IdEntite));

        $fournisseurs = $fournisseur->GetByArg(false, true);
       
        $modele->AddElement($fournisseurs);

        return new Libelle($modele->Render());
   }
   
   /*
    * Pop In d'ajout de fournisseur
    */
   function ShowAddFournisseur($commerceId, $fournisseurId)
   {
    $jbFournisseur = new AjaxFormBlock($this->Core, "jbFournisseur");
    $jbFournisseur->App = "EeCommerce";
    $jbFournisseur->Action = "SaveFournisseur";

    $jbFournisseur->AddArgument("commerceId", $commerceId);
    
    if($fournisseurId != "")
    {
        $fournisseur = new EeCommerceFournisseur($this->Core);
        $fournisseur->GetById($fournisseurId);
        
        $jbFournisseur->AddArgument("fournisseurId", $fournisseurId);
    }
    
    //Ajout des champs
    $jbFournisseur->AddControls(array(
                                  array("Type"=>"TextBox", "Name"=> "tbNameFournisseur", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($fournisseur != null) ? $fournisseur->Name->Value : ""  ),
                                  array("Type"=>"TextBox", "Name"=> "tbContactFournisseur", "Libelle" => $this->Core->GetCode("Contact"), "Value" => ($fournisseur != null) ? $fournisseur->Contact->Value : "" ),
                                  array("Type"=>"TextBox", "Name"=> "tbEmailFournisseur", "Libelle" => $this->Core->GetCode("Email"), "Value" => ($fournisseur != null) ? $fournisseur->Email->Value : "" ),
                                  array("Type"=>"TextBox", "Name"=> "tbTelephoneFournisseur", "Libelle" => $this->Core->GetCode("Telephone"), "Value" => ($fournisseur != null) ? $fournisseur->Telephone->Value : "" ),
                                  array("Type"=>"TextArea", "Name"=> "tbAdresseFournisseur", "Libelle" => $this->Core->GetCode("Adresse"), "Value" => ($fournisseur != null) ? $fournisseur->Adresse->Value : "" ),
                                  array("Type"=>"TextBox", "Name"=> "tbCommissionFournisseur", "Libelle" => $this->Core->GetCode("Commission"), "Value" => ($fournisseur != null) ? $fournisseur->Commission->Value : "" ),
                                  array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                                  array("Type"=> "Libelle", "Name" => "dvUser", "Value" => $this->GetUser($fournisseurId)),
                                  array("Type"=> "Libelle", "Name" => "dvPayament", "Value" => $this->ShowAccountFournisseur($fournisseur))
                      )
            );

               
    return $jbFournisseur->Show();
   }

   /*
    * Pop in d'ajout de marque
    */
   function ShowAddMarque($commerceId, $marqueId)
   {
    $jbMarque = new AjaxFormBlock($this->Core, "jbMarque");
    $jbMarque->App = "EeCommerce";
    $jbMarque->Action = "SaveMarque";

    $jbMarque->AddArgument("commerceId", $commerceId);
    
    if($marqueId != "")
    {
        $marque = new EeCommerceMarque($this->Core);
        $marque->GetById($marqueId);
        
        $jbMarque->AddArgument("marqueId", $marqueId);
    }
    
    
    if($marqueId == "")
    {
        //Ajout des champs
        $jbMarque->AddControls(array(
                                  array("Type"=>"TextBox", "Name"=> "tbNameMarque", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($marque != null) ? $marque->Name->Value : ""  ),
                                  array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                                 )
            );
    }
    else
    {
        //Ajout des champs
        $jbMarque->AddControls(array(
                                  array("Type"=>"TextBox", "Name"=> "tbNameMarque", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($marque != null) ? $marque->Name->Value : ""  ),
                                  array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                                  array("Type"=>"UploadAjaxFile", "IdEntite"=> $marqueId , "Action" => "UploadImageMarque", "App"=> "EeCommerce"),
                             )
            );
    }
    
    
    return $jbMarque->Show();
   }
   
   
   /*
    * Obtient les marques des produits
    */
   function GetTabMarque($commerce)
   {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabMarque.tpl", $this->Core); 
       
        $modele->AddElement(new Text("idCommerce", false, $commerce->IdEntite));
       
         //Recuperation des formulaire du projet
        $marque = new EeCommerceMarque($this->Core);
        $marque->AddArgument(new Argument("EeCommerceMarque", "CommerceId", EQUAL, $commerce->IdEntite));

        $marques = $marque->GetByArg(false, true);
       
        $modele->AddElement($marques);

        return new Libelle($modele->Render());
   }
   
   /*
    * Information de Paiemnt fournisseur
    */
   function ShowAccountFournisseur($fournisseur)
   {
       $html .= "<h2>Stripe</h2>";
       
       if($fournisseur->StripeId->Value == "")
       {
           $btnCreateStrip = new Button(BUTTON);
           $btnCreateStrip->Value = "Créer un compte stripe";
           $btnCreateStrip->OnClick = "EeCommerceAction.CreateStripeAccount(".$fournisseur->IdEntite.")";
           
           $html .= $btnCreateStrip->Show();
       }
       else
       {
          $html .=  "Clée stripe du fournisseur : " . $fournisseur->StripeId->Value;
          
          //Bouton pour validé 
          $btnAccept = new Button(BUTTON);
          $btnAccept->Value = "Valider le compte Stripe";
          
          $btnAccept->OnClick = "EeCommerceAction.ValideStripeAccount(".$fournisseur->IdEntite.")";
           
          $html .= $btnAccept->Show();
       }
       return $html;
   }
   
   /*
    * Obtient les utilisateurs liés aux fournisseurs
    */
   function GetUser($fournisseurId)
   {
       $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetUser.tpl", $this->Core); 
    
       $users = FournisseurHelper::GetUsers($this->Core, $fournisseurId);
       
       if(count($users) > 0)
       {
            $modele->AddElement($users);
       }
       else
       {
            $modele->AddElement(array());
       }
       
        //Recherche d'utilisateur
        $tbContact = new AutoCompleteBox("tbContact", $this->Core);
        $tbContact->PlaceHolder = "'".$this->Core->GetCode("EeMessage.SearchUser")."'";
        $tbContact->Entity = "User";
        $tbContact->Methode = "SearchUser";
        $tbContact->Parameter = "AddAction=EeCommerceAction.AddUser($fournisseurId)";
        $modele->AddElement($tbContact);
                
       return $modele->Render();
   }
   
   
   /*
    * Obtient les categories des produtis
    */
   function GetTabProductCategory($commerce)
   {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabProductCategory.tpl", $this->Core); 
       
        $modele->AddElement(new Text("idCommerce", false, $commerce->IdEntite));
       
         //Recuperation des formulaire du projet
          $category = new EeCommerceProductCategory($this->Core);
        $category->AddArgument(new Argument("EeCommerceProductCategory", "CommerceId", EQUAL, $commerce->IdEntite));

        $categorys = $category->GetByArg(false, true);
        
        $modele->AddElement(new Libelle($this->Core->GetCode("Name"), "lbName" ));
        $modele->AddElement(new Libelle($this->Core->GetCode("Description", "lbDescription")));

        $modele->AddElement($categorys);

        //Libelle sur les icones
        $modele->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("EeCommerce.DetailCategory")));

        return new Libelle($modele->Render());
   }
     
   
   /*
    * Pop In d'ajout de catégorie
    */
   function ShowAddCategory($commerceId, $categoryId)
   {
    $jbCategory = new AjaxFormBlock($this->Core, "jbCategory");
    $jbCategory->App = "EeCommerce";
    $jbCategory->Action = "SaveCategory";

    $jbCategory->AddArgument("commerceId", $commerceId);
    
    if($categoryId != "")
    {
        $categorie = new EeCommerceProductCategory($this->Core);
        $categorie->GetById($categoryId);
        
        $jbCategory->AddArgument("categoryId", $categoryId);
    }
    
    //Ajout des champs
    $jbCategory->AddControls(array(
                                  array("Type"=>"TextBox", "Name"=> "tbNameCategory", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($categorie != null) ? $categorie->Name->Value : ""  ),
                                  array("Type"=>"TextArea", "Name"=> "tbDescriptionCategory", "Libelle" => $this->Core->GetCode("Description"), "Value" => ($categorie != null) ? $categorie->Description->Value : "" ),
                                  array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                      )
            );

    return $jbCategory->Show();
   }
  
   /*
    * Obtient les fiches produtis
    */
   function GetTabFicheProduct($commerce)
   {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabFicheProduct.tpl", $this->Core); 
       
        //Recuperation des formulaire du projet
        $fiche = new EeCommerceFicheProduct($this->Core);
     
        $fiches = $fiche->GetAll();
        
        $modele->AddElement(new Libelle($this->Core->GetCode("Name"), "lbName" ));
        $modele->AddElement(new Libelle($this->Core->GetCode("Description", "lbDescription")));

        $modele->AddElement($fiches);

        //Libelle sur les icones
        $modele->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("EeCommerce.DetailCategory")));

        return new Libelle($modele->Render());
   }
     
   
   /*
    * Pop In d'ajout de fiche produit
    */
   function ShowAddFicheProduct($ficheId)
   {
    $jbFiche = new AjaxFormBlock($this->Core, "jbFiche");
    $jbFiche->App = "EeCommerce";
    $jbFiche->Action = "SaveFiche";

    if($ficheId != "")
    {
        $fiche = new EeCommerceFicheProduct($this->Core);
        $fiche->GetById($ficheId);
        
        $jbFiche->AddArgument("ficheId", $ficheId);
    }
    
    //Ajout des champs
    $jbFiche->AddControls(array(
                                  array("Type"=>"TextBox", "Name"=> "tbNameFiche", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($fiche != null) ? $fiche->Name->Value : ""  ),
                                  array("Type"=>"TextBox", "Name"=> "tbKeywordFiche", "Libelle" => $this->Core->GetCode("Keyword"), "Value" => ($fiche != null) ? $fiche->KeyWord->Value : "" ),
                                  array("Type"=>"TextBox", "Name"=> "tbShortDescriptionFiche", "Libelle" => $this->Core->GetCode("ShortDescription"), "Value" => ($fiche != null) ? $fiche->ShortDescription->Value : "" ),
                                  array("Type"=>"TextArea", "Name"=> "tbLongDescriptionFiche", "Libelle" => $this->Core->GetCode("LongDescription"), "Value" => ($fiche != null) ? $fiche->LongDescription->Value : "" ),
                                  array("Type"=>"EntityListBox", "Name"=> "lstCategory", "Entity"=> "EeCommerceProductCategory" , "Libelle" => $this->Core->GetCode("Description"), "Value" => ($fiche != null) ? $fiche->CategoryId->Value : "" ),
                                  array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                               )
            );

    //Ajout des produits à la fiche
    if($ficheId != "")
    {
        
        $lstProduct = new EntityListBox("lstFicheProduct", $this->Core);
        $lstProduct->Entity = "EeCommerceProduct";
      //  $lstProduct->AddArgument(new Argument("EeCommerceProduct", "Actif", EQUAL, "1"));
        $lstProduct->AddField("NameProduct");
        $lstProduct->AddOrder("NameProduct");
            
        $addIcone = new AddIcone();
        $addIcone->OnClick = "EeCommerceAction.AddProductFiche(".$ficheId.")";
        $addIcone->Title = $this->Core->GetCode("AddProductFiche");
                
        $html = "<table><tr>";
        $html .= "<td>".$jbFiche->Show()."</td>";
        $html .= "<td>".$lstProduct->Show().$addIcone->Show();
        $html .= "<div id='dvProduct' >".$this->GetProductsFiche($ficheId)."</div></td>";
        
        $html .= "</tr></table>";
        
        return $html;
    }
    else
    {
       return $jbFiche->Show();
    }
   }
   
   /*
    * Obtient les produits d'un fiche
    */
   function GetProductsFiche($ficheId)
   {
       $product = new EeCommerceFicheProductProduct($this->Core);
       $product->AddArgument(new Argument("EeCommerceFicheProduct", "FicheId", EQUAL, $ficheId));
       
       $products = $product->GetByArg();
       
       if(count($products) >  0)
       {
           $html = "<ul>";
           
           foreach($products as $product)
           {
               $delIcone = new DeleteIcone();
               $delIcone->OnClick = "EeCommerceAction.RemoveProductFiche(this,".$product->IdEntite.")";
               $html .= "<li>".$product->Product->Value->NameProduct->Value.$delIcone->Show()."</li>"; 
           }
           $html .= "</ul>";
       }
       
       return $html;
   }
   
   /*
    * Obtient les produits du commerce
    */
   function GetTabProduct($commerce, $fournisseurId = "")
   {
       $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabProduct.tpl", $this->Core); 
       
        $modele->AddElement(new Text("idCommerce", false, $commerce->IdEntite));
       
        //Fournisseur
        $lstFournisseur = new EntityListBox("lstFournisseur", $this->Core);
        $lstFournisseur->Entity = "EeCommerceFournisseur";
        $lstFournisseur->ListBox->Add($this->Core->GetCode("EeCommerce.ChoseFournisseur"), "");
        
        if($fournisseurId != "")
        {
            $lstFournisseur->ListBox->Selected = $fournisseurId;
        }    
        
        $lstFournisseur->ListBox->OnChange = "EeCommerceAction.ShowProductFournisseur(this)";
        $modele->AddElement($lstFournisseur);
   
         //Recuperation des formulaire du projet
        $product = new EeCommerceProduct($this->Core);
        $product->AddArgument(new Argument("EeCommerceProduct", "CommerceId", EQUAL, $commerce->IdEntite));
        
        if($fournisseurId != "")
        {
            $product->AddArgument(new Argument("EeCommerceProduct", "FournisseurId", EQUAL, $fournisseurId));
        }
        else
        {
            $product->SetLimit(1,5);
        }
        
       

        $product->AddOrder("Id", "desc");
        $products = $product->GetByArg(false, true);
        
        $modele->AddElement($products);

        return new Libelle($modele->Render());
   }

   //Affiche les produits d'un fournisseur
   function ShowProductFournisseur($fournisseurId)
   {    
       //Recuperation du commerce Vente Givre
       //TODO A METTRE DANS UN FICHIER DE CONFIG
       $commerce = new EeCommerceCommerce($this->Core);
       $commerce->GetByName("VenteGivree");
       
       return $this->GetTabProduct($commerce, $fournisseurId)->Show();
   }

               
   /*
    * Pop in d'ajout de produit
    */
   function ShowAddProduct($commerceId, $productId)
   {
       $jbProduct = new JBlock($this->Core, "jbProduct" . $productId);
       $jbProduct->Localise = true;
       $jbProduct->AddStyle("width", "900px");
       $jbProduct->CssClass = "products";
       $jbProduct->Table = true;
       $jbProduct->Frame = false;
       
       $product = new EeCommerceProduct($this->Core);
       
       if($productId != "" && $productId != "undefined")
       {
           $product->GetById($productId);
           $jbProduct->AddParameter("productId", $productId);
       }
       
       //Ajout des champs
       $jbProduct->AddNew(new Libelle("<br/><h3 class='icon-gear'>".$this->Core->GetCode("EeCommerce.DetailProduct")."</h3>"), 6 );
       
       $product->NameProduct->Control->Id .= $productId;
       $product->NameProduct->Control->AddStyle("width","150px");
       $jbProduct->AddNew($product->NameProduct);
       
       $product->RefProduct->Control->Id .= $productId;
       $product->RefProduct->Control->AddStyle("width","150px");
       $jbProduct->Add($product->RefProduct);
       
       $lstMarque = new EntityListBox("lstMarque" .$productId, $this->Core);
       $lstMarque->Entity = "EeCommerceMarque";
       $lstMarque->Selected = $product->MarqueId->Value;
       $lstMarque->ListBox->Add("","");
       $jbProduct->AddNew(new Libelle($this->Core->GetCode("EeCommerce.Marque")));
       $jbProduct->Add($lstMarque, 2);
               
       $product->LinkFournisseur->Control->Id .= $productId;
       $product->LinkFournisseur->Control->AddStyle("width","150px");
       $jbProduct->AddNew($product->LinkFournisseur);
       
       $link = new Link($product->LinkFournisseur->Value, $product->LinkFournisseur->Value) ;
       $link->AddAttribute("target","_blank");
       $jbProduct->Add($link);
       
       
       
      
                  
       $product->Actif->Control->Id .= $productId;
       $jbProduct->AddNew($product->Actif);
       $product->SmallDescriptionProduct->Control->Id .= $productId;
       $product->SmallDescriptionProduct->Control->AddStyle("width","550px");
       $jbProduct->AddNew($product->SmallDescriptionProduct, 4);
       
       //Reformatage des données pour CKEditor
       $product->LongDescriptionProduct->Control->Id .= $productId;
       $product->LongDescriptionProduct->Value = str_replace("!et!", "&", $product->LongDescriptionProduct->Value);
       $jbProduct->AddNew($product->LongDescriptionProduct, 4);
      
       
       //Categorie
       $lstCategory = new EntityListBox("lstCategory".$productId, $this->Core);
       $lstCategory->Libelle = $this->Core->GetCode("EeCommerce.Category");
       $lstCategory->Entity = "EeCommerceProductCategory";
       $lstCategory->AddArgument(new Argument("EeCommerceProductCategory","CommerceId", EQUAL, $commerceId));
       $lstCategory->ListBox->Selected = $product->CategoryId->Value;
       $lstCategory->ListBox->AddStyle("width","150px");
       $jbProduct->AddNew($lstCategory);
       
       if($this->Core->User->Groupe->Value->Name->Value == "Admin")
       {
            //Fournisseur
            $lstFournisseur = new EntityListBox("lstFournisseur".$productId, $this->Core);
            $lstFournisseur->Libelle = $this->Core->GetCode("EeCommerce.Fournisseur");
            $lstFournisseur->Entity = "EeCommerceFournisseur";
            $lstFournisseur->AddArgument(new Argument("EeCommerceFournisseur","CommerceId", EQUAL, $commerceId));
            $lstFournisseur->ListBox->Selected = $product->FournisseurId->Value;
            $lstFournisseur->ListBox->AddStyle("width","150px");
            $jbProduct->Add($lstFournisseur);
       }
       
       //Prix
       $jbProduct->AddNew(new Libelle("<h3 class='icon-gear'>".$this->Core->GetCode("EeCommerce.ProductPrices")."</h3>"), 6);
       
       $product->PriceVenteMini->Control->Id .= $productId;
       $product->PriceVenteMini->Control->AddStyle("width","150px");
       $jbProduct->AddNew($product->PriceVenteMini);
       $product->PriceVenteMaxi->Control->Id .= $productId;
       $product->PriceVenteMaxi->Control->AddStyle("width","150px");
       $jbProduct->Add($product->PriceVenteMaxi);
     
       if($this->Core->User->Groupe->Value->Name->Value == "Admin")
       {
        $product->PriceBuy->Control->Id .= $productId;
        $product->PriceBuy->Control->AddStyle("width","150px");
        $jbProduct->AddNew($product->PriceBuy);  
       }
      
       
       $product->PricePort->Control->Id .= $productId;
       $product->PricePort->Control->AddStyle("width","150px");
       $jbProduct->AddNew($product->PricePort);
     
       if($this->Core->User->Groupe->Value->Name->Value == "Admin")
       {
        $product->PriceDown->Control->Id .= $productId;
        $product->PriceDown->Control->AddStyle("width","150px");
        $jbProduct->Add($product->PriceDown);
       }
       
       $product->Quantity->Control->Id .= $productId;
       $product->Quantity->Control->AddStyle("width","150px");
       $jbProduct->AddNew($product->Quantity);
       
       $product->DeliveryDelay->Control->Id .= $productId;
       $product->DeliveryDelay->Control->AddStyle("width","150px");
       $jbProduct->Add($product->DeliveryDelay);
     
       //Bouton de sauvegarde
       $btnSave = new Button(BUTTON);
       $btnSave->CssClass = "btn btn-primary";
       $btnSave->Value = $this->Core->GetCode("Save");
       $btnSave->OnClick = "EeCommerceAction.SaveProduct(".($commerceId != "" ? $commerceId : $product->CommerceId->Value).", ".($productId != "" ? $productId : 0).")";
       
       $jbProduct->AddNew($btnSave, 2, ALIGNRIGHT); 
       
       if($productId != "" && $productId != "undefined")
       { 
           //Refernces liées
           $jbProduct->AddNew(new Libelle($this->GetReferences($productId)), 6);
           
           $jbProduct->AddNew(new Libelle("<h3 class='icon-gear'>".$this->Core->GetCode("EeCommerce.ImageProduct")."</h3>" ), 6);
                    
            $html ="<div id='Image' class='conta' >";
            
            //Upload Ajax
             $inFile = new UploadAjaxFile("EeCommerce", $product->CommerceId->Value.":".$productId, "EeCommerceAction.RefreshImageProduct(".$productId.");", "SaveImageProduct", "fileProduct".$productId);
             $html .= $inFile->Show()."<br/><br/>";
            
             //Recuperation des images qui sont dans le repertoire
             $html .= "<div id='lstImage".$productId."' class='row'>".$this->GetImages($product)."</div>";
             
            $html .= "</div>";
       }
       
       $jbProduct->AddNew(new Libelle($html));
       
       return $jbProduct->Show();
   }
   
   /*
    * Obtient les images des produits
    */
   public function GetImages($product)
   {
       $html ="<div>";
       
      //Product Directory
      $directory = "../Data/Apps/EeCommerce/".$product->CommerceId->Value. "/product/".$product->IdEntite;
      
        if ($dh = opendir($directory))
         { $i=0;
         
             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 && substr_count($file,"_300") == 0)
               {
                   $nameFile[$i] = $directory."/".$file;
                   
                   $fileNameMini =str_replace(".png", "", $file);
                   $fileNameMini =str_replace(".jpg", "", $fileNameMini);
                   $fileNameMini =str_replace(".jpeg", "", $fileNameMini);
                   $fileNameMini =str_replace(".ico", "", $fileNameMini);
                     
                   $html .="<div class='col-md-3' >";
                   
                   $images = new Image($directory."/".$fileNameMini."_96.png");
                   $html .= $images->Show();
                   
                   $deleteIcone = new DeleteIcone($this->Core);
                   $deleteIcone->OnClick = "EeCommerceAction.DeleteImage(this, $product->IdEntite, '".$directory."/".$fileNameMini."_96.png" ."')";
                           
                   $html .= $deleteIcone->Show();
                   
                   //Boutton radio pour choisir l'image par défaut
                   $rbDefault = new RadioButton("rbDefault");
                   $rbDefault->SetTitle($this->Core->GetCode("EeCommerce.SetAsImageDefault"));
                
                   if($this->GetFileName($product->ImageDefault->Value) == $this->GetFileName($directory."/".$fileNameMini."_96.png"))
                   {
                      $rbDefault->Checked = true; 
                   }
                   
                   $rbDefault->OnClick = "EeCommerceAction.SetImageDefault(".$product->IdEntite.", this)";
                   $html .= $rbDefault->Show();
                           
                   $html .="</div>";
                   
                   $i++;
               }
             }
         }  
         
         $html .= "</div>";
         return $html;
   }
   
   /*
    * Obtient le nom du fichier 
    */
   public function GetFileName($file)
   {
       $filename = explode("/", $file);
       return $filename[count($filename) - 1];
   }
   
   /*
    * Obtient les references du produit
    */
   public function GetReferences($productId)
   {
       $html = "<h3>".$this->Core->GetCode("EeCommerce.ProductReference")."</h3>";
       
       $html .= "<div id='lstReference'>";
       
       $html .= $this->GetReferencesProduct($productId);
       
       $html .= "</div>";
       
       $html .= "<div>";
         
       $html .= "<h6>".$this->Core->GetCode("EeCommerce.AddReference")."</h6>";
       $tbCode = new TextBox("tbCodeRefence");
       $tbCode->AddStyle("width", "150px");
       $tbCode->PlaceHolder = $this->Core->GetCode("Refrence");
       $tbLibelle = new TextBox("tbLibelleReference");
       $tbLibelle->PlaceHolder = $this->Core->GetCode("Libelle");
       $tbLibelle->AddStyle("width", "150px");
       $tbQuantity = new NumericBox("tbQuantityReference");
       $tbQuantity->AddStyle("width", "150px");
       $tbQuantity->PlaceHolder = $this->Core->GetCode("Quantity");
       
       $addIcone = new AddIcone($this->Core);
       $addIcone->OnClick =  "EeCommerceAction.AddReference(".$productId.")";
       
       $html.= "<span class='col-md-3' >".$tbCode->Show()."</span>";
       $html.= "<span class='col-md-3' >".$tbLibelle->Show()."</span>";;
       $html.= "<span class='col-md-3' >".$tbQuantity->Show()."</span>";
       $html.= "<span class='col-md-1' >".$addIcone->Show()."</span>";
       
       $html .= "</div>";
       
      
       
       return $html;
   }       
   
   /*
    * Obtient toutes les réferences du produit
    */
   public function GetReferencesProduct($productId)
   {
       $reference = new EeCommerceProductReference($this->Core);
       $reference->AddArgument(new Argument("EeCommerceProductReference", "ProductId", EQUAL, $productId));
       $references = $reference->GetByArg();
       
      $modele =  new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetReferenceProduct.tpl", $this->Core); 
      
      if(count($references) > 0 )
      {
        $modele->AddElement($references);
      }
      else
      {
         $modele->AddElement(array()); 
      }
      
      return $modele->Render();
   }
   
   /*
    * Edite une reference
    */
   public function EditReference($productId, $referenceId)
   {
       $reference= new EeCommerceProductReference($this->Core);
       $reference->GetById($referenceId);
               
       $tbCode = new TextBox("tbUpdateCode" . $referenceId);
       $tbCode->PlaceHolder = $this->Core->GetCode("Code");
       $tbCode->Value = $reference->Code->Value;
       
       $tbLibelle = new TextBox("tbUpdateLibelle" . $referenceId);
       $tbLibelle->PlaceHolder = $this->Core->GetCode("Libelle");
       $tbLibelle->Value = $reference->Libelle->Value;
       
       $tbQuantity = new NumericBox("tbUpdateQuantity" . $referenceId);
       $tbQuantity->PlaceHolder = $this->Core->GetCode("Quantity");
       $tbQuantity->Value = $reference->Quantity->Value;
        
       $addIcone = new SaveIcone($this->Core);
       $addIcone->OnClick =  "EeCommerceAction.UpdateReference(this, ".$productId.", ".$referenceId.")";
       
       $html.= "<td>".$tbCode->Show()."</td>";
       $html.= "<td>".$tbLibelle->Show()."</td>";;
       $html.= "<td>".$tbQuantity->Show()."</td>";
       $html.= "<td>".$addIcone->Show()."</td>";
       
       return $html;
   }
   
   /*
    * Met  jour une référence
    */
   public function GetReference($referenceId)
   {
       $reference = new EeCommerceProductReference($this->Core);
       $reference->GetById($referenceId);
       
       $html.= "<td>".$reference->Code->Value."</td>";
       $html.= "<td>".$reference->Libelle->Value."</td>";;
       $html.= "<td>".$reference->Quantity->Value."</td>";
       $html.= "<td><i class='icon-edit' onclick='EeCommerceAction.EditReference(this, ".$reference->ProductId->Value." , ".$reference->IdEntite.")'>
                <i class='icon-remove' onclick='EeCommerceAction.DeleteReference(this, ".$reference->ProductId->Value.", ".$reference->IdEntite.")'>
      </td>";
       
       return $html;
   }
   
   
   public function GetHelp()
   {
       return "";
   }
   
   /*
    * POp in d'import de produit
    */
   public function ShowImport($commerceId)
   {
        //Upload Ajax
        $inFile = new UploadAjaxFile("EeCommerce", $commerceId, "", "ImportProduct", "fileProduct");
        return $inFile->Show();
    }
}
