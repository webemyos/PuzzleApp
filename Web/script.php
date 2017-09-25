<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

include("../autoload.php");

use Core\Script\ScriptManager;
use Core\Core\Request;

//Get a specific script
if(Request::Get("s"))
{
    echo ScriptManager::Get(Request::Get("s"));    
}
//Get a application script
if(Request::Get("a"))
{
    echo ScriptManager::GetApp(Request::Get("a"), "js");   
}
//Get all Script of the framework
else
{
    echo ScriptManager::GetAllJs();    
}

?>
