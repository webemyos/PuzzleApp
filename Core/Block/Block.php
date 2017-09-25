<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Block;

use Core\Core\Core;
use Core\Control\Control;
use Core\Core\Request;
use Core\Utility\File\File;


class Block extends Control
{
	//Proprietes
	private $ShowObligatoryField;

	protected $Body="";
	protected $Table=false;
	protected $Frame=true;
	protected $Title;
	protected $IsValid;
	protected $Core;
	protected $Parameters = array();
	protected $Template;

	public $BackgroundImage;
	public $Localise = false;

	//Constructeur
	function __construct($core="", $name ="")
	{
		//Version
 		$this->Version = "2.0.2.0";

		$this->Core = Core::getInstance();
                
		//Classe par defaut
		$this->CssClass = "Frame";

    if($name != "")
    {
		  $this->Id= $name;
    }
    else
    { 
      $this->Id= "Block";
    }
	}

	//Insertion d'un control
	public function Add($Control,$cell="", $row="", $attribut="", $ajaxAction ="")
	{
		//Nombre de cellule
		if($cell != "")
			$colspan ="colspan='".$cell."'";
		else
			$colspan ="";

		if($row != "")
			$rowsspan ="rowspan='".$row."'";
		else
			$rowsspan ="";

		if($ajaxAction != "")
		{
			$ajaxAction->AddControl($Control->Control->Id);
		}

		if($this->Localise)
		{
			$libelle = $this->Core->GetCode($Control->Libelle);
		}
		else
		{
			$libelle = $Control->Libelle;
		}

		//Nombre de ligne
		if($this->Table)
		{
			//pour les checbox le libelle est derrier
			if($Control->Libelle != "" && (get_class($Control) !="CheckBox" && get_class($Control) !="RadioButton"))
					$this->Body.="\n\t<td>".$libelle."</td>";

				$this->Body.="<td $colspan $rowsspan $attribut>".$Control->Show()."</td>";

			if($Control->Libelle != "" && (get_class($Control) =="CheckBox" || get_class($Control) =="RadioButton" ))
				$this->Body.="\n\t<td>".$libelle."</td>";

		}
		else
		{
			if(get_class($Control) != "CheckBox" && get_class($Control) != "RadioButton")
			{
				$this->Body.= $libelle.$Control->Show();
			}
			else
			{
				$this->Body.= $Control->Show().$libelle;
			}
		}
	}

	//Insertion d'un control sur une nouvelle ligne
	public function AddNew($Control="",$cell="",$attribut="", $ajaxAction ="")
	{
		//Si le control est vide on insert juste une ligne
		if(empty($Control))
		{
			if($this->Table)
				$this->Body .="</tr><br/><tr>";
			else
			 	$this->Body .="<br/>";
		}
		else
		{
			if($this->Table)
			{
				$this->Body .="</tr><tr $attribut>";
				$this->Add($Control,$cell, "", "", $ajaxAction);
			}
			else
			{
				$this->Body.="<br/>";
				$this->Add($Control,$cell, "", "", $ajaxAction);
			}
		}
	}

	//Ajout le conctrol et le converti en libelle
	public function AddAsLibelle($Control="",$addNew=false, $text="",$cell="",$row="")
	{
		$Libelle = new Libelle($Control->Value.$text);

		if(isset($text) && !empty($text)) $Libelle->Libelle = $Control->Libelle;

		if($addNew)
			$this->AddNew($Libelle,$cell,$row);
		else
			$this->Add($Libelle,$cell,$row);
	}

