<?php
header('Content-Type: text/html; charset=UTF-8');

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

session_start();
/**
 * Page et Classe Ajax
 * Page appel� par les appele Ajax
 ***/
include("../autoload.php");


use Core\Core\Core;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;

$Core= Core::getInstance("dev", false);
$Core->Init();

if(Request::GetPost("App") != "")
{
    $appName = "Apps\\". Request::GetPost("App"). "\\".Request::GetPost("App");
    $class= new $appName($Core);
}
else
{
    $class= new DashBoardManager($Core);
}

//Get the Methode
$Methode = Request::GetPost("Methode");

//Get A multilangue Code
if($Methode == "GetCode")
{
    echo $class->GetCode(Request::GetPost("Code"));
}
else
{
  $class->$Methode();
}
