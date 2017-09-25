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
 class CommentIcone extends Icone
 {

 	function __construct($core = null)
 	{
     $core = Core::getInstance();

     $this->CssClass = "fa fa-comment";

     if($core != null)
     {
         $this->Title = $core->GetCode("Comment");
     }
 	}
 }