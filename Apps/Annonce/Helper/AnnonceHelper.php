<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Annonce\Helper;

use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;

use Apps\Annonce\Entity\AnnonceAnnonce;
use Apps\Annonce\Entity\AnnonceReponse;


class AnnonceHelper
{
    /**
     * Sauvegarde une annonce
     * @param type $core
     * @param type $objet
     * @param type $message
     * @param type $usersId
     */
    public static function Save($core, $title, $description, $annonceId)
    {
        $annonce = new AnnonceAnnonce($core);
        
        if($annonceId != "")
        {
          $annonce->GetById($annonceId);  
        }
        
        $annonce->UserId->Value = $core->User->IdEntite;
        $annonce->Title->Value = $title;
        $annonce->Description->Value = $description;
        $annonce->DateCreated->Value = Date::Now();
        
        $annonce->Save();
    }
    
    /**
     * Obtient les annonce d'un utilisateur
     */
    public static function GetByUser($core, $userId)
    {
        $annonces = new AnnonceAnnonce($core);
        $annonces->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceAnnonce", "UserId", EQUAL, $userId));
        $annonces->AddOrder("Id");
        
        return $annonces->GetByArg();
    }
    
    /**
     * Recupère les annonces
     * @param type $core
     * @param type $userId
     */
    public static function GetByArg($core, $userId)
    {
        $annonces = new AnnonceAnnonce($core);
        $annonces->addArgument(new Argument("Apps\Annonce\Entity\AnnonceAnnonce", "UserId", NOTEQUAL, $userId));
        
        $annonces->AddOrder("Id", "desc");
        
        return $annonces->GetByArg();
    }
    
    /*
     * Obtient une annonce
    */
    public static function GetById($core, $annonceId)
    {
          $annonce = new AnnonceAnnonce($core);
          $annonce->GetById($annonceId);
          $annonce->AddOrder("Id");
             
          return array($annonce);
    }
    
    /*
     * Sauvegare la reponse
     */
    public static function SaveReponse($core, $message, $annonceId)
    {
       $reponse = new AnnonceReponse($core); 
       $reponse->AnnonceId->Value = $annonceId ;
       $reponse->UserId->Value= $core->User->IdEntite;
       $reponse->Reponse->Value = $message;
       $reponse->DateCreated->Value = Date::Now();
       $reponse->Save();
    
       //Recuperation de l'annonce
       $anonce = new AnnonceAnnonce($core);
       $anonce->GetById($annonceId);
       
       //Message envoye dans l'email
       $subjet = $core->GetCode("Annonce.SubjetMessageReponseAdd");
       $message = $core->GetCode("Annonce.MessageMessageReponseAdd");
       
       //Notification
        $Notify = DashBoardManager::GetApp("Notify", $core);
        $Notify->AddNotify($core->User->IdEntite, "Annonce.ReponsesAdded", $anonce->UserId->Value,  "Annonce", $annonceId, $subjet, $message);
    
    }
    
    /**
     * Obtient les réponse d'une annonce
     */
    public static function GetReponse($core, $annonce)
    {
        $reponses = new AnnonceReponse($core);
        $reponses->AddOrder("Id");
        
        if(is_object($annonce))
        {
            $reponses->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceReponse", "AnnonceId", EQUAL, $annonce->IdEntite));
        }
        else
        {
            $reponses->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceReponse", "AnnonceId", EQUAL, $annonce));
        }
        return $reponses->GetByArg();
    }
    
    /*
     * Nombre de réponse
     */
    public static function GetNumberUserResponse($core, $annonceId)
    {
        return count(AnnonceHelper::GetReponse($core, $annonceId));
    }
    /**
     * Retourne les annonce d'une application
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $message = new AnnonceAnnonce($core);
        $message->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceAnnonce", "AppName" ,EQUAL, $appName));
        $message->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceAnnonce", "EntityName" ,EQUAL, $entityName));
        $message->AddArgument(new Argument("Apps\Annonce\Entity\AnnonceAnnonce", "EntityId" ,EQUAL, $entityId));
        
        return $message->GetByArg();
    }
   
    /**
     * Enregistre une annonce pour une app
     * @param type $core
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     * @param type $libelle
     * @param type $commentaire
     */
    public static function SaveByApp($core, $appName, $entityName,$entityId, $title, $description )
    {
         $annonce = new AnnonceAnnonce($core);
         $annonce->UserId->Value = $core->User->IdEntite;
         $annonce->AppName->Value = $appName;
         $annonce->EntityName->Value = $entityName;
         $annonce->EntityId->Value = $entityId;
         $annonce->Title->Value = $title;
         $annonce->Description->Value = $description;
         $annonce->DateCreated->Value = Date::Now();
         
        $annonce->Save();
    }
    
    /**
     * Retourne les dernieres annonces
     */
    public static function GetLast($core)
    {
         $annonce = new AnnonceAnnonce($core);
         $annonce->SetLimit(1, 3);
         $annonce->AddOrder("DateCreated");
         
         return $annonce->GetAll();
    }
    
    /**
     * Affiche le détail d'un réponse
     */
    public static function GetDetailReponse($core, $reponseId)
    {
        $response = new AnnonceReponse($core);
        $response->GetById($reponseId);
        
        return $response->Reponse->Value;
    }
}
