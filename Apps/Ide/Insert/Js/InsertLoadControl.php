<?php

/**
 * Permet de charger un control en ajax
 */
class InsertLoadControl extends Insert
{
    /*
     * Constructeur
     */
    function InsertLoadControl()
    {
        $this->Parameter = array("App", "Methode", "Id", "Type");
    }
        
    function ShowInsert($parameters)
    {
        $content =  "var data = 'App=EeXXX&Methode=XXX';
                  Eemmys.LoadControl('Id', data,'','Type','EeXXX');";
        
        $data = array();
        
         foreach($parameters as $parameter)
         {
                $data[] = explode(":", $parameter);
         }
         
         $content = str_replace("App=EeXXX", "App=".$data[0][1], $content);
         $content = str_replace("Methode=XXX", "Methode=".$data[1][1] , $content);
         $content = str_replace("Id", $data[2][1], $content);
         $content = str_replace("Type", $data[3][1], $content);
         $content = str_replace("EeXXX", $data[0][1], $content);
         
         return $content;
    }
}


?>