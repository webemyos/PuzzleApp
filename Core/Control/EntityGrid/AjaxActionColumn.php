<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EntityGrid;

use Core\Action\AjaxAction\AjaxAction;
use Core\Control\Control;
use Core\Control\Grid\IColumn;
use Core\Control\Image\Image;

//Column d'action ajax
class AjaxActionColumn extends Control implements IColumn
{
    //Propri�tes
  private $HeaderName;
  private $PropertyName;
  private $EntityProperty;
  private $Methode;
  private $Title;
  private $Directory;
  private $ChangedControl;
  private $ClassCss;
  private $Argument;

  //Constructeur
  function __construct($headerName , $classe, $methode,$argument="",$image,$title,$changedControl ="", $confirm = false, $classCss ="")
  {
    $this->HeaderName = $headerName;
    $this->Image= $image;
    $this->Classe = $classe;
    $this->Methode = $methode;
    $this->Title = $title;
    $this->ChangedControl = $changedControl;
    $this->Argument = $argument;
    $this->Confirm = $confirm;
    $this->ClassCss = $classCss;
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
  	$Action = new AjaxAction($this->Classe,$this->Methode);

  	if($this->Confirm)
  		$Action->Confirm = $Entite->Core->GetCode("DeleteElement")."?";

  	$Action->AddArgument("idEntity",$Entite->IdEntite);
  	$Action->AddArgument($this->Argument);
  	$Action->ChangedControl =$this->ChangedControl;
  
  
     if($this->Image != "")
    {
        $Image = new Image($this->Image);
        $Image->Title = $this->Title;
    	$img = $Image->Show();
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


    return "\n\t<td onClick =\"".$Action->DoAction()."\"  title='".$this->Title."'><b $class>&nbsp;".$img."</b></td>";
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


