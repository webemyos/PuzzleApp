<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\Entity;

/**
 * Description of StorageManager
 *
 * @author jerome
 */
class StorageManager
{
    static $entities = array();

    /*
     * Find a entity
     */
    public static function FindById($entity)
    {
        if(isset(StorageManager::$entities[$entity->Alias]) == true )
        {
            if(isset(StorageManager::$entities[$entity->Alias][$entity->IdEntite]))
            {
              return StorageManager::$entities[$entity->Alias][$entity->IdEntite];
            }
        }

        return null;
    }

    /*
     * Find à list of Entity
     * Filtrer by where,Limit
     */
    public static function Find($entity)
    {
        $key = StorageManager::GetKey($entity);

        if(isset(StorageManager::$entities[$entity->Alias]))
        {
            if(isset(StorageManager::$entities[$entity->Alias][$key]) == true )
            {
                return StorageManager::$entities[$entity->Alias][$key];
            }
        }
        return null;
    }

    /*
     * Store the list of entities
     */
    public static function Store($entity, $entities)
    {
          $key = StorageManager::GetKey($entity);

           if(!isset(StorageManager::$entities[$entity->Alias]))
           {
               StorageManager::$entities[$entity->Alias] = array();
           }

           StorageManager::$entities[$entity->Alias][$key] = $entities;
    }

    /*
     * Obtai te key for the resquest
     */
    public static function GetKey($entity)
    {
         $key = $entity->Alias;

        if(count($entity->GetArgument() )>0)
        {
            foreach($entity->Argument as $arg)
            {
                if($arg->Value != "")
                {
                    $key .= " AND ".$arg->Data;
                }
            }
        }

        if(count($entity->GetOrder() )>0)
        {
           foreach($entity->GetOrder() as $order)
            {
                if(is_object($order))
                {
                    if($key == "")
                        $key .= $order->TableName ;
                    else
                        $key .=",".$order->TableName ;
                }
                else
                {
                    if($key == "")
                        $key .=$order ;
                    else
                        $key .=",".$order;
                }
            }
        }

        if($entity->LimitStart !="")
          $key .= " LIMIT ".($entity->LimitStart-1).",".$entity->LimitNumber;

        return $key;
    }

    /*
     * Restore a entite
     */
    public static function StoreById($entity)
    {
        if(!isset(StorageManager::$entities[$entity->Alias]))
        {
            StorageManager::$entities[$entity->Alias] = array();
        }

        StorageManager::$entities[$entity->Alias][$entity->IdEntite] = $entity;
    }

    /*
     * Delete a entity into the store
     */
    public static function DeleteById($entity)
    {
        //When the precedent is GetById
        if(isset(StorageManager::$entities[$entity->Alias]))
        {
            unset(StorageManager::$entities[$entity->Alias][$entity->IdEntite]);
        }

        //When the precedent request is getByArg
        $stores = StorageManager::Find($entity);

        if(count($store) > 0 )
        {
            foreach($stores as $store)
            {
                if(isset($store::$entities))
                {
                unset($store::$entities[$entity->Alias][$entity->IdEntite]);
                }
            }
        }
    }
    
    /*
     * Remove the entity by arg
     */
    public static function DeleteByArg($entity)
    {
        //When the precedent request is getByArg
        $stores = StorageManager::Find($entity);

        foreach($stores as $store)
        {
            unset($store::$entities[$entity->Alias][$entity->IdEntite]);
        }
    }
        
}
