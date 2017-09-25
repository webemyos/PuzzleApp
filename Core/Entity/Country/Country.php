<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 class Country extends JHomEntity
{
	function Country($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_country";
		$this->Alias = "co";
		$this->LangAlias ="ctlg";
		$this->LangClass="CountryLang";

		//Ajout d'une jointure sur les libelle traduits
		$Joins = new Joins(LEFTJOIN,"ee_country_lang","CountryId","Id",$this->LangAlias);
		$Joins->AddArgument(new Argument("CountryLang","LangId",EQUAL,$this->Core->GetLang("code")));
		$this->AddJoin($Joins);

		//proprietes
		$this->Code = new Property("Code","Code",TEXTBOX,true,$this->Alias);
		$this->Libelle = new LangProperty("Libelle","Libelle",TEXTBOX,false,$this->LangAlias);

		//Creation de l'entit�
		$this->Create();
	}
}

class CountryLang extends JHomEntity
{
	protected $Lang;
	protected $Country;

	function CountryLang($core)
	{
		$this->Core=$core;
		$this->TableName="ee_country_lang";
		$this->Alias = "ctlg";

		//Cle primaire
		$this->AddPrimaryKey("LangId");
		$this->AddPrimaryKey("CountryId");

		$this->Libelle = new Property("Libelle","Libelle",TEXTAREA,false,$this->Alias);
		$this->LangId = new Property("Lang","LangId",TEXTBOX,false,$this->Alias);
		$this->Lang = new EntityProperty("Lang","LangId");

		$this->CountryId = new Property("CountryId","CountryId",TEXTBOX,false,$this->Alias);
		$this->Country = new EntityProperty("Country","CountryId");

		//Creation de l'entit�
		$this->Create();
	}

	function SaveElement($langId,$countryId)
	{
	    $this->LangId->Value=$langId;
		$this->CountryId->Value = $countryId ;

		$this->Save();
	}
}


?>
