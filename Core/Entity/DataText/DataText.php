<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class DataText extends JHomEntity
{
	/*
	 * Constructeur
	 * */
	function DataText($core="")
	{
		//Version
		$this->Version ="2.0.2.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_datatext";
		$this->Alias = "dt";
		$this->LangAlias ="dtlg";
		$this->LangClass="DataTextLang";

		//Ajout d'une jointure sur les libelle traduits
		$Joins = new Joins(LEFTJOIN,"ee_datatext_lang","TextId","Id",$this->LangAlias);
		$Joins->AddArgument(new Argument("DataTextLang","LangId",EQUAL,$this->Core->GetLang("code")));
		$this->AddJoin($Joins);

		//proprietes
		$this->Code = new Property("Code","Code",TEXTBOX,true,$this->Alias);
		$this->Title = new Property("Title","Title",TEXTBOX,false,$this->Alias);
		$this->Text = new LangProperty("Text","Text",TEXTAREA,false,$this->LangAlias);

		//Creation de l'entit�
		$this->Create();
	}
}

//Traduction des onglets des menu
class DataTextLang extends JHomEntity
{
	protected $Lang;
	protected $DataText;

	function DataTextLang($core)
	{
		$this->Core=$core;
		$this->TableName="ee_datatext_lang";
		$this->Alias = "dtlg";

		//Cle primaire
		$this->AddPrimaryKey("LangId");
		$this->AddPrimaryKey("TextId");

		$this->Text = new Property("Text","Text",TEXTAREA,false,$this->Alias);
		$this->LangId = new Property("Lang","LangId",TEXTBOX,false,$this->Alias);
		$this->Lang = new EntityProperty("Lang","LangId");

		$this->TextId = new Property("TextId","TextId",TEXTBOX,false,$this->Alias);
		$this->DataText = new EntityProperty("DataText","TextId");

		//Creation de l'entit�
		$this->Create();
	}

	function SaveElement($langId,$TextId)
	{
	    $this->LangId->Value=$langId;
		$this->TextId->Value = $TextId ;

		$this->Save();
	}
}
?>
