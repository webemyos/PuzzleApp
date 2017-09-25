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
//Class pour obtenir une propriï¿½tï¿½ d'une autre entitï¿½
class EntityProperty
{
	private $EntityField;
	private $Entity;
	private $Value;
	private $TableName;
	private $IdEntite;

	//Constructeur
	function __construct($entity,$entityField)
	{
            $this->Entity=$entity;
            $this->EntityField=$entityField;
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
