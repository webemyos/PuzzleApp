<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Helper;

use Apps\Ide\Helper\HelperHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Core\Request;

class HelperController extends Controller
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
         * Permet d'ajouter un helper
         */
        function ShowAddHelper()
        {
            $jbHelper = new Block($this->Core, "jbHelper") ;
           
           //Nom
           $tbName = new TextBox("tbNameHelper");
           $tbName->PlaceHolder = $this->Core->GetCode("Name");
           $jbHelper->AddNew($tbName);
           
           //Action
           $action = new AjaxAction("Ide","AddHelper");
           $action->AddArgument("App", "Ide");
           $action->AddArgument("Projet", Request::GetPost("Projet"));
           $action->ChangedControl = "jbHelper";
           $action->AddControl($tbName->Id);
           
           //Bouton de sauvegarde
           $btnCreate = new Button(BUTTON);
           $btnCreate->CssClass = "btn btn-primary";
           $btnCreate->Value = $this->Core->GetCode("Save");
           $btnCreate->OnClick = $action;
           $jbHelper->AddNew($btnCreate);
           
           return $jbHelper->Show();
        }
        
        /**
         * Crée le nouvel helper
         */
        function AddHelper()
        {
            //Recuperation du nom
            $name = Request::GetPost("tbNameHelper");
            $projet = Request::GetPost("Projet");;
            
            if($name == "")
            {
                return "<span class='error'>".$this->Core->GetCode("NameObligatory")."</span>". self::ShowAddHelper();
            }
            else
            {
                //Creation du projet
                if(HelperHelper::CreateHelper($this->Core, $projet, $name))
                {
                    return "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>"; 
                }
                else
                {
                    return "<span class='error'>".$this->Core->GetCode("HelperExist")."</span>". self::ShowAddHelper();
                }
            }
        }
}