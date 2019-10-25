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
class UploadProperty
{
	private $EntityField;
	private $Entity;
	private $Value;
	private $TableName;
	private $IdEntite;
	private $App;

	//Constructeur
	function __construct($app, $label)
	{
		$this->App = $app;
		$this->Type = UPLOAD;
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