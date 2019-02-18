<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

class Request
 {
    public static $IdEntity;

//Retourne la version
    function __constructeur()
    {
        $this->Version = "2.0.0.0";
    }

    //Recupere une variable de type Get
    public static function Get($name)
    {
        return (isset($_GET[$name]))?($_GET[$name]):false;
    }

    /*
     * Define if Data Posted
     */
    public static function IsPost()
    {
        return count($_POST) > 0;
    }

    //Recupere une variable de type Post
    public static function GetPost($name="")
    {
        if($name != "")
            return (isset($_POST[$name]))?($_POST[$name]):false;
        else
            return $_POST;
    }

    //Recupere une variable de session
    public static function GetSession($name)
    {
            return (isset($_SESSION[$name]))?($_SESSION[$name]):false;
    }

    //Initialise un variable de session
    public static function SetSession($name,$value)
    {
            $_SESSION[$name] = $value;
    }

    //Supprime une variable de session
    public static function ClearSession($name)
    {
            unset($_SESSION[$name]);
    }

    /* Recupere une variable de type Server
     * @param $name nom de la variable
     * \return la valeur de la variable ou false si elle n'existe pas \n ou toutes les variable Post
     */
    public static function GetServer($name="")
    {
            if($name != "")
                    return (isset($_SERVER[$name]))?($_SERVER[$name]):false;
            else
                    return $_SERVER;
    }

    //Connecte un utilisateur
    public static function Connect($user,$group="", $core="" , $userId = "")
    {
        //Nom du site
        $siteName = Core::getInstance()->GetSiteName();

        Request::SetSession(md5($siteName."_Log"),"Ok");

        if($userId != "")
        {
              Request::SetSession(md5($siteName."_User"), $userId);
        }
        else
        {
            Request::SetSession(md5($siteName."_User"),$user->IdEntite);
        }

        if($group != "")
        {
            Request::SetSession(md5($siteName."_Group"), $group); 
        }
        else
        {
            Request::SetSession(md5($siteName."_Group"),$user->GroupeId->Value);
        }

            //Met a jour la date de connection
            //User::UpdateDateConnect($core, $user->IdEntite);
    }

    //Deconnecte l'utilisateur
    public static function Disconnect($core)
    {
        //Nom du site
        $siteName = $core->GetSiteName();

        //suppression des variable de session
        Request::ClearSession(md5($siteName."_Log"));
        Request::ClearSession(md5($siteName."_User"));
        Request::ClearSession(md5($siteName."_Group"));
    }

    //Verifie la connection d'un utilisteur
    public static function IsConnected($core)
    {
        //Nom du site
        $siteName = $core->GetSiteName();

        if((Request::GetSession(md5($siteName."_Log"))) && Request::GetSession(md5($siteName."_Log"))=="Ok")
                return true;
        else
                return false;
    }

    //Retourne l'identifiant de l'utilisateur connect�
    public static function GetUser($core)
    {
            //Nom du site
            $siteName = $core->GetSiteName();

            if(Request::IsConnected($core))
                    return Request::GetSession(md5($siteName."_User"));
            else
                    return false;
    }

    //Retourne le groupe de l'utilisateur connect�
    public static function GetUserGroup($core)
    {
    //Nom du site
        $siteName = $core->GetSiteName();

        if(Request::IsConnected($core))
                return Request::GetSession(md5($siteName."_Group"));
        else
                return false;
    }

    //Retourne l'identifiant de l'entite
    public static function IdEntity()
    {
            return JVar::GetPost("IdEntity");
    }

    //Asseceurs
    public function __get($name)
    {
            return JVar::GetPost(self::$name);
    }

    public function __set($name,$value)
    {
            $this->$name=$value;
    }
}
?>
