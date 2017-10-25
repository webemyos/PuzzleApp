<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EntityGrid;

use Core\Control\Control;
use Core\Control\Grid\IColumn;

class EntityColumn extends Control implements IColumn
{
  //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $EntityProperty;
  private $ClassCss ;

  private $CellClassCss ;

  //Constructeur
  function __construct($headerName,$propertyName,$entityProperty="", $cellClassCss="")
  {
    $this->HeaderName = $headerName;
    $this->PropertyName = $propertyName;
    $this->EntityProperty = $entityProperty;
    $this->CellClassCss = $cellClassCss;
  }

  /*
   * Get the Header
   */
  public function GetHeader()
  {
      return $this->HeaderName;
  }
  
  //Retourne les data
  public function GetCell($Entite)
  {
    $Propertie = $this->PropertyName;
   	if($this->CellClassCss)
   	{
   		$CssClass = " class='".$this->CellClassCss."'";
   	}
   	else
   	{
   		$CssClass ="";
   	}

    if($Entite->$Propertie && is_object($Entite->$Propertie->Value))
    {
      $class=$Entite->$Propertie->Value;
      $property = $this->EntityProperty;
      return "\n\t<td $CssClass>".$class->$property->Value."</td>";
    }
    else if($Entite->$Propertie)
    {
      return "\n\t<td $CssClass>".$Entite->$Propertie->Value."</td>";
    }
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

