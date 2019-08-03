<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control;

use Core\Core\Core;
use Core\Core\Request;

class Control
{
	//Proprietes
	protected $Id;
	protected $Name;
	protected $Enabled=true;
    protected $Required = false;
	protected $Type;
	protected $CssClass;
	protected $Style;
	protected $Attribute;
	protected $Libelle;
	protected $Value;
	protected $LangValue;
	protected $DataSet;
	protected $OnClick;
	protected $OnMouseMove;
	protected $OnMouseOver;
	protected $OnMouseEnter;
	protected $OnMouseLeave;
	protected $OnMouseOut;
	protected $OnChange;
	protected $OnKeyUp;
	protected $RegExp;
	protected $MessageErreur;
	protected $MessageObligatoire;
	protected $IsValid=true;
	protected $Obligatory=true;
	protected $PlaceHolder;
    protected $AutoCapitalize = "None";
    protected $AutoCorrect = "None";
    protected $AutoComplete = "None";
    protected $Info;

	//Constructeur
	function __construct($name)
	{
		//Version
		$this->Version ="2.0.1.1";

		$this->Name=$name;
	}

	//Ajout de style
	function AddStyle($property,$value)
	{
		$this->Style.=$property.":".$value.";";
	}

        /*
         * Ajoutun icone info
         */
        function SetInfo($info)
        {
            $this->Info = $info;
        }
        
	//Ajout d'attributs
	function AddAttribute($event,$action)
	{
		$this->Attribute.=$event."='".$action."' ";
	}

	/**
	 * Ajout d"element type data-type
	 */
	function AddDataSet($key, $value)
	{
		$this->DataSet .= "data-" .$key ." ='".$value."' ";
	}
        
	//Fonction d'affichage du control
	function Show()
	{
		$html ="\n<input type='".$this->Type."'";
		$html .= $this->getProperties();
		$html .="></input>";

		//Affichage d'une eventuelle erreur d'expression reguliere saisie
		if(!$this->IsValid)
		{
                    $html .="<span style='color:red;'> ".(($this->MessageErreur)?$this->MessageErreur:'Invalide')." </span>";
		}

		//Affichage d'un champ obligatoire non saisi
		if(!$this->Obligatory)
		{
			//TODO gerer si on vu on non l'�toile'$html .="<span style='color:blue;'> ".(($this->MessageObligatoire)?$this->MessageObligatoire:'*')." </span>";
			//$html .="<span style='color:blue;'> ".(($this->MessageObligatoire)?$this->MessageObligatoire:'')." </span>";
		}

                if($this->Info != "")
                {
                    $html .= "&nbsp;<p class='fa fa-info' title='".$this->Info."' >&nbsp;</p>";
                }
		return $html ;
	}

	//Retourne les propri�tes du control
	protected function getProperties($addValue = true)
	{
		$html ="";

		$html .=($this->Id  !="")?"id='".$this->Id."' ":"";
		$html .=($this->Name !="")?"name='".$this->Name."' ":"";
		$html .=($this->Enabled !=true)?" Disabled " :"";
		$html .=($this->CssClass !="")?" class='".$this->CssClass."' " :  "";
		$html .=($this->Style !="")?"    style='".$this->Style."'    "  :  "";
		$html .=($this->Attribute !="")? $this->Attribute : "";
		$html .=($this->DataSet !="")? $this->DataSet : "";

		//  $html .= $this->Required;
        $html .=($this->Required === true || $this->Required === "1"  )?" required "  :  "";
	
		if($addValue)
		{
			//Reload the value if In post
			if(Request::GetPost($this->Id) !== false && get_class($this) != "Core\Control\Submit\Submit"  && get_class($this) != "Core\Control\Button\Button" )
			{
				$this->Value = !is_array(Request::GetPost($this->Id))?Request::GetPost($this->Id):"" ;
			}
			if($this->LangValue != "")
			{
				$core = Core::getInstance();
				$html .= "value='".$core->GetCode($this->LangValue)."'";
			}
			else
			{
				$html .=($this->Value !="")? "  value='".$this->Value."'" : "";
			}
		}
                
		
		//Gestion des actions
		if(is_object($this->OnClick))
			$html .=($this->OnClick != "")? " onclick=\"".$this->OnClick->DoAction()."\"": "";
		else
			$html .=($this->OnClick != "")? " onclick=\"".$this->OnClick."\"": "";

		//Survol de la sourie
		if(is_object($this->OnMouseMove))
			$html .=($this->OnMouseMove != "")? " onmousemove=\"".$this->OnMouseMove->DoAction()."\"": "";
		else
			$html .=($this->OnMouseMove != "")? " onmousemove=\"".$this->OnMouseMove."\"": "";

		//Passage de la sourie
		if(is_object($this->OnMouseOver))
			$html .=($this->OnMouseOver != "")? " onmouseover=\"".$this->OnMouseOver->DoAction()."\"": "";
		else
			$html .=($this->OnMouseOver != "")? " onmouseover=\"".$this->OnMouseOver."\"": "";

		//Entr�e de la sourie
		if(is_object($this->OnMouseEnter))
			$html .=($this->OnMouseEnter != "")? " onmouseenter=\"".$this->OnMouseEnter->DoAction()."\"": "";
		else
			$html .=($this->OnMouseEnter != "")? " onmouseenter=\"".$this->OnMouseEnter."\"": "";

		//Sourie de la sourie
		if(is_object($this->OnMouseLeave))
			$html .=($this->OnMouseLeave != "")? " onmouseleave=\"".$this->OnMouseLeave->DoAction()."\"": "";
		else
			$html .=($this->OnMouseLeave != "")? " onmouseleave=\"".$this->OnMouseLeave."\"": "";

		//Sortie de la sourie
		if(is_object($this->OnMouseOut))
			$html .=($this->OnMouseOut != "")? " onmouseout=\"".$this->OnMouseOut->DoAction()."\"": "";
		else
			$html .=($this->OnMouseOut != "")? " onmouseout=\"".$this->OnMouseOut."\"": "";

		//Changement de la valeur
		if(is_object($this->OnChange))
			$html .=($this->OnChange != "")? " onchange=\"".$this->OnChange->DoAction()."\"": "";
		else
			$html .=($this->OnChange != "")? " onchange=\"".$this->OnChange."\"": "";

		//Sortie du clavier
		if(is_object($this->OnKeyUp))
			$html .=($this->OnKeyUp != "")? " onkeyup=\"".$this->OnKeyUp->DoAction()."\"": "";
		else
			$html .=($this->OnKeyUp != "")? " onkeyup=\"".$this->OnKeyUp."\"": "";

		//TODO d�finir la prorri�t� Ben
		if($this->PlaceHolder != "")
		{
			$html .= " placeholder='".$this->PlaceHolder."'";
		}

		return $html;
	}

	//fonction de verification
	public function Verify()
	{
		$verif=true;

		if($this->Value !="")
			{
				//Test d'une expression reguliere
				if($this->RegExp != "")
				{
					if(!preg_match(''.$this->RegExp.'', $this->Value))
				    	 $verif=false;
				}
			}
			$this->IsValid=$verif;

		return $verif;
	}

	//asseceurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
	  $this->$name=$value;
	}
}

//Interface obligatoires pour tout les controls
interface IControl
 {
	public function Show();
	public function Verify();
 }

?>