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
use Core\Entity\User\UserToken;
use Core\Entity\Entity\Argument;


/**
 * Gestion of token
 *
 * @author OLIVA
 */
class TokenManager 
{
    /**
     * 
     */
    public static function Generate($core, $userId, $delay ="1d")
    {
        $token = bin2hex(random_bytes(32));

        $userToken = new UserToken($core);
        $userToken->AddArgument(new Argument("Core\Entity\User\UserToken", "UserId", EQUAL, $userId));
        $usToken = $userToken->GetByArg();

        //TODO DATE D'EXPIRATION

        if(count($usToken) > 0)
        {
            $usToken = $usToken[0];
            $usToken->Token->Value = $token;
            $usToken->Expire->Value = "9999";
            $usToken->Save();
        }
        else
        {
            $userToken = new UserToken($core);
            $userToken->Token->Value = $token;
            $userToken->UserId->Value = $userId;
            $userToken->Expire->Value = "9999";
            $userToken->Save();
       }
        return $token;
    }

    /**
     * Vérify if the token Is Valid
     * Return UserId if true
     */
    public static function IsValid($core, $token)
    {
        if($token == "")
        {
            return false;
        }

        $userToken = new UserToken($core);
        $userToken->AddArgument(new Argument("Core\Entity\User\UserToken", "TOKEN", EQUAL, $token));
        $usToken = $userToken->GetByArg();

        if(count($usToken) > 0)
        {
            return $usToken[0];
        }
        else
        {
            return false;
        }
    }
}