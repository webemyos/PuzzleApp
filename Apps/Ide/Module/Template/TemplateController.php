<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Ide\Module\Template;

use Apps\Ide\Helper\ToolHelper;
use Apps\Ide\Ide;
use Apps\Ide\Helper\ElementHelper;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Utility\File\File;

class TemplateController extends Controller
{
	function __construct($core)
	{
            $this->Core = $core;
	}
	
	/*
	* Crée le module
	*/	
	function Create()
	{
	}

	/*
	* Initialise
	*/
	function Init()
	{
	}
	
	/*
	* Affiche le module
	*/
	function Show()
	{	
            $this->SetTemplate(__DIR__ . "/View/Template.tpl");
    
            //Recuperation des variable
            $projet = Request::GetPost("Projet");
            $module = Request::GetPost("Module");
            
            $directory = "../Apps/".$projet."/Module/".$module."/View";
      
            //Lecture du dossier
            if ($dh = opendir($directory))
            {
                $lstTemplate = "<ul class='alignLeft'>";
            
                while (($file = readdir($dh)) !== false)
                {
                  if($file != "." && $file != ".." )
                  {
                      if(is_dir($file) || strpos($file, ".") === false || strpos($file, ".php") > 0)
                      {
                      }
                      else
                      {
                       $lstTemplate .="<li class='blue' onclick='IdeElement.LoadCodeTemplate(\"".$projet."\", \"".$module."\", \"".$file."\", true)'>".$file."</li>";
                      }
                  }
                }
                
                 $lstTemplate .= "</ul>";
            }
            else
            {
                return $this->Core->GetCode("TemplateNotFound");
            }
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!lstTemplate' => $lstTemplate,
                                       '!Tools'=> ToolHelper::GetTemplateEditorTool($this->Core),
                                       '!cssFile' => ElementHelper::LoadCssFile($projet),
                                       '!idDivApp' => "appRun" .$projet
                ) 
                                    );
                
            return $this->Render();
	}
        
        /**
         * Charge le templace
         */
        function LoadCodeTemplate()
        {
            $projet = Request::GetPost("Projet");
            
            if(Request::GetPost("ShowStyle"))
            {
                 //Ajout du style css
                 $filecss = "../Apps/".$projet."/".$projet.".css";
                 $contentCss = File::GetFileContent($filecss); 
            
                 //Les css sont préxifer par le nom de l'application
                 $contentCss = str_replace("#appRun".$projet , "", $contentCss );
            
                $html = "<style type='text/css' >".$contentCss."</style>";
            }
            
            $file = "../Apps/".$projet."/Module/".Request::GetPost("Module")."/View/".Request::GetPost("File");
            $html .= File::GetFileContent($file);    
            
            return $html;
        }
       
        /**
         * Sauivegarde le template
         */
        function SaveTemplate()
        {
            //Enregistrement du template
            $file = "../Apps/".Request::GetPost("Projet")."/Blocks/".Request::GetPost("Module")."/".Request::GetPost("File");
            File::SetFileContent($file, Request::GetPost("Content"));
            
            //Enregistrement du fichier css
            $file = "../Apps/".Request::GetPost("Projet")."/".Request::GetPost("Projet").".css";
            return File::SetFileContent($file, Request::GetPost("CssContent"));
        }
}
