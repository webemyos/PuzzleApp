<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Block\LinkBlock;

use Core\Block\Block;

class LinkBlock extends Block 
{
	//Constructeur
	function __construct($name)
	{
		//Version
 		$this->Version = "2.0.1.0";

		$this->Id =$name;
		$tis->Name= $name;
	}

	//Ajout d'un lien avec retour � la ligne
	function AddNewLink($libelle,$url,$image="")
	 {
	 	$link = new Link($libelle,$url);

	 	if($image)
	 	{
	 		if(!is_object($image))
	 		$image = new Image("$image");
	 		$image->AddStyle("width","25px");

	 		parent::AddNew($image);
	 		parent::Add($link);
	 	}
	 	else
	 	{
			parent::AddNew($link);
	 	}
	}

	//Affichage
	function Show()
	{
		//Declaration de la balise
		return parent::Show();
	}

	public function LoadControl()
	{}
	public function CallMethod()
	{}
	public function Create()
	{}
	public function Init()
	{}

	//Asseceur
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