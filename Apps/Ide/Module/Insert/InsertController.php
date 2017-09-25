<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Insert;

use Apps\Ide\Ide;
use Core\Control\Button\Button;
use Core\Control\ListBox\ListBox;
use Core\Control\TextArea\TextArea;
use Core\Controller\Controller;
use Core\Core\Request;


class InsertController extends Controller
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
	function ShowInsertJs()
	{	
            $this->SetTemplate(__DIR__ . "/View/Insert.tpl");
    
            //Recuperation des foncion Js disponible
            $lstFonction = new ListBox("lstFonction");
            $lstFonction->Add($this->Core->GetCode("ChoseFunction"), "");
            
            foreach($this->GetJsFonction() as $fonction)
            {
                $lstFonction->Add($fonction, $fonction);
            }
            $lstFonction->OnChange = "IdeInsert.fonctionJsSelected(this)";
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!Title' => $this->Core->GetCode("Ide.AddJsFonction"),
                                       '!lstFonction' => $lstFonction->Show()));                   
                
            return $this->Render();
	}
        
        /**
         * Récuprer toutes les fonction Js
         */
        function GetJsFonction()
        {
            $fonctions = array();
            $directory = Ide::$Directory."/Insert/Js";
       
            if ($dh = opendir($directory))
            {
                 while (($file = readdir($dh)) !== false)
                 {
                   if($file != "." && $file != ".." )
                   {
                       if(is_dir($file) || strpos($file, ".") === false)
                       {
                           //  $html .="<li class='icon-folder-close green' style='display:block'>".$file."</li>";
                       }
                       else
                       {
                        $fonctions[] = str_replace(".php", "", $file);
                       }
                   }
                 }
              }
         return $fonctions;
        }
        
        /**
         * Récuprer toutes les fonction Js
         */
        function GetPhpFonction()
        {
            $fonctions = array();
            $directory = Ide::$Directory."/Insert/Php";
       
            if ($dh = opendir($directory))
            {
                 while (($file = readdir($dh)) !== false)
                 {
                   if($file != "." && $file != ".." )
                   {
                       if(is_dir($file) || strpos($file, ".") === false)
                       {
                           //  $html .="<li class='icon-folder-close green' style='display:block'>".$file."</li>";
                       }
                       else
                       {
                        $fonctions[] = str_replace(".php", "", $file);
                       }
                   }
                 }
              }
         return $fonctions;
        }
        
        /**
         * Récupère les parametres a initialiser d'une fonction js
         */
        function GetParameterJsFonction()
        {
            $fonction = Request::GetPost("Fonction");
            
            //Inclusion de la classe
            include(Ide::$Directory."/Insert/Insert.php" );
            include(Ide::$Directory."/Insert/Js/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $TextControl = $fonctionInsert->GetParameter();
     
            //Sauvegarde
            $btnSave = new Button(BUTTON);
            $btnSave->CssClass = "btn btn-success";
            $btnSave->Value = $this->Core->GetCode("Create");
            $btnSave->OnClick = "IdeInsert.GetCodeTemplate('Js')";
            
            $TextControl .= "<br/>".$btnSave->Show();
            
            return $TextControl;
        }
        
        /**
         * Récupere le code du template
         */
        function GetCodeTemplate()
        {
            $fonction = Request::GetPost("Fonction");
            $parameters = explode("_-", Request::GetPost("Parameter"));
            $type = Request::GetPost("Type");
                    
            //Inclusion de la classe
            include(Ide::$Directory."/Insert/Insert.php" );
            include(Ide::$Directory."/Insert/".$type."/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $Content = $fonctionInsert->ShowInsert($parameters);
            
            $tbContent = new TextArea("tb");
            $tbContent->Value = $Content;
            
            return $tbContent->Show();
        }
        
        /*
	* Affiche le module
	*/
	function ShowInsertPhp()
	{	
            $this->SetTemplate(__DIR__. "/View/Insert.tpl");
    
            //Recuperation des foncion Js disponible
            $lstFonction = new ListBox("lstFonction");
            $lstFonction->Add($this->Core->GetCode("ChoseFunction"), "");
            
            foreach($this->GetPhpFonction() as $fonction)
            {
                $lstFonction->Add($fonction, $fonction);
            }
            $lstFonction->OnChange = "IdeInsert.fonctionPhpSelected(this)";
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!Title' => $this->Core->GetCode("Ide.AddPhpFonction"),
                                       '!lstFonction' => $lstFonction->Show()));                   
                
            return $this->Render();
	}
        
         /**
         * Récupère les parametres a initialiser d'une fonction php
         */
        function GetParameterPhpFonction()
        {
            $fonction = Request::GetPost("Fonction");
            
            //Inclusion de la classe
            include(Ide::$Directory."/Insert/Insert.php" );
            include(Ide::$Directory."/Insert/Php/".$fonction.".php");
            
            $fonctionInsert = new $fonction();
            $TextControl = $fonctionInsert->GetParameter();
     
            //Sauvegarde
            $btnSave = new Button(BUTTON);
            $btnSave->CssClass = "btn btn-success";
            $btnSave->Value = $this->Core->GetCode("Create");
            $btnSave->OnClick = "IdeInsert.GetCodeTemplate('Php')";
            
            $TextControl .= "<br/>".$btnSave->Show();
            
            return $TextControl;
        }
}

?>
