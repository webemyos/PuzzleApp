<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Grid;

use Core\Control\Control;

//Classe de base pour les colonnes
class Column extends Control implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;

  function __construct($headerName,$value)
  {
    $this->HeaderName = $headerName;
    $this->Value = $value;
  }

  //Retourne les data
  public function GetCell($Tab)
  {
    return "\n\t<td>".$Tab[$this->Value]."</td>";
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

