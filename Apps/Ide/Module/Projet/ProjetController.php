<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Projet;

use Apps\Ide\Helper\ProjetHelper;
use Apps\Ide\Helper\ToolHelper;
use Apps\Ide\Ide;
use Apps\Ide\Helper\ElementHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Core\Request;


class ProjetController extends Controller
{
	function _construct($core)
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
        
        /**
         * Creation d'un nouveau projet
         */
        function ShowCreateNewProjet()
        { 
           //Block
           $jbNewProjet = new Block($this->Core, "jbNewProjet");
           $jbNewProjet->Table = true;
            
           //Nom
           $tbNameProjet = new TextBox("tbNameProjet");
           $tbNameProjet->PlaceHolder = "Ide.ProjetName";
           $jbNewProjet->AddNew($tbNameProjet);
           
           //Action
           $action = new AjaxAction("Ide", "CreateProjet");
           $action->AddArgument("App", "Ide");
           $action->ChangedControl = "jbNewProjet";
           $action->AddControl($tbNameProjet->Id);
           
           //Sauvegarde
           $btnCreate = new Button(Button);
           $btnCreate->CssClass = "btn btn-success";
           $btnCreate->Value = $this->Core->GetCode("Create");
           $btnCreate->OnClick = $action;
           
           $jbNewProjet->AddNew($btnCreate, '', ALIGNRIGHT);
           
           return $jbNewProjet->Show();
        }
        
        /**
         * Création du projet
         */
        function CreateProjet()
        {
            //Recuperation du nom
            $name = Request::GetPost("tbNameProjet");
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowCreateNewProjet();
            }
            else
            {
                //Creation du projet
                if(ProjetHelper::CreateProjet($this->Core, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='error'>".$this->Core->GetCode("ProjetExist")."</span>". self::ShowCreateNewProjet();
                }
            }
        }
        
        /**
         * Charge les outils et le projets
         */
        function LoadProjet()
        {
            //echo "ici";
            $this->SetTemplate(__DIR__ . "/View/Projet.tpl");

            //Recuperation du projet
            $projet = Request::GetPost("Projet");
            
            //TabStrip de l'editeur
            $tsEditor = new TabStrip("tsEditor","Ide");
            $tsEditor->AddTab("information", new Libelle("Votre projet"));
            
            //Passage des parametres à la vue
            $this->AddParameters(array('!lstTools' => ToolHelper::GetTool($this->Core, $projet),
                                 '!lstElement' => ElementHelper::GetAll($this->Core, $projet),
                                 '!lstEditor' => $tsEditor->Show(),
                                ));
            
            return $this->Render();
        }
}

?>
