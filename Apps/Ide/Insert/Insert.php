<?php

use Core\Control\Button\Button;
use Core\Control\TextBox\TextBox;

/**
 * Classe de base des insertions
 * */
class Insert
{
	protected $Body;
        protected $Parameter = array();

	//
	function ShowInsert()
	{
		$this->Body .= $this->GetButtonAction();
		echo $this->Body;
	}

	/**
	 * Recupere les boutons d'action
	 * */
	function GetButtonAction()
	{
		$textControl = "<div id='dvButton'>";

		//Bouton d'insertion
		$btnInsert = new Button(BUTTON);
		$btnInsert->Value = "Insert";

		$textControl .= $btnInsert->Show();
		$textControl .= "</div>";

		return $textControl;
	}
        
        /**
         * Retourne les parametres a initialiser
         */
        function GetParameter()
        {
            $TextControl = "";
            
            foreach($this->Parameter as $parameter)
            {
                $TextControl .= "<br/>".$parameter;
                
                $tbParameter = new TextBox("tb");
                $tbParameter->Id = $parameter;
                
                $TextControl .= $tbParameter->Show();
            }
            
            return $TextControl;
        }
}


?>