<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\EeNotify\Blocks\HomeBlock;

use Core\Modele\Modele;
use Apps\EeNotify\Helper\NotifyHelper;
/**
 * Module accueil
 * */
 class HomeBlock extends Block 
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
          $modele = new Modele(EeNotify::$Directory . "/Blocks/HomeBlock/View/HomeBlock.tpl", $this->Core); 

          $notifys = NotifyHelper::GetByUser($this->Core, $this->Core->User->IdEntite, 10, false);

          //Recuperation 
          $modele->AddElement($notifys);

          return $modele->Render();
        }    
 }?>