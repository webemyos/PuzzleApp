<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

use Core\Utility\Format\Format;

/**
 * Description of EntityManager
 *
 * @author jerome
 */
class EntityManager
{
    /*
     * Contains the Entite saved
     */    
    private $Entitys = array();
    
    /*
     * Get a Entity By this Id
     */
    public static function GetById($entity)
    {   
        //Find th entity in the storage
        $store = StorageManager::FindById($entity);
            
        if($store != null)
        {
            //Reload the Property into the Entity
            foreach($entity->GetProperty() as $propertie)
            {
                $field = $propertie->Name;
                $propertie->Value = isset($store->$field)?$store->$field->Value:"";
            }
        }
        else
        {
            //Create the Sql Request
            $request = SqlRequestBuilder::Select($entity);
            $request .= SqlRequestBuilder::From($entity);
            $request .= SqlRequestBuilder::Where($entity);

            //Get the data
            $data = $entity->Core->Db->GetLine($request);
            
            //Map the data in the Entity
            DataManager::Load($entity, $data);
            
            //Store the Entity in the Storage Manager
            StorageManager::StoreById($entity);
        }
    }
    
    /*
     * Obtain a entity By this Email
     */
    public static function GetByEmail($entity, $email)
    {
        $entity->AddArgument(new Argument(get_class($entity), "Email", EQUAL, $email));
        
        $entities = $entity->GetByArg();
        
        return count($entities) > 0 ? $entities[0] : false;
    }
    
    /*
     * Obtain a entity By this Code
     */
    public static function GetByCode($entity, $code)
    {
        $entity->AddArgument(new Argument(get_class($entity), "Code", EQUAL, $code));
        
        $entities = $entity->GetByArg();
        
        return count($entities) > 0 ? $entities[0] : false;
    }
    
    /*
     * Obtain a entity By this Email
     */
    public static function GetByName($entity, $name)
    {
        $entity->AddArgument(new Argument(get_class($entity), "Name", IN, "'".$name."','".Format::ReplaceUrl($name, false)."'"  ));
        
        $entities = $entity->GetByArg();
        
        return count($entities) > 0 ? $entities[0] : false;
    }
    
    /*
     * Get All Entity
     */
    public static function GetAll($entity)
    {
        return EntityManager::GetByArg($entity, false);
    }
    
    /*
     * Get Entity By Arg
     */
    public static function GetByArg($entity, $where = true)
    {
         $stores = StorageManager::Find($entity);
     
         if($stores != null)
         {
            return $stores;
         }
         else
         {
            $request = SqlRequestBuilder::Select($entity);
            $request .= SqlRequestBuilder::From($entity);
            
            if($where)
            {
               $request .= SqlRequestBuilder::Where($entity);
            }
            
            $request .= SqlRequestBuilder::CreateOrder($entity);
            $request .= SqlRequestBuilder::CreateLimit($entity);
                
            //Get the data
            $data = $entity->Core->Db->GetArray($request);

            //Map the data in the Entity
            $entities = DataManager::LoadEntities($entity, $data);

            //Store the Entity in the Storage Manager
            StorageManager::Store($entity, $entities);
            
            return $entities;
        }
    }
    
    /*
     * Obtient le nombre d'élement
     */
    public static function GetCount($entity)
    {
        $request = "Select Count(Id) as number";
        $request .= SqlRequestBuilder::From($entity);
            
        if($where)
        {
           $request .= SqlRequestBuilder::Where($entity);
        }
        
        $result = $entity->Core->Db->GetLine($request);
        return $result["number"];
    }
    
    /*
     * Save the Entity
     */
    public static function Save($entity)
    {
        $valide = EntityManager::IsValid($entity);
        
        if($valide === true)
        {
            if($entity->IdEntite == "")
            {
                $request = SqlRequestBuilder::Insert($entity);
                
                //Store the Entity in the Storage Manager
                StorageManager::StoreById($entity);
            }
            else
            {
                $request = SqlRequestBuilder::Update($entity);
                $request .= SqlRequestBuilder::Where($entity);
                
                $stores = StorageManager::Find($entity);
                
                //Store the Entity in the Storage Manager
                StorageManager::StoreById($stores);
            }

            $entity->Core->Db->Execute($request);
        }
        else
        {
            throw new \Exception("Property ". $valide ." not valide");
        }
    }
    
    /*
     * Delete a entity
     */
    public static function Delete($entity)
    {
        $request = SqlRequestBuilder::Delete($entity);
        $entity->Core->Db->Execute($request);
        
        //Store the Entity in the Storage Manager
        StorageManager::DeleteById($entity);
    }
    
    /*
     * Delete entities by arg
     */
    public static function DeleteByArg($entity)
    {
        $request = SqlRequestBuilder::Delete($entity);
        $request .= SqlRequestBuilder::Where($entity);
        
        $entity->Core->Db->Execute($request);
        
         //Store the Entity in the Storage Manager
        StorageManager::DeleteByArg($entity);
    }
    
    /*
     * Verify the entitty
     */
    public static function IsValid($entity)
    {
        //Verification de chaque property
        $IsValid=true;

        foreach($entity->GetProperty() as $property)
        {
            if(get_class($property)=="Core\Entity\Entity\Property" && !$property->IsValid())
            {
                return $property->Name;
            }
        }
        return $IsValid;
    }
}
