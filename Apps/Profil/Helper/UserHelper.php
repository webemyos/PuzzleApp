<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Helper;

use Core\Entity\City\City;

class UserHelper
{
    /**
     * Sauvegarde les informations de l'utilisateur
     */
    public static function Save($core, $firstName, $name, $description, $city)
    {
        if($firstName != "" && $name != "")
        {
            $core->User->FirstName->Value = $firstName;
            $core->User->Name->Value = $name;
            $core->User->Descritpion->Value = $description;
            
            
           if($city != "")
           {
                $City = new City($core);
                $City = $City->GetByName($city);

                if($City != "")
                {
                  $core->User->CityId->Value = $City->IdEntite;
                }
           }
                      
            $core->User->Save();
        
            return "<div class='success'>".$core->GetCode("SaveOk")."</div>";
        }
        else
        {
           return "<div class='error'>".$core->GetCode("EeProfil.SaveInformation")."</div>";
        }
    }
    
     /**
     * Enregistre les compétences d'un utilisateur
     * @param type $core
     * @param type $userId
     * @param type $competenceId
     */
    public static function SaveCompetence($core, $userId, $competenceId)
    {
        //Suppression avant enregistrement
        self::DeleteCompetence($core, $userId);
        
        $competences = explode(";", $competenceId);
        
        foreach($competences as $competence)
        {
            $competenceUser = new EeProfilCompetenceEntity($core);
            $competenceUser->UserId->Value = $userId;
            $competenceUser->CompetenceId->Value = $competence;
            
            $competenceUser->Save();
        }
    
        echo "<div class='success'>".$core->GetCode("SaveOk")."</div>";
    
    }
    
    /**
     * Supprime les compétences d'un utilisateur
     * @param type $core
     * @param type $userId
     */
    public static function DeleteCompetence($core, $userId)
    {
        $request = "DELETE FROM EeProfilCompetenceEntity WHERE UserId=".$userId;
        $core->Db->Execute($request);
    }
    
    
}

?>
