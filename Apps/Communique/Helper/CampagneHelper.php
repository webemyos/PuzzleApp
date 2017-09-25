<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Helper;

class CampagneHelper
{
    /**
     * Obtient les statistiques sur une campagne
     * @param type $core
     * @param type $campagneId
     */
    public static function GetStatistique($core, $campagneId)
    {
        $request ="SELECT COUNT(Email) AS nbEmailSend, 
                   SUM(case WHEN  NumberOpen is null THEN 0 ELSE 1 END) as nbEmailOpen,
                   SUM(NumberOpen) AS nbOpen 
                   FROM CommuniqueCampagneEmail WHERE campagneId = ". $campagneId;
        
        return $core->Db->GetLine($request);
    }
}