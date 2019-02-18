<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Lang\Helper;

use Core\Entity\Entity\Argument;
use Core\Entity\Langs\Langs;
use Core\Entity\Langs\LangsCode;
use Core\Entity\Langs\LangsElement;

class ElementHelper
{
    /**
     * Supprime un element
     * @param type $core
     * @param type $elementId
     */
    public static function RemoveElement($core, $elementId)
    {
        //Suppression des enfants
        $request = "DELETE FROM ee_lang_element WHERE CodeId = " . $elementId;
        $core->Db->Execute($request);
 
         $code = new LangsCode($core);
         $code->GetById($elementId);
         
         $code->Delete();
    }
    
    /*
     * Met a jour un element dans la langue courante
     */
    public static function UpdateElement($core, $idElement, $value)
    {
        //Recuperation de l'identifiant de la langue
        $Lang = new Langs($core);
        $Lang->AddArgument(new Argument("Core\Entity\Langs\Langs","Code",EQUAL, $core->GetLang()));
        $Langs=$Lang->GetByArg();
                
       //Update ou insert l'element
       $element = new LangsElement($core);
            $element->CodeId->Value = $idElement;
            $element->LangId->Value = $Langs[0]->IdEntite;
            $element->Libelle->Value = $value;

            $element->Save();
    }
}

