<?php 
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Entity ;

use Apps\Profil\Helper\CompetenceHelper;
use Core\Control\CheckBox\CheckBox;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;

class ProfilCompetenceCategory extends Entity  
{
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="ProfilCompetenceCategory"; 
        $this->Alias = "ProfilCompetenceCategory"; 

        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Get the compétence 
     * And Cheked for current user
     */
    public function GetHtmlCompetenceByUser()
    {
        //Recuperation des compétences
        $competences = CompetenceHelper::GetByCategoryByUser($this->Core, $this->IdEntite, $this->Core->User->IdEntite);

        $html = "<ul>";

        foreach($competences as $competence)
        {
          $cbCompetence = new CheckBox($competence["Id"]); 
          $cbCompetence->Checked = $competence["Selected"];

          $html .= "<li>".$cbCompetence->Show()."&nbsp;".$competence["Code"]."</li>";
        }

        $html .= "</ul>";

        return $html;
    }
}
?>