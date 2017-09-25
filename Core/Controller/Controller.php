<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Controller;

use Core\Utility\File\File;

/**
 * Description of Controller
 *
 * @author oliva
 */
class Controller {
   
    /*
     * Core 
     */
    protected $Core;
     
    /*
     * Property
     */
    protected $Parameters = array();
    
   
    
    function __construct($core = "")
    {
        $this->Core= $core;
    }
    /*
    * Ajoute un parametre
    */
    public function AddParameter($key, $value)
    {
            $this->Parameters[$key] = $value;
    }

    /*
    * Ajoute des parametres
    */
    public function AddParameters($paramatres)
    {
            foreach($paramatres as $key => $value)
            {	
                    $this->Parameters[$key] = $value;
            }
    }

    /*
    * Définie le template
    */
    public function SetTemplate($template)
    {
         //Recherche du fichier template
        if(!file_exists($template))
        {
            $template= str_replace("Apps/", "../Apps/", $template);

            if(!file_exists($template))
            {
                $template= str_replace("../Apps/", "../../Apps/", $template);

                if(!file_exists($template))
                {
                    $template= str_replace("../../Apps/", "../../../Apps/", $template);
                }
            }
        }

        $this->Template = $template;
    }

    /*
    * crée le control selon le template
    */
    public function Render()
    {
        //Attention on est dans un sous dossier
        if(!file_exists($this->Template))
        {
           // $this->Template = "../".$this->Template;
        }
        //Recupere le template
        $html = File::GetFileContent($this->Template);

        foreach($this->Parameters as $key => $value )
        {
                $html = str_replace($key, $value, $html);
        }	
        return $html;
    }
}
