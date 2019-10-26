<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeApp\Helper;

use Core\Core\Core;
use Core\Entity\Entity\Argument;
use Apps\EeApp\Entity\EeAppUser;
use Apps\EeApp\Entity\EeAppApp;
use Apps\EeApp\Entity\EeAppAdmin;
use Core\Utility\File\File;
use Core\Utility\Format\Format;

class UploadHelper
{
  /*
  Add the App to the systéme
  */
  public static function DoUploadApp($fileName, $tmpFileName)
  {
      $core = Core::getInstance();

      echo "<br/>Copie du fichier temporaire : ".$tmpFileName;
      $appName = str_replace(".zip", "", $fileName);


      if(move_uploaded_file($tmpFileName, __DIR__."/../../".$fileName))
      {
        echo "<br/> Can't move de file";
      }

      echo "<br/>Decompression du fichier : ".$fileName;
      File::UnCompresse( __DIR__."/../../", $fileName);

      echo "<br/>Suppression de l'archive : ".$fileName;
      File::Delete($fileName,  __DIR__."/../../");

      echo "<br/> Mise à jour de la base de donnée :";
      $request = File::GetFileContent(__DIR__."/../../".$appName."/Db/install.sql");
      $core->Db->ExecuteMulti($request);

      echo  "<br/> Ajout de l'application dans la base de donnée:";
      $app = new EeAppApp($core);
      $app->Name->Value = $appName;
      $app->CategoryId->Value = 1;
      $app->Actif->Value = 1;


      echo "<br/>Ajout de la langue francaise";
      self::DoUploadLanguage("","", __DIR__."/../../".$appName."/Lang/langFr.json");
      
      $app->Save();
  }

   /*
  Add the App to the systéme
  */
  public static function DoUploadLanguage($fileName, $tmpFileName, $packageFile ="")
  {
      $core = Core::getInstance(); 
  
      if($fileName != "")
      {
        if(move_uploaded_file($tmpFileName, __DIR__."/../../".$fileName))
        {
          echo "<br/> Can't move de file";
        }

        $data = json_decode(File::GetFileContent( __DIR__."/../../".$fileName));
      }
      else
      {
        $data = json_decode(File::GetFileContent($packageFile));
      }

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
            $request .= "(( select Id from ee_lang_code where code = '".$element->Code."' limit 0,1), ".$langId ." , '".Format::EscapeString($element->Libelle)."');";
            $core->Db->Execute($request);
          }
      }
      

      echo "<br/>Suppression de l'archive : ".$fileName;
      File::Delete($fileName,  __DIR__."/../../");

  }

}
