<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */ 

namespace Core\Modele;

/**
 * Description of ElementModele
 *
 * @author jerome
*/

class ContentModele
{
    public $key;
    public $value;
    
    public function __construct($key, $value)
    {
        $this->key = $key;
        $this->value = $value;
    }
}
