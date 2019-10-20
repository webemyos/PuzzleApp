<?php
/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 02/04/2019
 * Time: 14:35
 */

namespace Core\Control\AppointmentBox;

use Core\Control\IControl;
use Core\Control\Control;
use Core\Core\Core;


class AppointmentBox extends Control implements IControl
{
	//Date minimum
	public $MinDate;

	//Constructeur
	function __construct($name, $minDate = "")
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
		//$this->RegExp="'([0-9]{1,4})/([0-9]{1,2})/([0-9]{1,4})'";
		$this->MessageErreur="Date invalide elle doit être au format jj/mm/aaaa";
		$this->Type="text";
		$this->CssClass="dateBox";
		$this->CssClass="form-control puzzleDateTimeBox";

		if($minDate != "")
		{
			$this->AddDataSet("mindate", $minDate);
		}
	
	}

	function Show()
	{
        $html = "<table id='tabInscription' class='grid' style='width:100%'>";
        $core = Core::getInstance();

        $date = new \DateTime('now', new \DateTimeZone( 'UTC' ));

        //Entete
        $html .= "<tr>";
        $html .= "<th style='width:200px'>".$date->format('M Y')."</th>";
        
        $days = array();

        for($i = 0; $i < 8; $i++)
        {
            $day = $date->add(new \DateInterval('P1D'));
            $html .= "<th>".$core->GetCode($day->format("l"));
            $html .= " " . $day->format("d") ."</th>";

            $days[$i] = $day->format("d/m/Y");
        }
        $html.= "</tr>";

        $dispos = array("De 8h à 10h", "De 10h à 12h", "De 14h à 16h", "De 16h à 18h", "De 18h à 20h");

        foreach($dispos as $dispo)
        {
            $html .= "<tr>";
            $html .= "<td>".$dispo."</td>";

            for($i = 0; $i < 8; $i++)
            {
                $html .= "<td><input type='checkbox' value='". $days[$i]. " ". $dispo. "' /></td>";
            }

            $html .= "</tr>";
        }

        $html .= "</table>";


		return $html;
	}
}