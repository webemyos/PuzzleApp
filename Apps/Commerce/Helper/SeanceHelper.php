<?php

/* 
 * classe utilitaire pour les seances
 */
class SeanceHelper
{
    /*
     * Sauvegarde une seance
     */
    public static function SaveSeance($core, $libelle, $dateStart, $dateEnd, $commerceId, $seanceId ="")
    {
        $seance = new EeCommerceSeanceVente($core);
        
        if($seanceId != "")
        {
            $seance->GetById($seanceId);
        }
        
        $seance->CommerceId->Value = $commerceId;
        $seance->Libelle->Value = $libelle;
        $seance->DateStart->Value = $dateStart;
        $seance->DateEnd->Value = $dateEnd;
        
        $seance->Save();
        
        return $idEntite==""? $core->Db->GetInsertedId():$idEntite ;
    }
    
    /**
     * Ajoute une ligne de produit a une séance de vente
     * On ajoute soit un produit directement si il est disponible
     * Soit on recherche un produit depuis les catégories
     * Soit on recherche un produit depuis les fournisseurs.
     * 
     * On prend le produit au hasard, mais on ajoute pas deux fois les mêmes
     * @param type $core
     * @param type $type0
     * @param type $subType0
     * @param type $type1
     * @param type $subType1
     * @param type $type2
     * @param type $subType2
     */
    public static function AddLigne($core, $seanceId, $type0, $subType0, $type1, $subType1, $type2, $subType2)
    {
        //Obtient le prochain numero de ligne
        $numLigne = SeanceHelper::GetLastNumberLine($core,$seanceId );
        
        SeanceHelper::AddVente($core, $seanceId, $type0, $subType0, $numLigne, 1);
        SeanceHelper::AddVente($core, $seanceId, $type1, $subType1, $numLigne, 2);
        SeanceHelper::AddVente($core, $seanceId, $type2, $subType2, $numLigne, 3);
    }
    
    /**
     * Ajoute une vente avec un produit
     * Soit le produit directement soit il faut aller le recuperer selon le fournisseur ou la catégorie de produit
     * 
     * @param type $core
     * @param type $type
     * @param type $idElement
     */
    public static function AddVente($core, $seanceId, $type, $idElement, $numLine, $position)
    {
        $vente = new EeCommerceVente($core);
        $vente->SeanceId->Value = $seanceId;
        
        switch($type)
        {
           //On prend le produit
           case 1:
               $vente->ProductId->Value = $idElement;
               break;
           //On se base sur les catégories
           case 2: 
               $vente->ProductId->Value = SeanceHelper::GetProductByCategory($core, $idElement, $seanceId);
               break;
           //On se base sur les fournisseurs
           case 3 :
               $vente->ProductId->Value = SeanceHelper::GetProductByFournisseur($core, $idElement, $seanceId);
             
               break;
        }
        
        $vente->Line->Value = $numLine;
        $vente->Position->Value = $position;
      
        $vente->Save();
    }
    
    /*
     * Obtient le prochaine numero de ligne pour une seance
     */
    public static function GetLastNumberLine($core, $seanceId)
    {
        $request = "SELECT CASE WHEN Max(Line) IS NULL THEN 1 ELSE MAX(Line) + 1 END  AS Line FROM EeCommerceVente WHERE seanceId = " . $seanceId;
        $result = $core->Db->GetLine($request);
        
        return $result["Line"];
    }
    
    /*
     * Obtient l'id d'un produit dans une catégorie 
     * Non présent dans la séance en cours
     */
    public static function GetProductByCategory($core, $categoryId, $seanceId)
    {
        $request = "SELECT  Id FROM EeCommerceProduct WHERE CategoryId = ".$categoryId."
                    AND Id NOT in (SELECT ProductId FROM EeCommerceVente WHERE SeanceId = ".$seanceId.")" ;
        
        $result = $core->Db->GetArray($request);
        
        //Retourne un des produit au hazard
        if(count($result) > 0)
        {
            return $result[rand(0, count($result) - 1)]["Id"];
        }
        else
        {
            //Sinon on prend le premier produit de la categorie
            $request = "SELECT Id FROM EeCommerceProduct WHERE CategoryId=".$categoryId;
            $result = $core->Db->GetLine($request);
        
            return $result["Id"];
        }
    }
    
