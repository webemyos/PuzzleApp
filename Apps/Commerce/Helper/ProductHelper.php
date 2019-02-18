<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Helper pour les produits
 */

class ProductHelper
{
    /*
     * Sauvegarde d'un produit
     */
    public static function SaveProduct($core, $commerceId, $productId, $NameProduct, $refProduct, $Actif, $PriceBuy, 
                                       $PriceVenteMini, $PriceVenteMaxi, $PricePort, $PriceDown,
                                       $Quantity, $DeliveryDelay,
                                       $SmallDescriptionProduct, $LongDescriptionProduct, $categoryId, $fournisseurId , $marqueId, $linkFournisseur)
    {
        $product = new EeCommerceProduct($core);
        
        if($productId != "" && $productId != 0 )
        {
           $product->GetById($productId); 
        }
        
        if($commerceId != 0)
        {                          
            $product->CommerceId->Value = $commerceId;
        }
        $product->NameProduct->Value = $NameProduct;
        $product->RefProduct->Value = $refProduct;
		
	$product->Code->Value =  JFormat::ReplaceForUrl($NameProduct) ;
        $product->Actif->Value = $Actif;
        $product->PriceBuy->Value = $PriceBuy;
        $product->PriceVenteMini->Value = $PriceVenteMini;
        $product->PriceVenteMaxi->Value = $PriceVenteMaxi;
        $product->PricePort->Value = $PricePort;
        $product->PriceDown->Value = $PriceDown;
        $product->Quantity->Value = $Quantity;
        $product->DeliveryDelay->Value = $Quantity;
        $product->SmallDescriptionProduct->Value = $SmallDescriptionProduct;
        $product->LongDescriptionProduct->Value = $LongDescriptionProduct;
        $product->CategoryId->Value = $categoryId;
        $product->MarqueId->Value = $marqueId;
         $product->LinkFournisseur->Value = $linkFournisseur;
        
        if($fournisseurId)
        {
            $product->FournisseurId->Value = $fournisseurId;
        }
        else
        {
            //Fournisseur de l'utilisateur
            $fournisseur = FournisseurHelper::GetByUser($core);
            $product->FournisseurId->Value = $fournisseur->FournisseurId->Value;
        }
        
        //Envoie une nitification à l'administrateur
        $enotify = Eemmys::GetApp("EeNotify", $core);
        $enotify->AddNotify($core->User->IdEntite, "EeCommerce.NotifySaveMessage", ID_ADMIN, "EeCommerce", $product->IdEntite, "EeCommerce.NotifySaveMessageSubject","EeCommerce.NotifySaveMessageMessage" );
        
        return $product->Save();
    }
    
    /*
     * Obtient ds produits de la boutique Disponible à la vente
     */
    public function GetSaleProduct($core, $shopName, $limit)
    {
        //Recup$shoperationde la noutique
        $shop = new EeCommerceCommerce($core);
        $shop->GetByName($shopName);
        
        if($shop->IdEntite != "")
        {
            $product = new EeCommerceProduct($core);
            $product->AddArgument(new Argument("EeCommerceProduct", "CommerceId", EQUAL, $shop->IdEntite));
            $product->SetLimit(1, $limit);

            return $product->GetByArg(true);
        }
        else
        {
            return false;
        }
   }
   
   /**
    * Définie l'image par défaut d'un produit
    * @param type $core
    * @param type $productId
    * @param type $image
    */
   public function SetImageDefault($core, $productId, $image)
   {
       $product = new EeCommerceProduct($core);
       $product->GetById($productId);
       $product->ImageDefault->Value = $image;
       $product->Save();
   }
   
   /*
    * Obtient les produits d'un fournisseurs
    */
   public function GetByFournisseur($core, $fournisseurId, $name)
   {
       $product = new EeCommerceProduct($core);
       $product->AddArgument(new Argument("EeCommerceProduct", "FournisseurId", EQUAL, $fournisseurId));
       
       if($name != "")
       {
        $product->AddArgument(new Argument("EeCommerceProduct", "NameProduct", LIKE, $name));
       }
       
       return $product->GetByArg();
   }
   
    /*
    * Obtient les produits d'un fournisseurs
    */
   public function GetByCategory($core, $categoryId, $start = 1 , $limit = 6, $actif = "")
   {
       $product = new EeCommerceProduct($core);
       $product->AddArgument(new Argument("EeCommerceProduct", "CategoryId", EQUAL, $categoryId));
       
       if($start == 1)
       {
        $product->SetLimit($start, $limit);
       }
       else
       {
        $product->SetLimit(($start * $limit) + 1, $limit);
       }
       
       if($actif != "")
       {
          $product->AddArgument(new Argument("EeCommerceProduct", "Actif", EQUAL, $actif));
       }
       return $product->GetByArg();
   }
   
