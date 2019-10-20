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
    
    
    private $EntityProperty=array();
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
    
    protected $Property=array();
    protected $Argument=array();

    protected $Inserts = array();

        
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

                if( is_object($this->$Name)  && (get_class($this->$Name)=="Core\Entity\Entity\Property"
                        || get_class($this->$Name)=="LangProperty"
                        || get_class($this->$Name)=="SqlProperty"
                        || get_class($this->$Name) == "Core\Entity\Entity\UploadProperty"  ))
                {
                    
                        //Suffixe de la propriete par le nom de l'entite
                        $this->Property[]=$this->$Name;
                }
                else if(is_object($this->$Name) && get_class($this->$Name)=="Core\Entity\Entity\EntityProperty")
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
     * Get All EntityProperty
     */
    public function GetEntityProperty()
    {
        return $this->EntityProperty;
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

    /**
     * Get The first Element
     */
    function GetFirst()
    {
        $this->setLimit(0,1);
        $elements = $this->GetAll();
        return $elements[0];
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
     * Get Entity By Params
     */
    function Find($where)
    {
        //Get all entity with Limit, order and join
        return EntityManager::Find($this, $where);
    }

    /*
     * Return the Number Of Element
     */
    function GetCount()
    {
       return EntityManager::GetCount($this); 
    }
    
    /*
     * Insert Or Update the Entity
     */
    function Save()
    {
        return EntityManager::Save($this);
    }
    
    /**
     * Update property
     * filtrer by WHere entity 
     * 
     */
    function Update($property, $where ="")
    {
        return EntityManager::Update($this, $property, $where);
    }

    /*
     * Delete a entity
     */
    function Delete()
    {
        return EntityManager::Delete($this);
    }
    
    /*
     * Delete Entity Filter by Arg
     */
    function DeleteByArg()
    {
        //Get all entity with Limit, order and join
        return EntityManager::DeleteByArg($this);
    }
    
    /* Ajoute les propietés
    * de partage
    */
    function AddSharedProperty()
    {
       $this->AppName = new Property("AppName", "AppName", TEXTBOX,  false, $this->Alias); 
       $this->AppId = new Property("AppId", "AppId", NUMERICBOX,  false, $this->Alias); 
       $this->EntityName = new Property("EntityName", "EntityName", TEXTBOX,  false, $this->Alias); 
       $this->EntityId = new Property("EntityId", "EntityId", TEXTBOX,  false, $this->Alias);
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
        if(isset($this->$name))
        {
            return $this->$name;
        }
    }
    
    //Verification The Data
    public function IsValid()
    {
        //Verification de chaque propriï¿½tï¿½
        $IsValid=true;

        foreach($this->Property as $property)
        {
                if(get_class($property)=="Property" && !$property->IsValid())
                {		//echo $property->Name;
                                $IsValid=false;
                }
        }
        return $IsValid;
    }
     
    function ToArray()
	{
		$values = array();

		foreach($this->GetProperty()  as $key => $value)
		{
			$values["IdEntite"] = $this->IdEntite;
			$values[$value->Name] = $value->Value;
		}

		return $values;
    }
    
    /**
     * Ajout des élements de sauvegarde
     */
    public function Insert($insert)
    {
        $this->Inserts[] = $insert;
    }

    /**
     * Construit et lance la requete d'insertion multiple
     */
    public function Flush()
    {
        EntityManager::Flush($this);
    }

    /*
     * Set the property
     */
    public function __set($name,$value)
    {
        $this->$name=$value;
    }
}
