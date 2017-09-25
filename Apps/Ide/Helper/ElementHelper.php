<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

use Apps\Ide\Ide;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Control\Libelle\Libelle;
use Core\Control\Upload\Upload;
use Core\Control\VTab\VTab;

/**
* Classe permettant d'obtenir les élements d'un projet
*/
class ElementHelper
{
    /**
     * Récupère tout les élements
     */
    public static function GetAll($core, $projet)
    {
        $tsElement = new VTab("tsElement", "Ide");
        $tsElement->AddTab($core->GetCode("File"), new Libelle(self::GetFiles($core, $projet)));
        $tsElement->AddTab($core->GetCode("Entity"), new Libelle("<div id='lstEntity'>".self::GetEntity($core, $projet)."</div>"));
        $tsElement->AddTab($core->GetCode("Modules"), new Libelle("<div id='lstBlock'>".self::GetModule($core, $projet)."</div>"));
        $tsElement->AddTab($core->GetCode("Helper"), new Libelle("<div id='lstHelper'>".self::GetHelper($core, $projet)."</div>"));
        $tsElement->AddTab($core->GetCode("Images"), new Libelle("<div id='lstImage'>".self::GetImage($core, $projet)."</div>"));
        
        return $tsElement->Show();
    }
    
    /**
     * Rècupere les fichiers
     * 
     * @param type $core
     * @param type $projet
     */
    public static function GetFiles($core, $projet)
    {
       $html = "<ul class='alignLeft'>";
       //$directory = "../Data/Apps/Ide/".$projet."/";
       $directory = Ide::$Destination."/".$projet."/";
       
        if ($dh = opendir($directory))
        {
             while (($file = readdir($dh)) !== false)
             {
               if($file != "." && $file != ".." )
               {
                   if(is_dir($file) || strpos($file, ".") === false)
                   {
                       //  $html .="<li class='icon-folder-close green' style='display:block'>".$file."</li>";
                   }
                   else
                   {
                    $html .="<li class='blue' onclick='IdeElement.LoadFile(\"".$file."\")'>".$file."</li>";
                   }
               }
             }
          }
       
       $html .= "</ul>";   
          
       return $html;
    }
    
    /**
     * Rècupere les entites
     * 
     * @param type $core
     * @param type $projet
     */
    public static function GetEntity($core, $projet)
    {
        $html = "<ul class='alignLeft'>";
         
        //Icone d'ajout
        $html .= "<li><b class='fa fa-plus' title='".$core->GetCode("AddEntity")."' onclick='IdeElement.ShowAddEntity()'>&nbsp;</b>";
        $html .= "<b class='icon-gear' title='".$core->GetCode("Ide.CreateTable")."' onclick='IdeElement.CreateTable()' >&nbsp</b></li>";
         
      //  $directory = "../Data/Apps/Ide/".$projet."/Entity";
        $directory = Ide::$Destination."/".$projet."/Entity";
      
        if ($dh = opendir($directory))
        {
             while (($file = readdir($dh)) !== false)
             {
               if($file != "." && $file != ".." )
               {
                   if(!is_dir($file) || strpos($file, ".") === true)
                   {
                         $html .="<li class='violet' >".str_replace('.php','',$file);
                         $html .= "&nbsp;<b class='icon-search' title='".$core->GetCode("ShowData")."' onclick='IdeElement.ShowData(\"".str_replace('.php','',$file)."\")'>&nbsp</b>";
                         //Suppression
                         $html .= "&nbsp;<b class='icon-remove' title='".$core->GetCode("DeleteEntity")."' onclick='IdeElement.DeleteEntity(\"".str_replace('.php','',$file)."\")'>&nbsp</b>";
                         
                         $html .="</li>";
                   }
               }
             }
          }
        
        
        $html .= "</ul>";
        return $html;
    }
    
    /**
     * Récupere les module du projets
     */
    public static function GetModule($core, $projet)
    {
         $html = "<ul class='alignLeft'>";
         
         //Icone d'ajout
         $html .= "<li><b class='fa fa-plus' title='".$core->GetCode("AddModule")."' onclick='IdeElement.ShowAddModule()'>&nbsp;</b></li>";
         
         //$directory = "../Data/Apps/Ide/".$projet."/Blocks";
        $directory = Ide::$Destination."/".$projet."/Module";
      
        
        if ($dh = opendir($directory))
        {
             while (($file = readdir($dh)) !== false)
             {
               if($file != "." && $file != ".." )
               {
                   if(is_dir($file) || strpos($file, ".") === false)
                   {
                         $html .="<li class='orange' >".$file;
                         $html .= "&nbsp;<b class='fa fa-plus' onclick='IdeElement.AddActionModule(\"$file\")' title='".$core->GetCode("AddAction")."'>&nbsp</b>";
                         $html .= "&nbsp;<b class='fa fa-code' title='".$core->GetCode("ShowCode")."' onclick='IdeElement.LoadCodeModule(\"$file\")'>&nbsp</b>";
                         $html .= "&nbsp;<b class='fa fa-desktop' title='".$core->GetCode("ShowTemplate")."' onclick='IdeElement.LoadTemplate(\"$file\")'>&nbsp</b>";
                   
                         $html .="</li>";
                   }
               }
             }
          }
          
         $html .="</ul>";
        return $html;
    }
    
