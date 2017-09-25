<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

Class City extends JHomEntity
{
	//Constructeur
	function City($core)
	{
		//Version
		$this->Version ="2.0.0.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_city";
		$this->Alias = "ct";

		//proprietes
		$this->Name = new Property("Name","Name",TEXTBOX,false,$this->Alias);

		$this->Insee = new Property("Insee","Insee",TEXTBOX,false,$this->Alias);
		$this->Code_postal = new Property("Code_postal","Code_postal",TEXTBOX,false,$this->Alias);
		$this->Altitude = new Property("Altitude","Altitude",TEXTBOX,false,$this->Alias);
		$this->Longitude = new Property("Longitude","Longitude",TEXTBOX,false,$this->Alias);
		$this->Latitude = new Property("Latitude","Latitude",TEXTBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}

	/**
	 * Recuperation du repertoire par son nom
	 * @param $name Nom recherch�
	 * */
	function GetByName($name)
	{
		$this->AddArgument(new Argument("City","Name",EQUAL,$name));
		$City = $this->GetByArg();

		if(sizeof($City)>0)
			return $City[0];
	}

	//retourne un liste de ville
	function SearchCity()
	{
		//Execution des requetes  en direct car plus rapide
		//Format le texte sans les accents
		$request = "select * From `ee_city` where Name like '".JFormat::EscapeString(JVar::GetPost("sourceControl"))."%'";

		$results = $this->Core->Db->GetArray($request);

		$TextControl = "<ul>";

		if(sizeof($results) > 0)
		{
			foreach($results as $result)
			{
				$TextControl .= "<li onclick='AutoCompleteBox.SetResult(this,  \"".JVar::GetPost("sourceControlId")."\");' id='".$result["Name"]."' >".$result["Name"]."</li>";
			}
		}
		else
		{
			$TextControl .= "<li>".$this->Core->GetCode("NoResult")."</li>";
		}

		$TextControl .= "</ul>";
		echo $TextControl;
	}

	//Todo factorise le code
	function SearchCityHome()
	{
		$ListBox = new EntityListBox("lstHomeTown",$this->Core);
		$ListBox->Entity = "City";

		//Name
		$ListBox->AddArgument(new Argument("City","Name",LIKE , JVar::GetPost("sourceControl")));

		//Ajout du style
		$ListBox->ListBox->AddStyle("width","205px");

		echo $ListBox->Show();
	}
        
        /**
         * Recherche les villes au alentour
         * TODO Ajouter un indice de précision
         **/
        public static function SearchAround($core, $city)
        {
           $request = "SELECT Id FROM ee_city WHERE
                     (Latitude > ".($city->Latitude->Value - 0.5)." AND Latitude < ".($city->Latitude->Value + 0.5)." ) 
                      AND Longitude >" .($city->Longitude->Value - 0.5)." AND Longitude <" .($city->Longitude->Value +0.5);
     
            $results = $core->Db->GetArray($request);
            
            $idCity = array();
            
            foreach($results as $result)
            {
                 $idCity[] = $result["Id"];
            }
           
            return $idCity;
        }

}
?>
