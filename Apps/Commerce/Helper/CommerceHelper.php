<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Classe utilitaire des commerces
 */
namespace Apps\Commerce\Helper;

use Core\Entity\Entity\Argument;
use Apps\Commerce\Entity\CommerceCommerce;

class CommerceHelper
{
    /*
     * Retourne les commerces de l utilisateur
     */
    public static function GetByUser($core)
    {
        $commerce = new CommerceCommerce($core);
        $commerce->AddArgument(new Argument("Apps\Commerce\Entity\CommerceCommerce","UserId",EQUAL, $core->User->IdEntite));
        
        return $commerce->GetByArg();
    }
    
    /*
     * Sauvegarde un commerce
     */
    public static function SaveCommerce($core, $name, $title, $smallDescription, $longDescription)
    {
        $commerce = new CommerceCommerce($core);
        $commerce->UserId->Value = $core->User->IdEntite;
        $commerce->Name->Value = $name;
        $commerce->Title->Value = $title;
        $commerce->SmallDescription->Value = $smallDescription;
        $commerce->LongDescription->Value = $longDescription;
        
        $commerce->Save();
    }
    
    /*
     * Met à jour un commerce
     */
    public static function UpdateCommerce($core, $commerceId, $name, $title, $smallDescription, $longDescription)
    {
        $commerce = new CommerceCommerce($core);
        $commerce->GetById($commerceId);
      
        $commerce->Name->Value = $name;
        $commerce->Title->Value = $title;
        $commerce->SmallDescription->Value = $smallDescription;
        $commerce->LongDescription->Value = $longDescription;
        
        $commerce->Save();
    }
            
    /*
     * Sauvegarde une catégorie de produit pour un e commerce
     */
    public static function SaveCategory($core, $commerceId, $name, $description, $categoryId = "")
    {
        $category = new CommerceProductCategory($core);
        
        if($categoryId != "")
        {
            $category->GetById($categoryId);
        }
        
        $category->CommerceId->Value = $commerceId;
        $category->Name->Value = $name;
        $category->Description->Value = $description;
        $category->Save();
    }
    
     /*
     * Sauvegarde un fournisseur de produit pour un e commerce
     */
    public static function SaveFournisseur($core, $commerceId, $name, $contact, $email, $telephone, $adresse, $commission, $fournisseurId = "")
    {
        $fournisseur = new CommerceFournisseur($core);
        
        if($fournisseurId != "")
        {
            $fournisseur->GetById($fournisseurId);
        }
        
        $fournisseur->CommerceId->Value = $commerceId;
        $fournisseur->Name->Value = $name;
        $fournisseur->Contact->Value = $contact;
        $fournisseur->Email->Value = $email;
        $fournisseur->Telephone->Value = $telephone;
        $fournisseur->Adresse->Value = $adresse;
        
         $fournisseur->Commission->Value = $commission;
        
        $fournisseur->Save();
    }
    
     /*
     * Sauvegarde une marque de produit pour un e commerce
     */
    public static function SaveMarque($core, $commerceId, $name, $marqueId = "")
    {
        $marque = new CommerceMarque($core);
        
        if($marqueId != "")
        {
            $marque->GetById($marqueId);
        }
        
        $marque->CommerceId->Value = $commerceId;
        $marque->Name->Value = $name;
        
        $marque->Save();
    }
    
    /*
     * Sauvegarde une fiche produit
     */
    public static function SaveFiche($core, $name, $keyWord, $shortDescription, $longDescription, $categoryId, $ficheId)
    {
        
        $fiche = new CommerceFicheProduct($core);
        
        if($ficheId != "")
        {
          $fiche->GetById($ficheId);
        }
        
        $fiche->Name->Value = $name;
        $fiche->Code->Value = JFormat::ReplaceForUrl($name);
        
        $fiche->KeyWord->Value = $keyWord;
        $fiche->ShortDescription->Value = $shortDescription;
        $fiche->LongDescription->Value = $longDescription;
        $fiche->CategoryId->Value = $categoryId;
        
        $fiche->Save();
    }
    
    /*
     * Ajoute un produit à une fiche
     */
    public static function AddProductFiche($core, $ficheId, $productId)
    {
        $ficheProduct = new CommerceFicheProductProduct($core);
        $ficheProduct->FicheId->Value = $ficheId;
        $ficheProduct->ProductId->Value = $productId;
        
        $ficheProduct->Save();
    }
    
    /*
     * Supprime un produit d'un fiche
     */
    public static function RemoveProductFiche($core, $ficheProductId)
    {
        $ficheProduct = new CommerceFicheProductProduct($core);
        $ficheProduct->GetById($ficheProductId);
        
        $ficheProduct->Delete();
    }

    /**
     * sauvegarde un coupon de réduction 
     */
    public static function SaveCoupon($core, $code, $libelle, $description,
                                      $type, $reduction, $couponId)
    {
        $coupon = new CommerceCoupon($core);

        if($couponId != '')
        {
            $coupon->GetById($couponId);
        }

        $coupon->Code->Value = $code;
        $coupon->Libelle->Value = $libelle;
        $coupon->Description->Value = $description;
        $coupon->Type->Value = $type;
        $coupon->Reduction->Value = $reduction;

        $coupon->Save();
    }
}