<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Router;

/**
 * Description of Route
 *
 * @author jerome
 */
class Route 
{
    private $app;
    private $action;
    private $params;
    private $publicRoute = array();
    
    public function __construct($app="", $action="", $params="")
    {
        $this->app = $app;
        $this->action=$action;
        $this->params = $params;
    }
    
    /*
     * Get the App
     */
    public function GetApp()
    {
        return $this->app;
    }
    
     /*
     * Set the App
     */
    public function SetApp($app)
    {
        return $this->app = $app;
    }
    
    /*
     * Get the Action
     */
    public function GetAction()
    {
        return $this->action;
    }
    
    /*
     * Set the Action
     */
    public function SetAction($action)
    {
        return $this->action = $action;
    }
    
    /*
     * Get the Params
     */
    public function GetParams()
    {
        return $this->params;
    }

    /***
     * 
     */
    public function SetPublic($routes)
    {
        $this->publicRoutes = $routes;
    }

    public function GetPublic()
    {
      
        return $this->publicRoutes;
    }   

    public function IsPublic($route)
    {
        if($this->publicRoutes == null)
        {
            return false;
        }
        return in_array($route, $this->publicRoutes);
    }


}
