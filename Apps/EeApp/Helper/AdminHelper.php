<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class AdminHelper
{
    /**
     * Ajoute un administrateur à une application 
     * @param type $core
     * @param type $appId
     * @param type $userId
     */
    public static function AddAmin($core, $appId, $userId)
    {
        $appUser = new  EeAppAdmin($core);
        $appUser->AddArgument(new Argument("EeAppAdmin", "AppId", EQUAL, $appId));
        $appUser->AddArgument(new Argument("EeAppAdmin", "UserId", EQUAL, $userId));
  
        if(count($appUser) ==  0)
        {
            $appUser = new  EeAppAdmin($core);
            $appUser->AppId->Value = $appId;
            $appUser->UserId->Value = $userId;
            $appUser->Save();
        }
    }
    
    /*
     * Obtient les administrateurs d'une app
     */
    public static function GetUserByApp($core, $appId)
    {
        $appUser = new  EeAppAdmin($core);
        $appUser->AddArgument(new Argument("EeAppAdmin", "AppId", EQUAL, $appId));
       
        return $appUser->GetByArg();
    }
    
    /**
     * Ajoute un administrateur à une application
     * @param type $core
     * @param type $appId
     * @param type $usersId
     */
    public static function AddAdmin($core, $appId, $usersId)
    { 
        $userId= explode(",", $usersId);
        
        foreach($userId as $id)
        {
            $appUser = new  EeAppAdmin($core);  
            $appUser->AppId->Value = $appId;
            $appUser->UserId->Value = $id;
            $appUser->Save();
        }
    }
    
    /*
     * Supprime un administrateur
     */
    public static function DeleteAdmin($core, $adminId)
    {
         $appUser = new  EeAppAdmin($core);  
         $appUser->GetById($adminId);
         
         $appUser->Delete();
    }
}

