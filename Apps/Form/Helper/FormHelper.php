<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Helper;

use Apps\Form\Entity\FormForm;
use Apps\Form\Entity\FormQuestion;
use Apps\Form\Entity\FormResponseUser;
use Apps\Form\Helper\QuestionHelper;
use Core\App\AppManager;
use Core\Control\Button\Button;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;


class FormHelper
{
    /*
     * Sauvegarde le formulaire
     */
    public static function SaveForm($core, $formId)
    { 
        $form = new FormForm($core);
        
         //Recuperation du formulaire
        if(Request::GetPost('idEntity'))
        {
          $form->GetById($formId);
        }
        else
        {
         $form->UserId->Value = $core->User->IdEntite;
        }
        
        $form->Code->Value = Format::ReplaceForUrl(Request::GetPost("Libelle"));
        if($form->IsValid())
        {
          $form->Save();
          $message = $core->GetMessageValid();
        }
        else
        {
         $message =  $core->GetMessageError();
         $message .= $this->DetailForm();
        }

         return "<p id='lbResultForm' class='success'>".$message."</p>";
    }
    
    /**
     * Supprime un formualaire et mes questions
     * @param type $core
     * @param type $formId
     */
    public static function DeleteForm($core, $formId)
    {
        $form = new FormForm($core);
        $form->GetById($formId);

        //Suprression des questionss
        //Recuperation des question
        $Question = new FormQuestion($core);
        $Question->AddArgument(new Argument("Apps\Form\Entity\FormQuestion","FormId", EQUAL, $formId));
        $questions = $Question->GetByArg();

        if(count($questions) > 0)
        {
          foreach($questions as $question)
          {
            QuestionHelper::DeleteResponse($core, $question->IdEntite);
            QuestionHelper::DeleteResponseUser($core, $question->IdEntite);

            $question->Delete();
          }
        }

        //Todo Suppression de reponse et reponse utilisateur
        $form->Delete();
    }
    
    /**
     * Envoie les données de test utilisateur
     */
    function SendFormUser($core)
    {
        
        //On enregistre pas les formulaire du compte de demo
	if($core->User == null || $core->User->IdEntite != 37)
	{
		//Le compte 38 est le compte anonyme
		if($core->User == null)
		{
			$user = new User($core);
			$user->GetById(38);
			$core->User = $user;
		}
	
		//Recuperation des données
	    $idForm = Request::GetPost('idForm');
            $form = new FormForm($core);
            $form->GetById($idForm);
            
            $data = explode('-!', Request::GetPost('data'));
	
	    //Enregistrement des réponses
	    foreach($data as $reponses)
	    {
	      $donne = explode('_', $reponses);
	      $reponseUser = new FormResponseUser($core);
	      $reponseUser->UserId->Value = $core->User->IdEntite;
	
	      switch($donne[0])
	      {
	        case 'tb':
	          $reponseUser->QuestionId->Value = $donne[1];
	          $reponseUser->Value->Value = $donne[2];
	        break;
	        case 'rb':
	          $reponseUser->QuestionId->Value = $donne[1];
	          $reponseUser->ResponseId->Value = $donne[2];
	        break;
	        case 'cb':
	          $reponseUser->QuestionId->Value = $donne[1];
	          $reponseUser->ResponseId->Value = $donne[2];
	        break;
	        case 'lst':
	          $reponseUser->QuestionId->Value = $donne[1];
	          $reponseUser->ResponseId->Value = $donne[2];
	        break;
	      }
	
              $reponseUser->AdresseIp->Value =  $_SERVER["REMOTE_ADDR"];;
              
	      $reponseUser->Save();
	    }
	
	    //Enregistrement avantage utilisateur
	
	    $textControl = '';
	    $textControl.= $core->GetCode('FormCompleted');
	
	    $btnClose = new Button(BUTTON);
	    $btnClose->CssClass = "btn btn-primary";
	    $btnClose->Value = $core->GetCode("Close");
	    $btnClose->OnClick = "Close('NaN','Form','undefined');";
	    $textControl .= $btnClose->Show();
	
	    
            //Envoi une notification au créateur
            $eNotify = AppManager::GetApp("Notify");
            $eNotify->AddNotify($core->User->Identite, $core->GetCode("Form.NewReponse"), 
                    $form->UserId->Value, "Form", $form->IdEntite, $core->GetCode("Form.NewReponseTitle") , $core->GetCode("Form.NewReponseMessage"));

             echo $textControl;
    }
    else
    {
    	echo "Ce compte est un compte de demonstration vous ne pouvez donc pas répondre au questionnaire!";
  		echo "<br/> Vous pouvez créer votre compte en cliquant sur le bouton 'Créer mon compte' ci-dessus.";
     }
    }
    
    /**
     * Obtient le nombre de répondant pour un formulaire
     * @param type $core
     * @param type $formId
     */
    public static function GetNumberUserResponse($core, $formId)
    {
        $request = "SELECT count(Distinct(reponseUser.AdresseIp)) as nbResult FROM FormForm AS form
                    JOIN FormQuestion as question on question.FormId = form.Id
                    JOIN FormResponseUser as reponseUser on reponseUser.QuestionId = question.Id 
                    WHERE form.Id =" .$formId ;
        
        $result = $core->Db->GetLine($request);
        return $result["nbResult"];
    }
    
    /**
     * Retourne les formulaire d'une application
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $form = new FormForm($core);
        $form->AddArgument(new Argument("Apps\Form\Entity\FormForm", "AppName" ,EQUAL, $appName));
        $form->AddArgument(new Argument("Apps\Form\Entity\FormForm", "EntityName" ,EQUAL, $entityName));
        $form->AddArgument(new Argument("Apps\Form\Entity\FormForm", "EntityId" ,EQUAL, $entityId));
        
        return $form->GetByArg();
    }
    
    /**
     * Enregistre un formuaire pour une app
     * @param type $core
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     * @param type $libelle
     * @param type $commentaire
     */
    public static function SaveByApp($core, $appName, $entityName,$entityId, $libelle, $commentaire )
    {
         $form = new FormForm($core);
         $form->UserId->Value = $core->User->IdEntite;
         $form->AppName->Value = $appName;
         $form->EntityName->Value = $entityName;
         $form->EntityId->Value = $entityId;
         $form->Libelle->Value = $libelle;
         $form->Commentaire->Value = $commentaire;
         
        $form->Save();
    }
    
     /**
     * Retourne les dernieres enqu^étes
     */
    public static function GetLast($core)
    {
         $annonce = new FormForm($core);
         $annonce->SetLimit(1, 3);
         $annonce->AddOrder("Id");
         
         return $annonce->GetAll();
    }
}
?>
