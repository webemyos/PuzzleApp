<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

use Apps\Ide\Entity\IdeProjet;
use Apps\Ide\Ide;
use Core\Entity\Entity\Argument;
use Core\Utility\File\File;

class ProjetHelper
{
    
    /**
     * Récupere l'application Ide
     */
    public static function GetApp($core)
    {
        return DashBoard::GetApp("Ide", $core);
    }
    
    /**
     * Obtient les projets
     * @param type $core
     */
    public static function GetProjet($core)
    {
        //recuperation des  projet dans config
        $projets = new IdeProjet($core);
        //TODO Reactiver 
        // Gerer le partage des projets
        $projets->AddArgument(new Argument("Apps\Ide\Entity\IdeProjet", "UserId", EQUAL, $core->User->IdEntite));
        return $projets->GetByArg();
        
       // return  $projets->GetAll();   
    }
    
    /**
     * Récupere les projets récents de l'utilisateur
     */
    public static function GetRecentProjet($core)
    {
        $elements = self::GetProjet($core);
        
        return $elements;
        /*if(count($elements) > 0)
        {
            $html = "<ul class='alignLeft'>";
            
            foreach($elements as $element)
            {
                $link = new Link($element->Name->Value, "#");
                $link->Title = $element->Name->Value;
                $link->OnClick = "IdeAction.LoadProjet('".$element->Name->Value."')";
          
                $html .= "<li>".$link->Show()."</li>";
            }
            
            $html .= "</ul>";
            
            return "<div id='lstProjet'>".$html."</div>";
        }
        else
        {
            return "<div id='lstProjet'>".$core->GetCode("Ide.NoProjet")."</div>";
        }*/
    }
    
    /**
     * Définie si un projet existe en base de donnée
     * 
     * @param type $core
     * @param type $name
     */
    public static function Exist($core, $name)
    {
       $projet = new IdeProjet($core);
       $projet->AddArgument(new Argument("Apps\Ide\Entity\IdeProjet", "Name", EQUAL, $name));
       
       $projets = $projet->GetByArg();
       
       return  ( count($projets) > 0);
    }
    
    /**
     * Création d'un nouveau projet
     */
    public static function CreateProjet($core, $name)
    {
        //Creation du repertoire du projet
	$destination = Ide::$Destination."/".$name; //;"../Data/Apps/Ide/".$name;
        
       //Le projet n'existe pas en base
        if(!ProjetHelper::Exist($core, $name))
        {
            echo "<span class='succes' >Enregistrement en base</span>";
            
            //Enregistrement en base 
            $projet = new IdeProjet($core);
            $projet->UserId->Value = $core->User->IdEntite;
            $projet->Name->Value = $name;
            $projet->Save();
        }
        
        if(!file_exists($destination))
        {
            //Creation du repertoire
            File::CreateDirectory($destination);
        
            //Copy des fichier
            copy(Ide::$Directory. '/Modele/App/EeXXX.xml', $destination."/".$name.".xml");
	    copy(Ide::$Directory. '/Modele/App/EeXXX.php', $destination."/".$name.".php");
            copy(Ide::$Directory. '/Modele/App/EeXXX.js', $destination."/".$name.".js");
            copy(Ide::$Directory. '/Modele/App/EeXXX.css', $destination."/".$name.".css");
            
            //Creation des dossiers indispensables
            File::CreateDirectory($destination. "/Entity");
            File::CreateDirectory($destination. "/Helper");
            File::CreateDirectory($destination. "/Db");
            File::CreateDirectory($destination. "/Images");
            
            //Création du controleur de base
            File::CreateDirectory($destination. "/Module");
            File::CreateDirectory($destination. "/Module/Admin");
            File::CreateDirectory($destination. "/Module/Admin/View");
            
            copy(Ide::$Directory. '/Modele/Module/XXXController.php', $destination."/Module/Admin/AdminController.php");
            copy(Ide::$Directory. '/Modele/Module/View/XXX.tpl', $destination."/Module/Admin/View/index.tpl");
           
            $content = File::GetFileContent($destination."/Module/Admin/AdminController.php");
            $content = str_replace("YYY", $name, $content);
            $content = str_replace("XXX", "Admin", $content);
            
            //Enregistrement
            File::SetFileContent($destination."/Module/Admin/AdminController.php", $content);
        
            //Copie du logo
            copy(Ide::$Directory. '/Modele/App/Images/logo.png', $destination."/Images/logo.png");
            
             //Renommage des noms
             self::ReplaceNameApp($destination."/".$name.".xml", $name);
             self::ReplaceNameApp($destination."/".$name.".php", $name);
             self::ReplaceNameApp($destination."/".$name.".js", $name);
            
            return true; 
        }
        else
        {
            return false;
        }
    }
    
    /**
    * Remplace touts les noms des applications
    * */
    public static function ReplaceNameApp($file, $name)
    {
        $content = File::GetFileContent($file);
        $content = str_replace("EeXXX", $name, $content);

        //Enregistrement
        File::SetFileContent($file, $content);
    }
    
    /**
     * Obtient les app d'un projet
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $ideProjet = new IdeProjet($core);
                
        $ideProjet->AddArgument(new Argument("Apps\Ide\Entity\IdeProjet", "AppName" ,EQUAL, $appName));
        $ideProjet->AddArgument(new Argument("Apps\Ide\Entity\IdeProjet", "EntityName" ,EQUAL, $entityName));
        $ideProjet->AddArgument(new Argument("Apps\Ide\Entity\IdeProjet", "EntityId" ,EQUAL, $entityId));
        
        return $ideProjet->GetByArg();
        
    }

	/***
	 * Retourne tous le projets
	 */
    public static function GetAll($core)
    {
        $projets = new IdeProjet($core);

        return $projets->GetAll();
    }
}

?>
