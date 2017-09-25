<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Test;

/**
 * Description of Test
 *
 * @author jerome
 */
class Test 
{
    public static function TestEntity()
    {
        //self::GetById();
        //self::GetAll();
        //self::GetByArg();
        
        //self::Insert();
        //self::Update();
        self::Delete();
    }
    
    public static function GetById()
    {
        //Test des entité
        $core = \Core\Core\Core::getInstance();
        
        echo "<br/>Debut Recupertion : ";
        echo "Get User Id 113";
    
        $user = new \Core\Entity\User\User($core);
        $user->GetById(113);
       
       echo "<br/> Identite : " . $user->IdEntite;
       echo "<br/> Name : ". $user->Name->Value;
       echo "<br/> Groupe Id :" . $user->GroupeId->Value;
       echo "<br/> Recuperation du groupe liee :" ;
       echo "<br/> Groupe : " .$user->Groupe->Value->Name->Value;
       echo "<br/> Groupe : " .$user->Groupe->Value->Name->Value;
      // echo "<br/> Section Id :" .$user->Groupe->Value->SectionId->Value;
       echo "<br/> Recuperation de la section lié "; 
       echo "<br/> Section :" .$user->Groupe->Value->Section->Value->Name->Value;
       echo "<br/> Section :" .$user->Groupe->Value->Section->Value->Name->Value;
    
       $groupe =new \Core\Entity\Group\Group($core);
       $groupe->GetById(2);
       echo "<br/> Groupe 2".$groupe->Name->Value;  
      
       $section =new \Core\Entity\Section\Section($core);
       $section->GetById(2);
       echo "<br/> Section 2".$section->Name->Value;  
      
       echo "<br/> Fin :" ;
       
       //Recuperation du groupe
       echo "<br/> Recuperation du groupe Direct";
       $group = new \Core\Entity\Group\Group($core);
       $group->GetById(2);
       echo "<br/>NOM DU GROUPE :".  $group->Name->Value;  
                
       echo "<br/> Recuperation depuis le storage manager";
       echo "<br/> Get User By Id 113" ;
       $user = new \Core\Entity\User\User($core);
       $user->GetById(113);

       echo "<br/> IdEntie :" .$user->IdEntite;
       echo "<br/> Name :" . $user->Name->Value;
       
       echo "br/> Recuperation via l'entité lié.";
       echo "<br/> Groupe : " .$user->Groupe->Value->Name->Value;
         
       echo "JE devrait avoir 3 appele base de donnée";
    }
    
    /*
     * Get All User
     */
    public static function GetAll()
    {
        $core = \Core\Core\Core::getInstance();
        
        echo "<br/>Debut Recupertion de tous les utilisateur: ";
        $user = new \Core\Entity\User\User($core);
        $users = $user->GetAll();
        $users = $user->GetAll();
        echo "Get All : Nombre = " . count($users);
    }
    
    /*
     * Get User with Group Id 1
     */
    public static function GetByArg()
    {
        $core = \Core\Core\Core::getInstance();
        
        echo "<br/>Debut Recupertion des utilisateur GetByArg : ";
        $user = new \Core\Entity\User\User($core);
        $user->AddArgument(new \Core\Entity\Entity\Argument("Core\Entity\User\User", "GroupeId", EQUAL, 2));
        
       
        $users = $user->GetByArg();
        echo "<br/> Nombre d'utilisateur trouvés Id = 2 : ".count($users);
        
        $user2 = new \Core\Entity\User\User($core);
        $user2->AddArgument(new \Core\Entity\Entity\Argument("Core\Entity\User\User", "GroupeId", EQUAL, 1));
     
        $users2 = $user2->GetByArg();
        $users = $user->GetByArg();
      
        $users2 = $user->GetByArg();
      
        echo "<br/> Nombre d'utilisateur trouvés Id = 1 : ".count($users);
        
        
        $userOrder = new \Core\Entity\User\User($core);
        $userOrder->AddArgument(new \Core\Entity\Entity\Argument("Core\Entity\User\User", "GroupeId", EQUAL, 2));
        $userOrder->AddOrder("Email");
        $userOrder->SetLimit(2,23);
        
        $users = $userOrder->GetByArg();
        
        echo "<br/> Limit : Nombre d'utilisateur : " . count($users);
    }
    
    /*
     * Insertion d'un utilisateur
     */
    public static function Insert()
    {
        
        echo "<br/> Insertion d'un utilisateur";
        
        $core = \Core\Core\Core::getInstance();
        
        $user = new \Core\Entity\User\User($core);
        
        $users = $user->GetAll();
        
        echo "<br/> Nombre d utilisateur avant insertion :"  . count($users);
        
        $user->Email->Value = "toto@test.com";
        $user->GroupeId->Value = "2";
        $user->PassWord->Value = "qjsdfsdfl";
        
        $user->Save();
        
        $users = $user->GetAll();
        echo "<br/> Nombre d utilisateur apres insertion :"  . count($users);
    }
    
    /*
     * Update a entity
     */
    public static function Update()
    {
        echo "<br/> Update a entity";
        
        $core = \Core\Core\Core::getInstance();
        
        $user = new \Core\Entity\User\User($core);
        $user->GetById(113);
        
        echo "<br/> Email : " . $user->Email->Value;
        
        $user->Email->Value = "Jerome.Oliva@gmail.com";
        
        $user->Save();
        
        echo "<br/>Recherche dans le store manager : ";
        $user->GetById(113);
        
        echo $user->Email->Value;
    }
    
    /*
     * Delete the last entity
     */
    public static function Delete()
    {
        echo "<br/>Delete the last user";
        
        $core = \Core\Core\Core::getInstance();
        $user = new \Core\Entity\User\User($core);
        $user->AddOrder("Id", false);
        $user->SetLimit(1,1);
        $users = $user->GetByArg();
        echo "<br/ > Nb user : " . count($users);
        
        echo "<br/> IdEntite : " .$users[0]->IdEntite;
        $users[0]->Delete();
        
        echo $usersNew = $user->GetByArg();
        echo "<br/ > Nb user : " . count($usersNew);
        
    }
}
