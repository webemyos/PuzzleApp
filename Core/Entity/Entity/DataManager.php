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
 * Description of DataManager
 *
 * @author jerome
 */
class DataManager 
{
     /*
     * Load the Data in the Entity
     */
    public static function Load($entity, $data)
    {
        //Ajout de l'identifiant
        $entity->IdEntite = $data["Id"];

        //Chargement des property
        foreach($entity->GetProperty() as $propertie)
        {
            if(get_class($propertie)=="Core\Entity\Entity\Property")
            {
                $propertie->Value= Format::ReplaceString($data[$entity->Alias."_".$propertie->TableName]);
            }
            else
            if(get_class($propertie)=="LangProperty")
            {
                if(isset($data[$entity->LangAlias."_".$propertie->TableName]))
                        $propertie->Value=JFormat::ReplaceString($data[$entity->LangAlias."_".$propertie->TableName]);
            }

            else
            if(get_class($propertie)=="SqlProperty")
            {
                    $propertie->Value= $data[$entity->LangAlias."_".$propertie->Name];
            }

            if(get_class($propertie)!="SqlProperty" && ( get_class($propertie->Control) == DATEBOX))
            {
                    if($propertie->Value)
                    {
                            $date = explode("-",$propertie->Value);
                            $propertie->Value = $date[2]."/".$date[1]."/".$date[0];
                    }
            }
            if(get_class($propertie)!="SqlProperty" && get_class($propertie->Control) == DATETIMEBOX)
            {
                    //Separation heure et jour
                    $dateJour  =  explode(" ", $propertie->Value);

                    if($propertie->Value)
                    {
                            $date = explode("-",$dateJour[0]);
                            $propertie->Value = $date[2]."/".$date[1]."/".$date[0] . " ".$dateJour[1];
                    }
            }
        }
    }
    
    /*
     * Charges les données dans une liste d'entites
     */
    public static function LoadEntities($entity, $datas)
    {
        $entitys = array();
        if($datas != false)
        {
            foreach($datas as $data)
            {
                $className = get_class($entity);
                $entitie = new $className($entity->Core);

                DataManager::Load($entitie, $data);

                $entitys[] = $entitie;
            }
        }
        return $entitys;
        
    }
}
