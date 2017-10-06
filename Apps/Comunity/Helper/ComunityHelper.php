<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Helper;

use Apps\Comunity\Entity\ComunityComunity;
use Apps\Comunity\Entity\ComunityUser;
use Core\Entity\Entity\Argument;

class ComunityHelper
{
    /**
     * Obtient les communautées
     */
    public static function GetAll($core)
    {
        $comunity = new ComunityComunity($core);
        
        return $comunity->GetAll();
    }
    
    /**
     * Ajotue une communauté à un utilisateur
     * @param type $core
     * @param type $comunityId
     */
    public static function Add($core, $comunityId)
    {
        $comunityUser = new ComunityUser($core);
        $comunityUser->UserId->Value = $core->User->IdEntite;
        $comunityUser->ComunityId->Value = $comunityId;
        return $comunityUser->Save();
    }
    
    /**
     * Supprime une communauté de l'utilisateur
     * @param type $core
     * @param type $comunityId
     */
    public static function remove($core, $comunityId)
    {
         $comunityUser = new ComunityUser($core);
         $comunityUser->GetById($comunityId);
         $comunityUser->Delete();
    }
    
    /*
     * Récupere les communauté de l'utilisateur
     */
    public static function GetByUser($core)
    {
       $comunityUser = new ComunityUser($core);
        $comunityUser->AddArgument(new Argument("ComunityUser", "UserId", EQUAL, $core->User->IdEntite));
        
        return $comunityUser->GetByArg();
    }
    
    /**
     * Vérifie si l'utilisateur à la communauté
     * 
     * @param type $core
     * @param type $comunityId
     */
    public static function UserHave($core, $comunityId)
    {
        $comunityUser = new ComunityUser($core);
        $comunityUser->AddArgument(new Argument("ComunityUser", "UserId", EQUAL, $core->User->IdEntite));
        $comunityUser->AddArgument(new Argument("ComunityUser", "ComunityId", EQUAL, $comunityId));
    
        return (count($comunityUser->GetByArg()) > 0 );
    }
    
    /**
     * Obtient une requete permettant d'obtenir les communauté de l'utilisateur
     */
    public static function GetRequestByUser($core)
    {
        $request = "SELECT ComunityId FROM ComunityUser WHERE UserId = ".$core->User->IdEntite;
         $request .= " union select 1 as ComunityId "; 
        return $request;
    }
}


?>
