<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
include("../environment.php");
include("../autoload.php");

use Core\Core\Core;
use Core\Script\ScriptManager;
use Core\Core\Request;

$Core= Core::getInstance(GetEnvironnement(), false);

//Get a specific script
if(Request::Get("s"))
{
    echo ScriptManager::Get(Request::Get("s"));    
}
//Get a application script
if(Request::Get("a"))
{
    echo ScriptManager::GetApp(Request::Get("a"), Request::Get("m"), "js");   
}
//Get all Script of the framework
else
{
    echo ScriptManager::GetAllJs();    
}

?>
