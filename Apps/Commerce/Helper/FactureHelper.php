<?php

/* 
 * Gestionnaire des factures
 * et bon de commande pour les fournisseurs
 */

class FactureHelper
{
    
    /*
     * Génére la facture client et les bons de commande fournisseur
     */
    public static function GenerateFacture($core, $commande, $front = true)
    {
        //Recuperation des toutes les informations
        $request = "SELECT commande.Id as CommandeId,
                           adresseLivraison.Adress as adressLivraison,
                           adresseLivraison.Complement as complementLivraison,
                           adresseLivraison.CodePostal as codePostalLivraison,
                           (SELECT Name FROM ee_city WHERE Id = adresseLivraison.cityId ) as cityLivraison,
                           
                           adresseFacturation.Adress as adressFacturation,
                           adresseFacturation.Complement as complementFacturation,
                           adresseFacturation.CodePostal as codePostalFacturation,
                           (SELECT Name FROM ee_city WHERE Id = adresseFacturation.cityId ) as cityFacturation,
                           
                           product.NameProduct as NameProduct,
                           commandeLine.Price as Price,
                           commandeLine.PricePort as PricePort,
                           ROUND(commandeLine.Price + commandeLine.PricePort, 2) as PriceTotal,
                           fournisseur.Id as fournisseurId,
                           fournisseur.Name as fournisseur,
                           fournisseur.Adresse as adressFournisseur
            
                    FROM EeCommerceCommande as commande
                    LEFT JOIN EeCommerceCommandeLine as commandeLine on commandeLine.commandeId = commande.Id
                    LEFT JOIN EeCommerceCommandeAdresse as adresseLivraison on commande.AdresseLivraisonId = adresseLivraison.Id
                    LEFT JOIN EeCommerceCommandeAdresse as adresseFacturation on commande.AdresseFacturationId = adresseFacturation.Id
                    LEFT JOIN EeCommerceVente as vente on vente.Id = commandeLine.EntityId
                    LEFT JOIN EeCommerceProduct as product on product.Id = vente.productId
                    LEFT JOIN EeCommerceFournisseur as fournisseur ON product.fournisseurId = fournisseur.Id
                    where commandeLine.CommandeId = " . $commande->IdEntite;

        $result = $core->Db->GetArray($request);
       
        //Pour l'envoi des email
        $communique = Eemmys::GetApp("EeCommunique", $core);
               
        //Génere la facture client
       FactureHelper::GenerateFactureClient($core, $commande, $result, $communique, $front);
       
       //Génere et envoie les bon de commande aux fourniseurs
       FactureHelper::GenerateBonCommande($core, $commande, $result, $communique, $front);
    }
    
