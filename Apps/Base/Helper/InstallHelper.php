<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Base\Helper;

use Core\Utility\File\File;
use Core\Core\DataBase;


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
    public static function Install($core, $serveur, $dataBase, $user, $password)
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
        
        //set the Install Key
        $core->Config->SetKey("INSTALLED", "1");
        
    }
    
}
