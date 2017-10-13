<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\Serialization;

/*
 * Classe de base de la serialisation
 * pour la communication langage serveur /Client
 *
 */
 class Serialization
 {
 	function __construct()
 	{
 		$this->Version = "2.0.1.0";
 	}

 	public static function Encode($arg)
 	{
		$Enconding="";

		foreach($arg as $key=>$value)
		{
                    if(!is_array($value)   && $value != "")
                    {
                        $Enconding .= "::".$key."!!".$value;
                    }
		}
	return $Enconding ;
 	}

	public static function Decode($arg)
	{
		$param = array();

		$params = explode("::", $arg);

		foreach($params as $value)
		{
			$data = explode('!!', $value);
			if(isset($data[1]))
			{
				$param[$data[0]] = $data[1];
			}
		}

		return $param;
	}

 	public static function Encode32($arg)
 	{
		$Enconding="";

		foreach($arg as $key=>$value)
			{
				$Enconding .= "^".$key."|".$value;
			}
	return $Enconding ;
 	}

 	// Encode en cryptant
 	public static function EncodeCrypt($arg)
 	{
		$Enconding="";

		foreach($arg as $key=>$value)
		{
			$Enconding .= "::".$key."!!".$value;
		}
		//TODO ENCODé
	return  $Enconding ;
	//return Format::ReplaceForJs($Enconding);

 	}

	// Encripte un chaine de caractere
 	public static function Cript($char)
 	{
 		$cript = "";

		if(!is_array($char))
		{
			for($i = 0;$i<strlen($char);$i++)
			{
				$cript .= (chr(ord($char{$i})+1)) ;
			}
		}
		return $cript;
 	}
 }
?>
