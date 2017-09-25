<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

use Core\Core\Core;


 /*
 * Icone d'edition
 */
 class EditIcone extends Icone
 {

 	function __construct($core = null)
 	{
     $core = Core::getInstance();

     $this->CssClass = "fa fa-edit";

     if($core != null)
     {
         $this->Title = $core->GetCode("Edit");
     }
 	}
 }
