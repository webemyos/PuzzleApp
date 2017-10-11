<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\TabStrip;

 use Core\Control\Control;
 use Core\Control\IControl;

class TabStrip  extends Control implements IControl
{
	//Propriete
	private $TitleIndex=array();
	private $Body=array();
	private $Img = array();
	private $CssClassTab = array();
	private $i;
	private $SelectedIndex;
	private $App;
	private $Widget;

	//Constructeur
	function __construct($name="", $app="", $widget="")
	{
		//Version
		$this->Version ="2.0.2.0";

		$this->i=0;

		$this->Id = $name;
		$this->Name = $name;
		$this->App = $app;
		$this->Widget = $widget;
	}

	//Ajout d'onglet
	function AddTab($titleIndex, $control, $selected = false, $img="", $cssClass= "")
	{
		$this->TitleIndex[$this->i]=$titleIndex;
		$this->Body[$this->i]=$control;
		$this->Img[$this->i]=$img;
		$this->CssClassTab[$this->i] = $cssClass;

		if($selected)
		{
			$this->SelectedIndex = $this->i;
		}
		$this->i++;
	}

	function RefreshTab($index,$control)
	{
		$this->Body[$index]=$control;
	}
	//Affichage
	function Show()
	{
		$TextControl="<div class='".($this->CssClass)."' id='".$this->Name."'><table><tr>";
		$iTab=0;

		//Insertion des onglets
		foreach($this->TitleIndex as $title)
		{

		 if($this->Img[$iTab] != "")
		 {
		  $img= new Image($this->Img[$iTab]);
		  $img->AddStyle("width","20px");
		  $Icone = $img->Show();
		 }
		 else
		 {
		 	$Icone ="";
		 }

		 if($this->CssClassTab[$iTab] != "")
		 {
		  	$class = $this->CssClassTab[$iTab];
		 }
		 else
		 {
		 	$class ="";
		 }

		$Selected =($this->SelectedIndex != "")?$this->SelectedIndex:0;

		if($this->App)
		{
			$name = $this->App;
		}
		else
		{
			$name = $this->Widget;
		}


		 if($iTab == $Selected)
			 $TextControl.="<th id=\"index_".$iTab."\" class='TabStripEnabled $class' onclick=\"TabStrip.ShowTab(this,'tab_".$iTab."',".sizeof($this->TitleIndex).", '".$name."',  '".$this->Widget."');\" name='".$title."' title='".$title."'><span>".$Icone.$title."</span></th>";
		 else
			 $TextControl.="<th id=\"index_".$iTab."\" class ='TabStripDisabled $class' onclick=\"TabStrip.ShowTab(this,'tab_".$iTab."',".sizeof($this->TitleIndex).", '".$name."', '".$this->Widget."');\" name='".$title."' title='".$title."'><span>".$Icone.$title."</span></th>";
		 $iTab++;
		}
		$TextControl.="</tr></table>";

		$iTab=0;

		//Insertion des textes
		foreach($this->Body as $tab)
		{
			if($iTab == $Selected)
				$TextControl .="<div id='tab_".$iTab."' class='TabContent' >".$tab->Show()."</div>";
			else
				$TextControl .="<div id='tab_".$iTab."' class='TabContent'  style='height:0px;overflow:hidden;display: none;'>".$tab->Show()."</div>";
			$iTab++;
		}
		$TextControl .="</div>";
		return $TextControl;
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
