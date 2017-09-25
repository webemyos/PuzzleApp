<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\GridColumn;

use Core\Control\Control;
use Core\Control\GridColumn\IColumn;

//Classe les colonnes coontenant un control
class IconColumn extends Control implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $TypeControl;

  function __construct($headerName,$value, $typeControl, $style="")
  {
    $this->HeaderName = $headerName;
    $this->TypeControl = $typeControl;
    $this->Value = $value;
    $this->Style = $style;
  }

  //Retourne les data
  public function GetCell($Tab,$idName="")
  {
  	if(is_object($Tab))
  	{
            $TextControl = new $this->TypeControl($Tab->IdEntite);
      }
  	else
  	{
  		$TextControl = new $this->TypeControl($Tab[$idName]);
      	$TextControl->Value = $Tab[$this->Value];
  	}
  	//Ajout de style sur les controls
  	if(is_array($this->Style))
  	{
	  	foreach($this->Style as $style)
	  	{
          $styleValue= split(":",$style);
          $TextControl->AddStyle($styleValue[0],$styleValue[1]);
	  	}
  	}


    return "\n\t<td>".$TextControl->Show()."</td>";
  }

  //asseceurs
  public function __get($name)
  {
    return $this->$name;
  }

  public function __set($name,$value)
  {
    $this->$name=$value;
  }
}