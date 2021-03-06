<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\DialogButton;

class DialogButton
{
    public $App;
    public $Class;
    public $Method;
    public $Label;
    public $Icon;
    public $Title;

    //Constructeur
    function __construct($class, $methode="", $url="")
    {
     //Version
     $this->Version = "2.0.1.0";

     $this->Class=$class;
     $this->Methode=$methode;
     $this->Url=$url;
   }

   /**
    * Render the control
    */
    public function Show()
    {
        $html =  "<div class='dialogButton' data-app='".$this->App."' data-title= '".$this->Title ? $this->Title : $this->Label."' data-class='". $this->Class."' data-method='".$this->Method."'>";
        $html .= "<i>".$this->Label."</i>";
        $html .= "</div>";

        //return $html;
    }
}