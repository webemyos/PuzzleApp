<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Module;

use Apps\Ide\Helper\ModuleHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Core\Request;

class ModuleController extends Controller
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
        {}
        
        /**
         * Permet d'ajouter un module
         */
        function ShowAddModule()
        {
           $jbModule = new Block($this->Core, "jbModule") ;
           
           //Nom
           $tbName = new TextBox("tbNameModule");
           $tbName->PlaceHolder = $this->Core->GetCode("Name");
           $jbModule->AddNew($tbName);
           
           //Action
           $action = new AjaxAction("Ide","AddModule");
           $action->AddArgument("App", "Ide");
           $action->AddArgument("Projet", Request::GetPost("Projet"));
           $action->ChangedControl = "jbModule";
           $action->AddControl($tbName->Id);
           
           //Bouton de sauvegarde
           $btnCreate = new Button(BUTTON);
           $btnCreate->CssClass = "btn btn-primary";
           $btnCreate->Value = $this->Core->GetCode("Save");
           $btnCreate->OnClick = $action;
           $jbModule->AddNew($btnCreate);
           
           return $jbModule->Show();
       }
       
       /**
        * Ajoute le module
        */
       function AddModule()
       {
            //Recuperation du nom
            $name = Request::GetPost("tbNameModule");
            $projet = Request::GetPost("Projet");;
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddModule();
            }
            else
            {
                //Creation du projet
                if(ModuleHelper::CreateModule($this->Core, $projet, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='success'>".$this->Core->GetCode("ModuleExist")."</span>". self::ShowAddModule();
                }
            }
        }
        
        
        /**
         * Permet d'ajouter une action à un module
         */
        function ShowAddActionModule()
        {
            //Recuperation des variables
            $projet = Request::GetPost("Projet");
            $block = Request::GetPost("Block");
            
            //Creation du bloc
            $jbAction = new Block($this->Core, "jbAction");
            
            //Nom de l'action
            $tbNameAction = new TextBox("tbNameAction");
            $tbNameAction->PlaceHolder = $this->Core->GetCode("Name");
            $jbAction->AddNew($tbNameAction);
            
            //Ajout d'un template
            $cbTemplate = new CheckBox("cbTemplate");
            $cbTemplate->Libelle = $this->Core->GetCode("Ide.AddTemplate");
            $jbAction->AddNew($cbTemplate);
            
            //Action   
            $action = new AjaxAction("Ide","AddActionModule");
            $action->AddArgument("App", "Ide");
            $action->AddArgument("Projet", $projet);
            $action->AddArgument("Block", $block);
            
            $action->ChangedControl = "jbAction";
            $action->AddControl($tbNameAction->Id);
            $action->AddControl($cbTemplate->Id);
            
            //Bouton de sauvegarde
            $btnCreate = new Button(BUTTON);
            $btnCreate->CssClass = "button orange";
            $btnCreate->Value = $this->Core->GetCode("Save");
            $btnCreate->OnClick = $action;
            $jbAction->AddNew($btnCreate);
            
            return $jbAction->Show();
        }
        
        /**
         * Ajoute une action à un module
         */
        function AddActionModule()
        {
            //Recuperation des données
            $projet = Request::GetPost("Projet");
            $block = Request::GetPost("Block");
            $nameAction = Request::GetPost("tbNameAction");
            $addTemplate = (Request::GetPost("cbTemplate") == 1);
            
            if($nameAction == "")
            {
                return "<span class='FormUserError'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddModule();
            }
            else
            {
                ModuleHelper::AddActionModule($projet, $block, $nameAction, $addTemplate);
                return "<span class='FormUserValid'>".$this->Core->GetCode("SaveOk")."</span>"; 
            }
        }
        
}