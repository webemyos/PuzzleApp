<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Helper;

use Apps\Agenda\Entity\ContactContact;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;


class InvitationHelper
{
    /**
     * Envoir une invitation
     * 
     * @param type $core
     * @param type $user
     */
    public static function Send($core, $sujet, $message, $users)
    {
        $Notify = DashBoardManager::GetApp("Notify", $core);
             
        foreach($users as $user)
        {
           if(!InvitationHelper::InContact($core, $core->User->IdEntite, $user))
           {
               //Enregistrement
               $contact = new ContactContact($core);
               $contact->StateId->Value = ContactContact::INVITATION;
               $contact->UserId->Value = $core->User->IdEntite;
               $contact->ContactId->Value = $user;
               $contact->Save();
              
               //Ajout d'une notification et envoi d'un email
                $Notify->AddNotify($core->User->IdEntite, "Contact.NotifyUserSendInvitation", $user, "Contact", $core->Db->GetInsertedId(), $sujet, $message );
           }
       }
       
       return true;
    }
    
    /**
     * relance une invitation
     * 
     * @param type $core
     * @param type $invitationId
     */
    public static function Relance($core, $invitationId, $Notify)
    {
        $invitation = new ContactContact($core);
        $invitation->GetById($invitationId);
        
        //Donnée de l'emai
        $sujet = $core->GetCode("Contact.SujetEmailRelance");
        $message = $core->GetCode("Contact.MessageEmailRelance");
        
       //Ajout d'une notification et envoi d'un email
       $Notify->AddNotify($core->User->IdEntite, "Contact.RelanceInvitation", $invitation->ContactId->Value, "Contact", $invitationId, $sujet, $message );
    }
    
    /**
     * Défini si les deux peronnes sont déjà en contact
     * 
     * @param type $core
     * @param type $userId
     * @param type $contactId
     */
    public static function InContact($core, $userId, $contactId)
    {
        $request = "SELECT * FROM ContactContact WHERE ";
        $request .= "    (UserId = ".$userId." AND ContactId = ".$contactId.") ";
        $request .= " OR (UserId = ".$contactId." AND  ContactId = ".$userId." )";
        
        $result = $core->Db->GetArray($request);
        
        return (count($result) > 0); 
    }
    
    /**
     * Récupère les invitations
     * 
     * @param type $core
     * @param type $userId
     * @param type $contactId
     */
    public static function GetByUser($core, $userId="", $contactId = "")
    {
        $invitations = new ContactContact($core);
     
        if($userId != "")
        {
            $invitations->AddArgument(new Argument("ContactContact", "UserId" , EQUAL, $userId));
        }
        if($contactId != "")
        {
           $invitations->AddArgument(new Argument("ContactContact", "ContactId" , EQUAL, $contactId));
        }
        
       $invitations->AddArgument(new Argument("ContactContact", "StateId", EQUAL, 1));
        
        return $invitations->GetByArg();
    }
    
    /**
     * Obtient le nombre d'invitation
     * @param type $core
     * @param type $type
     */
    public static function GetNumber($core, $type)
    {
        $invitations = new ContactContact($core);
     
        if($type == 0)
        {
            $invitations->AddArgument(new Argument("ContactContact", "ContactId" , EQUAL, $core->User->IdEntite));
        }
        else if($type == 1)
        {
            $invitations->AddArgument(new Argument("ContactContact", "UserId" , EQUAL, $core->User->IdEntite));
        }
        
        $invitations->AddArgument(new Argument("ContactContact", "StateId" , EQUAL, ContactContact::INVITATION));
        
        return count($invitations->GetByArg());
    }
    
    /**
     * Envoie un email d'invitation à découvrir Webemyos
     */
    public static function SendEmailInvitation($core, $email)
    {
         //Creation de l'email
        $Email  = new Email();
        $Email->Template = "MessageTemplate";
        $Email->Sender = WEBEMYOSMAIL;

         // sujet et message de l'email
         $Email->Title = $core->GetCode("Contact.EmailInvitationSubjet") . " ".  $core->User->GetPseudo();
         $Email->Body .= $core->GetCode("Contact.EmailInvitationMessage");
         
         $Email->Send($email);
         $Email->SendToAdmin();
    }
    
    /**
     * Accepte une invitation
     */
    public static function Accept($core, $invitationId)
    {
        $contact = new ContactContact($core);   
        $contact->GetById($invitationId);
        
        $contact->UserId->Value = $contact->UserId->Value;
        $contact->StateId->Value = ContactContact::CONTACT;
        $contact->Save();
    }
    
    /**
     * Refuse une invitation
     */
    public static function Refuse($core, $invitationId)
    {
        $contact = new ContactContact($core);   
        $contact->GetById($invitationId);
        
        $contact->UserId->Value = $contact->UserId->Value;
        $contact->StateId->Value = ContactContact::BLOCKED;
        $contact->Save();
    }
}

?>
