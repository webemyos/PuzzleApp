<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Image;

use Core\Control\IControl;
use Core\Control\Control;

class Image extends Control implements IControl
{
	//Proprietes
	private $Directory;
	private $Src;
	private $Title;
	private $Description;
	private $Alt;
        public $ToolTip;

	//Constructeur
	function __construct($source,$description="")
	{
		//Version
		$this->Version ="2.0.0.1";

		$this->Src=$source;
		$this->Description = $description;
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<img src='";

		//Definition du repertoire
		if($this->Directory != "")
			$TextControl .= $this->Directory."/"  ;

		$TextControl .= $this->Src."' " ;
		$TextControl .= $this->getProperties();
		$TextControl .=" title='".$this->Title."'";
		$TextControl .=" alt ='".$this->Alt."'";

                if($this->ToolTip != "")
                {
                    $TextControl .= " onclick=\"".$this->ToolTip->DoAction()."\"";
                }
                
		$TextControl .="  />";

		if($this->Description != "")
			$TextControl .= "<br/><p class='Description'>".$this->Description."</p>";

		return $TextControl ;
	}

	//Asseceurs
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