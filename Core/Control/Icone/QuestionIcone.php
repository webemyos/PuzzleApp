<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

/*
* Icone d'ajout
*/
class QuestionIcone extends Icone
{
    function __construct($core)
    {
        $this->CssClass = "fa fa-question";

        if($core != null)
        {
            $this->Title = $core->GetCode("Add");
        }
    }
}
