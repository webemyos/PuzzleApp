<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Action\AjaxAction;

use Core\Action\Action;
use Core\Utility\Serialization\Serialization;

class AjaxAction extends Action
{
  private $Sender;
  private $Class;
  protected $Arg;
  private $IdEntity;
  private $Argument=array();
  private $SourceControl;
  private $SourceControls;
 private $Asynchrone;
  private $Type;
  private $Confirm;
  public $ChangedControl;


  //Constructeur
  function __construct($class="", $methode="", $type="Class",$confirm = false, $cssClass ="")
  {
  	//Version
	$this->Version = "2.0.0.0";

    $this->Class=$class;
    $this->Methode=$methode;
    $this->Type = $type;
    $this->Asynchrone = "false";
    $this->Confirm = $confirm;
    $this->CssClass = $cssClass;
  }

  //Enregistrement de l'action � effectuer
  function DoAction()
  {
  $Property = array();

  $reflection = new \ReflectionObject($this);
  $Properties=$reflection->getProperties();

  //Ajout des propri�t�s
  foreach($Properties as $control)
  {
    $name=$control->getName();
      $Property[$name]=$this->$name;
  }

  //Ajout des arguments
  $this->AddArgument($this->Type,$this->Class);
  $this->AddArgument("Methode",$this->Methode);
  $this->AddArgument("Argument",$this->Argument);
  $this->AddArgument("Asynchrone",$this->Asynchrone);


  //return "var JAjaxAction=new AjaxAction('".Serialization::Encode($Property)."','".Serialization::Encode($this->Argument)."');JAjaxAction.DoAction()";
	return "Jax('".Serialization::Encode($Property)."','".Serialization::Encode($this->Argument)."', '".$this->Confirm."')";
  }

  //Ajoute des arguments pour la methode Serveur
  function AddArgument($key, $value="")
  {
  	//Attention Certain argument n'ont pas de valeur'
  	if($value == "")
  	{
  		$arguments = explode("&", $key);
  		if(sizeof($arguments) > 0)
  		{
                    foreach($arguments as $argument)
                    {
                        $argument = explode("=",$argument);
                        $this->Argument[$argument[0]]= isset($argument[1])?$argument[1]:"" ;
                    }
  		}
  		else
  		{
                    $argument = explode("=",$key);

                    if(isset($argument[1]))
                            $this->Argument[$argument[0]]=$argument[1];
  		}
  	}
  	else
  	{
    	$this->Argument[$key]=$value;
  	}
  }

  //Ajoute un control source
  function AddControl($idControl)
  {
    $this->SourceControls .= "-".$idControl;
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
?>
