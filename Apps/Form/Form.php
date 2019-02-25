<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form;

use Apps\Form\Entity\FormForm;
use Apps\Form\Entity\FormQuestion;
use Apps\Form\Entity\FormResponseUser;
use Apps\Form\Helper\FormHelper;
use Apps\Form\Helper\QuestionHelper;
use Apps\Form\Module\Form\FormController;
use Apps\Form\Module\Question\QuestionController;
use Apps\Form\Module\Front\FrontController;
use Core\App\Application;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Utility\Email\Email;

class Form extends Application
{
  /**
   * Auteur et version
   * */
  public $Author = 'Eemmys';
  public $Version = '1.0.0';
  public static $Directory = "../Apps/Form";

  /**
   * Constructeur
   * */
   function __construct($core)
   {
     parent::__construct($core, "Form");
     $this->Core = $core;
   }

   /**
    * Execution de l'application
    */
    function Run()
    {
      echo parent::RunApp($this->Core, "Form", "Form");
    }

    

     /**
     * Set the Public Routes
     */
    public function GetRoute()
    {
       $this->Route->SetPublic(array("Form"));
      
       return $this->Route;
    }
   /*
    * Détail d'un formulaire 
    */
   function Form($params)
   {
      $this->Core->MasterView->Set("Title", "Form");

      $frontController = new FrontController($this->Core);
      return $frontController->Index($params);
   }
   
   
    /**
   * Récupère les formulaires de l'utilisateur
   */
   function LoadForm()
   {
      $formController = new FormController($this->Core);
      echo $formController->LoadForm();
   }

   /**
    * Edition d'un formulaire
    *
    */
   function DetailForm()
   {
      $formController = new FormController($this->Core);
      echo $formController->DetailForm();
   }

   /**
    * Enregistre le formulaire
    */
   function SaveForm()
   {
        echo FormHelper::SaveForm($this->Core, Request::GetPost('idEntity'));
   }

   /**
    * Suppression du formulaire
    * */
   function DeleteForm()
   {
       FormHelper::DeleteForm($this->Core, Request::GetPost('idEntity'));
       $this->LoadForm();
   }

   /**
    * Charge les questions et les réponses utilisateurs
    *
    */
   function LoadQuestionReponse()
   {
      $formController = new FormController($this->Core);
      echo  $formController->LoadQuestionReponse(Request::GetPost('idEntity'));
   }

   /**
    * Detail d'une question
    */
   function DetailQuestion()
   {
       $questionController = new QuestionController($this->Core);
       echo $questionController->DetailQuestion(Request::GetPost('idEntity'));
   }

   /**
    * Enregistre la question
    */
   function SaveQuestion()
   {
      echo QuestionHelper::SaveQuestion($this->Core, 
                            Request::GetPost('idEntite'),
                            Request::GetPost("idForm"),
                            Request::GetPost("lstType")
               );
   }

  /**
   * Supprime une question et ces réponses
   */
  function DeleteQuestion()
  {
    $question = new FormQuestion($this->Core);
    $question->GetById(Request::GetPost('idEntity'));
    $idForm = $question->FormId->Value;
  
    QuestionHelper::DeleteResponse($this->Core, $question->IdEntite);
    $question->Delete();

    $formController = new FormController($this->Core);
    
    echo$formController->GetTabQuestion($idForm)->Show();
  }
  

  /**
   * Permet de tester le questionnaire
   * */
  function TryForm()
  {
    $questionController = new FormController($this->Core);
    echo $questionController->TryForm(Request::GetPost('idForm'));
  }

  /**
   * Envoi des emails d'invitations
   * Pour s'incrire et répondre au formulaire
   *
   */
  function SendForm()
  {
    //Recuperation du formulaire
    $formId = Request::GetPost("FormId");
    $form = new FormForm($this->Core);
    $form->GetById($formId);
  	
    if(Request::GetPost('tbEmail') != '')
    {
      $emails = explode(';', Request::GetPost('tbEmail'));

      foreach($emails as $email)
      {
        $Email  = new Email($this->Core);
        $Email->Template = "MessageTemplate";
        $Email->Sender = WEBEMYOSMAIL;

        //Venez découvrir et participer au projet de
        $Email->Title = $this->Core->GetCode("TitleInvitationForm") ." ". $this->Core->User->GetPseudo();

        //Recuperation des email
        $TextInvitation = $this->Core->GetCode("TextInvitationForm");
        
        $text = str_replace("{User}", $this->Core->User->GetPseudo(), $TextInvitation );
        $text = str_replace("{TitleEnquete}",  $form->Libelle->Value, $text);
        $text = str_replace("{DescriptionEnquete}",  $form->Commentaire->Value, $text);
        
        $Email->Body .= $text;
        $Email->Body .= "<br/><br/> Vous pouvez y répondre en cliquant sur ce lien <a href='".$this->Core->GetPath("/")."/Form/".$formId.".html'>Voir le questionnaire</a>";

        $Email->Send($email);
        $Email->SendToAdmin();
      }

      echo "<span id='lbResultSend'><span class='success'> ".$this->Core->GetCode("Form.InvitationSended")."</span></span>";
    }
    else
    {
      echo "<span id='lbResultSend'><span class='error'>".$this->Core->GetCode("Form.FieldEmpty")."</span></span>";
    }
  }

