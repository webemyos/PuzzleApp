<?php

/* 
 * Module de gestion des canaux de vente
 */
class SaleBlock
{
    
    private $Core;
    
    /*
     * Constructeur 
     */
    function SaleBlock($core)
    {
        $this->Core = $core;
    }
    
    function GetTool()
    {
        $commerce = $this->Commerce;

        //Tab veriticale
        $vTab = new VTab("vTVente"); 
        $vTab->CssClass = "content";
        $vTab->SelectedIndex = 99;
        $vTab->AddTab($this->Core->GetCode("EeProjet.TitleTabSeanceVente"), $this->GetTabSeance($commerce), false);

        return $vTab;
    }
    
    /**
     * Obtient les seances
     * @param type $commerce
     */
    function GetTabSeance($commerce)
    {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabSeance.tpl", $this->Core); 
       
        $modele->AddElement(new Text("idCommerce", false, $commerce->IdEntite));
       
        //Recuperation des seances du projet
        $seance = new EeCommerceSeanceVente($this->Core);
        $seance->AddArgument(new Argument("EeCommerceSeanceVente", "CommerceId", EQUAL, $commerce->IdEntite));

        $seance->AddOrder("Id");
        
        $seances = $seance->GetByArg(false, true);
        
        $modele->AddElement($seances);

        return new Libelle($modele->Render());
    }
    
    /**
     * Pop in de détail d'une vente
     * @param type $commerceId
     * @param type $seanceId
     */
    function ShowAddSeanceVente($commerceId, $seanceId)
    {
        $jbVente = new JBlock("jbVente");
        $jbVente->Frame = false;
        $jbVente->Id = "jbVente";
        
        $seance = new EeCommerceSeanceVente($this->Core);
        
        if($seanceId != "")
        {
            $seance->GetById($seanceId);
            $jbVente->AddParameter("seanceId", $seanceId);
        }
        
        $seance->Libelle->Control->Id = "tbSeanceLibelle";
        $jbVente->Add($seance->Libelle);
        $jbVente->AddNew($seance->DateStart);
        $jbVente->Add($seance->DateEnd);
        
        //Bouton de sauvegarde
        $btnStart = new Button(BUTTON);
        $btnStart->CssClass = "btn btn-primary";
        $btnStart->Value = $this->Core->GetCode("Save");
        $btnStart->OnClick = "EeCommerceAction.SaveSeance(".$commerceId.", ".($seanceId ? $seanceId : 0).")";
        $jbVente->AddNew($btnStart);
        
        $btnReset = new Button(BUTTON);
        $btnReset->Value = "Reset";
        $btnReset->OnClick = "EeCommerceAction.Reset($seanceId);";
        $jbVente->AddNew($btnReset);
        
        if($seanceId != "")
        {
            $jbVente->AddNew( new Libelle("<h3>".$this->Core->GetCode("EeCommerce.ProductSeance")."</h3>"));  
        
            $btnAddArticle = new Button(BUTTON);
            $btnAddArticle->Value = $this->Core->GetCode("EeCommerce.AddLigne");
            $btnAddArticle->CssClass = "btn btn-success";
            
            $btnAddArticle->OnClick = "EeCommerceAction.AddLigneSeance($seanceId)";
            $jbVente->AddNew($btnAddArticle);
            
            $jbVente->AddNew(new Libelle($this->GetArticleLines($seanceId)));
            
            $jbVente->AddNew(new Libelle($this->GetLike($seanceId)));
        }
        
        return $jbVente->Show();
    }
    
    /*
     * Obtient les lignes d'articles et la liste pour en ajouté à la volée
     */
    public function GetArticleLines($seanceId, $showAll = true)
    {
        if($showAll)
        {
            $html = "<div id='lstArticle'>";
        }
        
        $request = "SELECT vente.Id as IdEntite, NameProduct  as NameProduct, Actif,
                    product.Quantity as quantiteProduct,
                   (Select Group_Concat(Quantity) From  EeCommerceProductReference as ref WHERE ref.ProductId =product.Id  ) as quantiteReference
                    FROM EeCommerceVente as vente
                    JOIN EeCommerceProduct as product On product.Id = vente.ProductId
                    WHERE SeanceId = " . $seanceId  . " order by vente.Line";
        
        
        //Liste des lignes dèjà présente
        //$lines = SeanceHelper::GetLines($this->Core, $seanceId);
        $lines = $this->Core->Db->GetArray($request);
        
        if(count($lines) > 0)
        {
           $html .= "<table class='SeanceVente'>";
           $html .= "<tr><th>".$this->Core->GetCode("EeCommerce.Product1")."</th>"; 
           $html .= "<th>".$this->Core->GetCode("EeCommerce.Product2")."</th>";  
           $html .= "<th>".$this->Core->GetCode("EeCommerce.Product3")."</th></tr>";  
           
            for($i = 0; $i < count($lines); $i += 3 )
            {
                //Affichage des lignes trois par trois
                $html .= "<tr><td id='".$lines[$i]["IdEntite"]."' >".JFormat::ReplaceString($lines[$i]["NameProduct"]). ":ETAT=" . $lines[$i]["Actif"]." ( ".$lines[$i]["quantiteProduct"]." : ".$lines[$i]["quantiteReference"]." )"."</td>";
                $html .= "<td id='".$lines[$i+1]["IdEntite"]."' >".JFormat::ReplaceString($lines[$i +1]["NameProduct"]). ":ETAT=" . $lines[$i]["Actif"]." ( ".$lines[$i +1 ]["quantiteProduct"]." : ".$lines[$i+1]["quantiteReference"]." )"."</td>";
                $html .= "<td id='".$lines[$i+2]["IdEntite"]."' >".JFormat::ReplaceString($lines[$i +2]["NameProduct"]). ":ETAT=" . $lines[$i]["Actif"]." ( ".$lines[$i + 2]["quantiteProduct"]." : ".$lines[$i + 2]["quantiteReference"]." )"."</td></tr>";
            }
        
            $html .= "</table>";
        }
         if($showAll)
        { 
        $html .= "</div>";
        
        //Module d'ajout
        $html .= "<div id='dvNewLigne'>";
        
        for($i = 0 ; $i < 3; $i++)
        {
            $lstType= new ListBox("lstType".$i);
            $lstType->name = "lstType".$i;
            $lstType->Add($this->Core->GetCode("EeCommerce.ChoseTypeAjout"), "0");
            $lstType->OnChange = "EeCommerceAction.LoadAddByType(this, $seanceId)";
            $lstType->Add($this->Core->GetCode("EeCommerce.Product"), "1");
            $lstType->Add($this->Core->GetCode("EeCommerce.Category"), "2");
            $lstType->Add($this->Core->GetCode("EeCommerce.Fournisseur"), "3");
            
            $html .= "<div>".$lstType->Show();
            $html .= "<span id='dvSubType$i' ></span></div>";
        }
        
            $html .= "</div>"; 
        }
    
        return $html;
    }
    
