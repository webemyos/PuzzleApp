<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Helper;

use Apps\Form\Entity\FormQuestion;
use Apps\Form\Entity\FormResponse;
use Apps\Form\Entity\FormResponseUser;
use Core\Core\Request;
use Core\Entity\Entity\Argument;

class QuestionHelper
{
    /**
     * Sauvegarde une question
     * @param type $core
     * @param type $libelle
     * @param type $description
     * @param type $type
     */
    public static function SaveQuestion($core, $questionId, $formId, $type)
    {
        //TODO
        //DESACTIVER TOUTES LES REPONSES LORS D'UN CHANGEMENT DE TYPE
       $question = new FormQuestion($core);

        //Recuperation du formulaire
        if($questionId != 'null')
        {
          $question->GetById($questionId);
          $idQuestion = $questionId;
        }
        else
        {
          $question->FormId->Value = $formId;
          $idQuestion = '';
        }

        $question->Type->Value = $type;

         if($question->IsValid())
         {
           $question->Save();

          if($idQuestion == '')
          {
            $idQuestion = $core->Db->GetInsertedId();
          }
          else
          {
            QuestionHelper::DeleteResponse($core, $idQuestion , Request::GetPost('response'));
          }

           //Enregistrement des responses
           if(Request::GetPost('response'))
           {
             $responses = explode('_-', Request::GetPost('response'));

             foreach($responses as $reponse)
             {
                 $reponse = explode("!!", $reponse);
                 
                 $rep = new FormResponse($core);
             
                 if($reponse[1] != "")
                 {
                     $rep->GetById($reponse[1]);
                 }

                $rep->QuestionId->Value = $idQuestion;
                $rep->Value->Value = $reponse[0];
                $rep->Actif->Value = 1;
                $rep->Save();
             }
           }
          $message =  $core->GetMessageValid();

         }
         else
         {
          $message =  $core->GetMessageError();
          }

         echo "<p class='success'>".$message."</p>";
    }
    
    /**
    * Suprime toutes les réponse d'une questions
    */
   public static function DeleteResponse($core, $idQuestion, $newReponse)
   {
       //GESTION DES SUPPRESSIONS 
        //ON VERIFIE SI IL Y A UNE REPONSE
        //SI OUI ON DESACTIVE LA REPONSE COURANTE
        //SI NON ON SUPPRIME LA REPONSE 
        $response = new FormResponse($core);
        $response->AddArgument(new Argument("Apps\Form\Entity\FormResponse", "QuestionId", EQUAL, $idQuestion));
        $reponses = $response->GetByArg();
        
        $newReponse = explode('_-', $newReponse);

        foreach($reponses as $reponse)
        {
            $delete = true;
            
             foreach($newReponse as $reponseValue)
             {
                 $reponseValue = explode("!!", $reponseValue);
                 
                  //C'est la même Reponse on la garde
                  if($reponseValue[1] == $reponse->IdEntite)
                  {
                      $delete = false;
                  }
             }
    
            if($delete)
            {
                $reponseUser = new FormResponseUser($core); 
                $reponseUser->AddArgument(new Argument("Apps\Form\Entity\FormResponseUser", "ResponseId", EQUAL, $reponse->IdEntite));
                $reponsesUser = $reponseUser->GetByArg();

                if(count($reponsesUser) > 0)
                {
                    $reponse->Actif->Value = 0;
                    $reponse->Save();
                }
                else
                {
                     $reponse->Delete();
                }
            }
        }
   }

   /**
    * Supprime les réponses utilisateurs
    */
   public static function DeleteResponseUser($core, $idQuestion)
   {
           $requete = 'DELETE FROM FormResponseUser WHERE QuestionId='.$idQuestion;
           $core->Db->Execute($requete);
   }
   
   /**
    * Récupère les réponse des utilisateurs
    */
   public static function GetResponseUser($core, $formId, $userId)
   {
              
            if($userId == "")
           {       
                             
       $requete = "SELECT
                                   question.id as QuestionId,
                               question.Libelle as LibelleQuestion,
                               reponse.Value as LibelleReponse,
                  GROUP_CONCAT(Distinct(reponseSimple.Value)) as LibelleReponseUser,
                                   COUNT(Distinct(reponseUser.Id)) as NombreReponse
                               FROM FormQuestion  as question
                                   LEFT JOIN FormResponse as reponse on reponse.QuestionId = question.Id
                                   LEFT join FormResponseUser as reponseSimple on reponseSimple.QuestionId = question.Id
                                   LEFT join FormResponseUser as reponseUser on reponseUser.QuestionId = question.Id AND reponseUser.ResponseId = reponse.Id
                                   LEFT join FormForm as form on question.FormId = form.Id
                                   ";

           $requete .= " WHERE form.Id = ".$formId." ";
           
           
            $requete .=" GROUP BY question.Id, reponse.Id";
           }
           else
           {
               $requete = "SELECT  question.id as QuestionId, question.Libelle as LibelleQuestion, 
reponse.Value as LibelleReponse,
reponseUser.Value as LibelleReponseUser, 
reponseUser.UserId as UserId


FROM FormResponseUser as reponseUser

JOIN FormQuestion as question on question.Id = reponseUser.QuestionId
LEFT JOIN FormResponse as reponse on reponse.Id = reponseUser.ResponseId
JOIN FormForm as form on form.Id = question.FormId


where  form.Id = ".$formId."

ORDER By reponseUser.Id";
               
           }
        $resultat = $core->Db->GetArray($requete);
           return $resultat;
   }
   
   /*
    * Get the reponee of form
    */
   public static function GetByForm($core, $form)
   {
       $questions = new FormQuestion($core);
       $questions->AddArgument(new Argument("Apps\Form\Entity\FormQuestion", "FormId", EQUAL, $form->IdEntite));
       
       return $questions->GetByArg();
   }
}

