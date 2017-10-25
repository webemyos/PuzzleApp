<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Grid;

//Interface de base pour les colonnes
interface IColumn
{
  public function GetCell($cell);
}
