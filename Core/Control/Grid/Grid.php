<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Grid;

use Core\Control\Control;

 class Grid extends Control
 {
 	public $DataSource;
	private $Headers;
	private $Line=array();
	private $Footer;

	private $Body;
	private $Count;
	private $NullVisible=false;
	private $IdVisible=false;
	private $OnLineclick;
	private $ActionCells=array();
	private $Column = array();
	private $IdName;
	private $NumberRows;

	//Constructeur
	function __construct()
	{
		//Version
		$this->Version ="2.0.0.0";

	}

	//Ajout d'une colonne
	public function AddColumn($Column)
	{
		$this->Column[] = $Column;
	}

	//Ajout une ligne
	function AddLine($line)
	{
	 $this->Line[]=$line;
	}

	//Remplie la table
	function Bind()
	{

     $this->Body  =" \n<table " ;
     $this->Body .= $this->getProperties();
     $this->Body .= ">";

		$Iline=0;
		$Icell=0;
		$this->Lines ="<tr>";

		//Ajout de la ligne d'entete
		foreach($this->Headers as $dataCell)
		{
			$this->Lines.="<th>".$dataCell."</th>";
			$TabGrid[$Iline][$Icell]="<th>".$dataCell."</th>";
			$Icell++;
		}

		//Colonnes d' action
		foreach($this->ActionCells as $dataCell)
		{
			$this->Lines.="<th>".$dataCell->Name."</th>";
			$TabGrid[$Iline][$Icell]="<th>".$dataCell->Name."</th>";
			$Icell++;
		}

		$this->Lines .="</tr>";

		//Ajout des lignes
		foreach($this->Line as $datalines)
			{
				$this->Lines .="\n<tr id='".($Iline+1)."'>";
				$i=0;
				$Iline++;
				$Icell=0;
					foreach($datalines as $dataCell)
					{
						//On affiche pas l'identifiant
						if($i>0 || $this->IdVisible)
								{
									if(1==2/*$this->OnLineclick->DoAction() != ""*/ && $Icell ==1)
											{
												//$this->Lines .="\n<td id='".$datalines['Id']."' onclick=".$this->OnLineclick->DoAction()." >$dataCell</td>";
												//$TabGrid[$Iline][$Icell]="\n<td id='".$datalines['Id']."' onclick=".$this->OnLineclick->DoAction()." >$dataCell</td>";
											}
										else
										{
											$this->Lines .="\n<td>$dataCell</td>";
											$TabGrid[$Iline][$Icell]="\n<td>$dataCell</td>";
										}
								}
					$i++;
					$Icell++;
				    }

					foreach($this->ActionCells as $dataCell)
					{
						$this->Lines.="\n\t<td id='".$datalines['Id']./*"'".$dataCell->DoAction().*/">$dataCell->Name</td>";
						//$TabGrid[$Iline][$Icell]="\n\t<td id='".$datalines['Id']."'".$dataCell->DoAction().">$dataCell->Name</td>";
						$Icell++;
					}
				$this->Lines .="</tr>";
			}
		$this->Lines.="\n</table>";
		$_SESSION[$this->Id]=$TabGrid;
		$this->Body .= $this->Lines;
		$this->count=sizeof($this->Line);
	}

	//Chargement du tableau par les colonnes
	function BindColumn()
	{
		$this->Body  =" \n<table " ;
        $this->Body .= $this->getProperties();
        $this->Body .= ">";

		$Iline=0;
		$Icell=0;
		$this->Lines ="<tr>";

		//Ajout de la ligne d'entete
		foreach($this->Column as $column)
		{
			$this->Lines.="<th>".$column->HeaderName."</th>";
			$TabGrid[$Iline][$Icell]="<th>".$column->HeaderName."</th>";
			$Icell++;
		}
	    $this->Lines .="</tr>";

            
          	//Ajout des data
		foreach($this->DataSource as $source)
		{
			$this->Lines .="<tr>";
			//Ajout de la ligne d'entete
			foreach($this->Column as $column)
			{
				$this->Lines.= $column->GetCell($source,$this->IdName);
				$TabGrid[$Iline][$Icell]="<th>".$column->HeaderName."</th>";
				$Icell++;
			}
			$this->Lines .="</tr>";
		}

		$this->Lines.="\n</table>";

		$this->Body .= $this->Lines;
	}

	//Affichage
	function Show()
	{
            //Chargement par les colonnes ou simplement
            if(sizeof($this->Column)== 0)
                    $this->Bind();
            else
                    $this->BindColumn();

            return $this->Body;
	}

	//Ajout d'un colonne d'action
	function AddAction($action)
	{
		$this->ActionCells[]=$action;
	}

	//Asseceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
		if($name=="DataSource")
		{
			foreach($value as $line)
				 $this->AddLine($line);
		}
      	$this->$name=$value;
	}
 }
?>