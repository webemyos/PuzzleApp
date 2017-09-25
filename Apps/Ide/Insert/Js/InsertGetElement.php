<?php

/*
 * Fonction de récuperation d'un éllement de l'application
 */
class InsertGetElement extends Insert
{
        /*
         * Constructeur
         */
        function InsertGetElement()
        {
            $this->Parameter = array("Id", "Type", "App");
        }
        
	function ShowInsert($parameters)
	{
            $content = "Eemmys.GetElement('Id','Type','App');";
            
            foreach($parameters as $parameter)
            {
                $data = explode(":", $parameter);
                
                $content = str_replace($data[0], $data[1], $content);
            }
            
            return $content;
	}
}


?>