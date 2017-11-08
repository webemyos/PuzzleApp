<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Modele;

use Core\Core\Request;


class Modele
{
    /*
     * Core
     */
    private $Core;
    
    /*
     * Entity
     */
    protected $Entity;
    
    /*
     * Exclude Field 
     */
    protected $Excludes = array();
    
    /*
     * State of the model
     */
    protected $State = "Init";
    
    /*
     * Constructeur
     */
    public function __construct($core = "")
    {
        $this->Core = $core;
    }
    
    /*
     * Return the Entite
     */
    public function GetEntity()
    {
       return $this->Entity;
    }
    
    /*
     * Exxclude Field
     */
    public function Exclude($excludes)
    {
       $this->Excludes = $excludes;
    }
    
    /*
     * Get Field Exclude
     */
    public function GetExcludes()
    {
        return $this->Excludes;
    }
    
    /*
     * Return the state
     */
    public function GetState()
    {
        return $this->State;
    }
    
    /*
     * Prepare
     */
    public function Prepare()
    {
    }
    
    /*
     * Event when the model has changed
     */
    public function Updated()
    {
        if(Request::IsPost())
        {
           $this->Entity->Save();
           $this->State = "Updated";
        }
    }
}
