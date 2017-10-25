<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EntityGrid;

use Core\Control\Control;
use Core\Control\IControl;

class EntityGrid extends Control implements IControl
{
  //Propriete
  private $Core;
  private $Entity;
  private $Column = array();
  private $Argument = array();
  private $Order= array();
  private $EntityLine;
  private $Count;
  private $EmptyVisible;
  private $LimitStart;
  private $LimitNumber;
  private $Asc;

  //Constructeur
  public function __construct($name, $core="")
  {
  	//Version
	$this->Version ="2.0.0.0";

    $this->Name = $name;
    $this->Core = $core;
    $this->Id = $name ;
    $this->EmptyVisible =true;
    $this->Asc=true;
  }

  //Ajout d'une colonne
  public function AddColumn($Column)
  {
    $this->Column[] = $Column;
  }

  //Ajout d'une colonne d'action
  public function AddActionColumn()
  {

  }

  //Ajout d'un ordre de tri
  public function AddOrder($order)
  {
    $this->Order[] = $order;
  }

  //Ajout d'une limite
  public function SetLimit($start,$number)
  {
  	$this->LimitStart = $start;
  	$this->LimitNumber = $number;
  }

  //Ajout d'un parametre
  public function AddArgument($argument)
  {
    $this->Argument[] = $argument;
  }

  //Chargement de la grille
  private function Load()
  {
    $lines ="";
    $Entites ="";

    //Creation de l'entit�
    $Entity = new $this->Entity($this->Core);
    $Entity->Asc= $this->Asc;

    //Ajout des ordres de tri
    if(sizeof($this->Order)>0)
    {
      foreach($this->Order as $order)
      {
        $Entity->AddOrder($Entity->$order);
      }
    }

   if($this->LimitStart != "")
	{
		$this->LimitStart.$this->LimitNumber;
		$Entity->SetLimit($this->LimitStart,$this->LimitNumber);
	}

    //Recuperation des entit�s
    if(sizeof($this->Argument) > 0)
    {
      foreach($this->Argument as $argument)
      {
        $Entity->AddArgument($argument);
      }

      $Entites = $Entity->GetByArg();
    }
    else
    {
      $Entites = $Entity->GetAll();
    }

    //Entete de le grille
    $lines .="\n<tr>";
    foreach($this->Column as $Column)
    {
        $lines .="\n\t<th>".$Column->GetHeader()."</th>";
    }
    $lines .="\n</tr>";

	$i=0;
	$this->Count=sizeof($Entites);

    //Chargement des lignes
    if($this->Count != 0)
    {
	    foreach($Entites as $Entite)
	    {
	      //Chargement des lignes
	      if($i == 0)
	      {
	      	$class ='lineFonce';
	      	$i++;
	      }
	      else
	      {
	      	$class ='lineClair';
	      	$i=0;
	      }

	      $lines .="\n<tr class='$class'>";
	      foreach($this->Column as $Column)
	      {
	        $lines .= $Column->GetCell($Entite);
	      }
	      $lines .="\n</tr>";
	    }
    }
    
    return $lines;
  }

  //Affichage
  public function Show()
  {
    $TextControl  =" \n<table " ;
    $TextControl .= $this->getProperties();
    $TextControl .= ">";

    $TextControl .= $this->Load();

    $TextControl .="</table>";

	if($this->Count == 0 && $this->EmptyVisible)
    	return $TextControl;
    else if($this->Count>0)
    	return $TextControl;
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
