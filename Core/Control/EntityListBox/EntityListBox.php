<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\EntityListBox;

use Core\Control\IControl;
use Core\Control\Control;
use Core\Control\ListBox\ListBox;

 class EntityListBox extends Control implements IControl
 {
 	 //Propriete
	  private $Core;
	  private $Entity;
	  private $ListBox;
	  private $Selected;
	  private $Argument = array();
	  private $Fields = array();

	//Constructeur
	public function __construct($name, $core="")
	{
	  	//Version
		$this->Version ="2.0.0.0";

	    $this->Name = $name;
	    $this->Core = $core;
	    $this->Id = $name ;
	    $this->EmptyVisible =false;
	    $this->Asc=true;

	    $this->ListBox = new ListBox($name);
	    $this->ListBox->Libelle = $this->Libelle;
   }

   //Ajout d'un parametre
   public function AddArgument($argument)
   {
     $this->Argument[] = $argument;
   }

  //Ajout d'un champ
  public function AddField($field)
  {
  	$this->Fields[] = $field;
  }

   //Chargement
   private function Load()
   {

	//Creation de l'entit�
    $Entity = new $this->Entity($this->Core);

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
    if(sizeof($Entites)> 0)
    {
		//Chargement
		foreach($Entites as $entity)
		{
			if(sizeof($this->Fields)>0)
			{
				$Value ="";
				foreach($this->Fields as $fields)
				{
					$field = $fields;
					$Value .= " ".$entity->$field->Value;
				}

			  $this->ListBox->Add($Value,$entity->IdEntite);

			}
			else
			  $this->ListBox->Add($entity->Name->Value,$entity->IdEntite);
		}
    }
   }

    //Affichage
  public function Show()
  {
  	//Chargement
    $this->Load();

    if($this->Selected)
		$this->ListBox->Selected = $this->Selected;

   return $this->ListBox->Show();

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
