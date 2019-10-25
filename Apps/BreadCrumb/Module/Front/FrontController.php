<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\BreadCrumb\Module\Front;

use Core\Core\Core;
use Core\View\ElementView;
use Core\View\View;
use Core\Controller\Controller;
use Core\Router\Router;
/**
 * Front Controller
 *
 * @author jerome
 */
class FrontController extends Controller
{
    function __construct($core = "")
    {
        parent::__construct($core);
    }

    function GetWidget()
    {
        //Extract the route Url
        $route = Router::ExtractRoute();
        $html = "<ul>";
        
       // var_dump($route);

        //racine
        $html .= "<li class='fa fa-home' ><a href='".$this->Core->GetPath("/")."' >&nbsp;".$this->Core->GetCode("BreadCrumb.Home")."</a></li>";
        
        //App
        $app = $route->GetApp();
        if($app != "" && $app != "index")
        {
            $html .= "<li class='fa fa-angle-right' >&nbsp; <a href='".$this->Core->GetPath("/".$app)."' >".$app."</a></li>";
        }

        $action = $route->GetAction();
        $params = $route->GetParams();
        $subParams = $route->SubParams;

        if($action)
        {
            $html .= "<li class='fa fa-angle-right' >&nbsp;".$action ."</li>";
        }

        if($params && !is_numeric($params))
        {
        $html .= "<li class='fa fa-angle-right' >&nbsp;".$params."</li>";
     
        } 
        if($subParams && !is_numeric($subParams))
        { 
        $html .= "<li class='fa fa-angle-right' >&nbsp;".$subParams."</li>";
     
        }

        $html .= "</ul>";


        return $html;
    }
}