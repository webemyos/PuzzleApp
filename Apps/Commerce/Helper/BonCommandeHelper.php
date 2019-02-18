<?php

/* 
 * Module utilitaire pour les bon de commande
 */
class BonCommandeHelper
{
    /*
     * Obtient les bons de commande 
     * du fournisseur de l'utilisateur
     */
    public static function GetByUser($core, $state)
    {
        //Recuperation du fournisseur
        $fournisseur = FournisseurHelper::GetByUser($core);
        
        $bonCommande = new EeCommerceBonCommande($core);
        $bonCommande->AddArgument(new Argument("EeCommerceBonCommande", "FournisseurId", EQUAL, $fournisseur->Fournisseur->Value->IdEntite));
        $bonCommande->AddOrder("Id", false);
        
        if($state != "")
        {
            $bonCommande->AddArgument(new Argument("EeCommerceBonCommande", "StateId", EQUAL, $state));
        }
        
        return $bonCommande->GetByArg();
    }
    
   
}
