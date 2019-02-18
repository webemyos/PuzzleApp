<?php

/* 
 *  Webemyos.
 *  Jérôme Oliva
 *  
 */

class LikeHelper
{
    
    /*
     * Ajout d'un like pour un utilisateur sur un produit
     */
    public static function AddLike($core, $productId)
    {
        //Recuperation du produit
        //$vente = new EeCommerceVente($core);
        //$vente->GetById($venteId);
        
        $like = new EeCommerceLike($core);
        $like->UserId->Value = $core->User->IdEntite;
        $like->ProductId->Value = $productId;
        $like->Save();        
    }
    
    /*
     * Ajoute l'email dans la newsletter des givres
     */
    public static function AddGivre($core, $email)
    {
        $eCommunique = Eemmys::GetApp("EeCommunique", $core);
          
        $eCommunique->AddEmailList("listegivre", $email);
    }
    
    /*
     * Obtient les favoris de l'utilisateur
     */
    public static function GetByUser($core, $userId)
    {
        $like = new EeCommerceLike($core);
        
        $like->AddArgument(new Argument("EeCommerceLike", "UserId", EQUAL, $userId));
        
        return $like->GetByArg();
    }
    
    /*
     * Délike un produit
     */
    public static function Dislike($core, $likeId)
    {
         $like = new EeCommerceLike($core);
         $like->GetById($likeId);
         
         $like->Delete();
    }
}