<?php

/* 
 * Module de generation des fatures
 * Format HTML et Pdf
 */

class FactureBlock 
{
    private $Core;
    
    public function FactureBlock($core)
    {
        $this->Core = $core;
    }
   
    /*
     * Obtient le html d'une facture
     */
    public function GetFacture($commande, $facture, $data)
    {
         $modele = new JModele("Apps/EeCommerce/Blocks/FactureBlock/View/Facture.html", $this->Core); 
        
         //Information sur la facture
         $modele->AddElement(new Text("factureNumero", false, $facture->Numero->Value));
         $modele->AddElement(new Text("factureDate", false, $facture->DateCreated->Value));
         
         //Adresse de livraison
         $modele->AddElement(new Text("adressLivraison", false, JFormat::ReplaceString($data[0]["adressLivraison"])));
         $modele->AddElement(new Text("complementLivraison", false, JFormat::ReplaceString($data[0]["complementLivraison"])));
         $modele->AddElement(new Text("codePostalLivraison", false, JFormat::ReplaceString($data[0]["codePostalLivraison"])));
         $modele->AddElement(new Text("cityLivraison", false, JFormat::ReplaceString($data[0]["cityLivraison"])));
         
         //Adresse de facturation
         $modele->AddElement(new Text("adressFacturation", false, JFormat::ReplaceString($data[0]["adressFacturation"])));
         $modele->AddElement(new Text("complementFacturation", false, JFormat::ReplaceString($data[0]["complementFacturation"])));
         $modele->AddElement(new Text("codePostalFacturation", false, JFormat::ReplaceString($data[0]["codePostalFacturation"])));
         $modele->AddElement(new Text("cityFacturation", false, JFormat::ReplaceString($data[0]["cityFacturation"])));
        
         //Ajout des lignes
         $modele->AddElement($data);
        
         //Total
          $modele->AddElement(new Text("total", false, CommandeHelper::GetTotal($this->Core, $commande)));
        
         return $modele->Render();
    }
    
    //Initialise un bon de commande
    public function InitBonCommande($commande, $bonCommande, $line)
    {
          $this->modele = new JModele("Apps/EeCommerce/Blocks/FactureBlock/View/BonCommande.tpl", $this->Core);
          
           //Information sur le bon de commande
         $this->modele->AddElement(new Text("BonCommandeNumero", false, $bonCommande->Numero->Value));
         $this->modele->AddElement(new Text("BonCommandeDate", false, $bonCommande->DateCreated->Value));
         
         //Adresse de livraison
         $this->modele->AddElement(new Text("adressLivraison", false, JFormat::ReplaceString($line["adressLivraison"])));
         $this->modele->AddElement(new Text("complementLivraison", false, JFormat::ReplaceString($line["complementLivraison"])));
         $this->modele->AddElement(new Text("codePostalLivraison", false, JFormat::ReplaceString($line["codePostalLivraison"])));
         $this->modele->AddElement(new Text("cityLivraison", false, JFormat::ReplaceString($line["cityLivraison"])));

         //Fournisseur
         $this->modele->AddElement(new Text("fournisseur", false, JFormat::ReplaceString($line["fournisseur"])));
         $this->modele->AddElement(new Text("adressFournisseur", false, JFormat::ReplaceString($line["adressFournisseur"])));
        
         
          
          $this->lines = array();
    }
    
    /*
     * Ajoute une lines
     */
    public function AddLigne($line)
    {
        $this->lines[] = $line;
    }
    
    /*
     * Retourne le html du bon de commande
     */
    public function GetBonCommande()
    {
        $this->modele->AddElement($this->lines);
        
        return $this->modele->Render();
    }
}