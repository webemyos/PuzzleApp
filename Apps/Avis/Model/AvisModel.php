<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Avis\Model;

use Core\Core\Request;
use Core\Model\Model;
use Core\Utility\Date\Date;

class AvisModel extends Model
{
	/*
	 * Constructeur
	 */
	public function __construct($core, $avisId = "", $appName ="", $entityId="" )
	{
		$this->Core = $core;

		$entityName = "Apps\Avis\Entity\AvisAvis";
		$this->Entity = new $entityName($core);
		$this->Entity->AppName->Value = $appName;
		$this->Entity->EntityId->Value = $entityId;

		if($avisId != "")
		{
			$this->Entity->GetById($avisId);
		}
	}

	/*
	 * Prepare the form
	 */
	public function Prepare()
	{
		$excludes = array("AppName", "AppId","EntityName","EntityId", "DateCreated");

		if($this->Entity->IdEntite == null)
		{
			$excludes[] = "Actif";
		}

		$this->Exclude($excludes);
	}

	/*
	 * Save/update the entity
	 */
	public function Updated()
	{
		if(Request::GetPost("Name"))
		{
			//Get The Defaul blog
			$this->Entity->DateCreated->Value = Date::Now();
			$this->Entity->Actif->Value = false;

			parent::Updated();
		}
	}
}
