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

//Classe de base qui appele une fonction de classe quelconque
class EntityIconColumn extends Control implements IColumn
{
  //Propriete
  private $HeaderName;
  private $Icons;

  //Constructeur
  function __construct($headerName, $icons)
  {
    $this->HeaderName = $headerName;
    $this->Icons = $icons;
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
    foreach($this->Icons as $icone)
    {
        $type = "Core\Control\Icone\\". $icone[0];
        $title = $icone[1];
        $action = $icone[2];
        $params = $icone[3];
        
        
        $icone = new $type();
        $icone->CssClass .= " actionIcon";
        $icone->Title = $title;
        $icone->Action = $action;
        $icone->IdEntite = $Entite->IdEntite;
        
        foreach($params as $param)
        {
           if($icone->Params != "")
           {
               $icone->Params .= ";";
           }
           $icone->Params .= $Entite->$param->Value;
        }
        
        $html .= $icone->Show();
    }
    
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