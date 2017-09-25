<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

/*
 * Entites des widgets
 */
 class Widgets extends JHomEntity
{
	function Widgets($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_widgets";
		$this->Alias = "wd";
		$this->LangAlias ="ctlg";
		$this->LangClass="WidgetsLang";

		//Ajout d'une jointure sur les libelle traduits
		$Joins = new Joins(LEFTJOIN,"ee_widgets_lang","WidgetsId","Id",$this->LangAlias);
		$Joins->AddArgument(new Argument("WidgetsLang","LangId",EQUAL,$this->Core->GetLang("code")));
		$this->AddJoin($Joins);

		//proprietes
		$this->Code = new Property("Code","Code",TEXTBOX,true,$this->Alias);
		$this->Deletable = new Property("Deletable","Deletable",CHECKBOX,true,$this->Alias);
		$this->Note = new Property("Note","Note",TEXTBOX,false,$this->Alias);

		$this->Title = new LangProperty("Title","Title",TEXTBOX,false,$this->LangAlias);
		$this->Libelle = new LangProperty("Libelle","Libelle",TEXTAREA,false,$this->LangAlias);
		$this->Description = new LangProperty("Description","Description",TEXTAREA,false,$this->LangAlias);
		$this->Notice = new LangProperty("Notice","Notice",TEXTAREA,false,$this->LangAlias);
		$this->DateAdd = new Property("DateAdd","DateAdd",DATEBOX,false,$this->Alias);

		//Category
		$this->CategoryId = new Property("CategoryId","CategoryId",TEXTBOX,false,$this->Alias);
		$this->Category = new EntityProperty("AppCategory","CategoryId");

		//Creation de l'entit�
		$this->Create();
	}

	/**
	 * Recuperation des 5 dernièrs widgets
	 * */
	static function GetLast($core)
	{
		$widgets = array();

		$request = "Select Id From ee_widgets order by Id Desc limit 0,5";
		$results = $core->Db->GetArray($request);

		foreach($results as $result)
		{
			$widget = new Widgets($core);
			$widget->GetById($result['Id']);
			$widgets[] = $widget;
		}

		return $widgets;
	}
}

class WidgetsLang extends JHomEntity
{
	protected $Lang;
	protected $Widgets;

	function WidgetsLang($core)
	{
		$this->Core=$core;
		$this->TableName="ee_widgets_lang";
		$this->Alias = "ctlg";

		//Cle primaire
		$this->AddPrimaryKey("LangId");
		$this->AddPrimaryKey("WidgetsId");

		$this->Title = new Property("Title","Title",TEXTBOX,false,$this->Alias);
		$this->Libelle = new Property("Libelle","Libelle",TEXTAREA,false,$this->Alias);
		$this->Description = new Property("Description","Description",TEXTAREA,false,$this->Alias);
		$this->Notice = new Property("Notice","Notice",TEXTAREA,false,$this->Alias);
		$this->LangId = new Property("Lang","LangId",TEXTBOX,false,$this->Alias);
		$this->Lang = new EntityProperty("Lang","LangId");

		$this->WidgetsId = new Property("WidgetsId","WidgetsId",TEXTBOX,false,$this->Alias);
		$this->Widgets = new EntityProperty("Widgets","WidgetsId");

		//Creation de l'entit�
		$this->Create();
	}

	function SaveElement($langId,$WidgetsId)
	{
	    $this->LangId->Value=$langId;
		$this->WidgetsId->Value = $WidgetsId ;

		$this->Save();
	}
}


?>
