<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
include("../environment.php");
include("../autoload.php");

use Core\Script\ScriptManager;
use Core\Core\Request;
use Core\Core\Core;

$Core= Core::getInstance(GetEnvironnement(), true);

//Get a specific css
if(Request::Get("s"))
{
    echo ScriptManager::Get(Request::Get("s"));    
}
//Get a application css
if(Request::Get("a"))
{
    echo ScriptManager::GetApp(Request::Get("a"), "", "css");   
}
//Get all css of the framework
else
{
    echo ScriptManager::GetAllJs();    
}

?>
