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
    
    public function __construct($app, $action, $params)
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
}
