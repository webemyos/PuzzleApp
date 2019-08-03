<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\Date;

/*
 Classe de base pour la mise en forme des dates
 */
 class Date
 {

    function __construct()
    {
        $this->Version = "2.1.0.0";
    }

    //Retourne la date actuelle
    static public function Now($heure = false, $format = '')
    {
        if($format == 'MYSQL')
        {
                return date("Y-d-m h:i:s");
        }
        else if($format != "")
        {
            return date($format);
        }
        else
        {
            if($heure)
            {
                return date("Y/m/d h:i:s");
            }
            else
            {
                return date("Y/m/d");
            }
        }
    }

    //Retourne la date formate
    static public function Format($date)
    {
        return date("d/m/Y h:i:s", mktime($date));
    }

    static function FormatFrench($date)
    {
       // echo "DATE ENTRR=>" .$date;

        $date = str_replace('-_',' ', $date);
        $date = explode(' ', $date);

        $day = explode('-', $date[0]);
        $hou = explode(':', $date[1]);

        //var_dump($day);
        return date("d/m/Y H:i:s", mktime($hou[0],
                                                                          $hou[1],
                                                                          $hou[2],
                                                                          $day[1],
                                                                          $day[2],
                                                                          $day[0]
                                                                ));
    }
    /**
     * Formate la date au format MYSQL
     * */
    static public function FormatMysql($date)
    {
        $date = str_replace('-_',' ', $date);
        $date = explode(' ', $date);

        $day = explode('/', $date[0]);
        $hou = explode(':', $date[1]);

        return date("Y/m/d H:i:s", mktime($hou[0],
                                                                          $hou[1],
                                                                          $hou[2],
                                                                          $day[1],
                                                                          $day[0],
                                                                          $day[2]
                                                                ));
    }

    /**
     * Retourne la date au format time
     * */
    static public function GetTime($date)
    {
        $date = str_replace('-_',' ', $date);
        $date = explode(' ', $date);

        $day = explode('/', $date[0]);
        $hou = explode(':', $date[1]);

        return mktime($hou[0],
                                  $hou[1],
                                  $hou[2],
                                  $day[1],
                                  $day[0],
                                  $day[2]);
    }

    /**
     * Récupére l'heure d'une date
     */
     static function GetHour($date)
    {
        $date = str_replace('-_',' ', $date);
        $date = explode(' ', $date);

        $hou = explode(':', $date[1]);

        return $hou[0];
    }

    /**
     * Récupère le nombre de jour de différence
     * */
    static function GetDayDiff($dateStart, $dateEnd)
    {
        $start = str_replace('-_',' ', $dateStart);
        $start = explode(' ', $start);
        $datesStart = explode("/", $start[0]);

        $timeStart = mktime(1,1,1, $datesStart[1],$datesStart[0], $datesStart[1]);

        $end = str_replace('-_',' ', $dateEnd);
        $end = explode(' ', $end);
        $datesEnd = explode("/", $end[0]);

        $timeEnd = mktime(1,1,1, $datesEnd[1], $datesEnd[0], $datesEnd[1]);

        return round(((($timeEnd - $timeStart) / 24) /60 )/60);
    }


    //Retourne l'ann�e
    //Format de base 20/01/1980
    static public function GetYear($date)
    {
        $dates = split("/",$date);
        return $dates[2];
    }

    /**
     * Retourne le premier jour de la semaine
     * */
    static function GetFirstDay($week, $year)
    {
        $timestamp = strtotime("monday january $year + $week week -2 week");
        // A verifier selon les années mettre -2 ou -1
        setlocale(LC_TIME, "fr");
        return date('Y-m-d', $timestamp);
    }
    /**
     * Ajoute un jour
     * */
    static function AddDay($date, $num =1, $hour= false)
    {
        //$date = str_replace('-',' ', $date);
        $date = explode('-', $date);
        
        if($hour)
        {
            return date('Y-m-d h:i:s',mktime(0,0,0,$date[1], $date[2]+$num, $date[0]));
        }
        else
        {
            return date('Y-m-d',mktime(0,0,0, $date[1], $date[2] + $num, $date[0]));
        }
    }

    /**
     * Convertie une date format string au format mysql
     */
    static function StringToDateTime($dateString)
    {
        $dates = explode(" ",$dateString);

        $day = $dates[0];
        $month = $dates[1];
        $year = $dates[2];
        $time = $dates[3];

        switch($month)
        {
            case "Janvier": $month = 1; break;
            case "Fevrier": $month = 2; break;
            case "Mars": $month = 3; break;
            case "Avril": $month = 4; break;
            case "Mai": $month = 5; break;
            case "Juin": $month = 6; break;
            case "Juillet": $month = 7; break;
            case "Aout": $month = 8; break;
            case "Septembre": $month = 9; break;
            case "Octobre": $month = 10; break;
            case "Novembre": $month = 11; break;
            case "Decembre": $month = 12; break;
        }

        $dateSql = $year . "-".$month."-".$day." " .  $time; 
        return $dateSql; 
    }

    /**
     * Ajoute une heure
     */
    public static function AddHour($date, $nbHours)
    {
        $dates = explode(" ", $date);
        $times = explode(":", $dates[1]);

        $dateSql = $dates[0] . " " .  ($times[0] +  $nbHours) . ":" . $times[1]; 

        return $dateSql;
    }
 }

?>
