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
class EntityActionColumn extends Control implements IColumn
{
  //Propriete
  private $HeaderName;
  private $Classe;
  private $Methode;
  private $Argument;
  private $Image;
  private $Title;
  private $ClassCss;

  //Constructeur
  function __construct($headerName , $classe, $image, $title, $classCss = "")
  {
    $this->HeaderName = $headerName;
    $this->Image= $image;
    $this->Classe = $classe;
    $this->Title = $title ;
    $this->ClassCss = $classCss;
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
    //Ajout de l'identifiant de l'entit�
    $this->Classe->AddArgument("idEntity",$Entite->IdEntite);
    
    if($this->Image != "")
    {
    	$img= "<img src='".$this->Image."'     title='".$this->Title."'>";
    }
    else
    {
    	$img ="";
    }
    
    if($this->ClassCss != '')
    {
 		$class= " class='".$this->ClassCss."'";   
    }
    else
    {
    	$class = "";
    }
    
    return "\n\t<td style='text-align:center;' onClick=\"".$this->Classe->DoAction()."\"    title='".$this->Title."' ><b $class>&nbsp;".$img."</b></td>";
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