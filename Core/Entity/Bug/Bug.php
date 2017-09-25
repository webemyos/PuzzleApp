<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

Class Bug extends JHomEntity
{
	//Constructeur
	function Bug($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_bug";
		$this->Alias = "bg";

		//proprietes
		$this->AppWidget = new Property("AppWidget","AppWidget",TEXTBOX,false,$this->Alias);
		$this->Navigateur = new Property("Navigateur","Navigateur",TEXTBOX,false,$this->Alias);
		$this->Commentaire = new Property("Commentaire","Commentaire",TEXTAREA,false,$this->Alias);
		$this->State = new Property("State","State",TEXTBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}
?>
