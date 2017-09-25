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

class HelperHelper
{
    /**
     * Crée un nouvel helper
     * @param type $core
     * @param type $projet
     * @param type $name
     * @return boolean
     */
    public static function CreateHelper($core, $projet, $name)
    {
        //Creation du repertoire du projet
	$destination = Ide::$Destination."/".$projet."/Helper/";
                
        if(!file_exists($destination."/".$name.".php"))
        {
            //Copie des fichiers
            copy(Ide::$Directory. '/Modele/Helper/XXXHelper.php', $destination."/".$name.".php");
            
            //Remplace les noms
            self::ReplaceNameBlock($destination."/".$name.".php", $name);
            
            //Enregistre le helper dans l'application
            self::RegisterHelper($core, $name, $projet);
            
            return true;
        }
        else
        {
            return false;
        }
    }
    
       /**
    * Ajoute l'entité dans l'app
    * @param type $core
    * @param type $name
    * @param type $projet
    */
   public static function RegisterHelper($core, $name, $projet)
   {
       $content = File::GetFileContent("../Apps/".$projet."/".$projet.".php", false);
       $content = str_replace("/*helper*/", "\r\t\tinclude_once(\"Helper/".$name.".php\");"."\r\n\t/*helper*/", $content);

       File::SetFileContent("../Apps/".$projet."/".$projet.".php", $content);
   }
   
   /**
    * Remplace touts les noms des applications
    * */
    public static function ReplaceNameBlock($file, $name)
    {
           $content = File::GetFileContent($file);
           $content = str_replace("XXXHelper", $name."", $content);

           //Enregistrement
           File::SetFileContent($file, $content);
    }
}

