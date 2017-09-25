<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

Class Comment extends JHomEntity
{
	//Constructeur
	function Comment($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_comment";
		$this->Alias = "cm";

		//proprietes
		$this->AppWidgetId = new Property("AppWidgetId","AppWidgetId",TEXTBOX,false,$this->Alias);
		$this->Type = new Property("Type","Type",TEXTBOX,false,$this->Alias);
		$this->Commentaire = new Property("Commentaire","Commentaire",TEXTAREA,false,$this->Alias);
		$this->UserName = new Property("UserName","UserName",TEXTBOX,false,$this->Alias);
		$this->ArticleId = new Property("ArticleId","ArticleId",TEXTBOX,false,$this->Alias);
		$this->Actif = new Property("Actif","Actif",CHECKBOX,false,$this->Alias);
		$this->DateCreate = new Property("DateCreate","DateCreate", DATEBOX,false,$this->Alias);
		$this->Email = new Property("Email","Email", TEXTBOX, false, $this->Alias);

		//Creation de l'entit�
		$this->Create();
	}

	/**
	 * Ajout un commentaire a un article
	 * */
	function AddCommentArticle()
	{
		if(JVar::GetPost("tbName") && JVar::GetPost("tbCommentaire"))
		{
			$comment = new Comment($this->Core);
			$comment->Actif->Value = false;
			$comment->UserName->Value = JVar::GetPost("tbName");
			$comment->Email->Value = JVar::GetPost("tbEmail");
			$comment->ArticleId->Value = JVar::GetPost("IdEntite");
			$comment->Commentaire->Value = JVar::GetPost("tbCommentaire");
			$comment->DateCreate->Value = JDate::Now();

			$comment->Save();

			echo "<span class='success' id='lbResult'>".$this->Core->GetCode("SaveOk")."</span>";
		}
		else
		{
			echo "<span class='error' id='lbResult'>".$this->Core->GetCode("FieldEmpty")."</span>";
		}
	}
}
?>
