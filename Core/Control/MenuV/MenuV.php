<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\MenuV;

use Core\Control\IControl;
use Core\Control\Control;

class MenuV extends Control implements IControl
{
	//Proprietes
	var $item;
	var $subItem;
	var $iItem=0;
	var $iSubItem=0;

	//Constructeur
	function Menu($name)
	{
		//Version
		$this->Version ="2.0.0.0";

		$this->Id=$name;
		$this->Name=$name;
	}

	//Ajout d'un menu principal
	function AddItem($Libelle, $Url="", $img="", $sizeImg="", $id="", $icone = "")
	{
		$this->item[$this->iItem]["libelle"]= $Libelle;
		$this->item[$this->iItem]["url"]=$Url;
		$this->item[$this->iItem]["img"]=$img;
		$this->item[$this->iItem]["sizeImg"]=$sizeImg;
		$this->item[$this->iItem]["id"]=$id;
		$this->item[$this->iItem]["icone"]= $icone;

		$this->iItem ++;
	}

	//Ajout d'un sous menu
	function AddSubItem($Ref,$Libelle,$Url,$id="", $img="", $icone ="")
	{
		$this->subItem[$this->iSubItem]["ref"]=$Ref;
		$this->subItem[$this->iSubItem]["libelle"]=$Libelle;
		$this->subItem[$this->iSubItem]["url"]=$Url;
		$this->subItem[$this->iSubItem]["id"]=$id;
		$this->subItem[$this->iSubItem]["img"]=$img;
		$this->subItem[$this->iSubItem]["icone"]= $icone;

		$this->iSubItem++;
	}

	//Recuperation d'un sous menu
	function GetSubMenu($subItems,$i)
	{
		if(sizeof($this->subItem)>0)
		{
			$TextSub="<div id='subItem$i' class='sub' onmouseover=\"MenuV.openSubMenu('subItem$i',this, '$this->Name');\" onmouseout=\"MenuV.CloseSubMenu('subItem$i',this, '$this->Name')\">";
			foreach($this->subItem as $items)
					{
						if($items["ref"]==$subItems)
							{
								if(isset($items["img"]) && $items["img"] != "")
								{	$img= new Image($items["img"]);
									$Icone = $img->Show();
								}
								else if(isset($items["icone"]) && $items["icone"] != "")
								{
									$items["icone"]->Show();
									$Icone=$items["icone"]->Show();
								}
								else
								{
									$Icone="";
								}

								if(isset($items["url"]) && $items["url"] != "")
									$TextSub.="<div class='subitem'>".$Icone."<a href='".$items["url"]."' >".$items["libelle"]."</a></div>";
								else
									$TextSub.="<div class='subitem' ><a href='#".$items["url"]."' id='".$items['id']."'>".$Icone.$items["libelle"]."</a></div>";

								$TextSub.=$this->GetSubMenu($items["libelle"],$i);
							}
					}
			$TextSub .="</div>";
			return 	$TextSub;
		}
	}

	//Affichage
	function Show()
	{
		$TextControl ="\n<table ";
		$TextControl .= $this->getProperties();
		$TextControl .=" cellspacing='0'>";
		$TextControl .="\n<tr>";
		$i=0;

		foreach($this->item as $items)
		{
			$TextControl .="\n\t<td class='headItem' id='".$items["id"]."'>";

			if($items["img"] != "")
			{	$img= new Image("Images/Menu/".$items["img"]);

				if($items["sizeImg"] != "") $img->AddStyle("width",$items["sizeImg"]."px");
				else $img->AddStyle("width","40px");

				$Icone = $img->Show();
			}
			else
			{
				$Icone ="";
			}

			if($items["url"] != "")
				$TextControl.=$Icone."<a href='".$items["url"]."' class='item' onmouseover=\"MenuV.openSubMenu('subItem$i',this, '$this->Name');\" onmouseout=\"MenuV.CloseSubMenu('subItem$i',this, '$this->Name')\">".$items["libelle"]."</a><br/>";
			else
				$TextControl.=$Icone."<a href='#".$items["url"]."' class='item' onmouseover=\"MenuV.openSubMenu('subItem$i',this, '$this->Name');\" onmouseout=\"MenuV.CloseSubMenu('subItem$i',this,'$this->Name')\">".$items["libelle"]."</a><br/>";

			$TextControl .=$this->GetSubMenu($items["libelle"],$i);

			$TextControl .="</td>";
			$i++;
		}
		 $TextControl .="\n</tr>\n</table>";

		return $TextControl;
	}
}
?>