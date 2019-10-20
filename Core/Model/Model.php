<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Model;

use Core\Core\Request;
use Core\Entity\Entity\Argument;


class Model
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
    
    /***
     * Element Type hidden
     */
    protected $Elements = Array();


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
    
    /**
     * Add Element
     */
    public function AddElement($key, $value)
    {
        $this->Elements[$key] = $value;
    }

    /**
     * Return the element
     */
    public function GetElements()
    {
        return $this->Elements;
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

           //Sauvegarde des ListProperty
           //Entité liées par une table intérmédiaire
           foreach($_POST as $key => $value)
           {
               if(strpos($key, "linked_") !== false)
               {
                    $data = json_decode($value);
                    $key = explode(",",$data->key);
                    $primary = $key[0];
                    $second = $key[1];

                    //On recherche si il existe
                    $entityClass = new $data->entity( $this->Entity->Core);
                    $entityClass->AddArgument(new Argument($data->entity,  $primary, EQUAL, $this->Entity->IdEntite));
                    $entityClass->AddArgument(new Argument($data->entity,  $second, EQUAL, $data->id));
                    $entites = $entityClass->GetByArg();
                    
                    if(count($entites) > 0)
                    {
                        $entity = $entites[0];
                    }else
                    {
                        $entity = null;
                    }

                    //On sauvegarde 
                    if($data->checked == 1 && $entity == null)
                    {
                        $entityClass = $data->entity;
                        $linked = new $entityClass( $this->Entity->Core);
                        $linked->$primary->Value = $this->Entity->IdEntite;
                        $linked->$second->Value = $data->id;
                        $linked->Save();
                    }
                    //On supprime
                    else if($data->checked == 0 && $entity != null)
                    {
                        $entity->Delete();
                    }
               }
           }
        }
    }
}
