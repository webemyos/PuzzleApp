<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Helper;

use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Helper\UserNewsLetterHelper;
use Apps\Communique\Entity\CommuniqueListContact;
use Apps\Communique\Entity\CommuniqueListMember;
use Apps\Downloader\Entity\DownloaderRessourceContact;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;
use Core\Entity\Entity\UserGroupUser;
use const EQUAL;

class ListHelper
{
    /**
     * Crée une nouvelle liste
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function SaveList($core, $name)
    {
        $List = new CommuniqueListContact($core);

        $List->UserId->Value = $core->User->IdEntite;
        $List->Name->Value = $name;

        $List->Save();

        return true;
        
    }
    
    /**
     * Ajoute un memebre à une liste
     */
    public static function AddMember($core, $listId, $name, $firstName, $email, $sexe)
    {
        $member = new CommuniqueListMember($core);
        $member->ListId->Value = $listId;
        $member->Name->Value = $name;
        $member->FirstName->Value = $firstName;
        $member->Email->Value = $email;
        $member->Sexe->Value = $sexe;
        $member->Actif->Value = 1;
        
        $member->Save();
    }
    
    /**
     * Supprime un membre d'une liste
     * @param type $core
     * @param type $memberId
     */
    public static function DeleteMember($core, $memberId)
    {
         $member = new CommuniqueListMember($core);
         $member->GetById($memberId);
         
         $member->Delete();
    }
    
    /*
     * Desabonne un email d'un liste de diffusion
     */
    public static function DesabonneMember($core, $ListId, $email)
    {
         $member = new CommuniqueListMember($core);
         $member->AddArgument(new Argument("CommuniqueListMember", "ListId", EQUAL,$ListId ));
         $member->AddArgument(new Argument("CommuniqueListMember", "Email", EQUAL, $email ));
         
         $members = $member->GetByArg();
         
         if(count($members) > 0)
         {
             $member = $members[0];
             $member->Actif->Value = false;
             $member->Save();
         }
    }
    
    /*
     * Obtient le nombre de contact d'une liste
     */
    public static function GetNumberMember($core, $listId)
    {
        $member = new CommuniqueListMember($core);
        $member->AddArgument(new Argument("CommuniqueListMember", "ListId", EQUAL,$listId ));
        
        return count($member->GetByArg());   
    }
    
    /*
     * Syncronise la liste avec tous les contacts Webemyos
     */
    public static function Synchronise($core, $listId)
    {
        //Recuperation des contacts de la liste
         $member = new CommuniqueListMember($core);
         $member->AddArgument(new Argument("CommuniqueListMember", "ListId", EQUAL,$ListId ));
         $members = $member->GetByArg();
         
         //Utilisateur
         $user = new User($core);
         $users = $user->GetAll();
         
         $emailAdded .=  "Users :" .ListHelper::AddUser($core, $listId, $users, $members);
         
         //Blog
         $eblog = DashBoardManager::GetApp("Blog", $core);
         $blog = new BlogBlog($core);
         $blog->GetByName("Webemyos");
         
         $blogger = UserNewsLetterHelper::GetByBlog($core, $blog->IdEntite);
         $emailAdded .=  "\n\rBloggers :" .ListHelper::AddUser($core, $listId, $blogger, $members);
       
         //Livre Blanc
          $eDownloader = DashBoardManager::GetApp("Downloader", $core);
                 
         $booker = new DownloaderRessourceContact($core);
         $booker->AddArgument(new Argument("DownloaderRessourceContact", "RessourceId", EQUAL, 2));
         $bookers = $booker->GetByArg();
         
         $emailAdded .=  "\n\rLivre blanc :" .ListHelper::AddUser($core, $listId, $bookers, $members);
       
         
         echo $core->GetCode("New Email").":". $emailAdded;
    }
    
    public static function AddUser($core, $listId, $users, $members)
    {
        $emailAdded ="";
         
        foreach($users as $user)
         {
             $exist = false;
             
             foreach($members as $member)
             {
                 if($member->Email->Value == $user->Email->Value)
                 {
                     $exist = true;
                     break;
                 }
             }
            
            //Ajout de l'email
            if($exist == false)
            {
                $emailAdded .= $user->Email->Value;

                $newMember = new CommuniqueListMember($core);
                $newMember->ListId->Value = $listId;
                $newMember->Email->Value = $user->Email->Value;
                
                $newMember->Save();
            }
         }
         
         return $emailAdded;
    }
}
