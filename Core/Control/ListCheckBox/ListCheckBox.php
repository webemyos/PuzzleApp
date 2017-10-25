<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Control\ListCheckBox;

 use Core\Control\IControl;
 use Core\Control\Control;
 
 class ListCheckBox extends Control
 {
    /*
     * List of Element   
     */
     public $Elements;
     
     function Show()
     {
        $html = "<ul ".$this->getProperties()." >";
         
        $this->Element = explode(";", $this->Elements);
         
        foreach($this->Element as $element)
        {
            $data = explode(":", $element);
            
            $html .= "<li><input type='checkBox' value='$data[0]'>$data[1]</input></li>";
        }
         
         $html .= "</ul>";
         
         return $html;
     }
 }
