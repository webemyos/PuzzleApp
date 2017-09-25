<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\GridColumn;

use Core\Control\Control;
 

//Interface de base pour les colonnes
interface IColumn
{
  public function GetCell($cell);
}

//Classe de base pour les colonne
class GridColumn
{
	function __construct()
	{
		$this->Version ="2.0.1.0";
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





?>
