<?php

/* 
 * classe utilitaire pour les adresse
 */
class AdressHelper
{
   /*
    * Sauvegarde l'adresse de livraison et facturation pour une commande
    */
    public static function SaveAdress($core, $nameLivraison, $adressLivraison, $complementLivraison, $codePostalLivraison, $cityLivraison,
                        $nameFacturation, $adressFacturation, $complementFacturation, $codePostalFacturation, $cityFacturation )
    {
       //TODO VERIFER SI L'ADRESSE EST DIFFerentes
        
        $City = new City($core);
        $City = $City->GetByName($cityLivraison);
        
        //Sauvegarde des deux adresses pour la commande en cours
        $adressLiv = AdressHelper::GetAdress($core, "Livraison", $nameLivraison, $adressLivraison, $complementLivraison, $codePostalLivraison, $City->IdEntite); 
        $adressLiv->Name->Value = $nameLivraison;
        $adressLiv->Adress->Value = $adressLivraison;
        $adressLiv->Complement->Value = $complementLivraison;
        $adressLiv->CodePostal->Value = $codePostalLivraison;
                
        $adressLiv->CityId->Value = $City->IdEntite;
        $adressLiv->TypeId->Value = EeCommerceCommandeAdresse::LIVRAISON ;
        
        $adressLiv->Save();
        
        $idAdressLivraison = $core->Db->GetInsertedId();
        
        $City = new City($core);
        $City = $City->GetByName($cityFacturation);
        
        $adressFact = AdressHelper::GetAdress($core, "Facturation", $nameFacturation, $adressFacturation, $complementFacturation, $codePostalFacturation, $City->IdEntite); 
        $adressFact->Name->Value = $nameFacturation;
        $adressFact->Adress->Value = $adressFacturation;
        $adressFact->Complement->Value = $complementFacturation;
        $adressFact->CodePostal->Value = $codePostalFacturation;
        
           
        $adressFact->CityId->Value = $City->IdEntite;
        $adressFact->TypeId->Value = EeCommerceCommandeAdresse::FACTURATION ;
        
        $adressFact->Save();
        $idAdressFacturation = $core->Db->GetInsertedId();
                
        //Sauvegarde les adresses de livraison et facturation
        CommandeHelper::SaveAdress($core, 
                                   ($adressLiv->IdEntite != "") ? $adressLiv->IdEntite:  $idAdressLivraison,
                                   ($adressFact->IdEntite != "") ? $adressFact->IdEntite:  $idAdressFacturation
                );
    }
    
    /*
     * Verifie si une adresse est identique aux donnée
     */
    public static function Equal($adresse, $name, $adress, $complement, $codePostal, $cityId)
    {
        return      $adresse->Name->Value == $name 
                &&  $adresse->Adress->Value == $adress 
                &&  $adresse->Complement->Value == $complement 
                &&  $adresse->CodePostal->Value == $codePostal 
                &&  $adresse->CityId->Value == $cityId; 
    }
    
    /*
     * Verifie si la commande en cours a dèjà une adresse 
     * Dans ce cas on modifie les données 
     * Sinon on test si il existe une adresse avec les meme données 
     * dans ce cas on racroche la commande à l'adresse
     * Sinon on ajoute une nouvelle adresse.
     */
    public static function GetAdress($core, $type, $name, $adress, $complement, $codePostal, $cityId)
    {
        $commande = CommandeHelper::GetActualCommande($core, false);
        $searchAdresse = new EeCommerceCommandeAdresse($core);
        
        if($type == "Livraison")
        {
            if($commande->AdresseLivraisonId->Value != "" && $commande->AdresseLivraisonId->Value != 0)
            {  
                //Si c'est l'adresse unique de la commande ou que les données n'on pas changé
                if(     AdressHelper::GetCountCommande($core, $type, $commande->AdresseLivraison->Value) == 1
                   ||   AdressHelper::Equal($commande->AdresseLivraison->Value,$name, $adress, $complement, $codePostal, $cityId ))
                {
                     return $commande->AdresseLivraison->Value;
                }
                else
                {
                    return new EeCommerceCommandeAdresse($core); 
                }
            }
            else
            {
                $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "TypeId", EQUAL, EeCommerceCommandeAdresse::LIVRAISON));
            }
        }
        
        if($type == "Facturation")
        {
            if($commande->AdresseFacturationId->Value != "" && $commande->AdresseFacturationId->Value != 0)
            {
                if(AdressHelper::GetCountCommande($core, $type, $commande->AdresseFacturation->Value) == 1
                    ||   AdressHelper::Equal($commande->AdresseFacturation->Value,$name, $adress, $complement, $codePostal, $cityId )
                        )
                {
                     return $commande->AdresseFacturation->Value;
                }
                else
                {
                    return new EeCommerceCommandeAdresse($core); 
                }
            }
            else
            {
                $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "TypeId", EQUAL, EeCommerceCommandeAdresse::FACTURATION));
            }
        }
        
        $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "Name", EQUAL, $name));
        $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "Adress", EQUAL, $adress));
        $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "Complement", EQUAL, $complement));
        $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "CodePostal", EQUAL, $codePostal));
        $searchAdresse->AddArgument(new Argument("EeCommerceCommandeAdresse", "CityId", EQUAL, $cityId));
          
        $adresse = $searchAdresse->GetByArg();
        
        if(count($adresse) > 0)
        {
            return $adresse[0];
        }
        else
        {
            return new EeCommerceCommandeAdresse($core); 
        }
    }
    
    /**
     * Compte le nombre de commandes qui ont cette adresse
     * @param type $adresse
     */
    public static function GetCountCommande($core, $type, $adresse)
    {
        $commande = new EeCommerceCommande($core);
        
        if($type == "Livraison")
        {
            $commande->AddArgument(new Argument("EeCommerceCommande","AdresseLivraisonId", EQUAL, $adresse->IdEntite));
        }
        if($type == "Facturation")
        {
            $commande->AddArgument(new Argument("EeCommerceCommande","AdresseFacturationId", EQUAL, $adresse->IdEntite));
        } 
        
         return count($commande->GetByArg());
    }
}

