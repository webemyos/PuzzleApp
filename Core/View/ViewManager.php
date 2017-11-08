<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\View;

use Core\Core\Core;



/**
 * Description of ViewManager
 *
 * @author jerome
 */
class ViewManager 
{
    /*
     * Find Template in the cache
     */
    public static function Find($template)
    {
        $surchageTemplate = str_replace("Apps", "View", $template);
        
        //Search if the Template is rewrite in the APP
        if(file_exists($surchageTemplate))
        {
            return $surchageTemplate;
        }
        else
        {
            return $template;
        }
    }
    
    /*
     * Replace the content
     */
    public static function ReplaceContent($html, $element)
    {
        return str_replace("{{".$element->key."}}", $element->value, $html);
    }
    
    /*
     * Replace path Entity->Property->Value by this Value
     */
    public static function ReplaceElement($html, $element)
    {
        $key = $element->key;
        $value = $element->value;
        
        if(get_parent_class($value) == "Core\Entity\Entity\Entity")
        {
           $html = ViewManager::ReplaceIf($key, $value, $html);
           $html = ViewManager::ReplaceProperty($key, $value, $html);
        }
        else if(is_array($value))
        {
            $html =  ViewManager::LoadCollections($html, $key, $value);
        }
        else
        {
            $html = ViewManager::ReplaceIfElement($element->key, $element->value, $html);
            $html = str_replace($element->key, $element->value, $html);
        }
        
        return $html;
    }
    
    /*
     * Replace the property
    */
    public static function ReplaceProperty($key, $value, $html)
    {
        $pattern = "`{{".$key."->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        { 
           $prop = $macthes[1][$i];
           $html = str_replace($match, $value->$prop->Value, $html);
           $i++;
        }

        return $html;
    }
    
    /*
     * Replace If COndition
     */
    public static function ReplaceIf($key, $value, $html)
    {
        //Remplacement des if
        $pattern = "`{{if ".$key."->(.+)->Value == (.+)}}`";
        
        preg_match_all($pattern, $html, $macthes);
        $i = 0;
 
        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           $searchValue = $macthes[2][$i];

           
           $start = strpos($html, "{{if ".$key."->".$prop."->Value == ".$searchValue."}}");
           $end = strpos($html, "{{/if ".$key."->".$prop."->Value == ".$searchValue."}}");
           
           $line = substr($html, $start, $end - $start);
      
           
           if($value->$prop->Value == $searchValue)
           {
              $html = str_replace("{{if ".$key."->".$prop."->Value == ".$searchValue."}}", "", $html);
              $html = str_replace("{{/if ".$key."->".$prop."->Value == ".$searchValue."}}", "", $html);
           }
           else
           {
              $html = str_replace($line, "", $html);
              $html = str_replace("{{/if ".$key."->".$prop."->Value == ".$searchValue."}}", "", $html);
           }
           
           $i++;
        } 
        
        return $html;
    }
    
    /*
     * Replace if element == value
     */
    public static function ReplaceIfElement($key, $value, $html)
    {
        //Remplacement des if
        $pattern = "`{{if ".$key." == (.+)}}`";
        
        preg_match_all($pattern, $html, $macthes);
        $i = 0;
 
        foreach($macthes[0] as $match)
        {
           $searchValue = $macthes[1][$i];
    
           $start = strpos($html, "{{if ".$key." == ".$searchValue."}}");
           $end = strpos($html, "{{/if ".$key." == ".$searchValue."}}");
           
           $line = substr($html, $start, $end - $start);
      
           if($value === $searchValue || 
            (($value == true && $searchValue == "true"))
            || 
            (($value == false && $searchValue == "false"))
                   
           )
           {
              $html = str_replace("{{if ".$key." == ".$searchValue."}}", "", $html);
              $html = str_replace("{{/if ".$key." == ".$searchValue."}}", "", $html);
           }
           else
           {
              $html = str_replace($line, "", $html);
              $html = str_replace("{{/if ".$key." == ".$searchValue."}}", "", $html);
           }
           
           $i++;
        } 
        
        return $html;
    }
    
    /*
     * Load Collections
     */
    public static function LoadCollections($html, $key, $element)
    {
        //On extrait la ligne a convertir
        $start = strpos($html, "{{foreach $key}}");
        $end = strpos($html, "{{/foreach $key}}");
  
        //On récupere la ligne entre les foreach 
        $line = substr($html, $start, $end - $start);
        $lines = "";

        $startPhp = strpos($line, "php");
        $endPhp = strpos($line, "!php");
        $codePhp = substr($line , $startPhp, $endPhp - $startPhp);

        if(count($element) > 0)
        {
            //Ajout des élements 
            foreach($element as $elm)
            {
                $newLine = $line;

                //Remplacement des Identifiants
                $newLine = str_replace("{{element->IdEntite}}", $elm->IdEntite, $newLine);
                $newLine = ViewManager::LoadElementProperty($elm, $html, $newLine );
                $newLine = ViewManager::LoadFunction($elm, $html, $newLine );
                $newLine = ViewManager::ReplaceIf("element", $elm, $newLine );
               
                //Ajout de la ligne
                $lines .= $newLine;
            }

            $html = str_replace($line, $lines, $html) ;

        }
        else
        {
            $html = str_replace($line, Core::getInstance()->GetCode("NoElement"), $html) ;
        }

        $html = str_replace("{{foreach $key}}", "", $html) ;
        $html = str_replace("{{/foreach $key}}", "", $html) ;
       
        return $html;
    }
    
    /*
     * Remplace les champs par les valeurs de
     */
    public static function LoadElementProperty($elm, $html, $newLine)
    {
        //Remplacement des propriete enfant
        $pattern = "`{{element->(.+)->Value->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        { 
           $prop = $macthes[1][$i];
           $subprop = $macthes[2][$i];

           $newLine = str_replace($match, $elm->$prop->Value->$subprop->Value, $newLine);
           $i++;
        }
        
        //Remplacement des proprietes
        $pattern = "`{{element->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        { 
           $prop = $macthes[1][$i];
           $newLine = str_replace($match, $elm->$prop->Value, $newLine);
           $i++;
        }
 
        return $newLine;
    }
    
     /*
     * Remplace les fonctions
     */
    public static function LoadFunction($elm, $html, $newLine)
    {
        //Remplacement des fonctions enfant
        $pattern = "`{{element->(.+)->Value->(.+)\(\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        { 
           $prop = $macthes[1][$i];
           $subprop = $macthes[2][$i];

           $newLine = str_replace($match, $elm->$prop->Value->$subprop(), $newLine);
           $i++;
        }
        
        //Remplacement des proprietes
        $pattern = "`{{element->(.+)\(\)}}`";
        preg_match_all($pattern, $newLine, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        { 
           $func = $macthes[1][$i];
           $newLine = str_replace($match, $elm->$func(), $newLine);
           $i++;
        }
        
        return $newLine;
    }
    
   // function LoadIf()

    
}
