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
use Core\Utility\ImageHelper\ImageHelper;
use Core\Utility\File\File;

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
		$excludes = array("AppName", "AppId", "Email", "EntityName","EntityId", "DateCreated");

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

			if(isset($_POST['imgs']) && $_POST['imgs'] != "" )
			{
				$avisId = $this->Core->Db->GetInsertedId();
				$path = explode("/", $_POST['imgs']);
				$fileName = $path[count($path) -1];

				File::CreateDirectory("Data/Apps/Avis/");
				
				rename("Data/Tmp/" .$fileName, "Data/Apps/Avis/". $avisId  .".png" );
				
				//Miniaturisation de l'image
				//Crée un miniature
				$image = new ImageHelper();
				$image->load("Data/Apps/Avis/". $avisId  .".png");
				$image->fctredimimage(200, 0,"Data/Apps/Avis/". $avisId  ."-96.png");

			}
			
		}
	}
}