  /**
   * Retounre toutes les réponse des questionnaires
   */
  function	GetReponsesProjet($idProjet)
  {
  	$TextControl = '';

  	$form = new eForm($this->Core);
  	$form->AddArgument(new Argument("eForm","ProjetId",EQUAL, $idProjet));
  	$forms = $form->GetByArg();

	if($forms > 0)
  	{
  		foreach($forms as $form)
  		{
  			$TextControl .= '<h5>'.$form->Libelle->Value.'</h5>';
  			$TextControl .= $form->Commentaire->Value;
  			$TextControl .= $this->GetTabResponseUser($form->IdEntite)->Show();
  		}
  	}

  	return $TextControl;
  }

/**
 * Affiche les réponse d'un questionnaire'
 *
 */
  function DetailResponse()
  {
	$idForm = Request::GetPost('idEntity');
	echo $this->GetTabResponseUser($idForm)->Show();
  }
	 
  /*
  * Définie si l'utilisateur à déjà répondue
  * au questionnaire
  */	 
  function HaveReponse($FormId)
  {
  	  //on ajoute pas les questionnaire remplie par l'utilisateur
      $userAvantage = new UserAvantage($this->Core);
      $userAvantage->AddArgument(new Argument("UserAvantage","UserId",EQUAL, $this->Core->User->IdEntite));
	  $userAvantage->AddArgument(new Argument("UserAvantage","FormId",EQUAL, $FormId));

	  $Avantage = $userAvantage->GetByArg();
		
	  return (count($Avantage) > 0);
  }

  /**
   * Enregistre le formulaire utilisateur
   * */
  function SendFormUser()
  {
    FormHelper::SendFormUser($this->Core);
  }

  /*
  *	Obtient le nombre de personnes qui ont répondu
  * aux questionnaires
  */
  function GetNumberUser($userId)
  {
	   $request = "SELECT COUNT(DISTINCT(reponseUser.UserId)) as Number
					 FROM eeForm_response_user as reponseUser
					 JOIN eeForm_question as question on reponseUser.QuestionId = question.Id
					 JOIN eeForm as form ON question.FormId = form.Id
					 WHERE form.UserId = " .$userId;
					 
		$result = $this->Core->Db->GetLine($request);
	
		return $result["Number"];
  }

  /*
  * Lance l'application en dehors du site
  */  
  function Display()
  {
        $TextControl = "";
        
        $TextControl .= "<div class='row center' style='text-align:center;margin:auto;'>";
    
  		//Recuperation du formulaire
  		$form = new FormForm($this->Core);
		$form->GetById($this->IdEntity);
  		
  		
  		if($form->IdEntite != "")
  		{
  			//Info du questionnaire
	  		$TextControl .="<div class='col-md-12' style='text-align:left'>";
	  
	  
	  		//Ajout de la description a la balise mete
        if(isset($this->Core->Page))
	  		 $this->Core->Page->Masterpage->AddControllerTemplate("!Description", $form->Commentaire->Value);
	  		
              $questionController = new FormController($this->Core);
              $TextControl .= $questionController->TryForm($form->IdEntite, false);

              $TextControl .="</div>";
	  	}
	  	else
	  	{
	  		$TextControl .= "Ce formulaire n'existe pas!";
	  	}
	  
                $TextControl .= "</span>";
                
  		return $TextControl;
  }
  
  /**
   * Retourne les formulaire d'une applciation
   * @param type $appName
   * @param type $entityId
   */
  public function GetByApp($appName, $entityName, $entityId)
  {
      return FormHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
  }
  
  /**
   * Sauvegarde un formualaire pour un App
   */
  public function SaveByApp($appName, $entityName, $entityId, $libelle, $commentaire)
  {
      return FormHelper::SaveByApp($this->Core, $appName, $entityName,$entityId, $libelle, $commentaire );
  }
  
  /**
   * Obtient les dernièere enquêtes
   */
  public function GetInfo()
  {
  $html ="";
            
            //Obtient les dernière evenements
            $forms = FormHelper::GetLast($this->Core);
            
            foreach($forms as $form)
            {
                   $html .= "<div class='form'><a href='#' onclick='mmys.ShowForm(".$form->IdEntite.")'>";
                    
                  // $html .= "<span class='date'>".$form->DateCreated->Value."</span>";
                   $html .= "<span class='text'>".$form->Libelle->Value."</span></a>";
                 
                  $html .= "</div>";
            }
            
            return $html;
  }
  
  public function GetNumberForm()
  {
      $eform = new FormForm($this->Core);
      return count($eform->GetAll());
  }
  
  public function GetNumberReponse()
  {
      $response = new FormResponseUser($this->Core);
      return count($response->GetAll());
  }
  
  /**
   * Affiche les réponse d'un formlaire groupé
   */
  public function ShowByGroup()
  {
      $formController =new FormController($this->Core);
      echo $formController->GetTabResponseUser(Request::GetPost("FormId"))->Show();
  }
  
  
  /**
   * Affiche les réponse d'un formlaire ^par utilisateur
   */
  public function ShowByUser()
  {
      $formController = new FormController($this->Core);
      echo $formController->GetTabResponseUser(Request::GetPost("FormId"), true)->Show();
  }
}
?>