    /*
     * Obtient l'id d'un produit dans une fournisseur 
     * Non présent dans la séance en cours
     */
    public static function GetProductByFournisseur($core, $fournisseurId, $seanceId)
    {
        $request = "SELECT  Id FROM EeCommerceProduct WHERE FournisseurId = ".$fournisseurId."
                    AND Actif = 1
                    AND Id NOT in (SELECT ProductId FROM EeCommerceVente WHERE SeanceId = ".$seanceId.")" ;
        
        $result = $core->Db->GetArray($request);
        
        //Retourne un des produits au hazard
        if(count($result) > 0)
        {
            return $result[rand(0, count($result) - 1)]["Id"];
        }
        else
        {
            //Sinon on prend le premier produit du fournisseur
            $request = "SELECT Id FROM EeCommerceProduct WHERE FournisseurId=".$fournisseurId;
            $result = $core->Db->GetLine($request);
        
            return $result["Id"];
        }
    }
    
    /*
     * Obtient les lignes d'une seance
     */
    public static function GetLines($core, $seanceId)
    {
        $vente = new EeCommerceVente($core);
        $vente->AddArgument(new Argument("EeCommerceVente", "SeanceId", EQUAL, $seanceId));
        
        return $vente->GetByArg();
    }
    
    /*
     * Récupere la seance en cours 
     */
    public static function GetSaleProduct($core, $shopName)
    {
        $seance = SeanceHelper::GetActualSeance($core, $shopName);
        
        if($seance != null)
        {
            //Obtient les 6 produit en cours de vente
            $products = SeanceHelper::GetActualProduct($core, $seance);

            return $products;
        }
        else
        {
            return array();
        }
    }
    
    /*
     * Obtient la seance en cours
     */
    public static function GetActualSeance($core, $shopName)
    {
        //Recuperation du commerce
        $commerce = new EeCommerceCommerce($core);
        $commerce->GetByName($shopName);
       
        $request = "SELECT Id From EeCommerceSeanceVente WHERE now() between DateStart and DateEnd AND CommerceId=1";//.$commerce->IdEntite;
        $result = $core->Db->GetLine($request); 
         
        if($result['Id'] != null)
        {
            $Seance = new EeCommerceSeanceVente($core);
            $Seance->GetById($result['Id']);

            return $Seance; 
        }
        else 
        {
            return null;
        }
    }
    
    /*
     * Obtient les produit actuels
     */
    public static function GetActualProduct($core, $seance)
    {
        //Appel de la procédure stocké qui va gérer tout cela
        $request = "set @Vente1 = '';
                    set @TimeEnd1 = '';
                    set @Vente2 = '';
                    set @TimeEnd2 = '';
                    set @Vente3 = '';
                    set @TimeEnd3 = '';
                    set @NextVente1 = '';
                    set @NextVente2 = '';
                    set @NextVente3 = '';
                    CALL GetActualProduct('".$seance->IdEntite."', @Vente1,@TimeEnd1,@Vente2,@TimeEnd2,@Vente3,@TimeEnd3, @NextVente1,@NextVente2,@NextVente3);";
        
         $core->Db->ExecuteMulti($request);
         
        //Recuperation des info dans la variable de sortie de la procédure
        $request ="SELECT @Vente1, @TimeEnd1, @Vente2, @TimeEnd2, @Vente3,@TimeEnd3, @NextVente1,@NextVente2,@NextVente3;";
        
        $result = $core->Db->GetLine($request);
        $ventes = array();
       
        //Produits en cours
        for($i=1; $i <= 3; $i++)
        {
            $vente = new EeCommerceVente($core);
            $vente->GetById($result["@Vente$i"]);
            $ventes[] = $vente;
        }
        
        //Produits suivants
        for($i=1; $i <= 3; $i++)
        {
            $vente = new EeCommerceVente($core);
            $vente->GetById($result["@NextVente$i"]);
            $ventes[] = $vente;
        }
        
        return $ventes;
    }
    
