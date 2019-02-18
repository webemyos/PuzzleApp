<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */

class CommandeHelper
{
    /*
     * Ajoute un ligne à a commande en cours 
     * OU la cée si elle n'existe pas
     */
    public static function AddLine($core, $entityId, $price)
    {
        //Recuperation de la commande en cours
        $commande = CommandeHelper::GetActualCommande($core, true);
        
        //Enregistremet de la ligne
        $line = new EeCommerceCommandeLine($core);
        $line->CommandeId->Value= $commande->IdEntite;
        $line->EntityId->Value = $entityId;
        $line->StateId->Value = EeCommerceCommande::BROUILLON;
        
        //TODO COMPRENDRE POURQUOI IL ME UNE VIRUGLE pour les MILLIEME
        $line->Price->Value = str_replace(",", "",$price);
        
        //Recuperation des frais de port
        $vente = new EeCommerceVente($core);
        $vente->GetById($entityId);
                
        $product = new EeCommerceProduct($core);
        $product->GetById($vente->ProductId->Value);
        
        $line->PricePort->Value = $product->PricePort->Value;
        
        $line->Save();
    }
    
    /*
     * Obtient la commande en cours 
     * OU la crée si elle est nouvelle
     */
    public static function GetActualCommande($core, $create)
    {
        $idCommande = JVar::GetSession("CommandeId");
        $commande = null;
        
        //La commande n'existe pas on la crée et sauvegarde en session
        if($idCommande == false)
        {
            if($create)
            {
                $commande = new EeCommerceCommande($core);
                
                //On rattache la commande à l'utilisateur si il est connecté
                if(JVar::IsConnected($core))
                {
                   $commande->UserId->Value = $core->User->IdEntite;
                  
                }
                //On met l'utilisateur par défaut
                else
                {
                    $commande->UserId->Value= 1; 
                }
                                
                $commande->StateId->Value = EeCommerceCommande::BROUILLON;
                $commande->DateCreated->Value = JDate::Now(true);
                $commande->Save();

                $idCommande = $core->Db->GetInsertedId();
                $commande->GetById($idCommande);

                JVar::SetSession("CommandeId", $idCommande);
            }
        }
        //On recupere la commande en cours
        else
        {
             $commande = new EeCommerceCommande($core);
             $commande->GetById($idCommande);
             
             //On rattache la commande à l'utilisateur
             if($commande->UserId->Value == 1 && JVar::IsConnected($core))
             {
                $commande->UserId->Value = $core->User->IdEntite;
                
                //Generation d'un numéro de commande
                $commande->Numero->Value = CommandeHelper::GenerateNumber($commande);
                
                $commande->Save();
             }
        }
        
        return $commande;
    }
    
    /*
     * Generer un numero de commande
     */
    public static function GenerateNumber($commande)
    {
        return date("Ydm").$commande->IdEntite.$commande->UserId->Value;
    }
    
    /*
     * Obtient le nombre de produit de la commande en cours
     */
    public static function GetNumberProduct($core)
    {
        return count(CommandeHelper::GetProducts($core));
    }
    
    /**
     * Obtient les produits de la commande en cours
     * @param type $commande
     */
    public static function GetProducts($core, $commande ="")
    {
        if($commande == "")
        {
            $commande = CommandeHelper::GetActualCommande($core, false);
        }
        
        if($commande != null)
        {
           $products = new EeCommerceCommandeLine($core);
           $products->AddArgument(new Argument("EeCommerceCommandeLine", "CommandeId", EQUAL, $commande->IdEntite ));

           return $products->GetByArg();
        }
    }
    
    /*
     * Vide le panier
     */
    public static function ClearCard()
    {
         unset( $_SESSION["CommandeId"]);
    }
    
    /*
     * Supprime un produit du panier
     */
    public static function RemoveProduct($core, $venteId)
    {
        $line = new EeCommerceCommandeLine($core);
        $line->GetById($venteId);
        $line->Delete();
    }
    
