<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

/**
 * Description of EntityProperty
 *
 * @author jerome
 */
//Class pour obtenir une liste d'entité liées par une table intermédiare
// Style Many To Manu

class ListProperty
{
    private $EntityField;
    private $Entity;
    private $PrimaryKey;
    private $SecondKey;	

	//Constructeur
	function __construct($entity, $entityField, $primaryKey, $secondKey)
	{
		$this->Entity=$entity;
		$this->EntityField=$entityField;
		$this->PrimaryKey = $primaryKey;
		$this->SecondKey = $secondKey;
	}

	//Assecceurs
	public function __get($name)
	{
	return $this->$name;
	}

	public function __set($name,$value)
	{
	$this->$name=$value;
}
}