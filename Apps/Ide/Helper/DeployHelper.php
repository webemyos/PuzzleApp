<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;


class DeployHelper
{
    /**
     * Constante principale
     */
    const DESTINATION_FOLDER = "../Data/Apps/EeIde/Deploy";
    const SOURCE_MODELE = "../Apps/EeIde/Modele/Site";
    const SOURCE_APP = "../Apps";
    
    /*
     * Deploit l'application sur Webemyos
     */
    function Deploy($core, $projet)
    {
        // Création de repertoire de destination
        self::CreateDestinationDirectory($projet);
        
        //Copie du modèle de site
        self::CopyModele($projet);
        
        //Ajout de l'application et de ces dépendance
        self::AddApplication($core, $projet);
        
        //Remplacement des XXX-APP-XXX dans les différents fichiers
        //self::ReplaceVariable($projet);
            
        //Remplacement du nom du site dans les templates
        
        //Complie les fichiers javascript 
        
        //Creation du script de la base de donnée
        self::CreateSqlScript($core, $projet);
        
        //Passage du script de base
        
        //Passage des script Install de l'application principale et des déppendances
        
        //Modifie le fichier de configuration
        
        //Modifie le fichier Constante
    }
    
    /**
     * Créer le dossier de destination du projet 
     */
    public static function CreateDestinationDirectory($projet)
    {
        self::Log("Création du repertoire");
        
        $folder = DeployHelper::DESTINATION_FOLDER. '/'.$projet;
        
        //Supprime le repertoire si il existe
        if(file_exists($folder))
        {
            JFile::DeleteDirectory($folder);
        }
        JFile::CreateDirectory($folder);
        
        self::Log("Repertoire crée");
    }
    
    /**
     * Copie tout les fichiers modele vers le nouveau site
     */
    public static function CopyModele($projet)
    {
        self::Log("Copie de modèle de site");
         
        self::CopyRecursive(self::SOURCE_MODELE , DeployHelper::DESTINATION_FOLDER. '/'.$projet);
        
        self::Log("Modèle copié");
    }
    
    /**
     * Ajoute l'application dans le repertoie APPS et les Dependances
     */
    public static function AddApplication($core, $projet)
    {
        self::Log("Ajout des applications");
          
        self::CopyRecursive(self::SOURCE_APP.'/'.$projet , DeployHelper::DESTINATION_FOLDER. '/'.$projet.'/Apps/'. $projet);
        
        //Recuperation de l'app
        $app = Eemmys::GetApp($projet, $core);
        
        $apps = $app->GetDependance();
        
        foreach($apps as $ap)
        {
            self::CopyRecursive(self::SOURCE_APP.'/'.$ap , DeployHelper::DESTINATION_FOLDER. '/'.$projet.'/Apps/'. $ap);
        }
        
        self::Log("Applications ajoutés");
    }
    
    /**
     * Copie les fichier modèle recursivement
     * @param type $src
     * @param type $dst
     */
    function CopyRecursive($src,$dst) 
    {
        $dir = opendir($src);
        @mkdir($dst);
        while(false !== ( $file = readdir($dir)) )
        {
            if (( $file != '.' ) && ( $file != '..' ))
            {
                if ( is_dir($src . '/' . $file) ) 
                {
                    self::CopyRecursive($src . '/' . $file,$dst . '/' . $file);
                }
                else
                {
                    copy($src . '/' . $file,$dst . '/' . $file);
                }
            }
        }
        closedir($dir);
   } 
   
   /**
    * Remplace les variables dans les différents fichiers
    */
   function ReplaceVariable($projet)
   {
   }
   
   /**
    * Créer le fichier sql
    */
   public static function CreateSqlScript($core, $projet)
   {
       self::Log("Création du scripte de base de donnée");
       
       //Récuperation du script de base
       $sql = JFile::GetFileContent(self::SOURCE_MODELE. "/Db/base.sql");
       
        //Recuperation de l'app
        $app = Eemmys::GetApp($projet, $core);
        
        $apps = $app->GetDependance();
        
        foreach($apps as $ap)
        {
            self::Log("Ajout du script de : " . $ap );
           $sql .= JFile::GetFileContent(self::SOURCE_APP."/".$ap. "/Db/install.sql");
        }
        
        JFile::SetFileContent( DeployHelper::DESTINATION_FOLDER. '/'.$projet."/Db/install.sql",  $sql);
        
        self::Log("Script crée");
   }
   
   /**
    * Affiche un message d'information
    */
   public static function Log($message)
   {
       echo "\n\r-- ".date("H::m")." : ".$message;
   }
}      

?>
