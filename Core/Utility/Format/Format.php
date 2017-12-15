<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\Format;

/*
 * Classe dee base pour la mise en forme des donnees
 * */
 class Format
 {
 	function __construct()
 	{
            $this->Version = "2.0.0.1";
 	}

 	//Retourne un texte format�
 	static public function Text($text , $replaceText)
 	{
            return  str_replace("!_0_!", $replaceText, $text);
 	}

	static public function Chaine($text, $arguments)
	{
		if(sizeof($arguments) > 0)
		{
			for($i=0 ; $i<sizeof($arguments);$i++)
			{
				$text = str_replace("{".$i."}", $arguments[$i], $text);
			}

			return $text;
		}
	}

 	//Retourne un expression reguliere formater pour le js
 	static public function RegEx($text)
 	{
 		return 	str_replace("'", "", $text);
 	}

 	/**
 	 * Remplace les caracteres speciaux par leurs esuivalent HTML
 	 * */
 	static public function EscapeString($text, $keepSpace = false)
 	{
 		//$Text = str_replace("'","|*",$text);
 		//$Text = str_replace("\"","-*",$Text);
		$search = array ('"',"'",
		"á","Á","â","Â","à","À","å","Å","ã","Ã","ä","Ä","æ","Æ",
		"ç","Ç",
		"é","É","ê","Ê","è","È","ë","Ë",
		"í","Í","î","Î","ì","Ì","ï","Ï",
		"ñ","Ñ",
		"ó","Ó","ô","Ô","ò","Ò","ø","Ø","õ","Õ","ö","Ö","œ","Œ",
		"š","Š","ß","ð","Ð","þ","Þ",
		"ú","Ú","û","Û","ù","Ù","ü","Ü",
		"ý","Ý","ÿ","Ÿ"," ");

		$replace = array ("&quot;","&acute;",
		"&aacute;","&Aacute;","&acirc;","&Acirc;","&agrave;","&Agrave;","&aring;","&Aring;",
		"&atilde;","&Atilde;","&auml;","&Auml;","&aelig;","&AElig;","&ccedil;","&Ccedil;",
		"&eacute;","&Eacute;","&ecirc;","&Ecirc;","&egrave;","&Egrave;","&euml;","&Euml;",
		"&iacute;","&Iacute;","&icirc;","&Icirc;","&igrave;","&Igrave;","&iuml;","&Iuml;",
		"&ntilde;","&Ntilde;","&oacute;","&Oacute;","&ocirc;","&Ocirc;","&ograve;","&Ograve;",
		"&oslash;","&Oslash;","&otilde;","&Otilde;","&ouml;","&Ouml;","&oelig;","&OElig;",
		"&scaron;","&Scaron;","&szlig;","&eth;","&ETH;","&thorn;","&THORN;","&uacute;",
		"&Uacute;","&ucirc;","&Ucirc;","&ugrave;","&Ugrave;","&uuml;","&Uuml;","&yacute;",
		"&Yacute;","&yuml;","&Yuml"," ");

		$Text = str_replace($search, $replace, $text);

                //On ne remplace pas les espaces
                if($keepSpace)
                {
                    $Text = str_replace("-_", " ", $Text);
                }
                    
                    
		return $Text;
 	}

 	//Retourne une chaine de caractere deformate de la base
 	static public function ReplaceString($text)
 	{
        $search = array ('"',"'",
		"á","Á","â","Â","à","À","å","Å","ã","Ã","ä","Ä","æ","Æ",
		"ç","Ç",
		"é","É","ê","Ê","è","È","ë","Ë",
		"í","Í","î","Î","ì","Ì","ï","Ï",
		"ñ","Ñ",
		"ó","Ó","ô","Ô","ò","Ò","ø","Ø","õ","Õ","ö","Ö","œ","Œ",
		"š","Š","ß","ð","Ð","þ","Þ",
		"ú","Ú","û","Û","ù","Ù","ü","Ü",
		"ý","Ý","ÿ","Ÿ"," ","&");

		$replace = array ("&quot;","&acute;",
		"&aacute;","&Aacute;","&acirc;","&Acirc;","&agrave;","&Agrave;","&aring;","&Aring;",
		"&atilde;","&Atilde;","&auml;","&Auml;","&aelig;","&AElig;","&ccedil;","&Ccedil;",
		"&eacute;","&Eacute;","&ecirc;","&Ecirc;","&egrave;","&Egrave;","&euml;","&Euml;",
		"&iacute;","&Iacute;","&icirc;","&Icirc;","&igrave;","&Igrave;","&iuml;","&Iuml;",
		"&ntilde;","&Ntilde;","&oacute;","&Oacute;","&ocirc;","&Ocirc;","&ograve;","&Ograve;",
		"&oslash;","&Oslash;","&otilde;","&Otilde;","&ouml;","&Ouml;","&oelig;","&OElig;",
		"&scaron;","&Scaron;","&szlig;","&eth;","&ETH;","&thorn;","&THORN;","&uacute;",
		"&Uacute;","&ucirc;","&Ucirc;","&ugrave;","&Ugrave;","&uuml;","&Uuml;","&yacute;",
		"&Yacute;","&yuml;","&Yuml"," ","!et!");

		$Text = str_replace($replace, $search, $text);

 		return $Text;
 	}

	/**
	 * Remplace les caracteres speciaux pour les url
	 * */
	static public function ReplaceForUrl ($text)
	{
		$search = array ('"',"'",
		"A","Á","â","Â","à","À","å","Å","ã","Ã","ä","Ä","æ","Æ",
		"ç","Ç",
		"é","É","ê","Ê","è","È","ë","Ë",
		"í","Í","î","Î","ì","Ì","ï","Ï",
		"ñ","Ñ",
		"ó","Ó","ô","Ô","ò","Ò","ø","Ø","õ","Õ","ö","Ö","œ","Œ",
		"š","Š","ß","ð","Ð","þ","Þ",
		"ú","Ú","û","Û","ù","Ù","ü","Ü",
		"ý","Ý","ÿ","Ÿ"," ");

		$replace = array ("_","_",
		"a","a","a","a","a","a","a","a",
		"a","a","a","a","a","a","c","c",
		"e","e","e","e","e","e","e","e",
		"i","i","i","i","i","i","i","i",
		"n","n","o","o","o","o","o","o",
		"o","o","o","o","o","o","o","o",
		"s","s","s","s","s","t","t","u",
		"u","u","u","u","u","u","u","y",
		"y","y","y","-");

		$Text = str_replace($search, $replace, $text);
		return $Text;
	}

        /**
	 * Remplace les caracteres speciaux pour les url
	 * */
	static public function GetReplaceForUrl ($text, $all = true)
	{
            if($all)
            {
		$search = array ('"',"'",
		"A","Á","â","Â","à","À","å","Å","ã","Ã","ä","Ä","æ","Æ",
		"ç","Ç",
		"é","É","ê","Ê","è","È","ë","Ë",
		"í","Í","î","Î","ì","Ì","ï","Ï",
		"ñ","Ñ",
		"ó","Ó","ô","Ô","ò","Ò","ø","Ø","õ","Õ","ö","Ö","œ","Œ",
		"š","Š","ß","ð","Ð","þ","Þ",
		"ú","Ú","û","Û","ù","Ù","ü","Ü",
		"ý","Ý","ÿ","Ÿ"," ");

		$replace = array ("_","_",
		"a","a","a","a","a","a","a","a",
		"a","a","a","a","a","a","c","c",
		"e","e","e","e","e","e","e","e",
		"i","i","i","i","i","i","i","i",
		"n","n","o","o","o","o","o","o",
		"o","o","o","o","o","o","o","o",
		"s","s","s","s","s","t","t","u",
		"u","u","u","u","u","u","u","y",
		"y","y","y","_");
            }
            else
            {
                $search = array (" ");

		$replace = array ("_");
            }
            
		$Text = str_replace($replace, $search, $text);
		return $Text;
	}
        
        /*
         * 
         */
        static public function ReplaceUrl ($text, $all = true)
	{
         if($all)
            {
		$search = array ('"',"'",
		"A","Á","â","Â","à","À","å","Å","ã","Ã","ä","Ä","æ","Æ",
		"ç","Ç",
		"é","É","ê","Ê","è","È","ë","Ë",
		"í","Í","î","Î","ì","Ì","ï","Ï",
		"ñ","Ñ",
		"ó","Ó","ô","Ô","ò","Ò","ø","Ø","õ","Õ","ö","Ö","œ","Œ",
		"š","Š","ß","ð","Ð","þ","Þ",
		"ú","Ú","û","Û","ù","Ù","ü","Ü",
		"ý","Ý","ÿ","Ÿ"," ");

		$replace = array ("_","_",
		"a","a","a","a","a","a","a","a",
		"a","a","a","a","a","a","c","c",
		"e","e","e","e","e","e","e","e",
		"i","i","i","i","i","i","i","i",
		"n","n","o","o","o","o","o","o",
		"o","o","o","o","o","o","o","o",
		"s","s","s","s","s","t","t","u",
		"u","u","u","u","u","u","u","y",
		"y","y","y","_");
            }
            else
            {
                $search = array ("-_");

		$replace = array ("_");
            }
            
		$Text = str_replace($replace, $search, $text);
		return $Text;
        }
        
	static public function ReplaceForJs($text)
	{
		$search = array ("a","b","c","d","e","f","s","-:-","-!-");

		$replace = array ("d","q","b","k","z","w","d","1","2");

		$Text = str_replace($search, $replace, $text);
		return $Text;
	}

	/**
	 * Remplace tous les accents
	 */
	static public function ReplaceAccent($text)
	{
		//return ereg_replace("éèô","eeo",$text);
		return $text;
	}

 	static public function ReverseDate($date)
 	{

 	}
        
        /**
         * Coupe un text sans couper les mots
         * @param type $texte
         * @param type $nbchar
         * @return type
         */
        public static function Tronquer($texte, $nbchar)
        {
            return (strlen($texte) > $nbchar ? substr(substr($texte,0,$nbchar),0,
            strrpos(substr($texte,0,$nbchar)," "))." ..." : $texte);
        }
 }

?>
