<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Modele;


class Modele
{
    /*
     * Core
     */
    private $Core;
    
    /*
     * Constructeur
     */
    public function __construct($core = "")
    {
        $this->Core = $core;
    }
}
