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
    
    if(is_file(__DIR__. '/' .$path . '.php') && !class_exists($class) )
    {
        require_once(__DIR__. '/' .$path . '.php');
    }
}