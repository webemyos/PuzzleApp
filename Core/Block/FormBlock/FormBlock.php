<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Block\FormBlock;

use Core\Block\Block;


abstract class Form extends Block
{
	private $Method;
	private $file;
	private $Action;
	private $UserAction;
	private $AjaxAction;
	private $ControlAction;
	private $ControlProperty;
	private $IdEntity;
	private $ClassAction;
	private $MethodAction;
	private $ArgumentAction;
	private $Sender;
	private $TypeAction;

	//Constructeur
	function __construct($name="",$fichier="",$mode="",$type="",$core="")
	{
		//Version
 		$this->Version = "2.0.0.0";

		$this->Core = $core;
		$this->Name=$name;
		$this->Method=$mode;
		$this->File=$fichier;
		$this->TypeAction=$type;

		if($type=="Page")
		{
		//Variables d'actions
		$this->Action="<input type='hidden' name='Action' value='' />";
		$this->UserAction="<input type='hidden' id='UserAction' name='UserAction' value='' />";
		$this->AjaxAction="<input type='hidden' name='AjaxAction' value='' />";
		$this->IdEntity="<input type='hidden' name='IdEntity' value='' />";
		$this->Sender="<input type='hidden' name='Sender' value='' />";
		}
		else if($type=="Bloc")
		{
		//Variables d'actions des blocs
		$this->UserAction="<input type='hidden' name='UserAction' value='' />";
		}
		$this->Arg = "<input type='hidden' name='Arg' value='' />";
	}

	//Affichage du control
	function Show()
	{
		//Declaration de la balise
		$TextControl ="\n<form  ";
		$TextControl .= $this->getProperties();

		//Propriete de formulaire
		$TextControl .="  method='".$this->Method."' " ;
		$TextControl .="  action='".$this->File."' enctype='multipart/form-data'>";

		if($this->TypeAction=="Page")
		{
			//Ajout des variables d'action
			$TextControl .= "\n".$this->Action;
			$TextControl .= "\n".$this->UserAction;
			$TextControl .="\n".$this->Arg;
			$TextControl .= "\n".$this->AjaxAction;
			$TextControl .= "\n".$this->IdEntity;
			$TextControl .= "\n".$this->Sender;
		}
		else if($this->TypeAction=="Bloc")
		{
		$TextControl .= "\n".$this->UserAction;
		}

		//Si on met dans un cadre
		/*if($this->Frame)
			{
			$TextControl .="<table class='Form' cellpadding='0' cellspacing='0'>";
			$TextControl .="<tr><td class='CoinGaucheHaut' ></td>";
			$TextControl .= "<th class='BordHautForm'>".$this->Title."</th>";
			$TextControl .="<td class='CoinDroitHaut'></td></tr>";
			$TextControl .="<tr><td class='BordGauche' width='25px'></td><td class='FormBodyForm'>";
			}
*/
		//Mise en forme dans un tableau
		if($this->Table)
			$TextControl .="<table><tr>\n";

		//Ajout des controls
		$TextControl .= $this->Body;

	//fermeture du tableau
		if($this->Table)
			$TextControl .="</table>\n";

		$TextControl .="</form>\n";
		//$this->Body .= $TextControl;
		return $TextControl;
	}
}

//Classe deriv�e de JHomForm
class FormBlock  extends Form
{

}
?>