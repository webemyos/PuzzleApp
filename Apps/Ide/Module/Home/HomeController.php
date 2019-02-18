<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Home;

use Apps\Ide\Helper\ProjetHelper;

use Core\Controller\Controller;
use Core\Control\Button\Button;
use Core\Control\Link\Link;

class HomeController extends Controller
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
            $this->SetTemplate(__DIR__ . "/View/Home.tpl");
    
           
            //Passage des parametres à la vue
            $this->AddParameters(array('!TitleHome' => $this->Core->GetCode("EeIde.TitleHome"),
                                 '!SubtitleHome' => $this->Core->GetCode("Ide.SubTitleHome"),
                                 '!lstRecentProjet' => $this->GetProjets(),
                               '!tools' => $this->GetTool(),
                    ))
                    ;
                
            return $this->Render();
	}
        
       function GetTool()
       {
           $html = "";
           
           //Creation de projet
           $btnNewProjet = new Button(BUTTON);
           $btnNewProjet->CssClass = "btn btn-success";
           $btnNewProjet->Value = $this->Core->GetCode("Ide.StartProjet");
           $btnNewProjet->OnClick = "IdeAction.NewProjet()";
           
           $html .= $btnNewProjet->Show();
           
           return $html;
       }

       /**
        * Obtient les projets de'lutilisateur
        */
       function GetProjets()
       {
            //Projet recent de l'utilisateur
           $html = "<div id='lstProjet' >";
           $lstRecentProjet = ProjetHelper::GetRecentProjet($this->Core);
            
            if(count($lstRecentProjet) > 0)
            {
                 //Entete
                $html .= "<div class='headFolder'  >";
                $html .= "<b class='blueTree'>&nbsp;</b>" ;
                $html .= "<span class='blueTree name' ><b>".$this->Core->GetCode("Name")."</b></span>" ;
                $html .= "</span>";  
                $html .= "</div>" ;
                
                foreach($lstRecentProjet as $projet)
                {
                    $html .= "<div class='projet'  >";
          
                    $link = new Link($projet->Name->Value, "#");
                    $link->Title = $projet->Name->Value;
                    $link->OnClick = "IdeAction.LoadProjet('".$projet->Name->Value."')";
          
                    $html .= "<span>".$link->Show()."</span>";
                    
                    $html .= "</div>";
                }
            }
            
            $html .= "</div>";
            
            return $html;
       }
}     
?>