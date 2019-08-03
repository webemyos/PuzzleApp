<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Security;

use Core\Core\Core;
use Core\Entity\User\User;


/**
 * Description of Authentication
 *
 * @author OLIVA
 */
class Authentication 
{
    /*
     * Connecte the user
     */
    public static function Connect($login, $password)
    {
        $core = Core::getInstance();
        
        $user = new User($core);
        $user = $user->GetByEmail($login);
        
        if($user !== false)
        {
            if($user->PassWord->Value == md5($password))
            {
                //Connect the User
                $core->Connect($user);
                
                return true;
            }
            else
            {
                return $core->GetCode("Base.IncorrectPass");
            }
        }
        else
        {
            return $core->GetCode("Base.UnkwonUser");
        }
    }
    
    /*
     * Create User
     */
    public static function CreateUser($core, $email, $pass, $verify)
    {
        if($pass != $verify)
        {
            return $core->GetCode("Base.PassNotEqual");
        }
        
        $User = new User($core);
        $User->Email->Value = $email;
        
        if($User->Exist($email))
        {
            return $core->GetCode("Base.UserExist");
        }
        
        $User->PassWord->Value = $pass;
        $User->GroupeId->Value = 2;
        $User->Save();
    }

    /**
     * Met à jour le password User
     */
    public static function UpdatePassword($core, $user, $password, $verify)
    {
        if($password == $verify)
        {
            $request = "Update ee_user set PassWord = '" .md5($password)."' where Id=" . $user->IdEntite ;
            $core->Db->Execute($request);

            return "Ok";
        }
        else
        {
            return $core->GetCode("PassNotEqual");
        }   
    }
}
