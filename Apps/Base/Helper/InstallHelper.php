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
        echo "<br/>Création des tables";
        $request = File::GetFileContent(__DIR__. "/../Db/install.sql");
        $core->Db->ExecuteMulti($request);
  
    
        //Set Admin
        echo "<br/>Création de l'administrateur";
        $request = "INSERT INTO ee_user ( GroupId, Email, Password) values(1, '".$admin."', '".md5($passAdmin)."' )"  ;
        $core->Db->Execute($request);
  
        //Set Table for EeApp
        echo "<br/>Création des tables de l'app";
        $request = File::GetFileContent(__DIR__. "/../../EeApp/Db/install.sql");
        $core->Db->ExecuteMulti($request);
  
        //Set Admin On EeApp
        echo "<br/>Initialisation de l'administrateur";
        $user = new User($core);
        $user = $user->GetByEmail($admin);
        
        $appAdmin = new EeAppAdmin($core);
        $appAdmin->AppId->Value = 1;
        $appAdmin->UserId->Value = $user->IdEntite;
        $appAdmin->Save();
 
        //Set The Cms Script
        echo "<br/>Installation du CMS";
        $request = File::GetFileContent(__DIR__. "/../../Cms/Db/install.sql");
        $core->Db->ExecuteMulti($request);
    
        //Set The Ide Script
        echo "<br/>Installation de l'ide";
        $request = File::GetFileContent(__DIR__. "/../../Ide/Db/install.sql");
        $core->Db->ExecuteMulti($request);


        //Set the Base languague
        echo "<br/>Passage des script de traduction";
        self::InsertLanguage($core, __DIR__. "/../Lang/langFr.json");   
        self::InsertLanguage($core, __DIR__. "/../../EeApp/Lang/langFr.json");   
        self::InsertLanguage($core, __DIR__. "/../../Cms/Lang/langFr.json");   

        //set the Install Key
        $core->Config->SetKey("INSTALLED", "1");
    }
    
    /**
     *  Insert les language de base en fr
     **/
    public static function InsertLanguage($core, $file)
    {
      $data = json_decode(file_get_contents($file));
      $codeLang = $data->lang;

      $request  =  "SELECT Id FROM ee_lang where Code='". $codeLang ."'" ;
      $result = $core->Db->GetLine($request);
      $langId = $result["Id"];

      foreach($data->data as $element)
      {

          $request = "SELECT Id FROM ee_lang_code where Code='".$element->Code."'";
          $result =  $core->Db->GetLine($request);

          if($result == null)
          {
            $request = "INSERT INTO ee_lang_code(Code) VALUES ('".$element->Code."' )";
            $core->Db->Execute($request);
          }

          $request = "SELECT Id FROM ee_lang_element where CodeId=(select Id from ee_lang_code where code = '".$element->Code."' limit 0,1) AND LangId=" .$langId ;
          $result =  $core->Db->GetLine($request);
          
          if($result == null)
          {
            $request = "INSERT INTO ee_lang_element (CodeId, LangId, Libelle) values ";
            $request .= "(( select Id from ee_lang_code where code = '".$element->Code."' limit 0,1), ".$langId ." , '".$element->Libelle."');";
            $core->Db->Execute($request);
          }
      }
    }
}
