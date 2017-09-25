<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 class Apps extends JHomEntity
{
	function Apps($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_app";
		$this->Alias = "apd";
		$this->LangAlias ="aplg";
		$this->LangClass="AppsLang";

		//Ajout d'une jointure sur les libelle traduits
		$Joins = new Joins(LEFTJOIN,"ee_app_lang","AppId","Id",$this->LangAlias);
		$Joins->AddArgument(new Argument("AppsLang","LangId",EQUAL,$this->Core->GetLang("code")));
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

		$this->AssociatedFile = new Property("AssociatedFile","AssociatedFile",TEXTAREA,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}

	/**
	 * Recuperation des 5 dernière applications
	 * */
	static function GetLast($core, $idCategory ="")
	{
		$apps = array();

		if($idCategory != '')
		{
			$request = "SELECT Id FROM ee_app WHERE CategoryId =". $idCategory ." ORDER BY Id Desc limit 0,5";
		}
		else
		{
			$request = "SELECT Id FROM ee_app WHERE CategoryId <> 3 ORDER BY Id Desc limit 0,5";
		}
		$results = $core->Db->GetArray($request);

		foreach($results as $result)
		{
			$app = new Apps($core);
			$app->GetById($result['Id']);
			$apps[] = $app;
		}

		return $apps;
	}

	/**
	 * Recherche les applu associée au fichiers
	 * */
	static function SearchAppFile($core, $extensiion)
	{
		$request = "SELECT Code FROM ee_app WHERE AssociatedFile like '%".$extensiion."%'";
		return $core->Db->GetArray($request);
	}
}

class AppsLang extends JHomEntity
{
	protected $Lang;
	protected $Apps;

	function AppsLang($core)
	{
		$this->Core=$core;
		$this->TableName="ee_app_lang";
		$this->Alias = "aplg";

		//Cle primaire
		$this->AddPrimaryKey("LangId");
		$this->AddPrimaryKey("AppId");

		$this->Title = new Property("Title","Title",TEXTBOX,false,$this->Alias);
		$this->Libelle = new Property("Libelle","Libelle",TEXTAREA,false,$this->Alias);
		$this->Description = new Property("Description","Description",TEXTAREA,false,$this->Alias);
		$this->Notice = new Property("Notice","Notice",TEXTAREA,false,$this->Alias);

		$this->LangId = new Property("Lang","LangId",TEXTBOX,false,$this->Alias);
		$this->Lang = new EntityProperty("Lang","LangId");

		$this->AppId = new Property("AppId","AppId",TEXTBOX,false,$this->Alias);
		$this->App = new EntityProperty("Apps","AppId");


		//Creation de l'entit�
		$this->Create();
	}

	function SaveElement($langId,$AppId)
	{
	    $this->LangId->Value=$langId;
		$this->AppId->Value = $AppId ;

		$this->Save();
	}
}

/**
 * Categorie des application et widgets
 */
class AppCategory extends JHomEntity
{
	function AppCategory($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_appcategory";
		$this->Alias = "pf";
		$this->LangAlias ="pflg";
		$this->LangClass="AppCategoryLang";

		//Ajout d'une jointure sur les libelle traduits
		$Joins = new Joins(LEFTJOIN,"ee_appcategory_lang","CategoryId","Id",$this->LangAlias);
		$Joins->AddArgument(new Argument("AppCategoryLang","LangId",EQUAL,$this->Core->GetLang("code")));
		$this->AddJoin($Joins);

		//proprietes
		$this->Code = new Property("Code","Code",TEXTBOX,true,$this->Alias);
		$this->Libelle = new LangProperty("Libelle","Libelle",TEXTBOX,false,$this->LangAlias);

		//Creation de l'entit�
		$this->Create();
	}
}

class AppCategoryLang extends JHomEntity
{
	protected $Lang;
	protected $Category;

	function AppCategoryLang($core)
	{
		$this->Core=$core;
		$this->TableName="ee_appcategory_lang";
		$this->Alias = "pflg";

		//Cle primaire
		$this->AddPrimaryKey("LangId");
		$this->AddPrimaryKey("CategoryId");

		$this->Libelle = new Property("Libelle","Libelle",TEXTAREA,false,$this->Alias);
		$this->LangId = new Property("Lang","LangId",TEXTBOX,false,$this->Alias);
		$this->Lang = new EntityProperty("Lang","LangId");

		$this->CategoryId = new Property("CategoryId","CategoryId",TEXTBOX,false,$this->Alias);
		$this->Category = new EntityProperty("AppCategory","CategoryId");

		//Creation de l'entit�
		$this->Create();
	}

	function SaveElement($langId,$CategoryId, $libelle="")
	{
	    $this->LangId->Value=$langId;
		$this->CategoryId->Value = $CategoryId ;

		if($libelle != "")
		{
			$this->Libelle->Value = $libelle;
		}

		$this->Save();
	}
}

?>
