<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

include("../Core/Profil/Member.php");
include("../Core/Profil/Administrator.php");

/*
 * Classe de base des profil
 */
class Profil
{
    /**
     * Obtient le menu selon le type utilisateur 
     */
    public static function GetMenu($core)
    {
    }
    
    /**
     * Obtient le tableau de bord selon le profil
     * @param type $core
     */
    public static function GetDashBoard($core)
    {
        if($core->User->Email->Value == "jerome.oliva@gmail.co")
        {
            return Administrator::GetDashBoard($core);
        }
        else
        {
            return Member::GetDashBoard($core);
        }        
    }
    
    /**
     * Obtient l'aide selonle profil
     * @param type $core
     */
    public static function GetHelp($core)
    {
         if($core->User->Email->Value == "jerome.oliva@gmail.com")
        {
            return Administrator::GetHelp($core);
        }
        else
        {
            return Member::GetHelp($core);
        }    
    }
}



?>
