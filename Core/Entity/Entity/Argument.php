<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

use Core\Core\Core;
use Core\Utility\Format\Format;

/**
 * Description of Argument
 *
 * @author jerome
 */
//Argument d'une entite utilise pour la selection
class Argument
{
	//propriete
	private $Entity;
	private $Field;
	private $EntityField;
	private $Operator;
	private $Value;
	private $Data;

	//Constructeur
	function __construct($entity, $field, $operateur, $value="")
	{
            $core= Core::getInstance();
            
            $this->Entity=new $entity($core);

            if(is_object($this->Entity->$field))
            {
                $this->Field=$this->Entity->$field->TableName;
            }
            else
            {
            if($field == "IdEntite")
                    $this->Field = "Id";
            else
                    $this->Field = $field;
            }

            $this->EntityField=$field;
            $this->Operator=$operateur;
            $this->Value= Format::EscapeString($value);

            switch($operateur)
            {
                    case "Equal":
                            $this->Data= $this->Field . " = '".Format::EscapeString($value)."' " ;
                    break;
                    case "NotEqual":
                            $this->Data = $this->Field ." <> '".Format::EscapeString($value)."' ";
                    break;
                    case "Less":
                            $this->Data =$this->Field ." < '".Format::EscapeString($value)." '";
                    break;
                    case "More":
                            $this->Data =$this->Field ." > '".Format::EscapeString($value)." '";
                    break;
                    case "Like":
                            $this->Data =$this->Field ." like '".Format::EscapeString($value)."%'";
                    break;
                    case "IsNull":
                            $this->Data = $this->Field." is null";
                            $value = ISNULL;
                    break;
                    case "In":
                            $this->Data = $this->Field ." in( ".$value.") ";
                    break;
                    case NOTIN:
                            $this->Data = $this->Field ." not in( ".$value.") ";
                    break;
            }

            $this->Value=$value;
	}

	//Assesseur
	public function __get($name)
	{
		return $this->$name;
	}
	//acsesceur
	public function __set($name,$value)
	{
      $this->$name=$value;
	}
}