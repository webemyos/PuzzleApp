<?php
/**
 * Module FactureCommandeBlock
 * */
 class FactureCommandeBlock extends JHomBlock implements IJhomBlock
 {
        
        protected $Commerce;
     
    	  /**
	   * Constructeur
	   */
	  function FactureCommandeBlock($core="")
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
          
         function GetTool()
        {
            $commerce = $this->Commerce;

            //Tab veriticale
            $vTab = new VTab("vTCommande"); 
            $vTab->CssClass = "content";
            $vTab->SelectedIndex = 99;
            $vTab->AddTab($this->Core->GetCode("EeProjet.TitleTabCommande"), $this->GetTabCommande($commerce), false);

            return $vTab;
        }
        
        /**
     * Obtient les seances
     * @param type $commerce
     */
    function GetTabCommande()
    {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetTabCommande.tpl", $this->Core); 
       
        //TODO RATTACHE LES COMMANDES 1 UN COMMERCE
        //Recuperation des seances du projet
        $commandes = new EeCommerceCommande($this->Core);
        $commandes->AddOrder("Id");
        $modele->AddElement( $commandes->GetAll());

        //Ajouter des filtres
        $lstState = new ListBox("lstState");
        $lstState->Add($this->Core->GetCode("All") , "");
        $lstState->Add($this->Core->GetCode("NonValide"), EeCommerceCommande::BROUILLON);
        $lstState->Add($this->Core->GetCode("Valide"), EeCommerceCommande::VALIDE);
        
        $modele->AddElement($lstState);
        
        //Numero
        $tbNumero = new TextBox("tbNumero");
        $tbNumero->PlaceHolder = $this->Core->GetCode("Numero");
        $modele->AddElement($tbNumero);
        
        //Recherche
        $btnSearch = new Button(BUTTON, "btnSearch");
        $btnSearch->Value = $this->Core->GetCode("Search");
        $btnSearch->OnClick = "EeCommerceAction.RefreshCommande()";
        $modele->AddElement($btnSearch);
          
        return new Libelle($modele->Render());
    }
    
   /*
    * Obtient les commandes selon les filtres 
    */
    function GetCommande($state, $numero)
    {
          $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetCommande.tpl", $this->Core); 
     
          $commande = new EeCommerceCommande($this->Core);
          $commande->AddOrder("Id");
          
          if($state != "")
          {
            $commande->AddArgument(new Argument("EeCommerceCommande", "StateId", EQUAL,$state ));
          }
          
          if($numero != "")
          {
            $commande->AddArgument(new Argument("EeCommerceCommande", "Numero", LIKE, $numero ));
          }
          
          if($state == "" && $numero == "")
          {
                $commandes = $commande->GetAll();
          }
          else
          {
            $commandes = $commande->GetByArg();
          }       
          if(count($commandes) > 0)
          {
            $modele->AddElement($commandes);
          }
          else
          {
            $modele->AddElement(Array());
          }
          
          return $modele->Render();
    }
    
    /*
     * Affiche le détail d'un commande
     */
    function EditCommande($commnandeId)
    {
         $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/EditCommande.tpl", $this->Core); 
       
         //Recuperation de la commande
         $commande = new EeCommerceCommande($this->Core);
         $commande->GetById($commnandeId);
         $modele->AddElement($commande);     
        
         //Ajout des produits depuis un autre template
         $modele->AddElement(new Libelle($this->GetProducts($commande), "TProducts")); 
        
         //Ajout des virements a effectués
         $modele->AddElement(new Libelle($this->GetVirements($commande), "TVirements")); 
         
         //Ajout des facture et des bon de commande
         $modele->AddElement(new Libelle($this->GetFactures($commande), "lstFacture")); 
         $modele->AddElement(new Libelle($this->GetBonCommande($commande), "lstBonCommande")); 
         
         return $modele->Render();
    }
   
    /*
     * Obtient les produits
     */
    function GetProducts($commande)
    {
        $modele = new JModele(EeCommerce::$Directory . "/Blocks/CommerceBlock/View/GetProducts.tpl", $this->Core); 
       
        //Ajout des produits
        $products = CommandeHelper::GetProducts($this->Core, $commande);
        $modele->AddElement($products);
        $modele->AddElement(new Libelle(CommandeHelper::GetTotal($this->Core, $commande), "lbTotal")); 
        
        return $modele->Render();
    }
    
    /*
     * Obtient les factures
     */
    function GetFactures($commande)
    {
        $facture = new EeCommerceFacture($this->Core);
        $facture->AddArgument(new Argument("EeCommerceFacture", "CommandeId", EQUAL, $commande->IdEntite));
        $factures = $facture->GetByArg();
        
        $html ="";
		
		$btnGenereFacture = new Button(BUTTON);
        $btnGenereFacture->Value = $this->Core->GetCode("EeCommerce.GenereFacture");
		$btnGenereFacture->OnClick = "EeCommerceAction.GenereFacture(".$commande->IdEntite.")";
		
		$html .= $btnGenereFacture->Show();
		
        foreach($factures as $facture)
        {
            $lkFacture =new Link($facture->Numero->Value, str_replace("Data/", "../Data/", $facture->File->Value));
            $lkFacture->AddAttribute("target", "_blank");
            $html .= "<li>".$lkFacture->Show()."</li>";
        }
        
        return $html;
    }
    
    /*
     * Obtient les bon de commandes
     */
    function GetBonCommande($commande)
    {
        $bonCommande = new EeCommerceBonCommande($this->Core);
        $bonCommande->AddArgument(new Argument("EeCommerceFacture", "CommandeId", EQUAL, $commande->IdEntite));
        $bonCommandes = $bonCommande->GetByArg();
        
        $html ="";
        
        foreach($bonCommandes as $bonCommande)
        {
            $lkBon =new Link($bonCommande->Numero->Value, str_replace("Data/", "../Data/",$bonCommande->File->Value));
            $lkBon->AddAttribute("target", "_blank");
            $html .= "<li>".$lkBon->Show()."</li>";
        }
        
        return $html;
    }
    
    /*
     * Obtient les virements a effectués par fournisseurs
     * Deux calcul possible commission sur le TTC 
     * Ou Commission sur le HT
     */
    function GetVirements($commande)
    {
        $html = "<table>";
        
        $html .= "<tr><th>Fournisseur</th><th>Commission</th><th>Name Product</th><th>Prix total</th><th>Prix achat</th><th>Mode Calcul</th><th>Montant à virer</th></tr>";
        
        $virements = VirementHelper::GetByCommande($this->Core, $commande);
        
        foreach($virements as $virement)
        {
            $html .= "<tr>";
            $html .= "<td>".$virement["fournisseur"]."</td>";
            $html .= "<td>".$virement["commission"]."</td>";
            $html .= "<td>".$virement["NameProduct"]."</td>";
            $html .= "<td>".$virement["priceTotal"]."</td>";
            $html .= "<td>".$virement["priceBuy"]."</td>";
            $html .= "<td>".$virement["modeCalul"]."</td>";
            $html .= "<td>".$virement["Montant"]."</td>";
               
            $html .= "</tr>";
        }
        
        $html .= "</table>";
        
        if($virement["nbVirement"] == 0 && $commande->StateId->Value == EeCommerceCommande::VALIDE)
        {
            //Boutton pour effectuer les virements
            $btnVirement = new Button(BUTTON);
            $btnVirement->CssClass = "btn btn-warning";
            $btnVirement->Value = $this->Core->GetCode("EeCommerce.DoVirement");

            $btnVirement->OnClick = "EeCommerceAction.DoVirement(".$commande->IdEntite.");";

            $html .= $btnVirement->Show();
        }
        
        return $html;
    }
    
    /*
     * Retourne l'aide
     */
    function GetHelp()
    {
      // return "ComandeBlockHelp"; 
    }
          /*action*/
 }?>