    /*
     * Obtient le total de la commande
     */
    public static function GetTotal($core, $commande = "")
    {
        if($commande == "")
        {
            $commande = CommandeHelper::GetActualCommande($core, false);
        }
        
        $request = "SELECT sum(round(line.Price + line.pricePort, 2)) as total FROM EeCommerceCommande as commande
                    JOIN EeCommerceCommandeLine as line on line.CommandeId = commande.Id
                    WHERE commande.Id = " .$commande->IdEntite;
        
        $result = $core->Db->GetLine($request);
        
        return $result[total];
    }
    
    /*
     * Sauvegarde les adresses pour la commande en cours
     */
    public static function SaveAdress($core, $idAdressLivraison, $idAdressFacturation)
    {
        $commande = CommandeHelper::GetActualCommande($core, false);
        
        if($idAdressLivraison != "")
        {
            $commande->AdresseLivraisonId->Value = $idAdressLivraison;
        }
        
        if($idAdressFacturation != "")
        {
            $commande->AdresseFacturationId->Value = $idAdressFacturation;
        }
        $commande->Save();
    }
    
    /*
     * Obtient l'adresse de la commande en cour ou l'ancienne adresse
     */
    public static function GetAdresse($core, $type)
    {
        $commande = CommandeHelper::GetActualCommande($core, false);
        
        //On propose l'adresse de la dernier commande
        $request = "SELECT Id FROM EeCommerceCommande WHERE UserId = " . $core->User->IdEntite . " Order BY Id Desc limit 1,1;";
        $result = $core->Db->GetLine($request);

        $lastCommande = new EeCommerceCommande($core);
        $lastCommande->GetById($result[Id]);
                
        if($type == "Livraison")
        {
            if($commande->AdresseLivraisonId->Value != "" && $commande->AdresseLivraisonId->Value != 0)
            {
                return $commande->AdresseLivraison->Value;
            }
            else if($lastCommande != null)
            {
                return $lastCommande->AdresseLivraison->Value;
            }
        }
        else if($type == "Facturation")
        {
             if($commande->AdresseFacturationId->Value != "" && $commande->AdresseFacturationId->Value != 0)
            {
                return $commande->AdresseFacturation->Value;
            }
            else if($lastCommande != null)
            {
                return $lastCommande->AdresseFacturation->Value;
            } 
        }
    }
    
    /*
     * Met à jour la commande
     */
    public static function UpdateCommande($core, $statut)
    {
        $commande = CommandeHelper::GetActualCommande($core, false);
        
        switch($statut)
        {
            case EeCommerceCommande::VALIDE :  
                if($commande->StateId->Value == EeCommerceCommande::BROUILLON)
                {
                    $commande->StateId->Value = EeCommerceCommande::VALIDE;
                    $commande->DateValidation->Value = JDate::Now(true);
                    
                    //Generation d'un numéro de commande
                    $commande->Numero->Value = CommandeHelper::GenerateNumber($commande);
                    
                    //Enregistre et créer les différentes facture et bon de commande
                    FactureHelper::GenerateFacture($core, $commande);
                    
                    //Met à jour les stocks
                    ProductHelper::UpdateStock($core, $commande);
                    
                    //On vide la panier
                    CommandeHelper::ClearCard();
                    
                    //TODO VIDER LE PANIER POUR NE PAS REPASSER LA COMMANDE
                  }
            break;
        }
        
         $commande->Save();
    }
    
    /*
     * Obtient les commandes de l'utiloisateur
     */
    public static function GetByUser($core, $userId)
    {
        $commande = new EeCommerceCommande($core);
        $commande->AddArgument(new Argument("EeCommerceCommande", "UserId", EQUAL, $userId));
        $commande->AddOrder("Id");
        $commandes = $commande->GetByArg();
        
        if(count($commandes) > 0 )
        {
           return $commandes; 
        }
        else
        {
            return array();
        }
    }
    
    /*
     * Selectionne une réference pour uen ligne
     */
    public static function SelectReference($core, $lineId, $referenceId)
    {
        $line = new EeCommerceCommandeLine($core);
        $line->GetById($lineId);
        $line->ReferenceId->Value = $referenceId;
        
        $line->Save();
    }
}