    /*
     * Obtient les deux prochain produit de la position
     */
    public static function GetLastProduct($core, $seanceId, $position)
    {
        $request ="SELECT Id FROM EeCommerceVente WHERE SeanceId = ".$seanceId." AND DateEnd is null AND Position =".$position." limit 0,2";
        $result = $core->Db->GetArray($request);
        $ventes = array();
        
        foreach($result as $res)
        {
            $vente = new EeCommerceVente($core);
            $vente->GetById($res["Id"]);
            $ventes[] = $vente;
        }
        
        return $ventes;
    }
    
    /*
     * Donne l'état et le prix actuel des produits
     */
    public static function RefreshVente($core, $shopName)
    {
        //TODO Prevoir une procedure stockée qui va gérer la mise a jour et le retour des informations
        $seance = SeanceHelper::GetActualSeance($core, $shopName);
        SeanceHelper::SaveUser($core, $seance);
        
        echo SeanceHelper::GetActualInfoProduct($core, $seance);
    }
  
    /**
     * Cloture la vente en cours pour la position 
     */
    public static function StartNewVente($core, $shopName, $seanceId, $position)
    {
        $vente = new EeCommerceVente($core);
        $vente->AddArgument(new Argument("EeCommerceVente", "SeanceId", EQUAL, $seanceId));
        $vente->AddArgument(new Argument("EeCommerceVente", "Position", EQUAL, $position));
    
        $ventes = $vente->GetByArg(true);
        
        //Vente en cours$
        $vente = $ventes[0];
        $vente->DateEnd->Value = JDate::Now();
        $vente->Save();
    }
    
    /*
     * Mémorise l'utilisateur pour la séance en cours
     */
    public static function SaveUser($core, $seance)
    {
        //Adresse Ip de l'utilisateur
        $ip = $_SERVER['REMOTE_ADDR'];
        
        $seanceUser = new EeCommerceSeanceUser($core);
        $seanceUser->AddArgument(new Argument("EeCommerceSeanceUser", "SeanceId", EQUAL, $seance->IdEntite));
        $seanceUser->AddArgument(new Argument("EeCommerceSeanceUser", "Ip", EQUAL, $ip));
        
        if(count($seanceUser->GetByArg()) == 0)
        {
              $seanceUser = new EeCommerceSeanceUser($core);
              $seanceUser->SeanceId->Value = $seance->IdEntite;
              $seanceUser->Ip->Value = $ip;
              
              $seanceUser->Save();
        }
    }
    
     /*
     * Obtient les informations actuelles sur les produits
     */
    public static function GetActualInfoProduct($core, $seances)
    {
        //Appel de la procédure stocké qui va gérer tout cela
        $request = "set @InfoProduct = '';
                    CALL GetActualInfoProduct(".$seances->IdEntite.", @InfoProduct);";
        
        $core->Db->ExecuteMulti($request);
        
        //Recuperation des info dans la variable de sortie de la procédure
        $request ="SELECT @InfoProduct as InfoProducts;";
        
        $result = $core->Db->GetLine($request);
        
        return $result["InfoProducts"];
    }
    
    /*
     * Reserve une vente
     */
    public static function Reserve($core, $venteId, $priceActual)
    {
        //Finalise la date d'arret
        $vente = new EeCommerceVente($core);
        $vente->GetById($venteId);
        
        //Si personne n'a reservé
        if($vente->DateEnd->Value == null)
        {
            $vente->DateEnd->Value = JDate::Now();
            $vente->Save();

            if($priceActual > $vente->PriceActual->Value)
            {   
                //Ajoute la ligne à la commande en cours 
                //Créer la commande si elle n'existe oas en session
                CommandeHelper::AddLine($core, $venteId, number_format($priceActual, 2));

                return "WIN";
            }
            else
            {
               return $core->GetCode("VenteGivree.ReservationImpossible"); 
            }
        }
        else
        {
            return $core->GetCode("VenteGivree.LostVente");
        }
    }
    
