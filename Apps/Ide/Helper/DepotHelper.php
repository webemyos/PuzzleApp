<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;




class DepotHelper
{
    /*
     * Information du FTP
     */
    const SERVER = "jhomsoft.fr";
    const USER = "u54760702";
    const PASSWORD = "jjoliva";
    const PORT = "";
    
    
    /*
     * COnnection au serveur FTP
     */
    public static function Connect()
    {
    echo "connection";
        //Connection ftp
        $ftp = new FtpHelper(DepotHelper::SERVER, DepotHelper::USER, DepotHelper::PASSWORD, DepotHelper::PORT); 
        
        if($ftp->connect()) 
        {
            return $ftp;
        }
        else
        {
            echo "Can't connect";
        }
        
    }
    
    /*
     * Télecharge un dépot
     */
    public static function Upload($core, $depot)
    {
        //Connection ftp
        $ftp = self::Connect(); 
      
        //On se positionne dans le repertoire Apps
        chdir("../");
        chdir("Apps/");
        
        //On récupére le dossier
        $ftp->GetFolder($depot);
        
        if(file_exists("../Apps/".$depot))
        {
            echo "<span class='success' >Le dépot ".$depot." à bien été ajouté</span>";
        }
    }
    
    /*
     * Obtient les dépot disponibles
     */
    public static function GetDepots()
    {
        $ftp = self::Connect();
        
        echo "Connection OK";

      //  $ftp->cd("WebemyosDevelloper");
        print_r($ftp->ls());
        
        //return $ftp->ls("Apps");
    }
    
    /**
     * Obtient les dépots de l'utilisateurs
     */
    public static function GetMyDepots()
    { 
        $folderName = dir("../Apps/");
        $folders = array();
        
       while($file = $folderName->read())
	  {
	   if(   ($file != ".") && ($file != "..") && ($file != "EeIde") && ($file != "EeInfo") 
              && ($file != "EeNotify")  && ($file != "EeBug") && ($file != "EeProfil") )
	   {
	     $folders[] = $file;
	   }
	  }
          
	  $folderName->close();
          
          return $folders;
    }
    
    /**
     * Supprime une dépot
     */
    public static function Delete($core, $depot)
    {
        $path = "../Apps/".$depot;
        
        JFile::RemoveAllDir($path);
        
        if(!file_exists("../Apps/".$depot))
        {
            echo "<span class='success' >Le dépot ".$depot." à bien été supprimé</span>";
        }
 
        //TODO Il faudrait aussi supprimer les tables en base de donnée
 
        //Si le dépot fait partie d'un projet on supprime aussi le projet
        $projet = new EeIdeProjet($core);
        $projet->AddArgument(new Argument("EeIdeProjet", "Name", EQUAL, $depot));
        $projets = $projet->GetByArg();
        
        if(count($projets) > 0)
        {
            $projets[0]->Delete();
        }
    }
    
    /*
     * Dépots des projets utilisateurs
     */
    public static function GetMyProjectDepots($core)
    {
        $projets = new EeIdeProjet($core);
        $projets->AddArgument(new Argument("EeIdeProjet", "UserId", EQUAL, $core->User->IdEntite));
        
        return $projets->GetByArg();
    }
    
    /*
     * Commit un dépot utilisateur
     */
    public static function Commit($depot)
    {
        //Connection ftp
        $ftp = self::Connect(); 
      
        //On se positionne dans le repertoire Apps
        chdir("../");
        chdir("Apps/");
        
        //On récupére le dossier
        $ftp->SetFolder($depot);
        
    }
}

