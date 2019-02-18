<?php

/* 
 * Gestion de l'administration
 */
class AdminHelper
{
    public static function SaveUser($core, $userId, $name, $firstName, $email, $groupId )
    {
        $user = new User($core);
        
        if($userId != "")
        {
            $user->GetById($userId);
        }
        
        $user->Name->Value = $name;
        $user->FirstName->Value = $firstName;
        $user->Email->Value = $email;
        $user->GroupeId->Value = $groupId;
        $saved = $user->Save();
        
        //Envoi email pour initialiser le mot de passe et la premier connexion
        if($saved && $userId == "")
        {
            //Utilisation du PassBlock Send Email pour envoyer l'email de reinit de mot de passe
            $passBlock = new PassBlock($core);
            $passBlock->SendEmail($email);
        }
        
        return $saved;
    }
}

