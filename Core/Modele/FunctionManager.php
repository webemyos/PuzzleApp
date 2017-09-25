<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Modele;

use Core\Utility\Date\Date;

/**
 * Replace element by executed fuction
 *
 * @author OLIVA
 */
class FunctionManager
{
     /**
     * Remplace les fonctions specials
     * {{GetCode(xxx)}} {{GetDate()}}
     * @param type $html
     * @return type
     */
    public static function LoadSpecialFunction($core, $html)
    {
        $html = FunctionManager::GetDate($core, $html);

        if($core != "")
        {

          $html = FunctionManager::GetCode($core, $html);
          $html = FunctionManager::GetPath($core, $html);
          $html = FunctionManager::GetForm($core, $html);
          $html = FunctionManager::GetControl($core, $html);
        }

        return $html;
    }

    /*
     * Replace the Date
     */
    public static function GetDate($core, $html)
    {
         return str_replace("{{GetDate()}}", Date::Now(),$html);
    }

    /*
     * Replace the multilangue
     */
    public static function GetCode($core, $html)
    {
        $pattern = "`{{GetCode\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
            $html = str_replace($match, $core->GetCode($macthes[1][$i]), $html);
            $i++;
        }

        return $html;
    }

    /*
     * Replace url
     */
    public static function GetPath($core, $html)
    {
        $pattern = "`{{GetPath\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
            $html = str_replace($match, $core->GetPath($macthes[1][$i]), $html);
            $i++;
        }

        return $html;
    }

    /*
     * Replace the form
     */
    public static function GetForm($core, $html)
    {
        $pattern = "`{{GetForm\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
            $html = str_replace($match, '<form method="post" action="'.$core->GetPath($macthes[1][$i]).'" >', $html);
            $i++;
        }

        //Close the form
        $html = str_replace("{{CloseForm()}}", "</form>", $html);

        return $html;
    }

    /*
     * Replace the control
     */
    public static function GetControl($core, $html)
    {
        //Control with name and property
        $pattern = "`{{GetControl\((.+),(.+),{(.+)}\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
          $type =  $macthes[1][$i];
          $name = $macthes[2][$i];
          $property = $macthes[3][$i];

          $path =  "\Core\Control\\" .$type . "\\" .$type;
          $iconePath =  "\Core\Control\Icone\\" .$type;

          if(class_exists($path))
          {
            $control = new $path($name);

            $propertys = explode(",", $property);

            foreach($propertys as $prop)
            {
                $props = explode("=", $prop);
                 $key =  $props[0];
                 $value = $props[1];

                $control->$key = $value;
            }

            $html = str_replace($match, $control->Show(), $html);
          }
        else if(class_exists($iconePath))
        {
          $control = new $iconePath($name);

          $propertys = explode(",", $property);

          foreach($propertys as $prop)
          {
              $props = explode("=", $prop);
               $key =  $props[0];
               $value = $props[1];

              $control->$key = $value;
          }

          $html = str_replace($match, $control->Show(), $html);
        }
        else {
         echo "non trouve ". $iconePath;
        }


          $i++;
        }

        //Control with name
        $pattern = "`{{GetControl\((.+),(.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {

          $type =  $macthes[1][$i];
          $name = $macthes[2][$i];
          $path =  "\Core\Control\\" .$type . "\\" .$type;
          if(class_exists($path))
          {
            $control = new $path($name);
            $html = str_replace($match, $control->Show(), $html);
          }

          $i++;
        }

        //Simple Control
        $pattern = "`{{GetControl\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

          foreach($macthes[0] as $match)
          {
             $type =  $macthes[1][$i];

             $path =  "\Core\Control\\" .$type . "\\" .$type;
             if(class_exists($path))
             {
                $control = new $path();

              $html = str_replace($match, $control->Show(), $html);
             }
              $i++;
          }

         return $html;

         $pattern = "`{{GetControl\((.+),(.+),(.+)\)}}`";
          preg_match_all($pattern, $html, $macthes);
           $i = 0;

          foreach($macthes[0] as $match)
          {
            $type = $macthes[1][$i];
            $value = $macthes[2][$i];
            $click = $macthes[3][$i];

            $control = new $type($this->Core);
            $control->Libelle = $value;
            $control->OnClick = $click;

              $html = str_replace($match, $control->Show(), $html);
              $i++;
          }
    }
}