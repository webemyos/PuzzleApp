<?php

/**
 * Fonction Ajax
 */
class InsertAjax extends Insert
{
        /*
         * Constructeur
         */
        function InsertAjax()
        {
            $this->Parameter = array("App", "Methode");
        }
    
	function ShowInsert($parameters)
	{
            $content = "var JAjax = new ajax();
    		            JAjax.data = 'App=XXX&Methode=XXX';
			    JAjax.GetRequest('Ajax.php');";
            
            foreach($parameters as $parameter)
            {
                $data = explode(":", $parameter);
                
                $content = str_replace($data[0]."=XXX", $data[0]."=".$data[1], $content);
            }
            
            return $content;
        }
}


?>