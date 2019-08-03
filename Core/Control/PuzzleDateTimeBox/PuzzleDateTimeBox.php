<?php
/**
 * Created by PhpStorm.
 * User: jerome
 * Date: 02/04/2019
 * Time: 14:35
 */

namespace Core\Control\PuzzleDateTimeBox;

use Core\Control\IControl;
use Core\Control\Control;


class PuzzleDateTimeBox extends Control implements IControl
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
		$TextControl = parent::show();


		return $TextControl;
	}
}