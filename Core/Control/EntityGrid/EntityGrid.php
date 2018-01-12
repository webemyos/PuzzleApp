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
use Core\Core\Request;

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
  private $App;
  private $Action;
  private $Params;

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

    $page = Request::GetPost("Page");
    
   if($this->LimitStart != "")
    {
            $this->LimitStart.$this->LimitNumber;
            $Entity->SetLimit($this->LimitStart,$this->LimitNumber);
    }
    else if($page != "" )
    {
       $Entity->SetLimit($page == 0 ? 1 : $page * 10 + 1, 10); 
    }
    else
    {
        $Entity->SetLimit(1, 10);
    }

     $sort = Request::GetPost("Sort");
     
    if($sort != "" )
    {
        //Sauvegarde l'order de tri en session
        $Entity->AddOrder($sort);
    }
    
    
    //Recuperation des entit�s
    if(sizeof($this->Argument) > 0)
    {
      foreach($this->Argument as $argument)
      {
        $Entity->AddArgument($argument);
        $lines .= "<input type='hidden' name='".$argument->Field."' value='".$argument->Value."' />" ;   
      }

      $Entites = $Entity->GetByArg();
    }
    else
    {
      $Entites = $Entity->GetAll();
    }

    //Nombre d'element et numéro
    $lines .= "<tr>";
    $lines .="<th colspan='8'>";
    $nbElement =  $Entity->GetCount();
    
    $lines .= "Nombre d'element :" . $nbElement;
    
    //Numero de pagde
    $nbPage = $nbElement / 10;
    
    //$lines .= "<th class='pager'  colspan='2'>";
    for($i = 0; $i < $nbPage ; $i++)
    { 
        $lines .= "<span class='entityPager' >".$i."</span>";
    }
    $lines .= "</th>";
    
    $lines .= "</tr>";
    
    
    //Entete de le grille
    $lines .="\n<tr>";
    foreach($this->Column as $Column)
    {
        $lines .="\n\t<th class='order'>".$Column->GetHeader()."</th>";
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
    $html  =" \n<table class='grid' data-app='" . $this->App ."' data-action='" . $this->Action . "' data-order=''  data-params='".$this->Params."'  "   ;
    $html .= $this->getProperties();
    $html .= ">";
    
    $html .= $this->Load();

    $html .="</table>";
    
    
	if($this->Count == 0 && $this->EmptyVisible)
    	return $html;
    else if($this->Count>0)
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
?>
