<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Security;

use Core\Core\Core;
use Core\Core\Request;

/**
 * Description of Autorisation
 *
 * @author OLIVA
 */
class Autorisation 
{
    /*
     * Défine if the Use can acces to a section
     */
    public static function IsAutorized($user, $section)
    {
       $core = Core::getInstance();
       
       if(Request::IsConnected($core))
       {
           if($core->User->Groupe->Value->Section->Value->Directory->Value == $section )
           {
               return true;
           }
           else
           {
               echo $core->GetCode("Autorisation.NotAutorised");
               return false;
           }
       }
       else
       {
           echo $core->GetCode("Autorisation.NotConnected");
           return false;
       }
    }
}
