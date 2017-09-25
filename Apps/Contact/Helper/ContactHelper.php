<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Helper;


class ContactHelper
{
    /**
     * Reccherche les contacts
     */
    public static function Search($core, $data, $competenceId)
    {
      if($data != "")
      {
        //Creation de la requête
        $request = " SELECT Id FROM ee_user WHERE ( Name LIKE '%".$data."%' ";            
        $request .= " OR FirstName like '%".$data."%' ";
        $request .= " OR Email like '%".$data."%' ) ";
        
        $request .= " AND Id <> " . $core->User->IdEntite;
        
        //On ne prend pas les contacts existants
        $request .= " AND Id NOT IN(SELECT UserId from ContactContact where ContactId = ".$core->User->IdEntite.")";
        $request .= " AND Id NOT IN(SELECT id from ContactContact where UserId = ".$core->User->IdEntite." AND ContactId IS NOT NULL )";
        $results = $core->Db->GetArray($request);
      }
      
      else  if($competenceId != "")
      {
           $requestCompetence = "SELECT Distinct(UserId) as Id FROM ProfilCompetenceEntity WHERE CompetenceId in (".$competenceId.")";
           $results = $core->Db->GetArray($requestCompetence);
        }
        
        $contacts = array();
        
        if(count($results) > 0 )
        {
            foreach($results as $result)
            {
                  $user = new User($core);
                  $user->GetById($result["Id"]);
                  $contacts[] = $user;
            }
            
            return $contacts;
        }
        else
        {
            return null;
        }
    }
    
    /**
     * Enregistre le contact
     * @param type $core
     * @param type $name
     * @param type $firstName
     * @param type $email
     * @param type $phone
     * @param type $mobile
     * @param type $adresse
     * @param type $contactId
     */
    function Save($core, $name, $firstName, $email, $phone, $mobile, $adresse, $contactId = "")
    {
        $contact = new ContactContact($core);
        if($contactId != "")
        {
            $contact->GetById($contactId);
            $contact->ContactId->Value = "0";
        }
        
        $contact->Name->Value = $name;
        $contact->FirstName->Value = $firstName;
        $contact->Email->Value = $email;
        $contact->Phone->Value = $phone;
        $contact->Mobile->Value = $mobile;
        $contact->Adresse->Value = $adresse;
        $contact->UserId->Value = $core->User->IdEntite;
        
        $contact->Save();
    }
    
    /**
     * Récupèere les contacts de l'utilisateur
     * 
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId)
    {
       $request = "SELECT Id From ContactContact ";
       $request .= " WHERE ( UserId = ". $userId . " AND (StateId IS NULL OR StateId = ".ContactContact::CONTACT." OR StateId = 0)) ";
       $request .= " OR ( ContactId = ".$userId ." AND StateId = ".ContactContact::CONTACT.") " ; 
       
       $results = $core->Db->GetArray($request);
       
       $contacts = array();
       
       if(count($results) > 0)
       {
           foreach($results as $result)
           {
               $contact = new ContactContact($core);
               $contact->GetById($result['Id']);
               
               $contacts[] = $contact;
           }
       }
       
       return $contacts;
    }
}

?>
