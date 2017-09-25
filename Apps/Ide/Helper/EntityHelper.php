<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

use Apps\Ide\Ide;
use Core\Utility\File\File;


class EntityHelper
{
    /**
     * Crée une entity
     * Fichier php et fichier sql
     * 
     * @param type $core
     */
    public static function CreateEntity($core, $name, $shared, $projet, $fields, $keys)
    {
        //Creation du fichier php
        self::CreateFile($core, $name, $shared, $projet, $fields);
        
        //Creation du fichier sql
        self::CreateSql($core, $name, $shared, $projet, $fields, $keys);
        
        //Enregistre l'entité
        self::RegisterEntity($core, $name, $projet);
    }
    
    /**
     * Créer le fichier de l'entity
     */
    public static function CreateFile($core, $name, $shared, $projet, $fields)
    {
         $newLigne = "\r\n";
         $tab = "\t";
         $openAccolade = "{";
         $closeAccolade = "}";
                 
         //
         $content = "<?php ";
         
         //Cartouche
         $content .= $newLigne."/*";
         $content .= $newLigne."* PuzzleApp";
         $content .= $newLigne."* Webemyos";
         $content .= $newLigne."* Jérôme Oliva";
         $content .= $newLigne."* GNU Licence";
         $content .= $newLigne."*/";
    
         $content .= $newLigne.$newLigne."namespace Apps\XXX\Entity;";
         $content .= $newLigne."use Core\Entity\Entity\Entity;";
         $content .= $newLigne."use Core\Entity\Entity\Property;";
         $content .= $newLigne."use Core\Entity\Entity\EntityProperty;";
  
         $content .= $newLigne.$newLigne."class ".$name." extends Entity  ";
         $content .= $newLigne.$openAccolade;
         $content .= $newLigne.$tab."//Constructeur";
         $content .= $newLigne.$tab.'function __construct($core)';
         $content .= $newLigne.$tab.$openAccolade;
         
         //Propriete de base
         $content .= $newLigne.$tab.$tab.'//Version'; 
	 $content .= $newLigne.$tab.$tab.'$this->Version ="2.0.0.0"; ';
         $content .= $newLigne.$newLigne.$tab.$tab.'//Nom de la table ';
         $content .= $newLigne.$tab.$tab.'$this->Core=$core; ';
	 $content .= $newLigne.$tab.$tab.'$this->TableName="'.$name.'"; ';
	 $content .= $newLigne.$tab.$tab.'$this->Alias = "'.$name.'"; ';
         $content .= $newLigne;
         
         //Ajout des champs
          $fields = explode("!!", $fields);
          
          foreach($fields as $field)
          {
              $data = explode("-_", $field);
              
              switch($data[1])
              {
                  case 0:
                      $type = "NUMERICBOX";
                   break;
                  case 1:
                      $type = "TEXTBOX";
                   break;
                   case 2:
                      $type = "TEXTAREA";
                   break;
                   case 3:
                      $type = "DATEBOX";
                   break;
              }
              
              if($data[2] == 0)
              {
                  $null = "true";
              }
              else
              {
                  $null = "false";
              }
              
              $content .= $newLigne.$tab.$tab. '$this->'.$data[0].' = new Property("'.$data[0].'", "'.$data[0].'", '.$type.',  '.$null.', $this->Alias); ';
          }
          
         if($shared)
         {
          //Entite partage entre appli
          $content .= $newLigne.$newLigne.$tab.$tab.'//Partage entre application ';
	  $content .= $newLigne.$tab.$tab.'$this->AddSharedProperty();';
          
         }
          //Creation
          $content .= $newLigne.$newLigne.$tab.$tab.'//Creation de l entité ';
	  $content .= $newLigne.$tab.$tab.'$this->Create(); ';
          
         $content .= $newLigne.$tab.$closeAccolade;
         $content .= $newLigne.$closeAccolade;
         $content .= $newLigne."?>"; 
         
          //Enregistrement
         $directory = Ide::$Destination; 
        // $file = "../Data/Apps/Ide/".$projet."/Entity/".$name.".php";
          $file = $directory."/".$projet."/Entity/".$name.".php";
           
         File::Create($file, $content);
    }
    
