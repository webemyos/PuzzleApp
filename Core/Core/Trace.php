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
    PUBLIC static function Sql($request)
    {
        Trace::$Requests[] = $request;
    }
    
    
    
}

