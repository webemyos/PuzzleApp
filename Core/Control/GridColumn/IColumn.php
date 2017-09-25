<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\GridColumn;

//Interface de base pour les colonnes
interface IColumn
{
  public function GetCell($cell);
}
