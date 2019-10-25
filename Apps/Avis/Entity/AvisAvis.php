<?php 
/*
* PuzzleApp
* Webemyos
* Jérôme Oliva
* GNU Licence
*/

namespace Apps\Avis\Entity;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\UploadProperty;


class AvisAvis extends Entity  
{
	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="AvisAvis"; 
		$this->Alias = "AvisAvis"; 

		$this->Name = new Property("Avis.Name", "Name", TEXTBOX,  true, $this->Alias); 
		$this->Email = new Property("Email", "Email", TEXTBOX,  false, $this->Alias);
		$this->Avis = new Property("Avis.Avis", "Avis", TEXTAREA,  true, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 
		$this->Actif = new Property("Actif", "Actif", CHECKBOX,  false, $this->Alias);
		
		// Le name correspond a l'app qui l'utilise
		$this->Image = new UploadProperty("Avis", "Image", UPLOAD,  false, $this->Alias);

		//Partage entre application 
		$this->AddSharedProperty();

		//Creation de l entité 
		$this->Create(); 
	}

	function GetImage()
	{
		$file = "../Web/Data/Apps/Avis/" . $this->IdEntite . "-96.png";

		if(file_exists($file))
		{

			return str_replace("../Web", "", $file);
		}
		else
		{
			return "images/nophoto.png";
		}
	}

	/**
	 * Class 
	 */
	function getClass()
	{
		$indexColor = rand(1, 5);

		switch($indexColor)
		{
			case 1: return "bgGrey";
			case 2 : return "bgGreen";
			case 3 : return "bgViolet";
			case 4 : return "bgPink";
			case 5: return "bgYellow";
		}
	}
}
?>