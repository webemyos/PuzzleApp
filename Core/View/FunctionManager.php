<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\View;

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
        if($core != "")
        {
          $html = FunctionManager::GetDate($core, $html);
          $html = FunctionManager::GetCode($core, $html);
          $html = FunctionManager::GetPath($core, $html);
          $html = FunctionManager::GetForm($core, $html);
          $html = FunctionManager::GetControl($core, $html);
          $html = FunctionManager::GetWidget($core, $html);
          $html = FunctionManager::GetModule($core, $html);
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
          //Control with name
          $pattern = "`{{GetForm\((.+),(.+)\)}}`";
          preg_match_all($pattern, $html, $macthes);
          $i = 0;
  
          foreach($macthes[0] as $match)
          {
            $url =  $macthes[1][$i];
            $name = $macthes[2][$i];

            $html = str_replace($match, '<form method="post" id="'. $name.'" action="'.$url.'" >', $html);
            $i++;
          }

        $pattern = "`{{GetForm\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
            $html = str_replace($match, '<form method="post" action="'.$macthes[1][$i].'" >', $html);
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
           
                if(get_class($control) == "Core\Control\Submit\Submit" && $key == "Value")
                {
                    $value = $core->GetCode($props[1]);
                }
                else
                {
                    $value = $props[1];
                }
                
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

    /*
    * Replace GetWidget Function
    */
    public static function GetWidget($core, $html)
    {
	    //Control with name and property
	    $pattern = "`{{GetWidget\((.+),(.+),(.+)\)}}`";
	    preg_match_all($pattern, $html, $macthes);
	    $i = 0;
	    foreach($macthes[0] as $match)
	    {
		    $apps =  $macthes[1][$i];
		    $appName =  $macthes[2][$i];
		    $entityId =  $macthes[3][$i];
		    $path =  "\Apps\\" .$apps . "\\" .$apps;
		    $app = new $path($core);
		    $html = str_replace($match, $app->GetWidget($appName, $entityId) , $html);
		    $i++;
	    }
	    //Control with name and property
        $pattern = "`{{GetWidget\((.+)\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;
        foreach($macthes[0] as $match)
        {
          $apps =  $macthes[1][$i];
          $path =  "\Apps\\" .$apps . "\\" .$apps;
          $app = new $path($core);
          $html = str_replace($match, $app->GetWidget() , $html);
          $i++;
        }
        return $html;
    }
    
     /*
    * Replace GetWidget Function
    */
    public static function GetModule($core, $html)
    {
	    //Control with name and property
	    $pattern = "`{{GetModule\((.+),(.+),(.+),(.+)\)}}`";
	    preg_match_all($pattern, $html, $macthes);
	    $i = 0;
	    foreach($macthes[0] as $match)
	    {
		    $apps =  $macthes[1][$i];
		    $module =  $macthes[2][$i];
		    $methode =  $macthes[3][$i];
            $args =  $macthes[4][$i];
            
		    $path =  "\Apps\\" .$apps . "\\Module\\" .$module . "\\" . $module . "Controller";
		    $app = new $path($core);
		    $html = str_replace($match, $app->$methode( $args) , $html);
		    $i++;
	    }
	    
        return $html;
    }
}
