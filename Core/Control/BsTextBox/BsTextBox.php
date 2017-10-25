<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\BsTextBox;

 use Core\Control\IControl;
 use Core\Control\Control;
 
class BsTextBox extends Control implements IControl
{
    //Constructeur
    function __construct($name)
    {
        //Version
        $this->Version ="2.0.0.0";

        $this->Id=$name;
        $this->Name=$name;
        $this->Type="text";

        $this->AutoCapitalize = false;
        $this->AutoCorrect = false;
        $this->AutoComplete = false;
    }

    /**
     * Affiche le control
     */
    function Show()
    {                   
        $TextControl = "<div class='global-input-material'>
                       <input type='text' required='' name='".$this->Name."'  id='".$this->Id."'  value='".$this->Value."'   >

                        <span class='highlight'></span>         
                        <span class='bar'></span>
                        <label>".$this->Title."</label>
                        </div>";

        return $TextControl;
    }
}
?>