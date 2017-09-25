<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Entity;

use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\ListEditTemplate\ListEditTemplate;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;
use ReflectionObject;

class EntityController extends Controller
{
	function __contstruct($core)
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
         * Pop in d'ajout d'entite
         */
        function ShowAddEntity()
        {
             $this->SetTemplate(__DIR__ . "/View/AddEntity.tpl");
             
             //Nomp 
             $tbNameEntity = new TextBox("tbNameEntity");
             $tbNameEntity->PlaceHolder = $this->Core->GetCode("Name");
             
             //Entité paretragé entre application
             $cbShared = new CheckBox("cbShared");
             
             
             //Bouton de creation
             $btnCreate = new Button(BUTTON);
             $btnCreate->CssClass = "btn btn-success";
             $btnCreate->Value = $this->Core->GetCode("Create");
             $btnCreate->OnClick = "IdeElement.CreateEntity();";
             
            //Passage des parametres à la vue
            $this->AddParameters(array('!tbName' =>    $tbNameEntity->Show(),
                                        '!btnCreate'=> $btnCreate->Show(),
                                        '!cbShared' => $cbShared->Show()
             
                                 
                                ));
           
            return $this->Render();
        }
        
        /**
         * Affiche les donnée de l'entité
         */
        function ShowDataEntity()
        {
            //Inclusion de la class
            //Inclusion des toutes les fichier entités
            $app = DashBoardManager::GetApp(Request::GetPost("Projet"), $this->Core);
            
            $EntityName = Request::GetPost("Entity");
            
            //Template des grille
            $lstTemplate = new ListEditTemplate($this->Core, "", Request::GetPost("Entity"), "Ide", Request::GetPost("Projet"));
            
            //Ajout des colonnes
                    //Relections sur les propriete de l'entity
            $reflection = new ReflectionObject(new $EntityName($this->Core));
            $Properties=$reflection->getProperties();

            $objet = new $EntityName($this->Core);

            $PropertyName = array();
            foreach($Properties as $property)
            {

                    $name = $property->getName();

                    //echo get_class($objet->$name);

                    if($name != "Version" && $name != "IdEntite" && get_class($objet->$name) != "EntityProperty")
                    {
                            if($name != "Text")
                            {
                                    $PropertyName[] = $name;
                            }
                    }
            }

            $lstTemplate->Column = $PropertyName;
            $lstTemplate->UrlPopUp = "DetailEntity.php?Entity=".$EntityName;
            $lstTemplate->ActionColumn = array("Edit");
            
            return $lstTemplate->Show();
        }
}
