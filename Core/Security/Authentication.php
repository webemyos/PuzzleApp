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
    public function CreateUser($core, $email, $pass, $verify)
    {
        if($pass != $verify)
        {
            return $core->GetCode("Base.PassNotEqual");
        }
        
        $User = new User($core);
        $User->Email->Value = $email;
        
        if($User->Exist())
        {
            return $core->GetCode("Base.UserExist");
        }
        
        $User->PassWord->Value = $pass;
        $User->GroupeId->Value = 2;
        $User->Save();
        
    }
    
}
