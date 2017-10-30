<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\RadioButton;

use Core\Control\IControl;
use Core\Control\Control;


class RadioButton extends Control implements IControl
{
    private $Checked;

    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.2.0";

        $this->Id=$name;
        $this->Type="Radio";
        $this->Name=$name;
    }

    //Affichage du control
    function Show()
    {
        $chek ="";

        if($this->Checked == 1 )
                $chek = " checked=checked  ";

        $html  =" \n<input type=".$this->Type."  value='$this->Value'" ;
        $html .= $this->getProperties();
        $html .= $chek.">";

        return $html;
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
?>
