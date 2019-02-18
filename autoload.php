<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

/**
 * Load class
 *
 * @author jerome
 */
function __autoload($class)
{
   $path = str_replace('\\', DIRECTORY_SEPARATOR, $class);
   $extended = false;

   //On recherche dans les extends
   if(strstr($path, "Core") !== false)
   {
    $extend = __DIR__ . '/' .str_replace("Core", "Extend", $path) . '.php';
  
    //Recherche dans les extensions
    if(is_file($extend) && !class_exists($class) )
    {
        $extended = true;
        require_once($extend);
    }
   }

   if($extended  == false && is_file(__DIR__. '/' .$path . '.php') && !class_exists($class) )
   {
        require_once(__DIR__. '/' .$path . '.php');
   }
}