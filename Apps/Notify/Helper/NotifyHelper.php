<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Notify\Helper;

use Apps\Notify\Entity\NotifyNotify;
use Core\Entity\Entity\Argument;
use Core\Entity\User\UserGroupUser;
use Core\Utility\Date\Date;
use Core\Utility\Email\Email;

class NotifyHelper
{
    /**
     * Obtient les notifications de l'utilisateur 
     * @param type $core
     * @param type $userId
     */
    public static function GetByUser($core, $userId, $limit = "", $recent= false)
    {
        $notify = new NotifyNotify($core);
        $notify->AddArgument(new Argument("Apps\Notify\Entity\NotifyNotify", "DestinataireId", EQUAL, $userId ));
        
        $notify->AddOrder("Id");
        
        
        if($recent == true)
        {
            $notify->AddArgument(new Argument("Apps\Notify\Entity\NotifyNotify", "View", ISNULL, "" ));
        }
        if($limit)
        {
        //Limit
        $notify->SetLimit(1, $limit);
            
        }    
        
        //TODO Rajouter les notification des cointacts qui me concerne
        return $notify->GetByArg();
    }
    
    /**
     * Obtient les notifications de l'utilisateur 
     * @param type $core
     * @param type $userId
     */
    public static function ViewByUser($core, $userId)
    {
        $request = "UPDATE NotifyNotify SET View = 1 WHERE DestinataireId=" .$userId;
        $core->Db->Execute($request);
    }
    
    /**
     * Ajoute une notification
     * @param type $userId
     * @param type $code
     * @param type $destinataireId
     * @param type $AppName
     * @param type $EntityId
     */
    public static function AddNotify($core, $userId, $code, $destinataireId, $AppName, $EntityId, $emailSubjet, $emailMessage)
    {
        $notify = new NotifyNotify($core);
        $notify->UserId->Value = $userId;
        $notify->Code->Value = $code;
        $notify->DestinataireId->Value = $destinataireId;
        $notify->AppName->Value = $AppName;
        $notify->EntityId->Value = $EntityId;
        $notify->DateCreate->Value = Date::Now();
        $notify->Save();
        
        //Creation de l'email
        $Email  = new Email();
        $Email->Template = "MessageTemplate";
        $Email->Sender = WEBEMYOSMAIL;

         // sujet et message de l'email
         $Email->Title = $emailSubjet . " ".  $core->User->GetPseudo();
         $Email->Body .= $emailMessage;
         $contact = new User($core);
         $contact->GetById($destinataireId);
      
         $Email->Send($contact->Email->Value);
         $Email->SendToAdmin();
    }
    
    /**
     * Obtient les notification d'une appli et d'une entité
     * 
     * @param type $core
     * @param type $appName
     * @param type $entityId
     */
    public static function GetNotify($core, $appName, $entityId)
    {
         $notify = new NotifyNotify($core);
         
         $notify->AddArgument(new Argument("Apps\Notify\Entity\NotifyNotify","AppName", EQUAL, $appName));
         $notify->AddArgument(new Argument("Apps\Notify\Entity\NotifyNotify","EntityId", EQUAL, $entityId));
         
         return $notify->GetByArg();
    }
    
    /*
     * Obtient les dernières notifications par utilisateur
     */
    public static function GetLastByUser($core, $userId)
    {
        return self::GetByUser($core, $userId, 3);
    }
}