<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Contact\Module\Menu;

use Core\Controller\Controller;

 class MenuController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
          $this->Core = $core;
    }

    /**
     * Creation
     */
    function Create()
    {
    }

    /**
     * Initialisation
     */
    function Init()
    {
    }

    /**
     * Affichage du module
     */
    function Show($all=true)
    {
        $html = "<ul class='alignLeft blueOne'> ";

        //Lien 
        $html .= "<li onclick='EeContactAction.LoadContact()'  ><a class='icon-group'>&nbsp;".$this->Core->GetCode("EeContact.MyContact")."</a></li>";
        $html .= "<li onclick='EeContactAction.LoadSearchContact()' ><a class='icon-search' >&nbsp".$this->Core->GetCode("EeContact.SearchContact")."</a></li>";

        $html .= "</ul>";

        return $html;

    }
 }?>