    /**
     * Créer le fichier SQL
     * @param type $core
     * @param type $name
     * @param type $projet
     * @param type $fields
     */
    public function CreateSql($core, $name, $shared, $projet, $fields, $keys)
    {
         $newLigne = "\r\n";
         $content = "";
         
        $content = "CREATE TABLE IF NOT EXISTS `".$name."` ( ";
        $content .= $newLigne."`Id` int(11) NOT NULL AUTO_INCREMENT, "; 
        
        //Ajout des champs
        $fields = explode("!!", $fields);
          
          foreach($fields as $field)
          {
              $data = explode("-_", $field);
              
              switch($data[1])
              {
                  case 0:
                      $type = "INT";
                   break;
                  case 1:
                      $type = "VARCHAR(200)";
                   break;
                   case 2:
                      $type = "TEXT";
                   break;
                   case 3:
                      $type = "DATE";
                   break;
              }
              
              if($data[2] == 0)
              {
                  $null = " NULL ";
              }
              else
              {
                  $null = " NOT NULL";
              }
              
              $content .= $newLigne."`".$data[0]."` ".$type." ". $null. ",";
          }
          
           if($shared)
           {
            $content .=  $newLigne."`AppName` VARCHAR(200)  NULL ,";
            $content .=  $newLigne."`AppId` INT  NULL ,";
            $content .=  $newLigne."`EntityName` VARCHAR(200)  NULL ,";
            $content .=  $newLigne."`EntityId` INT  NULL ,";
           }
        
          //Ajout des clé étrangères
           $content .= $newLigne."PRIMARY KEY (`Id`)";
           
          //Ajout des champs
          if($keys != "")
          {
              $content .= ",";
               
             $keys = explode("!!", $keys);
             $index = 0;
          
               foreach($keys as $key)
               {
                   $data = explode("-_", $key);
                   $content .= $newLigne."CONSTRAINT `".$data[0]."_".$name."` FOREIGN KEY (`".$data[2]."`) REFERENCES `".$data[0]."`(`".$data[1]."`)";

                   $index++;

                   if($index < count($keys) )
                   {
                       $content .= ",";
                   }
               }
          }
           
           $content .= $newLigne.") ENGINE=InnoDB  DEFAULT CHARACTER SET `utf8`; ";
           
          //Enregistrement
         $directory = Ide::$Destination; 
         
           $file = $directory."/".$projet."/Db/".$name.".sql";
          File::Create($file, $content);
   
          //TODO AJOUTER LE SCRIPT DANS LE FICHIER INSTALL.SQL
          self::AddToInstall($core, $projet, $name, $content);
          
          //Ajout dans le fichier de suppression
          self::AddToUninstall($core, $projet, $name);
          
          
          //Execution de la requete
          $core->Db->execute($content);
        }
        
    /**
     * Ajoute le script au fichier Install
     * @param type $core
     * @param type $projet
     * @param type $name
     * @param type $content
     */
     public static function AddToInstall($core, $projet, $name, $content)
     {
         $directory = Ide::$Destination; 
         $file = $directory."/".$projet."/Db/install.sql";
         
         if(!file_exists($file))
         {
             File::Create($file, $content);
         }
         else
         {
            File::Append($file, "\r\n\n".$content);   
         }
     }
    
     /**
     * Ajoute la ligne de suppression au debut de l'unistall
     * La suppression des table se fait a l'inverse de la création
     * @param type $core
     * @param type $projet
     * @param type $name
     * @param type $content
     */
     public static function AddToUnInstall($core, $projet, $name)
     {
         $directory = Ide::$Destination; 
         $file = $directory."/".$projet."/Db/UnInstall.sql";
         
         $request = "\r\n DROP TABLE IF EXISTS ".$name .";";
         
         if(!file_exists($file))
         {
             
             File::Create($file, $request);
         }
         else
         {
            $content = File::GetFileContent($file);
            File::SetFileContent($file, $request.$content);   
         }
     }
     
    /**
     * Supprime une enitité
     * @param type $name
     */
    public static function DeleteEntity($core, $projet, $name)
    {
       echo $file = "../Data/Apps/Ide/".$projet."/Db/Delete".$name.".sql";
        
        //Script sql
        $content = "DROP TABLE ".$name. ";";
        File::Create($file, $content);
        $core->Db->execute($content);
        
        //Suppression du fichier
        File::Delete("../Data/Apps/Ide/".$projet."/Entity/".$name.".php");
    }
    
    /**
     * Passe le script de creation des tables
     */
    public static function CreateTable($core, $projet)
    {
        //Recuperation du fichier sql
        $request = File::GetFileContent("../Apps/".$projet."/Db/install.sql", false);
        
        $core->Db->ExecuteMulti($request);
    }
    
    /**
     * Ajoute l'entité dans l'app
     * @param type $core
     * @param type $name
     * @param type $projet
     */
    public static function RegisterEntity($core, $name, $projet)
    {
        $content = File::GetFileContent("../Apps/".$projet."/".$projet.".php", false);
        $content = str_replace("/*entity*/", "\r\t\tinclude_once(\"Entity/".$name.".php\");"."\r\n\t/*entity*/", $content);
        
        File::SetFileContent("../Apps/".$projet."/".$projet.".php", $content);
    }
}
