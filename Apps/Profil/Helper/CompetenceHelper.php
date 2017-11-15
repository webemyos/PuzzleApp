<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Helper;

use Apps\Profil\Entity\ProfilCompetenceCategory;

class CompetenceHelper
{
    /**
     * Obtient les catégorie de compétences
     * 
     * @param type $core
     */
    public static function GetCategorie($core)
    {
        $categories = new ProfilCompetenceCategory($core);
        return $categories->GetAll();
    }
    
    /**
     * Récupére toutes les compétences dont celle de l'utilisateur
     * @param type $core
     */
    public static function GetByCategoryByUser($core, $categoryId, $userId)
    {
        $request = "SELECT competence.id as Id, competence.Code as Code, competenceUser.Id as Selected
                    FROM ProfilCompetence as competence
                    LEFT JOIN ProfilCompetenceEntity as competenceUser ON competenceUser.CompetenceId = competence.Id AND competenceUser.UserId =" .$userId."
                    WHERE competence.CategoryId = ".$categoryId;
        
        return $core->Db->GetArray($request);
    }
    
    /*
     * Obtient les compétences de l'utilisateur
     */
    public static function GetByUser($core, $userId)
    {
        $request = "SELECT categorie.Name as categoryName,competence.Name as CompetenceName
                    FROM ProfilCompetence as competence
                    JOIN ProfilCompetenceEntity as competenceUser ON competenceUser.CompetenceId = competence.Id AND competenceUser.UserId =$userId
                    JOIN ProfilCompetenceCategory as categorie on categorie.Id = competence.CategoryId
                    WHERE competenceUser.UserId = $userId 

                    Order By competence.CategoryId"  ;          
        
        return $core->Db->GetArray($request);
        
    }
}
?>
