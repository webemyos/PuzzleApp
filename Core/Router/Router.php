<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Router;

/**
 * Description of Router
 *
 * @author jerome
 */
class Router 
{
    /*
     * Extract the route
     */
    public static function ExtractRoute()
    {
        //Get The Complete Uri
        $url = explode("/", $_SERVER[REQUEST_URI]);
        
        if($_SERVER[HTTP_HOST] == "localhost")
        {
            $route = new Route($url[2], $url[3], $url[4]);
        }
        else
        {
            $route = new Route($url[1], $url[2], $url[3]);
        }
        
        return $route;
    }
}