    /*
     * Obtient les likes sur les produis mi en vente permettra de comparer 
     * les impacts d'une campagne d'email
     */
    function GetLike($seanceId, $showAll =true )
    {
        if($showAll)
        {
            $html = "<div id='lstLike'>";
        }
        
        $html .= "<h2>".$this->Core->GetCode("Like")."</h2>";
     
        $Refresh = new RefreshIcone($this->Core);
        $Refresh->OnClick = "EeCommerceAction.RefreshLike(".$seanceId.")";
                
        $Share = new ShareIcone();
        $Share->OnClick = "EeCommerceAction.ShareLike(".$seanceId.")";
        
        
        $html .= $Refresh->Show(). $Share->Show();
                
        $users = SeanceHelper::GetLikes($this->Core, $seanceId);
        
        $html .= "<ul>";
        foreach($users as $user)
        {
            $html .= "<li>".$user["email"].":".$user["nameProduct"]."</li>";
        }
        $html .= "</ul>";
     
        if($showAll)
        {
           $html .= "</div>";
        }
     
        return $html;
    }
    
    /**
     * Charge une liste déroulante des produits, fournisseurs ou catégories
     */
    public function LoadAddByType($type, $seanceId, $field)
    {
        $lstSubType = new EntityListBox("lstSubType".$field, $this->Core);
        
        //Recuperation de la seance
        $seance = new EeCommerceSeanceVente($this->Core);
        $seance->GetById($seanceId);
        
        switch($type)
        {
             case 1 :
                $lstSubType = $this->GetListProduct("lstSubType".$field, false, true);
                 
                 break;
             case 2 : 
                   $lstSubType->Entity = "EeCommerceProductCategory";  
                   $lstSubType->AddArgument(new Argument("EeCommerceProductCategory", "CommerceId", EQUAL, $seance->CommerceId->Value));
               
                 break;
              case 3 : 
                    $lstSubType->Entity = "EeCommerceFournisseur";  
                    $lstSubType->AddArgument(new Argument("EeCommerceFournisseur", "CommerceId", EQUAL, $seance->CommerceId->Value));
               
                 break;
        }
        
        return $lstSubType->Show();
    }
    
    /**
     * Edite une vente
     * @param type $venteId
     */
    function EditeVente($venteId)
    {
        //Recuperation de la vente
        $vente = new EeCommerceVente($this->Core);
        $vente->GetById($venteId);
        
        $jbVente = new AjaxFormBlock($this->Core, "jbVente");
        $jbVente->App = "EeCommerce";
        $jbVente->Action = "UpdateVente";
 
        $argument = new Argument("EeCommerceProduct", "CommerceId", EQUAL, $vente->CommerceId->Value);
              
        //Ajout des champs
        $jbVente->AddControls(array(
                                      array("Type"=>"Libelle", "Value"=> $this->GetListProduct("lstProduct", true, true)),
                                      array("Type"=>"SaveIcone", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save") , "OnClick" => "EeCommerceAction.UpdateVente(this, $venteId)"),
                          )
                );

        return $jbVente->Show();
    }
    
    /*
     * Obtient la liste des produits avec les stocks
     */
    function GetListProduct($name = "lstProduct" , $show = true, $actif = null)
    {
        $lstProduct = new ListBox($name);
     
        $products = ProductHelper::GetProductQuantity($this->Core, null, $actif);
        
        foreach($products as $product)
        {
            $libelle = $product["NameProduct"] . "(".$product["QuantityProduct"]. ":".$product["QuantityReference"]. ")";
            $lstProduct->Add($libelle, $product["IdEntite"]);
        }
        if($show)
        {
            return $lstProduct->Show();
        }
        else
        {
            return $lstProduct;
        }
    }
    
    
    function GetHelp()
    {
       "Module de gestion des ventes";
    }
}