    /**
     * Récupere tout les helpers du projet
     */
    public static function GetHelper($core, $projet)
    {
         $html = "<ul class='alignLeft'>";
         
         //Icone d'ajout
         $html .= "<li><b class='fa fa-plus' title='".$core->GetCode("AddHelper")."' onclick='IdeElement.ShowAddHelper()'>&nbsp;</b></li>";
         
        //$directory = "../Data/Apps/Ide/".$projet."/Helper";
        $directory = Ide::$Destination."/".$projet."/Helper";
      
        if ($dh = opendir($directory))
        {
             while (($file = readdir($dh)) !== false)
             {
               if($file != "." && $file != ".." )
               {
                    $html .="<li class='violet' >".$file;
                    $html .= "&nbsp;<b class='fa fa-code' title='".$core->GetCode("ShowCode")."' onclick='IdeElement.LoadCodeHelper(\"$file\")'>&nbsp</b>";

                    $html .="</li>";
               }
             }
          }
          
         $html .="</ul>";
        return $html;
    }
    
    /**
     * Obtient les images du projet
     * @param type $core
     * @param type $projet
     */
    public static function GetImage($core, $projet)
    {
         $html = "<ul class='alignLeft'>";
         
        //Icone d'ajout
        $inFile = new Upload("Ide", $projet, "IdeElement.RefreshImageObjet();");
        $html .= "<li>".$inFile->Show()."</li>";
         
        //$directory = "../Data/Apps/Ide/".$projet."/images";
        $directory = Ide::$Destination."/".$projet."/images";
      
        if ($dh = opendir($directory))
        {
             while (($file = readdir($dh)) !== false)
             {
               if($file != "." && $file != ".." )
               {
                    $html .="<li class='violet' >".$file;
                    $html .= "&nbsp;<b class='icon-code' title='".$core->GetCode("ShowImage")."' onclick='IdeElement.LoadImage(\"$file\")'>&nbsp</b>";

                    $html .="</li>";
               }
             }
          }
          
         $html .="</ul>";
        return $html;
    }
    
    /**
     * Charge le contenu d'un fichier
     */
    public static function LoadFile($core, $projet, $file, $module, $helper)
    {
      // $directory = "../Data/Apps/Ide/".$projet."/";
        $directory = Ide::$Destination."/".$projet."/";
      
       if($module != "")
       {
          $file = $directory."Module/".$module."/".$module."Controller.php";
       }
       else if($helper != "")
       {
          echo $file = $directory."Helper/".$helper;
       }
       else
       {
        $file = $directory.$file;
       }
       
       return File::GetFileContent($file);
    }
    
    /**
     * Enregistre le fichier
     */
    public static function SaveFile()
    {
        $name = Request::GetPost('name');
        $projet = Request::GetPost('Projet');
        $code = Request::GetPost('code');

        //Reformatage du code
        $code = str_replace('!-!','"' , $code ) ;
        $code = str_replace('-!!-',"'", $code ) ;
        $code = str_replace('-!-',"&", $code ) ;
        $code = str_replace('!--!',"+", $code ) ;

        //C'est un module
        if(strpos($name, "Module:") > -1)
        {
            $name = str_replace("Module:", "", $name);
            //File::SetFileContent("../Data/Apps/Ide/".$projet."/Blocks/".$name."/".$name.".php", $code);
            $directory = Ide::$Destination;
            File::SetFileContent($directory."/".$projet."/Module/".$name."/".$name."Controller.php", $code);
      
            }
        //C'est un helper
        else if(strpos($name, "Helper:") > -1)
        {
            $name = str_replace("Helper:", "", $name);
          //  File::SetFileContent("../Data/Apps/Ide/".$projet."/Helper/".$name, $code);
             $directory = Ide::$Destination;
            File::SetFileContent($directory."/".$projet."/Helper/".$name, $code);
      
        }
        //C'est un fichier de base
        else
        {
             $directory = Ide::$Destination;
            //File::SetFileContent("../Data/Apps/Ide/".$projet."/".$name, $code);
       
             File::SetFileContent($directory."/".$projet."/".$name, $code);
       }
     }
     
     /**
      * Charge le fichier css
      */
     function LoadCssFile($projet)
     {
        $directory = Ide::$Destination;
       
        $file = $directory."/".$projet."/".$projet.".css";
        return File::GetFileContent($file);
     }
}