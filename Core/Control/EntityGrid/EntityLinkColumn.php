<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EntityGrid;

use Core\Core\Core;
use Core\Control\Control;
use Core\Control\Grid\IColumn;

//Classe de base qui appele une fonction de classe quelconque
class EntityLinkColumn extends Control implements IColumn
{
  //Propriete
  private $HeaderName;
  private $Url;

  //Constructeur
  function __construct($headerName, $url)
  {
    $this->HeaderName = $headerName;
    $this->Url = $url;
    $this->Core = Core::getInstance();
  }
   
  /*
   * Get the Header
   */
  public function GetHeader()
  {
      return $this->HeaderName;
  }
  
  function GetCell($Entite)
  {
      
    $html = "<td>";
   
    $html .= "<a target='_blank' href='".$this->Core->GetPath("/" .$this->Url ."/" . $Entite->Code->Value)."' >".$Entite->Name->Value."</a>";
    
    $html .= "</td>";
    
    return $html;
      
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