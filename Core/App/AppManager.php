<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Core\App;


class AppManager
{
    /*
    * Défine if te system use à app or one page on site base
    *
    */
   public function IsApp($app)
   {
       //TODO USE A APPMANAGE
       //REFLECHIR COMMENT ON TROUVE LES APPS
       $apps = array("Blog", "Devis", "Solution","Webemyos");

       return (in_array($app, $apps));
   }
}

