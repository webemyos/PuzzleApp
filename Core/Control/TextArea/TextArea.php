<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\TextArea;

use Core\Core\Request;
use Core\Control\IControl;
use Core\Control\Control;

class TextArea extends Control implements IControl
{
    //Proprietes
    private $Title="";
    private $Text="";
    protected $Info;

    //Constructeur
    public function __construct($name, $resize=false)
    {
        //Version
        $this->Version ="2.0.0.0";

        $this->Id=$name;
        $this->Name=$name;
        $this->CssClass="form-control";
    }

    //Affichage
    function Show()
    {
        //Recuperation d'une eventuelle valeur
        if(Request::GetPost($this->Name))
        {
            $this->Value= Request::GetPost($this->Name);
        }

        //Declaration de la balisepx
        $TextControl ="\n<textArea  " ;
        $TextControl .= $this->getProperties(false);
        $TextControl .=">";

        $TextControl .=$this->Title;
        $TextControl .=$this->Text;
        $TextControl .= htmlspecialchars($this->Value, ENT_QUOTES );

        $TextControl .="</textArea>\n";

         if($this->Info != "")
        {
            $TextControl .= "&nbsp;<p class='fa fa-info' title='".$this->Info."' >&nbsp;</p>";
        }

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
