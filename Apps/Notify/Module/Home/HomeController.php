<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Notify\Module\Home;

use Apps\Notify\Helper\NotifyHelper;
use Core\Controller\Controller;
use Core\View\View;


 class HomeController extends Controller
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
          $view = new View(__DIR__ . "/View/HomeBlock.tpl", $this->Core); 

          $notifys = NotifyHelper::GetByUser($this->Core, $this->Core->User->IdEntite, 10, false);

          //Recuperation 
          $view->AddElement($notifys);

          return $view->Render();
        }    
 }?>