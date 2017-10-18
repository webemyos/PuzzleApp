<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\File;

/*Classe de gestion des fichiers
 */

 class File
 {
   function File()
   {
     $this->Version = "2.0.1.0";
   }

   //Cree un fichier unique et sauvegarde le texte
   //retourne un exception si le fichier existe
   public static function Create($fileName,$text)
   {
     if(!file_exists($fileName))
     {
   	  $file = fopen($fileName,"a");
       fputs($file,$text);
       return true;
     }
     else
     {
       return false;
     }
   }

   //Cree un fichier unique et sauvegarde le texte
   //retourne un exception si le fichier existe
   public static function Append($fileName, $text)
   {
        $file = fopen($fileName,"a");
        fputs($file,$text);
   }

   /*
    * Créer l'arborescence des dossiers
    */
   public static function CreateArboresence($file)
   {
       $path = explode("\\" , $file);
       $createPath = "";

       for($i=0 ; $i < count($path)- 1 ; $i++)
       {
           if($createPath != "")
           {
               $createPath .= "\\";
           }
           $createPath .= $path[$i];
           File::CreateDirectory($createPath);
       }
   }

 /**
  * Recupere le contenu d'un fichier
  */
  public static function GetFileContent($file, $replace = true)
  {
    if(file_exists($file))
     {
     	if($file)
        	return str_replace('-!-', '&' , file_get_contents($file));
        else
        	return file_get_contents($file);
     }
     else
     {
       return false;
     }
  }

/*
 * Enregistre le contenu d'un fichier
 */
  public static function SetFileContent($fileName, $content)
  {
     if(file_exists($fileName))
     {
        return file_put_contents($fileName, $content);
     }
     else
     {
        $file = fopen($fileName,"a");
        fputs($file,$content);

       return false;
     }
  }

  //Telechargement d'un fichier
   public static function UploadFile($file,$Directory,$fileName, $createMiniature=true, $createSmall=true, $fileType ="")
   {
	//Pour les fichiers partagées en met tout
		if($fileType == "Partage")
		{
		   if(file_exists($Directory."/".$fileName)) unlink($Directory."/".$fileName);
		    move_uploaded_file($file, $Directory."/".$fileName);
		}
		else
		// TODO VOIR si on met les fichiers dans des dossiers speciaux au si on l'aisse l'utilisateur choisir
		{
		   if(file_exists($Directory."/".$fileName)) unlink($Directory."/".$fileName);
		    move_uploaded_file($file, $Directory."/".$fileName);
		}

		if(substr_count($Directory,"Profil") || substr_count($Directory,"Wall"))
		{
			     //Recuperation du nom du fichier
          $miniatureName = explode(".",$fileName);

          if(file_exists($Directory."/".$miniatureName[0]."_96.".$miniatureName[1]))
          {
            unlink($Directory."/".$miniatureName[0]."_96.".$miniatureName[1]);
          }

           $image = new JImage();
           $image->load($Directory."/".$fileName);
           $image->fctredimimage(100, 0, $Directory."/".$miniatureName[0]."_96.".$miniatureName[1]);
           $image->load($Directory."/".$miniatureName[0]."_96.".$miniatureName[1]);
           $image->fctcropimage(100, 100, $Directory."/".$miniatureName[0]."_96.".$miniatureName[1]);

		}

	//Si on est dans un repertoire de base on preselectionne le repertoire
	// Par Type Image sond ...
	/*else if()
	{

	}*/

   return true;
    $target = str_replace('//','/',$Directory);
    $fileNameInfos = explode(".",$fileName);

    //Nom du fichier
    $newFileName = $fileName;

    // Tester l'existence d'un fichier commencant par "UserIDUSER"
    if(file_exists($target."/".$newFileName)) unlink($target."/".$newFileName);

     move_uploaded_file($file, $target."/".$newFileName);

 	 //Fichier Images
	 $ExtfichierOK = '" jpg jpeg png gif"';
	  if(!strpos($ExtfichierOK,$fileNameInfos[1]) != '')
	  	return $newFileName;

    $image = new JImage();
    $image->load($target."/".$newFileName);
    $image->fctredimimage(700, 700, $target."/".$newFileName);

    // S'il s'agit d'une photo de profil on va créer des miniatures
    if($Directory=='User') {
      //Creation de la miniature
      if($createMiniature)
      {
          //Recuperation du nom du fichier
          $miniatureName = explode(".",$newFileName);

          if(file_exists($target."/".$miniatureName[0]."_48.".$miniatureName[1]))
          {
            unlink($target."/".$miniatureName[0]."_48.".$miniatureName[1]);
          }

           $image = new JImage();
           $image->load($target."/".$newFileName);
           $image->fctredimimage(50, 0, $target."/".$miniatureName[0]."_48.".$miniatureName[1]);
           $image->load($target."/".$miniatureName[0]."_48.".$miniatureName[1]);
           $image->fctcropimage(50, 50, $target."/".$miniatureName[0]."_48.".$miniatureName[1]);
      }

      if($createSmall)
      {
          //Recuperation du nom du fichier
          $miniatureName = explode(".",$newFileName);

          if(file_exists($target."/".$miniatureName[0]."_96.".$miniatureName[1]))
          {
            unlink($target."/".$miniatureName[0]."_96.".$miniatureName[1]);
          }

           $image = new JImage();
           $image->load($target."/".$newFileName);
           $image->fctredimimage(100, 0, $target."/".$miniatureName[0]."_96.".$miniatureName[1]);
           $image->load($target."/".$miniatureName[0]."_96.".$miniatureName[1]);
           $image->fctcropimage(100, 100, $target."/".$miniatureName[0]."_96.".$miniatureName[1]);
      }
    }

    return $newFileName;
  }

  //Suprression d'un fichier
  public static function Delete($file,$Directory)
  {
  //  echo "<br/>Suppression de : ". $Directory."/".$file;

    if(file_exists($Directory."/".$file))
     {
       echo "Suppression de : ". $Directory."/".$file;

       unlink($Directory."/".$file);

        //Recuperation du nom du fichier
      $miniatureName = explode(".",$file);

      if(file_exists($Directory."/".$miniatureName[0]."_48.".$miniatureName[1]))
        unlink($Directory."/".$miniatureName[0]."_48.".$miniatureName[1]);

      if(file_exists($Directory."/".$miniatureName[0]."_96.".$miniatureName[1]))
        unlink($Directory."/".$miniatureName[0]."_96.".$miniatureName[1]);

       return true;
     }
     else
     {
       echo "Impossible de supprimer : " . $Directory."/".$file;
       return false;
     }

  }

    //Ajout de repertoire
  public static function CreateDirectory($file)
  {
     if(!file_exists($file))
     {
         mkdir ($file, 0777);
         return true;
     }
     else
     {
       return false;
     }
  }

  /**
   * Recupere le type de fichier
   */
  public static function GetType($file)
  {
    $fileNameInfos = explode(".", $file);

	//Fichier sans extension
    if(sizeof($fileNameInfos) == 1)
      return false;

      $ext =  $fileNameInfos[1];
	//Interdiction d'upload de fichier executable
	//TODO ajouter toutes les extensions
    if($ext=="exe" || $ext=="php" || $ext== "php5" || $ext == "py")
    	return false;

      $type = "";

    //TODO ajouter toutes les extensions
      if($ext == "jpg" || $ext == "png" || $ext =='ico' || $ext == "JPG")
      {
      $type = "Images";
      }
      else if($ext == "mp3")
      {
        $type = "Sound";
      }
      else if($ext == "mpeg")
      {
        $type = "Video";
      }
      else
      {
         $type = "Files";
      }

      return $type;
  }

  public static function DirSize($path , $recursive=TRUE , $format = true)
  {
	  $result = 0;
	  if(!is_dir($path) || !is_readable($path))
	   return 0;

	  $fd = dir($path);

	  while($file = $fd->read())
	  {
	   if(($file != ".") && ($file != ".."))
	   {
	    if(@is_dir("$path$file/"))
	     $result += $recursive?JFile::DirSize("$path$file/",$recursive, $format):0;
	    else
	     $result += filesize("$path$file");
	   }
	  }
	  $fd->close();

	  if($format)
	  	return JFile::FormatSize($result);
	  else
	  	return $result;
 }

  /**
   * Formate la taille d'un fichier
   * */
  public static function FileSize($file, $format = true)
  {
  	if($format)
		return JFile::FormatSize(filesize($file));
	else
		return filesize($file);
  }

/**
 * Formate la taille d'un fichier
 * */
 public static function FormatSize($size)
 {
	if($size >= 1000000)
	{
		return round(($size / 1000000),2)."Mo";
	}
	else if( $size >= 1000)
	{
		return round(($size / 1000),2)."Ko";
	}
	else
	{
		return round($size,2)."o";
	}
 }

  /**
   * Suppression d'un repertoire
   * */
   public static function DeleteDirectory($directory)
   {
     if(file_exists($directory))
     {
         rmdir ($directory);
         return true;
     }
     else
     {
        echo "Dossier inconnue";
       return false;
     }
   }

	public static function GetMini($file)
	{
		//Todo Determiner L'extension
		$newFile = str_replace(".jpg","_96.jpg",$file);
		return $newFile;
	}

        //TODO A VERIFIER
  public static function RemoveAllDir($dir)
	{
    //echo "Supression du repertoire" . $dir;

	    $files = glob( $dir . '*', GLOB_MARK );

           // print_r($files);
	    foreach( $files as $file )
	    {
	    	$filetype = explode(".",$file);

                if(is_dir($file)  /* substr( $file, -1 ) == "\\" */ /*A VERIFIER SOUS LINUX$filetype == 1 /* substr( $file, -1 ) == '/'*/ )
	         {
                    File::RemoveAllDir( $file );
	         }
	        else
                 {
                   unlink($file);
                  //  File::Delete($file,"");
	         }
	    }

	    rmdir( $dir );
	}

  //Decompression d'un dossier zip
  public static function UnCompresse($directory, $folder)
  {
    $tab_liste_fichiers = array(); //Initialisation
    $zip = zip_open($directory."/".$folder);

    $folderDes ="";
    if ($zip)
    {
      while ($zip_entry = zip_read($zip)) //Pour chaque fichier contenu dans le fichier zip
      {
        if (zip_entry_filesize($zip_entry) > 0)
        {
          $complete_path = $directory."/".dirname(zip_entry_name($zip_entry));

          // Nom du dossier de destination
          $folderDes =dirname(zip_entry_name($zip_entry));
          /*On supprime les �ventuels caract�res sp�ciaux et majuscules*/
          $nom_fichier = zip_entry_name($zip_entry);
          $nom_fichier = strtr($nom_fichier,"�����������������������������������������������������","AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn");
          $nom_fichier = $nom_fichier;

          /*On ajoute le nom du fichier dans le tableau*/
          array_push($tab_liste_fichiers,$nom_fichier);

          $complete_name = $directory."/".$nom_fichier; //Nom et chemin de destination

          if(!file_exists($complete_path))
          {
            $tmp = '';
            foreach(explode('/',$complete_path) as $k)
            {
              $tmp .= $k.'/';

              if(!file_exists($tmp))
              { mkdir($tmp, 0755); }
            }
          }

          /*On extrait le fichier*/
          if (zip_entry_open($zip, $zip_entry, "r"))
          {
            $fd = fopen($complete_name, 'w');

            fwrite($fd, zip_entry_read($zip_entry, zip_entry_filesize($zip_entry)));

            fclose($fd);
            zip_entry_close($zip_entry);
          }
        }
      }

      zip_close($zip);

      /*On efface �ventuellement le fichier zip d'origine*/
      /*if ($effacer_zip === true)
      unlink($file);*/

      return $folderDes;
    }
  }
 }
?>
