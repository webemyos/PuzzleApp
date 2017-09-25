<?php

/*
 * Fonction Php standard 
 */
class InsertFonctionPHP extends Insert
{
     /*
         * Constructeur
         */
        function InsertFonctionPHP()
        {
            $this->Parameter = array("App");
        }
        
	function ShowInsert($parameters)
	{
		$content = "function App()
			{}";
                
            foreach($parameters as $parameter)
            {
                $data = explode(":", $parameter);
                
                $content = str_replace($data[0], $data[1], $content);
            }
            
            return $content;
	}
}


?>