<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

use Core\Utility\Format\Format;

 class Language
 {
 	//Propri�t�s
 	private $Core;
 	public $Version;
        
        private $ElementsBase = null;
        private $ElementsCode; 
        
	//Constructeur
 	function __construct($core="")
 	{
 		//Version
		$this->Version = "2.0.0.0";

 		$this->Core=$core;
 	}

        /*
         * Load All Code
         */
        function LoadCode($langue)
        {
            $request = "SELECT code.Code as Code, element.Libelle as Libelle,
               (Select count(id) from ee_lang_element where element.codeId = code.id ) as nb 
                FROM ee_lang_code as code
                join ee_lang_element as element on code.id = element.codeId
                 join ee_lang as lang on lang.id = element.langId 
                AND lang.Code = '".$langue."'";
           
           $this->ElementsBase  = $this->Core->Db->GetArray($request);
           
           
           foreach($this->ElementsBase as $element)
           {
               if($element["nb"] > 0)
               {
                $this->ElementsCode[$element["Code"]] = $element["Libelle"];
               }
               else
               {
                    $this->ElementsCode[$element["Code"]] = false;
               }
            }
        }
        
	//Retourne un code dans une langue
	function GetCode($code,$langue)
	{
        //Load All Code
        if($this->ElementsBase == null)
        {
            $this->LoadCode($langue, true);
        }
        
        //Code exist but no libelle
        if(isset($this->ElementsCode[$code]) && $this->ElementsCode[$code] === false )
        {
            return $code;
        }
        
        //Code and libelle exist return libelle
        if(isset($this->ElementsCode[$code]) && $this->ElementsCode[$code] != false )
        {
            return $this->ElementsCode[$code];
        }
        
        //Code not exist
        if(!isset($this->ElementsCode[$code]) || $this->ElementsCode[$code] === null )
        {
            $requete = "select * from ee_lang_code where code = '".$code."'";
            $result = $this->Core->Db->GetArray($requete);

            if(count($result) == 0)
            {
                $requete ="INSERT INTO ee_lang_code (Code) VALUES ('$code')";
                $this->Core->Db->execute($requete);
            }

            //Add To the Tab
            $this->ElementsCode[$code] = false;
            
            return $code;
        }
    }

	/**
	 * Retourne tous les élements multiluange traduit
	 */
	function GetAllCode($langue)
	{
		$requete ="	SELECT code.Code,Libelle FROM ee_lang_code AS code
					JOIN ee_lang_element as element ON code.Id = element.CodeId
					JOIN ee_lang AS lang ON element.LangId = lang.Id
					AND lang.Code = '".$langue."' ";
		$elements = $this->Core->Db->GetArray($requete);

		$codes = array();

		foreach($elements as $code)
		{
			$codes[$code["Code"]] = JFormat::ReplaceString($code["Libelle"]);
		}

		return Serialization::Encode($codes);
	}
 }
?>
