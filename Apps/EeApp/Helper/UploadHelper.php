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

class UploadHelper
{
  /*
  Add the App to the systéme
  */
  public static function DoUpload($fileName, $tmpFileName)
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
      
      $app->Save();
  }

}
