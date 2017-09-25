<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\ListBox;

 use Core\Control\IControl;
 use Core\Control\Control;
 use Core\Core\Request;


 class ListBox extends Control implements IControl
 {
 	//Propriete
 	private $Option;
 	private $DataSource;
 	private $Selected;
 	private $OnSelected;
 	private $Size;
 	private $Options=array();
        protected $Info;

 	//Constructeur
 	function __construct($name)
 	{
            //Version
            $this->Version ="2.0.0.0";

            $this->Id=$name;
            $this->Name=$name;
            $this->CssClass="form-control";
 	}

        /**
         * Icone info
         * @param type $info
         */
        function SetInfo($info)
        {
            $this->Info = $info;
        }

	//Ajout d'un element � la liste
	function Add($key,$value)
	{
		$this->Options[$key] = $value;
	}

	function Clear()
	{
		unset($this->Options);
		$this->Options=array();
	}
	//Affichage du control
	function Show()
	{
		$TextControl  =" \n<select " ;

		if($this->Size !="")
			$TextControl .="size='".$this->Size."' ";

		$TextControl .= $this->getProperties();
		$TextControl .= ($this->OnSelected !="")?" onChange=\"".$this->OnSelected->DoAction()."\"": "";
		$TextControl .= ">";

		//Ajout des elements
		//$TextControl .= $this->Option;
		foreach($this->Options as $option=>$value)
		{
			if((Request::GetPost($this->Name) && Request::GetPost($this->Name) == $value)
			   || (is_object($this->Selected) && $this->Selected->Value == $value)
			   || ($this->Selected != "" && $this->Selected == $value)
			   )
		  	{
				$selected=" selected ";
		  	}
			else
			{
				$selected="";
			}
		$TextControl .="\n<option value='".$value."' $selected  >".$option."</option>";

		}

		$TextControl .= "</select>";

                 if($this->Info != "")
                {
                    $TextControl .= "&nbsp;<p class='fa fa-info' title='".$this->Info."' >&nbsp;</p>";
                }

		return $TextControl;
	}

	//Assesseurs
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
		if($name=="DataSource")
		{
			foreach($value as $line)
				$this->Add($line["Id"],$line["Nom"]);
		}
      $this->$name=$value;
	}
 }
?>
