<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
class VirementHelper
{
    const STRIP_KEY = "";
    
    /*
     * Crée le paiement client
     */
    function CreateCharge($core, $commande)
    {
        require_once('./config.php');

                $total = CommandeHelper::GetTotal($this->Core);
                 
                $token  = $_POST['stripeToken'];

                $customer = \Stripe\Customer::create(array(
                    'email' => $_POST["stripeEmail"],
                    'source'  => $token
                ));

                $charge = \Stripe\Charge::create(array(
                    'customer' => $customer->id,
                    'amount'   => $total * 100,
                    'currency' => 'eur',
                    'transfer_group' => $commande->IdEntite
                ));
    }
    
    /*
     * Obtient les virements pour une commande 
     * et les différents forurniseur
     */
    function GetByCommande($core, $commande)
    {
        $request = "SELECT 
            
            fournisseur.Id as fournisseurId, 
            fournisseur.Name as fournisseur, 
            fournisseur.commission as commission ,
            count(product.Id) as nbProduct,
            GROUP_CONCAT(product.NameProduct) as NameProduct, 
            round(sum(vente.PriceActual),2) as priceTotal,
            sum(vente.PriceMini) as priceBuy,
     
            (SELECT count(Id) FROM EeCommerceVirement WHERE CommandeId = ".$commande->IdEntite.") as nbVirement,    


            Case fournisseur.Ttc
                    WHEN 1 then 'Calcul ttc'
                    WHEN 0 then 'Calcul ht'
            END as modeCalul,

            CASE fournisseur.Ttc
            WHEN 0 
	 	THEN 
                    SUM( (vente.PriceMini - (vente.PriceMini * 20 /100)) - 
		 
		       ((vente.PriceMini - (vente.PriceMini * 20 /100) )  * fournisseur.commission  /100 ) 
		       + product.PricePort )
	        WHEN 1 
                THEN
                    SUM((vente.PriceMini - (vente.PriceMini * fournisseur.commission /100) ) + product.PricePort )  
                END as Montant

                FROM EeCommerceCommande as commande
                JOIN EeCommerceCommandeLine as line on line.commandeId = commande.id
                JOIN EeCommerceVente as vente on vente.id = line.EntityId
                JOIN EeCommerceProduct as product on product.Id = vente.ProductId
                JOIN EeCommerceFournisseur as fournisseur on fournisseur.Id = product.FournisseurId

                WHERE  commande.Id = ".$commande->IdEntite."

                GROUP BY fournisseur.Id ";
        
        return $core->Db->GetArray($request);
    }
    
    /*
     * Lance les virements pour les différents fournisseurs
     */
    function DoVirement($core, $commandeId)
    {
        $commande = new EeCommerceCommande($core);
        $commande->GetById($commandeId);
        
        $virements = VirementHelper::GetByCommande($core, $commande);
         $i = 0;
         
        foreach($virements as $virement)
        {
          $vir = new EeCommerceVirement($core);  
          $vir->CommandeId->Value = $commandeId;
          $vir->FournisseurId->Value = $virement["fournisseurId"];
          $vir->Montant->Value = $virement["Montant"];
          $vir->DateCreated->Value = JDate::Now();
          $vir->Montant->Value = $virement["Montant"];
          $vir->StateId->Value = EeCommerceVirement::CREATE;
          $vir->Save();
          
          //Recuperation du fournisseur
          $fournisseur = new EeCommerceFournisseur($core);
          $fournisseur->GetById($vir->FournisseurId->Value);
          
          //Virements stripe 
           require("../config.php");
        
          \Stripe\Stripe::setApiKey($stripe["secret_key"]);
          
         // Create a Transfer to a connected account (later):
            $transfer = \Stripe\Transfer::create(array(
              "amount" => $vir->Montant->Value * 100,
              "currency" => "eur",
              "destination" => $fournisseur->StripeId->Value,
              "transfer_group" =>  $vir->CommandeId->Value,
            ));

          
          $i++;
        }
        
        
        return $i . "  virements viennent d'être effectués.";
    }
    
    /*
     * Créer un compte stripe pour le fournisseur
     */
    function CreateStripeAccount($core, $fournisseurId)
    {
        $message = "Creation du compte pour le fournisseur :". $fournisseurId;
        
        require("../config.php");
        
        \Stripe\Stripe::setApiKey($stripe["secret_key"]);

        $acct = \Stripe\Account::create(array(
            "country" => "FR",
            "type" => "custom"
        ));
        
       echo " Stripe Id = créer" . $acct["id"];
       
       //Sauvegarde de la clé Stripe pour le fournisseur
       $fournisseur = new EeCommerceFournisseur($core);
       $fournisseur->GetById($fournisseurId);
       $fournisseur->StripeId->Value = $acct["id"];
       
       $fournisseur->Save();
    }
    
     /*
     * Valide un compte stripe pour le fournisseur
     */
    function ValideStripeAccount($core, $fournisseurId)
    {
        $message = "Validation pour le fournisseur :". $fournisseurId;
        
        //Sauvegarde de la clé Stripe pour le fournisseur
        $fournisseur = new EeCommerceFournisseur($core);
        $fournisseur->GetById($fournisseurId);
       
        require("../config.php");
        
        \Stripe\Stripe::setApiKey($stripe["secret_key"]);

        $acct = \Stripe\Account::retrieve($fournisseur->StripeId->Value);
        $acct->tos_acceptance->date = time();
        // Assumes you're not using a proxy
        $acct->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];
        $acct->save();
    }
}
