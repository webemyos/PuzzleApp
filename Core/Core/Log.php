<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

 class Log
 {
 	//Retourne la version
 	function __construct()
 	{
            $this->Version = "2.0.0.0";
 	}


 	//Enregistre un message dans le dossier correspondant
 	public static function Log($type,$message,$level)
 	{
            Log::Write($type,$message,$level);
 	}

	//Ajoute un titre
 	public static function Title($type, $message ,$level)
 	{
		$message="\n<br/><br/>**********************".$message."*****************";
		Log::Write($type,$message,$level);
 	}

	//Ajoute un message
 	public static function Write($type,$message,$level)
 	{
 		switch ($level)
 		{
 			case LogLEVEL :
 			    if(file_exists("Log\\"))
 			    {
				//Ouverture du fichier
		 		$Name =$type.date('dmY');
		 		$Directory ="Log\\".$type."\\";

				$File=$Directory.$Name.".JLog";

				$log= "--".$_SERVER['PHP_SELF']." :: ".date('j/m/Y: G:i'). " : ".$message;
		 		//�criture depuis fin du fichier
		 			$fp = fopen($File,"a");
		 			fputs($fp, "\n\<br/>"); // on va a la ligne
					fputs($fp, $log); // on �crit le message dans le fichier
					fclose($fp);
 			    }
		 	break;
 		}
 	}

	//Recupere les logs du jour enregistre selon le types
 	public static function GetLog($type)
 	{
 		//Ouverture du fichier
		$Name =$type.date('dmY');
		$Directory ="Log\\".$type."\\";

		$File=$Directory.$Name.".JLog";
		$Log = "";

		if (!file_exists($File) || !$fp = fopen($File,"r"))
		{
			echo "--Echec de l'ouverture du fichier";
			exit;
		}
		else
		{
			while(!feof($fp))
			{
				$Ligne = fgets($fp,255);
				$Log .= $Ligne;
			}

		fclose($fp); // On ferme le fichier
		return $Log;
		}
 	}

	//Supppression des fichiers
 	public function Delete()
 	{   $Name ="En".date('dmY');
		$Directory ="Log\\"."En\\";
		$File=$Directory.$Name.".JLog";
		unlink($File);

		$Name ="Core".date('dmY');
		$Directory ="Log\\"."Core\\";
		$File=$Directory.$Name.".JLog";
		unlink($File);

		$Name ="Db".date('dmY');
		$Directory ="Log\\"."Db\\";
		$File=$Directory.$Name.".JLog";
		unlink($File);
 	}
}
 ?>
