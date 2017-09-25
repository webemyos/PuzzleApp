<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

/**
 * Description of Entity
 *
 * @author jerome
 */
class Entity 
{
    private $Core;
    public  $IdEntite;
    private $Table;
    private $TableName;
    
    protected $Property=array();
    private $EntityProperty=array();
    private $Argument=array();
    private $Order=array();
    private $Join=array();
    private $PrimaryKey = array();
    private $Alias;
    private $LangAlias;
    private $LangClass;
    private $CascadeDelete =array();
    
    //limite
    private $LimitStart;
    private $LimitNumber;
    private $Asc;
        
    function __construct($core)
    {
        $this->Core = $core;
    }
    
    /*
    * Construction de l'entite
    * */
    function Create()
    {
        //Insertion des proprietes dans un tableau
        //Creation d'un objet reflection afin de recuperer toutes les proprietes
        $Reflection = new \ReflectionObject($this);
        $Properties=$Reflection->getProperties();
        
        //Parcourt des propriete afin de les inserer dans le tableau Properties
        foreach($Properties as $Propertie)
        {
                //Recuperation du nom de la propriï¿½te
                $Name=$Propertie->getName();

                if( is_object($this->$Name)   && (get_class($this->$Name)=="Core\Entity\Entity\Property"
                        || get_class($this->$Name)=="LangProperty"
                        || get_class($this->$Name)=="SqlProperty") )
                {
                    
                        //Suffixe de la propriete par le nom de l'entite
                        $this->Property[]=$this->$Name;
                }
                else if(is_object($this->$Name) && get_class($this->$Name)=="EntityProperty")
                {
                        $this->EntityProperty[]=$this->$Name;
                }
        }
    }

    /*
     * Get all Property
     */
    public function GetProperty()
    {
       return $this->Property;
    }

    /*
    * Ajout d'un argument
    * @param $arg Argument
    * */
    function AddArgument($arg)
    {
        $this->Argument[]=$arg;
    }
    
     /*
     * Get all Argument
     */
    public function GetArgument()
    {
       return $this->Argument;
    }
    
    /*
    * Ajout d'un ordre de tri
    * @param $order Ordre
    * */
   function AddOrder($order)
   {
        $this->Order[]=$order;
   }
   
   /*
    * Obtient les tris
    */
   function GetOrder()
   {
       return $this->Order;
   }
   
   /*
    * Definit les nombres et les limites
    * D'entitï¿½es a rï¿½cuperer
    * @param $start Debut
    * @param $number nombre d'ï¿½lement
    * */
   function SetLimit($start,$number)
   {
       $this->LimitStart = $start;
       $this->LimitNumber = $number;
   }
    
    /*
     * Get this by Id
     */
    function GetById($id)
    {
       $this->IdEntite = $id;
        
       //Get The Entity by this Id
       EntityManager::GetById($this);
    }
    
    /*
     * Get this by Email
     */
    function GetByEmail($email)
    {
       $this->Email = $email;
        
       //Get The Entity by this Id
       return EntityManager::GetByEmail($this, $email);
    }
    
     /*
     * Get this by Name
     */
    function GetByName($name)
    {
       $this->Name = $name;
        
       //Get The Entity by this Id
       return EntityManager::GetByName($this, $name);
    }
    
       /*
     * Get this by Code
     */
    function GetByCode($code)
    {
       $this->Code = $code;
        
       //Get The Entity by this Id
       return EntityManager::GetByCode($this, $code);
    }
    /*
     * Get All Entity
     */
    function GetAll()
    {
        //Get all entity with Limit, order and join
        return  EntityManager::GetAll($this);
    }
    
    /*
     * Get Entity Filter by Atg
     */
    function GetByArg()
    {
        //Get all entity with Limit, order and join
        return EntityManager::GetByArg($this);
    }
    
    /*
     * Insert Or Update the Entity
     */
    function Save()
    {
        return EntityManager::Save($this);
    }
    
    /*
     * Delete a entity
     */
    function Delete()
    {
        return EntityManager::Delete($this);
    }
    
    /* Ajoute les propietés
    * de partage
    */
    function AddSharedProperty()
    {
       $this->AppName = new Property("AppName", "AppName", TEXTBOX,  false, $this->Alias); 
       $this->AppId = new Property("AppId", "AppId", NUMERICBOX,  false, $this->Alias); 
       $this->EntityName = new Property("EntityName", "EntityName", TEXTBOX,  false, $this->Alias); 
       $this->EntityId = new Property("EntityId", "EntityId", NUMERICBOX,  false, $this->Alias); 
    }
        
    /*
     * Get the entity or EntityProperty
     */
    public function __get($name)
    {
        if(isset($this->$name) && is_object($this->$name) && get_class($this->$name) == "Core\Entity\Entity\EntityProperty")
        {
            $entityPropertie = $this->$name;
        
            $entite= new $entityPropertie->Entity($this->Core);
            $Field= $entityPropertie->EntityField ;
            $entite->GetById($this->$Field->Value);
            $entityPropertie->Value=$entite;
        }
        
        return $this->$name;
    }
    
    /*
     * Set the property
     */
    public function __set($name,$value)
    {
        $this->$name=$value;
    }
}