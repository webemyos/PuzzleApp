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

	function Date()
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
            	$date = str_replace('-_',' ', $date);
		$date = explode(' ', $date);

		$day = explode('/', $date[0]);
		$hou = explode(':', $date[1]);

		return date("d/m/Y H:i", mktime($hou[0],
										  $hou[1],
										  $hou[2],
										  $day[1],
										  $day[0],
										  $day[2]
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
		return date('d/m/Y', $timestamp);
	}
	/**
	 * Ajoute un jour
	 * */
	static function AddDay($date, $num =1, $hour= false)
	{
		$date = str_replace('-_',' ', $date);
		$date = explode(' ', $date);

		$dates = explode("/", $date[0]);
		if($hour)
			return date('d/m/Y h:i:s',mktime(0,0,0,$dates[1], $dates[0]+$num, $dates[2]));
		else
			return date('d/m/Y',mktime(0,0,0,$dates[1], $dates[0]+$num, $dates[2]));
	}
 }

?>
