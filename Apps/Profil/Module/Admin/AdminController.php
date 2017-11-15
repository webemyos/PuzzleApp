<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Module\Admin;

use Apps\Profil\Entity\ProfilCompetence;
use Apps\Profil\Entity\ProfilCompetenceCategory;
use Apps\Profil\Modele\CompetenceCategoryModele;
use Apps\Profil\Modele\CompetenceModele;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\View\ElementView;
use Core\View\View;

/**
 * Description of AdminController
 *
 * @author OLIVA
 */
class AdminController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core="")
    {
        $this->Core = $core;
    }
    
    /*
     * Show Admin
     */
    function Show()
    {
        $tbAdmin = new TabStrip("tbAdmin", "Profil");
        $tbAdmin->AddTab($this->Core->GetCode("Profil.CompetenceCategory"), $this->GetTabCategory());
        $tbAdmin->AddTab($this->Core->GetCode("Profil.Competence"), $this->GetTabCompetence());
        
        return $tbAdmin->Show();
    }
    
    /*
     * Get The Category of Compétence
     */
    function GetTabCategory()
    {  
        $view = new View(__DIR__."/View/ShowCategory.tpl", $this->Core);
        
        $category = new ProfilCompetenceCategory($this->Core);
        $view->AddElement(new ElementView("Category", $category->GetAll()));
        
        return $view->Render();
    }
        
    /*
     * Pop in Add Compétence
     */
    function ShowAddCategory($entityId)
    {
        $view = new View(__DIR__."/View/ShowAddCategory.tpl", $this->Core);
        
        //Add Message Modele
        $modele = new CompetenceCategoryModele($this->Core, $entityId);
                 
        // Set modele vith Ajax
        $view->SetModel($modele, true);
        $view->SetApp("Profil");
        $view->SetAction("ShowAddCategory");
        
        return $view->Render();
    }
    
     /*
     * Get The Compétence
     */
    function GetTabCompetence()
    {  
        $view = new View(__DIR__."/View/ShowCompetence.tpl", $this->Core);
        
        $competence = new ProfilCompetence($this->Core);
        $view->AddElement(new ElementView("Competence", $competence->GetAll()));
        
        return $view->Render();
    }
    
    /*
     * Pop in Add Compétence
     */
    function ShowAddCompetence($entityId)
    {
        $view = new View(__DIR__."/View/ShowAddCompetence.tpl", $this->Core);
        
        //Add Message Modele
        $modele = new CompetenceModele($this->Core, $entityId);
                 
        // Set modele vith Ajax
        $view->SetModel($modele, true);
        $view->SetApp("Profil");
        $view->SetAction("ShowAddCompetence");
        
        return $view->Render();
    }
}