   /*
    * Ajoute une réference à un produit
    */
   public function AddReference($core, $productId, $code, $libelle, $quantity)
   {
       $reference = new EeCommerceProductReference($core);
       $reference->ProductId->Value = $productId;
       $reference->Code->Value = $code;
       $reference->Libelle->Value = $libelle;
       $reference->Quantity->Value = $quantity;
       $reference->Save();
   }
   
    /*
    * Ajoute une réference à un produit
    */
   public function UpdateReference($core, $referenceId, $code, $libelle, $quantity)
   {
       $reference = new EeCommerceProductReference($core);
       $reference->GetById($referenceId);
       $reference->Code->Value = $code;
       $reference->Libelle->Value = $libelle;
       $reference->Quantity->Value = $quantity;
       $reference->Save();
   }
   
   /*
    * Supprime une réference
    */
   public function DeleteReference($core, $referenceId)
   {
       //TODO FAIRE UNE SUPPRESSION LOGIQUE PLUTOT QUE PHISIQUE 
       // SI ON A DES COMMANDES RATTACHEES AFIN DE POUVOIR LES RETROUVER
        $reference = new EeCommerceProductReference($core);
        $reference->GetById($referenceId);
        $reference->Delete();
   }
   
   /*
    * Otient les réferences du produit qui ont du stock
    */
   public static function GetReference($core, $productId, $withStock = true)
   {
        $reference = new EeCommerceProductReference($core);
        $reference->AddArgument(new Argument("EeCommerceProductReference", "ProductId", EQUAL, $productId));
       
        if($withStock)
        {
            $reference->AddArgument(new Argument("EeCommerceProductReference", "Quantity", NOTEQUAL, "0"));
        }
        
        return $reference->GetByArg();
   }
   
   /*
    * Met à jour les quantités des produits
    */
   public static function UpdateStock($core, $commande)
   {
       $lines = CommandeHelper::GetProducts($core, $commande);
       
       foreach($lines as $line)
       {
           if($line->ReferenceId->Value != "")
           {
               //On met a jour la réference
               $reference = new EeCommerceProductReference($core);
               $reference->GetById($line->ReferenceId->Value);
               $reference->Quantity->Value = $reference->Quantity->Value - 1;
               $reference->Save();
           }
           else
           {
               $vente = new EeCommerceVente($core);
               $vente->GetById($line->EntityId->Value);
               
               $product = new EeCommerceProduct($core);
               $product->GetById($vente->ProductId->Value);
               $product->Quantity->Value = $product->Quantity->Value - 1;
               $product->Save();
           }
       }
   }
   
   /*
    * Obtient un tableau des produits et leur quantite
    */
   public static function GetProductQuantity($core, $productId = "", $actif = null)
   {
        $request = " SELECT product.Id As IdEntite, product.NameProduct  as NameProduct, product.Quantity AS QuantityProduct ,
                     (SELECT Group_Concat(Quantity) FROM  EeCommerceProductReference AS ref WHERE ref.ProductId =product.Id  ) as QuantityReference
                     FROM EeCommerceProduct  as product";
        
        if($productId != "")
        {
          $where = " WHERE product.Id = ".$productId;
        }
        
        if($actif != null)
        {
           if($where != "")
           {
            $where .= " AND " ;
           }
           else
           {
            $where .= " WHERE " ;
           
           }
                       
           $where .= " product.Actif = " . ( $actif ? "1" : "0" );
              
        }
        $request .=    $where;
        
       return $core->Db->GetArray($request);
   }
   
   /*
    * Prend trois produits au hazard 
    */
   public static function GetRand($core)
   {
       $products =array();
       
       $request = "SELECT min(Id) as min, max(Id) as max FROM EeCommerceProduct";
       $result = $core->Db->GetLine($request);
       
       for($i = 0; $i < 3; $i++)
       {
        $product = new EeCommerceProduct($core);
        $product->GetById(rand($result["min"], $result["max"]));
        $products[] = $product;
       }
       
       return $products;
       
   }
   
   /*
    * Obtient les fiches produit d'une catégorie
    */
   public static function GetFicheByCategory($core, $categoryId)
   {
       $ficheProduct = new EeCommerceFicheProduct($core);
       $ficheProduct->AddArgument(new Argument("EeCommerceFicheProduct", "CategoryId", EQUAL, $categoryId ));
       
       return $ficheProduct->GetByArg();
   }
}