    /*
     * Reinitialise une seance de vente
     */
    public static function Reset($core, $seanceId)
    {
        $request = "UPDATE EeCommerceVente SET DateStart = null, DateEnd = null, PriceStart = null, PriceActual = null, PriceMini = null, TimeEnd= null WHERE SeanceId=".$seanceId  ;
    
        return $core->Db->Execute($request);
    }
    
    /*
     * Met a jour une vente
     */
    public static function UpdateVente($core, $venteId, $productId)
    {
        $vente = new EeCommerceVente($core);
        $vente->GetById($venteId);
        $vente->ProductId->Value = $productId;
        $vente->Save();
    }
    
    /*
     * Obtient la prochaine seance disponible
     */
    public static function GetNextSeance($core, $shopName)
    {
        $commerce = new EeCommerceCommerce($core);
        $commerce->GetByName($shopName);
        
        $request = "SELECT Id FROM EeCommerceSeanceVente WHERE DateStart > NOW() AND CommerceId= ".$commerce->IdEntite;
        $request .= " ORDER BY DateStart Asc Limit 0,1";
        
        $result = $core->Db->GetLine($request);
        
        
        $seance = new EeCommerceSeanceVente($core);
        $seance->GetById($result["Id"]);
        
        return $seance;
    }
    
    /*
     * Obtient les produits d'une seances
     */
    public static function GetProducts($core, $seance, $limit, $start)
    {
        $seanceVente = new EeCommerceVente($core);
        $seanceVente->AddArgument(new Argument("EeCommerceVente", "SeanceId", EQUAL, $seance->IdEntite));
        
        if($limit)
        {
            if($start != "" )
            {
                $seanceVente->SetLimit(($start * $limit) + 1, $limit);
            }
            else
            {
                $seanceVente->SetLimit(1, $limit);
            }
        }
        
        $seanceVentes = $seanceVente->GetByArg();
        $products = array();
        
        foreach($seanceVentes as $vente)
        {
            $product = new EeCommerceProduct($core);
            $product->GetById($vente->ProductId->Value);
            $products[] = $product;
        }
        
        return $products;
  }
  
  /*
   * Obtient les lke pour une seance
   */
  public static function GetLikes($core, $seanceId)
  {
      $request = "select Distinct(user.Email) as email, product.NameProduct as nameProduct 

                FROM EeCommerceVente as vente
                INNER JOIN EeCommerceLike as likes on vente.ProductId = likes.ProductId
                INNER JOIN EeCommerceProduct as product on product.Id = vente.ProductId 
                INNER JOIN ee_user as user on likes.UserId = user.Id

                WHERE SeanceId = " . $seanceId;
      
      return $core->Db->GetArray($request);
  }
  
  /*
   * Envoie la newletters pour les like
   */
  public static function ShareLike($core, $seanceId)
  {
      $users = SeanceHelper::GetLikes($core, $seanceId);
      $us = "";
      $i =0;
      $html = "";
      
      $eCommunique = Eemmys::GetApp("EeCommunique", $core);
      
      foreach($users as $user)
      {
            if($us != $user["email"])
            {
                $us = $user["email"];
                $html = "";
            }
            
            //Ajout du produit
            $html .= "<br/>". $user["nameProduct"];
                    
            //Prochaine line
            $i++;
            
            if(count($users) == $i || $users[$i]["email"] != $us)
            {
                
                //TODO VERIFIER QUE L'Utilisateur ne s'est pas desinscrit de la newletters
                //Envoie de l'email
                $eCommunique->SendEmail(EeCommuniqueEmail::EMAILLIKE, $us, $html);
            }
        }
        
        echo $this->Core->GetCode("EeCommerce.EmailSended");
  }
  
}

