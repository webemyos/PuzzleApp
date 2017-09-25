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

class ModuleHelper
{
   /**
    * Ajoute un module au projet
    * 
    * @param type $core
    * @param type $projet
    * @param type $name
    */
   public static function CreateModule($core, $projet, $name)
   {
         //Creation du repertoire du projet
	//$destination = "../Data/Apps/Ide/".$projet."/Blocks/".$name."Block";
        $destination = Ide::$Destination."/".$projet."/Module/".$name;
                
        if(!file_exists($destination))
        {
            //Creation du repertoire
             File::CreateDirectory($destination);
            
            //Copie des fichiers
            copy(Ide::$Directory. '/Modele/Module/XXXController.php', $destination."/".$name."Controller.php");
            
            //Remplace les noms
            self::ReplaceNameBlock($destination."/".$name."Controller.php", $name);
            
            //Enregistre le module dans l'application
            self::RegisterBlock($core, $name, $projet);
            
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
   public static function RegisterBlock($core, $name, $projet)
   {
       $content = File::GetFileContent("../Apps/".$projet."/".$projet.".php", false);
       $content = str_replace("/*block*/", "\r\t\tinclude_once(\"Blocks/".$name."/".$name.".php\");"."\r\n\t/*block*/", $content);

       File::SetFileContent("../Apps/".$projet."/".$projet.".php", $content);
   }
       
   /**
    * Remplace touts les noms des applications
    * */
    public static function ReplaceNameBlock($file, $name)
    {
           $content = File::GetFileContent($file);
           $content = str_replace("XXX", $name."", $content);

           //Enregistrement
           File::SetFileContent($file, $content);
    }
    
    /**
     * Ajoute une action à un module
     * @param type $projet
     * @param type $block
     * @param type $nameAction
     * @param type $addTemplate
     */
    public static function AddActionModule($projet, $block, $nameAction, $addTemplate)
    {
        //nom du fichier
        //$fileName = "../Data/Apps/Ide/".$projet."/Blocks/".$block."/".$block.".php";
        $fileName = Ide::$Destination."/".$projet."/Blocks/".$block."/".$block.".php";
        
        //Recuperation du contenu
        $content = File::GetFileContent($fileName);
        
        //Fin du fichier
        $EndFile = "/*action*/";
        
        $tab = "\t";
        $newLigne = "\r\n".$tab;
        
        $newContent .="$newLigne/*$newLigne*Expliquer la fonction de cette action$newLigne*/";
        $newContent .="$newLigne function ".$nameAction. "()";
        $newContent .="$newLigne{";
            
        if($addTemplate)
        {
           $newContent .= "$newLigne$tab %this->SetTemplate($projet::%Directory . \"/Blocks/$block/$nameAction.tpl\");";
           $newContent .= "$newLigne$tab %this->AddParameters(array('!monParametre' => '' ));";
           $newContent .= "$newLigne$tab return %this->Render();";
           
           //Repertoire de destination
           $destination = Ide::$Destination."/".$projet."/Blocks/".$block."/";
           
           //On crée le nouveau fichier de template
           copy(Ide::$Directory. '/Modele/Blocks/XXX.tpl', $destination."/".$nameAction.".tpl");
        }
               
        $newContent .="$newLigne}$newLigne";
        
        //Ajout de la fonction à la fin du fichier
        $newContent = str_replace($EndFile, $newContent.$EndFile, $content);
        $newContent = str_replace(chr(37), chr(36), $newContent);
        
        //Enregistrement de l'action 
        //On enregistre la nouvelle action à la fin du fichier
        File::SetFileContent($fileName, $newContent );
    }
}
