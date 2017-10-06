<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ressource\Helper;



class RessourceHelper
{

  /*
  * Recherhe les ressources selon des mots cl�
  */
  public static function Search($core, $keyWord)
  {
      $ressources = array();
      
      //Recherche dans les article de blog 
      //1 recherche simple dans le titre et la description
      $request = "SELECT Name, Description, DateCreated FROM BlogArticle WHERE Name like '%".$keyWord."%'
                   or  Description like '%".$keyWord."%'
      ";
      
      $result = $core->Db->GetArray($request);
      
      //Si pas de resultat decoupage des mots
      
      foreach($result as $res)
      {
        $ressource = new RessourceRessource($core);
        $ressource->Title->Value = JFormat::ReplaceString($res["Name"]);
        $ressource->Description->Value = JFormat::ReplaceString($res["Description"]);
        $ressource->DateCreated->Value = $res["DateCreated"];
        $ressource->Link->Value = "article-".JFormat::ReplaceForUrl(JFormat::ReplaceString($res["Name"])).".html";
             
        $ressources[] =   $ressource;
      }
      
      return $ressources;
  }
  
  /*
   * Fait une recherche plus poussé
   */
  public function AdvancedSearch()
  {
      //Decomposition de la phrase
      
      //Suppression des mots à ne pas rechercher (un ,une, le, la  ...)
      
      //Recherche sur tout les mots de la phrase
      
      //Recherche sans les accents
      
      //Recherche avec des lettre inverser 
  }
}

?>