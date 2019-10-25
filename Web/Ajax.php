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
 * Page appel par les appele Ajax
 ***/
include("../environment.php");
include("../autoload.php");


use Core\Core\Core;
use Core\Core\Request;
use Core\Dashboard\DashBoardManager;

$env = GetEnvironnement();

$Core= Core::getInstance($env, $env == "dev");
$Core->Init();

if(!Request::IsConnected($Core)) 
{
    die("Need Authentification");
}

//Get the Methode
$Methode = Request::GetPost("Methode");

if(Request::GetPost("App") != "")
{
    $appName = "Apps\\". Request::GetPost("App"). "\\".Request::GetPost("App");
    $class= new $appName($Core);
}
else if(Request::GetPost("Class") != "" && Request::GetPost("Class") != "DashBoardManager")
{
    $className = str_replace("/","\\", Request::GetPost("Class"));
    $class = new $className($Core);
}
else
{
    $class= new DashBoardManager($Core);
}

//Get A multilangue Code
if($Methode == "GetCode")
{
    echo $class->GetCode(Request::GetPost("Code"));
}
else
{
  echo $class->$Methode();
}
