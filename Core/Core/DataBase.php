<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

use Core\Core\Log;
use Exception;

class DataBase implements IDataBase
{
	//Proprietes
	public $CommandText="";
	public $Count=0;

	private $connection;
	public $Version;

	/*Constructeur
	 * @param nom du serveur
	 * @param nom de la base
	 * @param utilisateur
	 * @param mot de passe
	 */
	function __construct($server="",$baseName="",$login="",$pass="")
	{
		//Version
		$this->Version = "2.1.0.0";

		if($server != "")
		{
                    	$erreur="";

                        //Connection � la base de donn�e
			$this->connection = mysqli_connect($server,$login,$pass) ;
			$erreurBase = mysqli_select_db($this->connection, $baseName);

            		if(!$this->connection)
			 throw new Exception("Probleme serveur :".mysqli_error($this->connection));
			if(!$erreurBase)
			 throw new Exception("Probleme Base de donnee :" .mysqli_error($this->connection));

			Log::Title(DB,"Connection",INFO);
		}
	}

        /**
         * Selection de la base de donnée
         */
        function SelectDb($baseName)
        {
            @mysqli_select_db($baseName, $this->connection);
        }
        
	/*
	 * Retourne une ligne
	 * @param requete sql
	 * \return un tableau de donnee
	 */
	function GetLine($requete="")
	{
            Trace::Sql($requete);
            
            $result="";
            
            if($requete !="")
                $res=mysqli_query($this->connection, ''.$requete.'');
            else
                $res=mysqli_query($this->connection, $this->CommandText);

            //Log de l'erreur
            if(!$res)
            {
                throw new  Exception(mysqli_error($this->connection));
                
                Log::Write(DB," GetLine : ".mysqli_error($this->connection) ,ERR);
                return false;
            }
            else
            {
                $result=mysqli_fetch_assoc($res);

                Log::Write(DB," GetLine : ".$requete ,INFO);

                return $result;
            }
	}

	/**
	 * Retourne plusieurs lignes
	 * @param requete sql
	 * \return un tableau de donnee
	 * */
	function GetArray($requete="")
	{
            //Execution de la requete
		if($requete !="")
                    $res=mysqli_query($this->connection, $requete);
		else
                    $res=mysqli_query($this->connection, $this->CommandText);

            	//Log de l'erreur
		if(!$res)
		{
	            Log::Write(DB," GetArray : ".mysqli_error($this->connection) ,ERR);
		 	return false;
		}
		else
		{

			$i=0 ;
			$Tab=array();
			//Parcourt des lignes
			while($lines=mysqli_fetch_assoc($res))
			{
				foreach($lines as $Key=>$Value)
				{
					$Tab[$i][$Key]=$Value;
				}
				$i++;
			}
			//Nombre de ligne
			$this->Count=sizeof($Tab);

			Log::Write(DB," GetArray : ".$requete , INFO);

			return $Tab;
		}
	}

	/*
	 * Recupere un element par son code
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByCode($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		return $this->GetLine($request);
	}

	 /** Recupere un element par son code
	 * @param $request requete sql
	 * @param $fields champs recherch�s
	 * @parma $tables table contenant les donn�es
	 * @param $arguments Arguments de fitlres
	 * */
	public function GetByName($request="",$fields="",$tables="",$alias="",$arguments="")
	{
		return $this->GetLine($request);
	}
	/**
	 * Execute une requete
	 * @param requete sql
	 *  \return un tableau de donnee
	 */
	function Execute($requete)
	{
              Trace::Sql($requete);
              
		Log::Write(DB," Execute : ".$requete , INFO);
         if(mysqli_query($this->connection, $requete))
         {}
         else
         {
             echo mysqli_error($this->connection);
         }
         
         return true ;
	}

	/**
	 * Execute plusieurs requetes (separateur ;)
	 * @param requete sql
	 * \return true ou false
	 */
	function ExecuteMulti($requete, $separator =";")
	{
		$request = explode($separator,$requete);

		for($i=0;$i<sizeof($request)-1;$i++)
		{
			if(!DataBase::Execute($request[$i]))
			{
				Log::Write(DB,mysqli_error(),ERR);
				return false;
			}
		}
		return true;
	}


	/*
	 * Retourne le dernier identifiant inserer
	 * \return l'identifiant insere
	 */
	function GetInsertedId()
	{
            return mysqli_insert_id($this->connection);
	}
}

/*
 * Interface obligatoires pour toutes les classe de gestion de base
 */
interface IDataBase
 {
	public function GetLine();
	public function GetArray();
	public function Execute($request);
 }


?>