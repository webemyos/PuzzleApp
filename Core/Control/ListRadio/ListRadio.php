<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\ListRadio;

 use Core\Control\IControl;
 use Core\Control\Control;
 
 class ListRadio extends Control
 {
    /*
     * List of Element   
     */
     public $Elements;
     
     /*
      * Group Name
      */
     public $Name;
     
     function Show()
     {
        $html = "<ul ".$this->getProperties()." >";
         
        $Elements = explode(";", $this->Elements);
         
        foreach($Elements as $element)
        {
            $data = explode(":", $element);
            
            $html .= "<li><input type='radio' name = '".$this->Name."'  value='$data[0]'>$data[1]</input></li>";
        }
         
         $html .= "</ul>";
         
         return $html;
     }
 }
