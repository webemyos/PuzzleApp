<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Lang;

use Core\App\Application;
use Core\Core\Request;

use Apps\Lang\Module\Element\ElementController;
use Apps\Lang\Helper\ElementHelper;


class Lang extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Lang";

    /**
     * Constructeur
     * */
     function __construct($core)
     {
        parent::__construct($core, "Lang");
        $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
        echo parent::RunApp($this->Core, "Lang", "Lang");
     }

    /**
     * Charge les elemernts multilangue courants
     */
    public function LoadElement()
    {
        $elementController = new ElementController($this->Core);
        echo $elementController->LoadElement(Request::GetPost("page"));
    }

    /**
     * Supprime un element multilangue
     */
    public function RemoveElement()
    {
        ElementHelper::RemoveElement($this->Core, Request::GetPost("idElement"));
    }

     /**
     * Supprime un element multilangue
     */
    public function UpdateElement()
    {
        ElementHelper::UpdateElement($this->Core, Request::GetPost("idElement"), Request::GetPost("value"));
    }

    /*
     * Edit un element
     */
    public function EditElement()
    {
        $elementController = new ElementController($this->Core);
        echo $elementController->EditElement(Request::GetPost("elementId"));
    }

    /*
     * Sauvegarde un element
     */
    public function SaveElement()
    {
       ElementHelper::UpdateElement($this->Core, Request::GetPost("elementId"), Request::GetPost("tbLibelle"));

       echo "<span class='sucess'>".$this->Core->GetCode("SaveOk")."</span>";
    }
}
?>