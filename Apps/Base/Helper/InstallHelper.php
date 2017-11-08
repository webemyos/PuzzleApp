<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Helper;

use Apps\EeApp\Entity\EeAppAdmin;
use Core\Core\DataBase;
use Core\Entity\User\User;
use Core\Utility\File\File;


/**
 * Helper for install the Framework
 *
 * @author jerome
 */
class InstallHelper 
{
    /**
     * Install the data base
     * And configure the Config File
     */
    public static function Install($core, $serveur, $dataBase, $user, $password, $admin, $passAdmin)
    {
        //Init the config file
        $core->Config->SetKey("DATABASESERVER", $serveur);
        $core->Config->SetKey("DATABASENAME", $dataBase);
        $core->Config->SetKey("DATABASELOGIN", $user);
        $core->Config->SetKey("DATABASEPASS", $password);
        
        //Connect to the database
        $core->Db=new DataBase(
                        $core->Config->GetKey("DATABASESERVER"),
                        $core->Config->GetKey("DATABASENAME"),
                        $core->Config->GetKey("DATABASELOGIN"),
                        $core->Config->GetKey("DATABASEPASS")
                );
      
        //Get the request File
        $request = File::GetFileContent(__DIR__. "/../Db/install.sql");
        
        $core->Db->ExecuteMulti($request);
  
        //Set Admin
        $user = new User($core);
        $user->Email->Value = $admin;
        $user->PassWord->Value = $passAdmin;
        $user->GroupeId->Value = 1;
        $user->Save();
        
        //Set Table for EeApp
        $request = File::GetFileContent(__DIR__. "/../../EeApp/Db/install.sql");
        $core->Db->ExecuteMulti($request);
  
        //Set Admin On EeApp
        $user = new User($core);
        $user = $user->GetByEmail($admin);
        
        $appAdmin = new EeAppAdmin($core);
        $appAdmin->AppId->Value = 1;
        $appAdmin->UserId->Value = $user->IdEntite;
        $appAdmin->Save();
        
        //set the Install Key
        $core->Config->SetKey("INSTALLED", "1");
    }
}
