<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Core;

class Trace
{
    public static $Requests;
    
    /*
     * Trace the sql Request
     */
    public static function Sql($request)
    {
        Trace::$Requests[] = $request;

        //var_dump(Trace::$Requests);

        if(!isset($_SESSION["Trace"]) /* || !is_array($_SESSION["Trace"])*/){
            $_SESSION["Trace"] = array();
        }
        $_SESSION["Trace"][] =  $request;
       
    }
}

