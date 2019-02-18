<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  Classe utilitaire des fournisseur
 * 
 */

class FournisseurHelper
{
    /*
     * Obtient le fournisseur de l'uilisateur
     */
    public static function GetByUser($core)
    {
       $userFournisseur = new EeCommerceUserFournisseur($core);
       $userFournisseur->AddArgument(new Argument("EeCommerceUserFournisseur", "UserId", EQUAL, $core->User->IdEntite ));
       
       $fournisseur = $userFournisseur->GetByArg();
       return $fournisseur[0];
    }
    
    /*
     * Obtient les utilisateurs d'un fournisseur
     */
    public static function GetUsers($core, $fournisseurId)
    {
       $userFournisseur = new EeCommerceUserFournisseur($core);
       $userFournisseur->AddArgument(new Argument("EeCommerceUserFournisseur", "FournisseurId", EQUAL, $fournisseurId ));
       
       return  $userFournisseur->GetByArg();
    }
    
    /*
     * Ajoute une utilisateur à un fournisseur
     */
    public static function AddUser($core, $fournisseurId, $userId)
    {
          $userFournisseur = new EeCommerceUserFournisseur($core);
          $userFournisseur->FournisseurId->Value = $fournisseurId;
           $userFournisseur->UserId->Value = $userId;
          $userFournisseur->Save();
    }
    
    /*
     * Supprime un utilisateur à un fournisseur
     */
    public static function RemoveUser($core, $userId)
    {
         $userFournisseur = new EeCommerceUserFournisseur($core);
        $userFournisseur->GetById($userId);
        $userFournisseur->Delete();
    }
}
