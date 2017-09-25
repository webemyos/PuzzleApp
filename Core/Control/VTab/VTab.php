<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\VTab;

use Core\Control\IControl;
use Core\Control\Control;


class VTab extends Control
{
	//Propriete
	private $TitleIndex=array();
	private $Body=array();
	private $Img = array();
        private $CssClassTab = array();
	private $i;
	public $SelectedIndex;

	//Constructeur
	function __construct($name="")
	{
		//Version
		$this->Version ="2.0.2.0";

		$this->i=0;

		$this->Id = $name;
		$this->Name = $name;
	}

	//Ajout d'onglet
	function AddTab($titleIndex,$control,$selected = false, $img="", $cssClass= "")
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

		//Affichage
	function Show()
	{
		$TextControl="<div class='".($this->CssClass)."' id='".$this->Name."'><table>";
		$iTab=0;

		//Insertion des onglets
		foreach($this->TitleIndex as $title)
		{

		 if(isset($this->Img[$iTab]) && $this->Img[$iTab] != "")
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

		 if($iTab == $Selected)
		 {
		 	$TextControl.="<tr><th id=\"".$this->Name."_vindex_".$iTab."\" class='VTabStripEnabled active' onclick=\"VTab.ShowTab(this,'".$this->Name."_vtab_".$iTab."',".sizeof($this->TitleIndex).", '".$this->Name."' );\" name='".$title."' title='".$title."'><span>".$Icone.$title."</span></th></tr>";
			$TextControl .="<tr><td><div id='".$this->Name."_vtab_".$iTab."' class='tabEnabled' >".$this->Body[$iTab]->Show()."</div></td></tr>";

		 }
		 else
		 {
			 $TextControl.="<tr><th id=\"".$this->Name."_vindex_".$iTab."\" class ='VTabStripDisabled' onclick=\"VTab.ShowTab(this,'".$this->Name."_vtab_".$iTab."',".sizeof($this->TitleIndex).", '".$this->Name."'  );\" name='".$title."' title='".$title."'><span>".$Icone.$title."</span></th></tr>";
			$TextControl .="<tr><td><div id='".$this->Name."_vtab_".$iTab."' class='tabDisabled' style='height:0px;overflow:hidden;display: none;'>".$this->Body[$iTab]->Show()."</div></td></tr>";
		 }
		 $iTab++;
		}
		$TextControl.="</table></div>";


		return $TextControl;
	}
}

?>