<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ressource\Module\Ressource;

use Apps\Ressource\Helper\RessourceHelper;
use Core\Controller\Controller;
use Core\View\View;

 class RessourceController extends  Controller
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
     * Recherche de ressources
     * */
    function Search($keyWord)
    {
       $modele = new View(__DIR__ . "/View/Search.tpl", $this->Core);

       $ressources = RessourceHelper::Search($this->Core, $keyWord);
       $modele->AddElement($ressources);


      return $modele->Render();
    }
 }?>