<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Ressource;

use Apps\Ressource\Module\Ressource\RessourceController;
use Core\App\Application;
use Core\Core\Request;

class Ressource extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'mmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Ressource";

    /**
     * Constructeur
     * */
     function Ressource($core)
     {
        parent::__construct($core, "Ressource");
        $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
        $textControl = parent::Run($this->Core, "Ressource", "Ressource");
        echo $textControl;
     }

    /**
     * Recherche une ressources seln des mots clé
     */
    public function Search()
    {
        $ressourceController = new RessourceController($this->Core);
        echo $ressourceController->Search(Request::GetPost("KeyWord"));
    }
}
?>