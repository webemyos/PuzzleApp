<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Helper;

use Apps\Communique\Entity\CommuniqueCampagne;
use Apps\Communique\Entity\CommuniqueCampagneEmail;
use Apps\Communique\Entity\CommuniqueCommunique;
use Apps\Communique\Entity\CommuniqueListMember;
use Core\Control\Link\Link;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;
use Core\Utility\Format\Format;


class CommuniqueHelper
{
    /**
     * Crée un nouveau communique
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function SaveCommunique($core, $title, $communiqueId="", $appName="", $entityName="", $entityId="")
    {
        $communique = new CommuniqueCommunique($core);

        if($communiqueId != "")
        {
            $communique->GetById($communiqueId);
        }

        $communique->UserId->Value = $core->User->IdEntite;
        $communique->Code->Value = Format::ReplaceForUrl($title);
        $communique->Title->Value = $title;

        $communique->AppName->Value = $appName;
        $communique->EntityName->Value = $entityName;
        $communique->EntityId->Value = $entityId;

        $communique->Save();

        return true;
    }
    
    /**
     * Met a jour le contenu
     */
    public function UpdateContent($core, $CommuniqueId, $content)
    {
        $communique = new CommuniqueCommunique($core);
        $communique->GetById($CommuniqueId);

        $communique->Text->Value = $content;

        $communique->Save();

        return true;
    }
        
