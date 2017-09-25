<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Helper;

use Core\Utility\Date\Date;

class DateHelper
{
    /**
     * Obtient le nombe d'heure de différence
     * @param type $dateStart
     * @param type $dateEnd
     */
    public static function GetDiffHour($dateStart, $dateEnd)
    {
        //Calcul du nombre d'heure
        $hourStart = explode(" ", $dateStart);
        $hourStart = explode(":", $hourStart[1]);
        
        $endStart = explode(" ", $dateEnd);
        $endStart = explode(":", $endStart[1]);
        return $endStart[0] - $hourStart[0];
    }
    
    /**
     * Calcul le nombre de jour d'écart 
     */
    public static function  GetDiffDay($dateStart, $dateEnd)
    {
        return Date::GetDayDiff($dateStart, $dateEnd) +1 ;
    }
    
}

?>
