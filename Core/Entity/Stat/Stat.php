<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class StatFront extends JHomEntity
{
	/**
	 * Statistiques sur le front office
	 */
	function StatFront($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="stat_front";
		$this->Alias = "stft" ;

	    //proprietes
		$this->Adresse = new Property("Adresse","Adresse",TEXTBOX,false,$this->Alias);
		$this->Url = new Property("Url","Url",TEXTBOX,false,$this->Alias);
		$this->Navigator = new Property("Navigator","Navigator",TEXTBOX,false,$this->Alias);
		$this->UserId = new Property("UserId","UserId",NUMERICBOX,false,$this->Alias);
		$this->DateCreate = new Property("DateCreate","DateCreate",DATETIMEBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}

/**
 * Statistique sur les applications
 *
 * */
class StatApp extends JHomEntity
{
	/**
	 * Statistique sur les applications
	 */
	function StatApp($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="stat_app";
		$this->Alias = "stft" ;

	    //proprietes
		$this->Adresse = new Property("Adresse","Adresse",TEXTBOX,false,$this->Alias);
		$this->App = new Property("App","App",TEXTBOX,false,$this->Alias);
		$this->Navigator = new Property("Navigator","Navigator",  TEXTBOX,false,$this->Alias);
		$this->UserId = new Property("UserId","UserId",NUMERICBOX,false,$this->Alias);
		$this->DateCreate = new Property("DateCreate","DateCreate",DATETIMEBOX,false,$this->Alias);
                $this->Question = new Property("Question","Question",TEXTBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}

/**
 * Statistiques sur les widgets
 * */
class StatWidget extends JHomEntity
{
	/**
	 * Statistique sur les widget
	 */
	function StatWidget($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="stat_widget";
		$this->Alias = "stWd" ;

	    //proprietes
		$this->Adresse = new Property("Adresse","Adresse",TEXTBOX,false,$this->Alias);
		$this->Widget = new Property("Widget","Widget",TEXTBOX,false,$this->Alias);
		$this->Navigator = new Property("Navigator","Navigator",TEXTBOX,false,$this->Alias);
		$this->UserId = new Property("UserId","UserId",NUMERICBOX,false,$this->Alias);
		$this->DateCreate = new Property("DateCreate","DateCreate",DATETIMEBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
}


/**
 * Statistiques sur les prototype
 * */
class StatPrototype extends JHomEntity
{
	/**
	 * Statistique sur les widget
	 */
	function StatPrototype($core)
	{
		//Version
		$this->Version ="2.0.1.0";

		//Nom de la table
		$this->Core=$core;
		$this->TableName="stat_prototype";
		$this->Alias = "stPr" ;

	    //proprietes
		$this->Adresse = new Property("Adresse","Adresse",TEXTBOX,false,$this->Alias);
		$this->Navigator = new Property("Navigator","Navigator",TEXTBOX,false,$this->Alias);
		$this->UserId = new Property("UserId","UserId",NUMERICBOX,false,$this->Alias);
		$this->PrototypeId = new Property("PrototypeId","PrototypeId",NUMERICBOX,false,$this->Alias);
		$this->StatistiqueId = new Property("StatistiqueId","StatistiqueId",NUMERICBOX,false,$this->Alias);
		$this->DateCreate = new Property("DateCreate","DateCreate",DATETIMEBOX,false,$this->Alias);

		//Creation de l'entit�
		$this->Create();
	}

	/*
	 * Ajoute un statistique
	 * */
	public static function Add($core, $CodePrototype, $CodeStatistique)
	{
		if(!class_exists('eeProjectPrototype'))
		{
			include('../Apps/EeProjet/Entity/eeProjectPrototype.php');
		}
		//Recuperation du prototype
		$prototype = new eeProjectPrototype($core);
		$prototype->GetByCode($CodePrototype);

		//Recuperation de la statistique
		$statistique = new eeProjectPrototypeStatistique($core);
		$statistique->AddArgument(new Argument("eeProjectPrototypeStatistique", "PrototypeId", EQUAL,$prototype->IdEntite));
		$statistique->AddArgument(new Argument("eeProjectPrototypeStatistique", "Name", EQUAL, $CodeStatistique));
		
		$statistiques = $statistique->GetByArg();

		$stat = new StatPrototype($core);
		$stat->Adresse->Value = $_SERVER['REMOTE_ADDR'];
		$stat->Navigator->Value = $_SERVER['HTTP_USER_AGENT'];
		$stat->DateCreate->Value = JDate::Now(true);
		$stat->UserId->Value = $core->User->IdEntite;

		$stat->PrototypeId->Value = $prototype->IdEntite;
		$stat->StatistiqueId->Value = $statistiques[0]->IdEntite;

		$stat->Save();
	}

	/**
	 * Retourne les statistiques
	 * du prototype
	 * */
	public static function GetByPrototype($core, $prototypeId, $groupBy, $userId =  null)
	{
		switch($groupBy)
		{
			case 0:
			 $date = '"Total" as curDate,';
			$group = '';
			break;
			case 1:
				$date = 'Concat(Day(DateCreate), "-", MONTH(DateCreate), "-", YEAR(DateCreate)) as curDate ,';
				$group = ', DAY(DateCreate)';
			break;
			case 2:
				$date = 'WEEK(DateCreate) as curDate ,';
				$group = ', WEEK(DateCreate)';
			break;
			case 3:
				$date = 'MONTH(DateCreate) as curDate ,';
				$group = ', MONTH(DateCreate)';
			break;
			case 4:
				$date = 'YEAR(DateCreate) as curDate ,';
				$group = ', YEAR(DateCreate)';
			break;
		}

		$requete = 'SELECT '.$date.' count(stat.Id) as Number, stat.prPrStName as Name 
					FROM stat_prototype as Proto
					JOIN eeProjet_prototype_statistique as stat ON Proto.StatistiqueId = stat.Id
					WHERE stat.PrototypeId = '.$prototypeId;
					
		if($userId != null)
		{
			$requete .= ' AND Proto.UserId = '. $userId;
		}			
					
		$requete .=' GROUP BY Proto.StatistiqueId ';

		//Ajout du regroupement
		$requete .= $group;

		$result = $core->Db->GetArray($requete);

		return $result;
	}
}

/**
 * Classe de stat
 * */
class Stat
{
	/**
	 * Ajoute une statistique
	 * */
	public static function Add($core, $url='', $app='', $widget='', $question = '')
	{
		if($url != '')
		{
			$stat = new StatFront($core);
			$stat->Url->Value = $_SERVER['REQUEST_URI'];
		}
		else if($app != '')
		{
			$stat = new StatApp($core);
			$stat->App->Value = $app;
		}
		else if($widget != '')
		{
			$stat = new StatWidget($core);
			$stat->Widget->Value = $widget;
		}
                else if($question != '')
                {
                    $stat = new StatApp($core);
                    $stat->App->Value = "Ca";
                    $stat->Question->Value = $question;
                }

		$stat->Adresse->Value = $_SERVER['REMOTE_ADDR'];
		$stat->Navigator->Value = $_SERVER['HTTP_USER_AGENT'];
		$stat->DateCreate->Value = JDate::Now(true);

		if($core->User != '')
		{
			$stat->UserId->Value = $core->User->IdEntite;
		}

		$stat->save();
	}
}
?>