<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

class LandingPageHelper
{
    
    /**
     * Charge la landing page d'un projet
     */
    function LoadLandingPage($projet)
    {
        $html = "<h1>".$this->Core->GetCode("LandingPage")."</h1>";
        
        return $html;
    }
    
}