    /*
     * Genere les pdf de la facture client
     * et les bon de commande fournisseur
     */
    public static function GenerateFactureClient($core, $commande, $data, $communique, $front)
    {
        //Enregistrement de la facture
        $facture = new EeCommerceFacture($core);
        $facture->CommandeId->Value =  $commande->IdEntite;
        $facture->DateCreated->Value = JDate::Now(true);
        $facture->Numero->Value = date("Ydm").$commande->IdEntite.$core->User->IdEntite ;  
        $facture->PriceTotal->Value = CommandeHelper::GetTotal($core, $commande);  
        $facture->Save();
                 
        $idFacture = $core->Db->GetInsertedId();
        $facture->GetById($idFacture);
        
        //Generation du html a partir de la facture et des data
        $factureBlock = new FactureBlock($core);
        $html = $factureBlock->GetFacture($commande, $facture, $data);
        
        //Recuperation de l'identifiant du commerce
        $EeCommerce = new EeCommerceCommerce($core);
        $EeCommerce->GetByName("VenteGivree");
        
		
        //Enregistrement du PDF
		if($front)
		{
			$fileName = 'Data/Apps/EeCommerce/'.$EeCommerce->IdEntite.'/facture/'.$facture->Numero->Value.'.pdf';
			require_once('Library/html2pdf/html2pdf.class.php');
		}
		else
		{
			$fileName = '../Data/Apps/EeCommerce/'.$EeCommerce->IdEntite.'/facture/'.$facture->Numero->Value.'.pdf';
			require_once('../Library/html2pdf/html2pdf.class.php');
		}
		
        $html2pdf = new HTML2PDF('P','A4','fr');
        $html2pdf->WriteHTML($html);
        $html2pdf->Output($fileName, 'F');
        
        //Sauvegare du lien dans la facture
        $facture->File->Value = $fileName;
        $facture->Save();
        
        //Envoi l'email de validaton est la facture au client
        $communique->SendEmailFile(EeCommuniqueEmail::EMAILVALIDATIONCOMMANDE, $core->User->Email->Value, $fileName);
    }
    
    
    /*
     * Génére les bon de commande et envoi un email  
     * à chaque fournisseur
     */
    public static function GenerateBonCommande($core, $commande, $lines, $communique, $front)
    {
        $fournisseurId = "";
        $products =array();
        $numeroLine = 0;
        
        //Parcourt des lignes
        foreach($lines as $line)
        {
            if($line["fournisseurId"] != $fournisseurId)
            {
                $fournisseurId = $line["fournisseurId"];
                
                //Enregistrement du BonDeCommande
                $bonCommande = new EeCommerceBonCommande($core);
                $bonCommande->CommandeId->Value =  $commande->IdEntite;
                $bonCommande->StateId->Value = EeCommerceBonCommande::ATRAITER;
                $bonCommande->DateCreated->Value = JDate::Now(true);
                $bonCommande->FournisseurId->Value = $line["fournisseurId"];
                $bonCommande->Numero->Value = date("Ydm").$commande->IdEntite.$commande->IdEntite .  $line["fournisseurId"].$core->User->IdEntite;  
                $bonCommande->Save();
                
                $idBonCommande = $core->Db->GetInsertedId();
                $bonCommande->GetById($idBonCommande);
        
               //Initialisation du modele
               //Generation du html a partir de la facture et des data
               $factureBlock = new FactureBlock($core);
               $factureBlock->InitBonCommande($commande, $bonCommande, $line);
            }
            
            //Ajout de la ligne
            $factureBlock->AddLigne($line);
                    
            //Si la prochaine ligne et un fournisseur différent ou qu'il n'y a plus de ligne
            if(count($lines) == $numeroLine + 1  ||   $lines[$numeroLine + 1]["fournisseurId"] !=   $line["fournisseurId"])
            {
                $html = $factureBlock->GetBonCommande();
               
                //Recuperation de l'identifiant du commerce
                $EeCommerce = new EeCommerceCommerce($core);
                $EeCommerce->GetByName("VenteGivree");

                //Sauvegarde du pdf
                if($front)
				{
					$fileName = 'Data/Apps/EeCommerce/'.$EeCommerce->IdEntite.'/bonCommande/'.$bonCommande->Numero->Value.'.pdf';
                }
				else
				{
					$fileName = '../Data/Apps/EeCommerce/'.$EeCommerce->IdEntite.'/bonCommande/'.$bonCommande->Numero->Value.'.pdf';
            	}
				
                $html2pdf = new HTML2PDF('P','A4','fr');
                $html2pdf->WriteHTML($html);
                $html2pdf->Output($fileName, 'F');

                //Sauvegare du lien dans la facture
                $bonCommande->File->Value = $fileName;
                $bonCommande->Save();
                    
                //Recuperation du fournisseur
                $fournisseur = new EeCommerceFournisseur($core);
                $fournisseur->GetById($fournisseurId);
                
                //Envoi de l'email
                $communique->SendEmailFile(EeCommuniqueEmail::EMAILVALIDATIONBONCOMMANDE, $fournisseur->Email->Value, $fileName);
            }
            
            $numeroLine++;
        }
    }
    
     /*
     * Fait évoluer le statut du bon de commande
     */ 
    public static function UpdateBon($core, $bonCommandeId)
    {
        $bon = new EeCommerceBonCommande($core);
        $bon->GetById($bonCommandeId);
        
         //Pour l'envoi des email
        $communique = Eemmys::GetApp("EeCommunique", $core);
        
        switch($bon->StateId->Value)
        {
            case EeCommerceBonCommande::ATRAITER :
                $bon->StateId->Value = EeCommerceBonCommande::VALIDE ;
                $bon->DateValided->Value = JDate::Now(true); 
                
                $communique->SendEmailAdmin(EeCommuniqueEmail::EMAILVALIDATIONBONCOMMANDEFOURNISSEUR);
                
                FactureHelper::UpdateLine($core, $bon, EeCommerceBonCommande::VALIDE);
                break;
              case EeCommerceBonCommande::VALIDE :
                $bon->StateId->Value = EeCommerceBonCommande::EXPEDIE ; 
                $bon->DateExpedited->Value = JDate::Now(true);
                
                $communique->SendEmail(EeCommuniqueEmail::EMAILEXPEDITIONCOMMANDEFOURNISSEUR, $bon->Commande->Value->User->Value->Email->Value );
                  
                FactureHelper::UpdateLine($core, $bon, EeCommerceBonCommande::EXPEDIE);
                break;
        }
        
        $bon->Save();
    }
    
    /*
     * Met à jour les lignes du bon de commande
     */
    public static function UpdateLine($core, $bonCommande, $state)
    {
        //Recuperation des lignes
        $request = "SELECT  line.Id as lineId FROM EeCommerceBonCommande AS bon

                    INNER JOIN EeCommerceCommande AS commande ON commande.Id = bon.CommandeId
                    INNER JOIN EeCommerceCommandeLine AS line ON commande.Id = line.CommandeId
                    INNER JOIN EeCommerceVente AS vente ON vente.Id = line.EntityId
                    
                    INNER JOIN EeCommerceProduct AS product ON product.Id = vente.ProductId and bon.fournisseurId = product.fournisseurId

                    WHERE bon.Id =  " .$bonCommande->IdEntite;
        
        $lines = $core->Db->GetArray($request);
        $ids =array();
        
        foreach($lines as $line)
        {
            $ids[] = $line["lineId"];
        }
        
        $request = "Update EeCommerceCommandeLine SET StateId=".$state." WHERE Id in(".implode($ids).")";
        $core->Db->Execute($request);
    }
    
}
