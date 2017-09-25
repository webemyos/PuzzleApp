<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

class InstallHelper
{
    /**
     * Installe Webemyos (Base de donnée)
     */
    public static function InstallWebemyos($core, $serverName, $login, $password, $dataBaseName)
    {
        ini_set('max_execution_time', -1);
        ini_set( "memory_limit", "20M");
        
        self::log("Installation de webemyos");
        self::SetConfig($core, $serverName, $login, $password, $dataBaseName);
        self::InitDataBase($core, $serverName, $login, $password, $dataBaseName);
        
        //self::InitUser();
    }
    
    /*
     * Configure le fichier de configuration de la base de donnée
     */
    public static function SetConfig($core, $serverName, $login, $password, $dataBaseName)
    {
        self::log("Mise à jour de la configuration ");
        $core->ConfigDb->SetKey("DATABASESERVER", $serverName);
        $core->ConfigDb->SetKey("DATABASENAME", $dataBaseName);
        $core->ConfigDb->SetKey("DATABASELOGIN", $login);
        $core->ConfigDb->SetKey("DATABASEPASS", $password);
    }
    
    /**
     * Initialise la base de donnée
     * 
     * @param type $core
     */
    public static function InitDataBase($core, $serverName, $login, $password, $dataBaseName)
    {
        self::log("Creation de la base de données");
         
        //Creation de la base de donnée
        $link = mysql_connect($serverName, $login, $password);
        if (!$link)
        {
            die('Connexion impossible : ' . mysql_error());
        }

        $sql = 'CREATE DATABASE ' . $dataBaseName;
        if (mysql_query($sql, $link))
        {
            self::log("Base de données créée correctement\n");
        }
        else
        {
            self::log('Erreur lors de la création de la base de données : ' . mysql_error() . "\n");
        }

         //Configuration de la base de donnée
        $core->Db=new JHomDB(
                                 $core->ConfigDb->GetKey("DATABASESERVER"),
                                 $core->ConfigDb->GetKey("DATABASENAME"),
                                 $core->ConfigDb->GetKey("DATABASELOGIN"),
                                 $core->ConfigDb->GetKey("DATABASEPASS")
                         );
        
        //insertion des donnée
        self::log("Création des tables et insertion des données");
        $requete = JFile::GetFileContent("Apps/EeIde/Sql/CreateInsertData.sql");
        $core->Db->ExecuteMulti($requete);
        
        //insertion de villes
        self::log("Insertion des villes");
        $requete = JFile::GetFileContent("Apps/EeIde/Sql/InsertCity.sql");
        $core->Db->ExecuteMulti($requete, "!");
        
         //Installation de EeIde
        self::log("Installation de EeIde");
        $requete = JFile::GetFileContent("Apps/EeIde/Db/install.sql");
        $core->Db->ExecuteMulti($requete);
    }
    
    /*
     * Affiche un message d'information
     */
    public static function log($message)
    {
        echo "<br/><i class='fa fa-check' >&nbsp;</i>".$message;
    }
    
}

