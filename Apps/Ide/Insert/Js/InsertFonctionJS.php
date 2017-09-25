<?php

/**
 * Fonction Java script simple
 */
class InsertFonctionJS extends Insert
{
        /*
         * Constructeur
         */
        function InsertFonctionJS()
        {
            $this->Parameter = array("App", "Methode");
        }
        
	function ShowInsert($parameters)
	{
            $content = "App.Methode = function(e)
            {};";

            foreach($parameters as $parameter)
            {
                $data = explode(":", $parameter);
                
                $content = str_replace($data[0], $data[1], $content);
            }
            
            return $content;
	}
}


?>