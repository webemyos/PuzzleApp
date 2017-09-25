<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Helper ;

use Apps\Ide\Ide;

class ToolHelper
{
    /**
     * Obtient les outils
     */
    public static function GetTool($core)
    {
        $tools = array('Saver', 'Player');
        $html ="";
        
        //Classe de base
        include(Ide::$Directory. "/Tools/Tool.php");
        
        foreach($tools as $toolName)
        {
            //Inclusion de l'outil
            include(Ide::$Directory. "/Tools/".$toolName.".php");
           
            //Creation du control
            $tool = new $toolName($core);
            $html .= $tool->Render();
        }
        
        //Block d'information
        $html .= "<span id='spToolInfo'>...</span";
        
        return $html;
    }
    
    /**
     * Obtient les outils de l'editeur de template
     * @param type $core
     */
    public static function GetTemplateEditorTool($core)
    {
         $tools = array('Saver','Refresh');
        $html ="";
        
        //Classe de base
        include(Ide::$Directory. "/Tools/Tool.php");
        
        foreach($tools as $toolName)
        {
            //Inclusion de l'outil
            include(Ide::$Directory. "/Tools/".$toolName.".php");
           
            //Creation du control
            $tool = new $toolName($core);
            $html .= $tool->Render();
        }
        
        return $html;
    }
}
