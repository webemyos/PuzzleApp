<?php
/**
 * Ouverture d'une popup
 */
class InsertPopUp extends Insert
{
    /*
     * Constructeur
     */
    function InsertPopUp()
    {
        $this->Parameter = array("AppName", "TitleName", "Class", "Methode", "Width", "Height", "RefreshAction");
    }
    
    function ShowInsert($parameters)
    {
        $content = "var param = Array();
                        param['App'] = 'AppName';
                        param['Title'] = 'TitleName';";

        $content .= "Eemmys.OpenPopUp('Class','Methode', 'Width','Height','', 'RefreshAction', param);";
        
        foreach($parameters as $parameter)
        {
            $data = explode(":", $parameter);

            $content = str_replace($data[0], $data[1], $content);
        }

        return $content;
    }
}


?>