    /**
     * Obtizent les communiques d'une App
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $communique = new CommuniqueCommunique($core);
        
        $communique->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCommunique","AppName", EQUAL, $appName));
        $communique->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCommunique","EntityName", EQUAL, $entityName));
        $communique->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCommunique","EntityId", EQUAL, $entityId));
        
        return $communique->GetByArg();
    }
    
    /**
     * Diffuse un communique de presse à une liste de contact
     * @param type $core
     * @param type $communiqueId
     * @param type $listId
     * @param type $nameExpediteur
     * @param type $emailExpediteur
     * @param type $replyTo
     */
    public static function Diffuse($core, $communiqueId, $listId, $nameExpediteur, $emailExpediteur, $replyTo, $email = "", $replace ="")
    {
        //Recuperatin du communique
        $communique = new CommuniqueCommunique($core);
        $communique->GetById($communiqueId);
        
        //Sauvegarde de la campagne
        $campagne = new CommuniqueCampagne($core); 
        $campagne->CommuniqueId->Value = $communiqueId;
        $campagne->Title->Value = $communique->Title->Value;
        $campagne->Message->Value = $communique->Text->Value;
        $campagne->DateSended->Value = Date::Now();
        $campagne->Save();
        
        $campagneId = $core->Db->GetInsertedId();
        
        //Constitution de l'email
        $expediteur = $nameExpediteur.' <'.$emailExpediteur.'>';

        $headers  = 'MIME-Version: 1.0' . "\r\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset="UTF-8"'."\r\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Content-Transfer-Encoding: 8bit';
        $headers .= "X-Sender: <".$_SERVER['HTTP_HOST'].">\r\n";
        $headers .= "X-auth-smtp-user: ".$nameExpediteur."\r\n";
        //$headers .= "X-abuse-contact: spam@webemyos.fr\r\n";
        $headers .= "Reply-To: ".$replyTo."\r\n"; // Mail de reponse
        $headers .= "From: $expediteur"; // Expediteur

        if($email != "")
        {
            $member = new CommuniqueListMember($core);
            $member->Email->Value = $email;
            $members = array();
            $members[] = $member;
        }
        else
        {
            //Recuperation des destinataires
            $member = new CommuniqueListMember($core);
            $member->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueListMember", "ListId", EQUAL, $listId));
            $member->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueListMember", "Actif", EQUAL, 1));
            $members = $member->GetByArg();
        }
        
        
        if(count($members) > 0)
        {
            foreach($members as $member)
            {
                //TODO VERSION EN LIGN
                //Version en ligne
                 $lkVersionOnLine = new Link($core->GetCode('Communique.Desabonnement'), "http://".$_SERVER["SERVER_NAME"]."/Communique/Detail/".CommuniqueCommunique->IdEntite));
                 $message .= $lkVersionOnLine->Show();

                
                //Message
                $message = str_replace("!et!", "&", $communique->Text->Value);
                
                //Lien vers les images ver webemyos
                $message = str_replace("Data/", "http://".$_SERVER["SERVER_NAME"]."/Data/", $message);
                
                
                //Lien vers l'image de tracking
                // La boite au lettre doit venir chercher l'image sur le serveur pour l'afficher
                // Cela nous permet de tracker l'email de campagne
                $message .= "<img src='http://".$_SERVER["SERVER_NAME"]."/image.php?Page=app&app=Communique&CampagneId=".$campagneId."&email=".$member->Email->Value."'></img>";
               
                if($email == "")
                {
                    //Lien de desabonnement
                    //$lkDesabonnement = new Link($core->GetCode('Communique.Desabonnement'), "http://".$_SERVER["SERVER_NAME"]."/index.php?Page=app&app=Communique&ListId=".$listId."&email=".$member->Email->Value);
                    $lkDesabonnement = new Link($core->GetCode('Communique.Desabonnement'), "http://".$_SERVER["SERVER_NAME"]."/Communique/Desabonnement/ListId=".$listId."&email=".$member->Email->Value);
                   
                    $message .= $lkDesabonnement->Show();
                }
                
                 //Texte a remplacé
                if($replace != "")
                {
                    foreach($replace as $key => $value)
                    {
                        $message = str_replace($key, $value, $message);
                    }
                }
                
                //Envoi
                mail($member->Email->Value, $communique->Title->Value, $message, $headers);
                
                //Sauvegarde
                $campagneEmail = new CommuniqueCampagneEmail($core);
                $campagneEmail->CampagneId->Value= $campagneId;
                $campagneEmail->Email->Value = $member->Email->Value;
                $campagneEmail->Save();
            }
        }
    }
    
    /**
     * Ajoute d'un comptage pour un email ouvert
     */
    function AddEmailOpen($core, $campagneId, $email)
    {
         $campagneEmail = new CommuniqueCampagneEmail($core);
         $campagneEmail->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCampagneEmail", "CampagneId", EQUAL, $campagneId));
         $campagneEmail->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCampagneEmail", "Email", EQUAL, $email));
         
         $emails =$campagneEmail->GetByArg();
         $email = $emails[0];
         
         $email->NumberOpen->Value = $email->NumberOpen->Value +1 ;
         $email->DateOpen->Value = Date::Now();
         $email->Save();
    }
    
    /**
     * Supprime une campagne
     * @param type $core
     * @param type $campagneId
     */
    function RemoveCampagne($core, $campagneId)
    {
        //Supprime les emails
        $email = new CommuniqueCampagneEmail($core);
        $email->AddArgument(new Argument("Apps\Communique\Entity\CommuniqueCampagneEmail", "CampagneId", EQUAL, $campagneId ));
        $emails =$email->GetByArg();
        
        foreach($emails as $email)
        {
            $email->Delete();
        }
        
        $campagne = new CommuniqueCampagne($core);
        $campagne->GetById($campagneId);
        $campagne->Delete();
    }
    
    /**
     * Obtient les images du communique
     * 
     * @param type $core
     * @param type $blogId
     */
    public static function GetImages($core, $communiqueId)
    { 
        $directory = "Data/Apps/Communique/". $communiqueId;
        $dir = "Data/Apps/Communique/". $communiqueId;
        
        $nameFile = array();
        $nameFileMini = array();
        
        
        if ($dh = opendir($directory))
         { $i=0;
         
             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 )
               {
                   $nameFile[$i] = $dir."/".$file;
                   
                   $fileNameMini =str_replace(".png", "", $file);
                   $fileNameMini =str_replace(".jpg", "", $fileNameMini);
                   $fileNameMini =str_replace(".jpeg", "", $fileNameMini);
                   $fileNameMini =str_replace(".ico", "", $fileNameMini);
                           
                   $nameFileMini[$i] = $dir."/".$fileNameMini."_96.png";
                   
                   $i++;
               }
             }
         }
         
         return implode("," , $nameFile) . ";".implode(",", $nameFileMini);
    }
}
