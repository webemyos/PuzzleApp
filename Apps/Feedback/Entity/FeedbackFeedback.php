<?php 
/*
* PuzzleApp
* Webemyos
* Jérôme Oliva
* GNU Licence
*/

namespace Apps\Feedback\Entity;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\Property;
use Core\Entity\Entity\EntityProperty;

class FeedbackFeedback extends Entity  
{
	//Entité liés
	protected $User;

	//Constructeur
	function __construct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="FeedbackFeedback"; 
		$this->Alias = "FeedbackFeedback"; 

		$this->Label = new Property("Label", "Label", TEXTBOX,  true, $this->Alias); 
		$this->Description = new Property("Description", "Description", TEXTAREA,  false, $this->Alias); 
		$this->DateCreated = new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 
		$this->UserId = new Property("UserId", "UserId", NUMERICBOX,  true, $this->Alias);
		$this->User = new EntityProperty("Core\Entity\User\User", "UserId"); 
		$this->StateId = new Property("StateId", "StateId", NUMERICBOX,  true, $this->Alias); 

		//Partage entre application 
		$this->AddSharedProperty();

		//Creation de l entité 
		$this->Create(); 
	}
}
?>