	//Affichage du bloc
	public function Show()
	{
		//Declaration de la balise
		$id = $this->Id != ""  ?  "id='$this->Id'" :  "" ;
		$TextControl = "\n<div $id ";
		$TextControl .= $this->getProperties();
		$TextControl .=">";

		//Si on met dans un tableau
		if($this->Table)
		{
			if($this->CssClass)
			{
				$class= "class='".$this->CssClass."'";
			}
			else
			{
				$class = '';
			}

			$TextControl .="\n<table $class ><tr><td>";
		}

		//Si on met dans un cadre
		if($this->Frame)
			{
				$TextControl .="<table class='".$this->CssClass."' cellpadding='0' cellspacing='0' >";
				$TextControl .="<tr><td class='".$this->CssClass."CoinGaucheHaut' ></td>";
				$TextControl .= "<th class='".$this->CssClass."BordHaut'>".$this->Title."</th>";
				$TextControl .="<td class='".$this->CssClass."CoinDroitHaut'></td></tr>";
				$TextControl .="<tr><td class='".$this->CssClass."BordGauche' width='25px'></td><td class='".$this->CssClass."Body'>";
			//	$TextControl .="<tr><td class='".$this->CssClass."BordGauche' width='25px'></td><td style='background-image:".$this->BackgroundImage."'>";

			}

			$TextControl .= "".$this->Body."";
			//$TextControl .= $this->Body;

		//Si on met dans un cadre
		if($this->Frame)
		{
			$TextControl .="</td><td  class='".$this->CssClass."BordDroit' width='25px'></td></tr>";
			$TextControl .="<tr><td class='".$this->CssClass."CoinGaucheBas'></td><th></th><td class='".$this->CssClass."CoinDroitBas'></td></tr></table>";
		}

		//Fermeture du tableau
		if($this->Table)
			$TextControl .="\n</td></tr></table>";

		$TextControl .="</div>\n";

		return $TextControl;
	}

	//Charge les control et effectue les verifications
	public function LoadControl()
	{
		$IsValid=true;

		//Creation d'un objet reflection afin de recuperer toutes les proprietes
		$reflection = new \ReflectionObject($this);
		$Properties=$reflection->getProperties();

		//Chargement des controls
		foreach($Properties as $control)
		{
		  	$name=$control->getName();
			//Test que c'est bien un control prevoir une recursivite pour la descendence des controls
			if(get_parent_class($this->$name)=="JHomControl" && get_class($this->$name)!= "Button")
			  {
			  	 $this->$name->Value= Request::GetPost($this->$name->Name);
				//Test Des valeurs saisies
				if(!$this->$name->Verify())
					$IsValid=false;
			  }
		}

		$this->IsValid=$IsValid;
	}

	//Appele la methode demand�
	public function CallMethod()
	{
		$Method=Request::GetPost("UserAction");
		if($Method != "")
			{
				if(method_exists($this,$Method))
				call_user_func(array($this,$Method));
			}
	}
	
	/*
	* Ajoute un parametre
	*/
	public function AddParameter($key, $value)
	{
		$this->Parameters[$key] = $value;
	}

	/*
	* Ajoute des parametres
	*/
	public function AddParameters($paramatres)
	{
		foreach($paramatres as $key => $value)
		{	
			$this->Parameters[$key] = $value;
		}
	}
	
	/*
	* Définie le template
	*/
	public function SetTemplate($template)
	{
             //Recherche du fichier template
            if(!file_exists($template))
            {
                $template= str_replace("Apps/", "../Apps/", $template);
               
                if(!file_exists($template))
                {
                    $template= str_replace("../Apps/", "../../Apps/", $template);
                    
                    if(!file_exists($template))
                    {
                        $template= str_replace("../../Apps/", "../../../Apps/", $template);
                    }
                }
            }
            
            $this->Template = $template;
	}
	
	/*
	* crée le control selon le template
	*/
	public function Render()
	{
            //Attention on est dans un sous dossier
            if(!file_exists($this->Template))
            {
               // $this->Template = "../".$this->Template;
            }
            //Recupere le template
            $html = File::GetFileContent($this->Template);

            foreach($this->Parameters as $key => $value )
            {
                    $html = str_replace($key, $value, $html);
            }	
            return $html;
	}
	
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

//Interface pour les block
interface IBlock
{
	public function Create();
	public function Init();
	public function LoadControl();
	public function CallMethod();
	public function Show();
}
?>