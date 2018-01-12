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
 * Description of Request
 *
 * @author jerome
 */
class SqlRequestBuilder 
{
    //Construction de la clause select
    public static function Select($entity)
    {
        $fields ="SELECT ";

        if(sizeof($entity->PrimaryKey)>0)
        {
            $fields .=$entity->Alias.".Id" ;

            foreach($entity->PrimaryKey as $primarykey)
            {
                    if($fields == "")
                    $fields=$entity->Alias.'.'.$primarykey ;
                    else
                    $fields .=",".$entity->Alias.'.'.$primarykey ;
            }
        }
        else
        {
            $fields .=$entity->Alias.".Id" ;
        }

        //Parcours des proprietes
        foreach($entity->GetProperty() as $propertie)
        {
            if(get_class($propertie)=="Core\Entity\Entity\Property")
            {
                if($fields=="")
                        $fields .= $propertie->Alias.'.'.$propertie->TableName." as ".$entity->Alias.'_'.$propertie->TableName;
                else
                        $fields .= ",".$propertie->Alias.'.'.$propertie->TableName." as ".$entity->Alias.'_'.$propertie->TableName;
            }
            else if(get_class($propertie)=="LangProperty")
            {
                    if($fields=="")
                            $fields .= $this->LangAlias.'.'.$propertie->TableName." as ".$entity->LangAlias.'_'.$propertie->TableName;
                    else
                            $fields .= ",".$this->LangAlias.'.'.$propertie->TableName." as ".$entity->LangAlias.'_'.$propertie->TableName;
            }
            else if(get_class($propertie)=="SqlProperty")
            {
                    if($fields=="")
                            $fields .= $propertie->Request." as ".$entity->LangAlias.'_'.$propertie->Name;
                    else
                            $fields .= ",".$propertie->Request." as ".$entity->LangAlias.'_'.$propertie->Name;
            }
        }

        return $fields;
    }
    
    //Construction de la selection de la table
    public static function From($entity)
    {
        $From = " FROM " . $entity->TableName. " as ".$entity->Alias ;

        $entity->Tables = $entity->TableName;

        //Ajout des jointures
        if(sizeof($entity->Join)>0)
        {
            foreach($entity->Join as $join)
            {
                    $From .= "  ".$join->TypeJoin." join ".$join->Table;
                    $From .=" as ".$join->Alias;
                    $From .= " on  ".$join->Alias.".".$join->PrimaryKey."=".$this->Alias.".".$join->ForeignKey."  ";

                    //Ajout des argument des jointures
                    if(sizeof($join->Argument)>0)
                    {
                            foreach($join->Argument as $argument)
                            $From .=" AND ".$argument->Entity->Alias.".".$argument->Data;
                    }
            }
        }

        return $From;
    }
    
    /*
     * Create the where clause
     */
    public static function Where($entity)
    {
        $where = " WHERE 1 = 1 ";
        
        //Si on a passer des argument on construit la clause en fonction d'eux'
        if(count($entity->GetArgument() )>0)
        {
            foreach($entity->Argument as $arg)
            {
                if($arg->Value != "")
                {
                    $where .= " AND ".$arg->Data;
                }
            }
        }
        //Sinon on prend l'id
        else
        {
            //Cle primaire composï¿½e
            if(sizeof($entity->PrimaryKey)>0)
            {
                foreach($entity->PrimaryKey as $primaryKey)
                {
                    $fields = "";
                    $fields =" AND ";
                    $fields .= $entity->Alias.".".$primaryKey."=".$entity->$primaryKey->Value ;

                    $where .= $fields ;
                }
            }
            else if($entity->IdEntite != '')
            {
                $fields=" AND ";
                $fields .= $entity->Alias.".Id =".$entity->IdEntite ;
                $where .= $fields ;

                $entity->Ids = $entity->IdEntite;
                
                //var_dump($entity->Argument);
                //$entity->Argument["Id"] = $entity->IdEntite;
            }
        }
        return $where;
    }
    
   /*
    * Create the order statement
    * 
    */
    public static function CreateOrder($entity)
    {
        $orders="";
 
        //Si on a passï¿½s des orders on construit la clause en fonction d'eux'
        if(sizeof($entity->GetOrder() )>0)
        {
           
            foreach($entity->GetOrder() as $order)
            {
                if(is_object($order))
                {
                    if($orders == "")
                        $orders .= $order->TableName ;
                    else
                        $orders .=",".$order->TableName ;
                }
                else
                {
                    if($orders == "")
                        $orders .=$order ;
                    else
                        $orders .=",".$order;
                }
            }
        }

        if($orders != "")
        {
            if($entity->Asc)
                $orders .= " asc";
            else
                $orders .= " desc";

           return " ORDER BY " . $orders;
        }
        else
                return "";
    }

    /*
     * Create the limit 
     */
    public static function CreateLimit($entity)
    {
        if($entity->LimitStart !="")
          return " LIMIT ".($entity->LimitStart-1).",".$entity->LimitNumber;
    }
    
    /*
     * Create insert Request
     */
    public static function Insert($entity)
    {
        $insert = " INSERT INTO ";
        $fields="";
        $values="";

        //Parcours des proprietes
        foreach($entity->GetProperty() as $propertie)
        {
            if(get_class($propertie) != "SqlProperty" && get_class($propertie) != "LangProperty" && $propertie->TableName != "Id" && $propertie->Value !="" )
            {
                //Control de type password
                if(get_class($propertie->Control) == PASSWORD || get_class($propertie->Control) == "BsPassword")
                {
                        if($fields=="")
                        {
                                $fields .= $propertie->TableName;
                                $values .= "'".md5(Format::EscapeString($propertie->Value))."'";
                        }
                        else
                        {
                                $fields .= ",".$propertie->TableName;
                                $values .= ",'".md5(Format::EscapeString($propertie->Value))."'";
                        }
                }
                else if(get_class($propertie->Control) == DATEBOX || get_class($propertie->Control) == DATETIMEBOX)
                {
                        if($fields=="")
                        {
                                $fields .= $propertie->TableName;
                                $values .= "'".$propertie->Value."'";
                        }
                        else
                        {
                                $fields .= ",".$propertie->TableName;
                                $values .= ",'".$propertie->Value. "'";
                        }
                }
                else
                {
                    if($fields=="")
                    {
                        $fields .= $propertie->TableName;
                        $values .= "'".Format::EscapeString($propertie->Value)."'";
                    }
                    else
                    {
                        $fields .= ",".$propertie->TableName;
                        $values .= ",'".Format::EscapeString($propertie->Value)."' ";
                    }
                }
            }
        }

        $insert .= $entity->TableName." ( ".$fields." ) VALUES (".$values.")  ";

        return $insert;
    }
    
    /*
     * Update a entity
     */
    public static function Update($entity)
    {
        //Construction de la clause update
        $update = " UPDATE "; 
        $fields="";

        //Parcours des proprietes
        foreach($entity->GetProperty() as $propertie)
        {

          //  echo get_class($propertie) . " : " . get_class($propertie->Control);
            
            if(get_class($propertie) != "SqlProperty")
            {
                //Update du champ passï¿½ en parametre
                if(isset($field) &&  $field != "")
                {
                    if($propertie->TableName == $field->TableName)
                    {
                       if(get_class($propertie->Control) == PASSWORD)
                                    $fields .= $entity->Alias.".".$propertie->TableName."='".md5(Format::EscapeString($propertie->Value))."' ";
                       else
                    $fields .= $entity->Alias.".".$propertie->TableName."='".Format::EscapeString($propertie->Value)."' ";
                  }
            }
            else
            {
                    //Control de type password
                    if(get_class($propertie->Control) == PASSWORD)
                    {
                            //Mot de passe on ne fais rien
                            /*if($fields=="")
                                    $fields .= $this->Alias.".".$propertie->TableName."='".md5(JFormat::EscapeString($propertie->Value))."' ";
                            else
                                    $fields .= ",".$this->Alias.".".$propertie->TableName."='".md5(JFormat::EscapeString($propertie->Value))."' ";

                            */
                    }
                    else if(get_class($propertie->Control) == DATEBOX)
                    {
                        if($fields=="")
                            {
                                $fields .= $entity->Alias.".".$propertie->TableName."='".$propertie->Value."' ";
                            }
                            else
                            {
                                $fields .= ",".$entity->Alias.".".$propertie->TableName."='".$propertie->Value."' ";
                                
                            }
                    }
                    else if(get_class($propertie->Control) == DATETIMEBOX)
                    {
                        //Separation heure et jour
                        $dateJour  =  explode(" ", $propertie->Value);

                        if($fields=="")
                        {
                            $date = explode("/",$dateJour[0]);
                            $fields .= $entity->Alias.".".$propertie->TableName."='".$date[2]."-".$date[1]."-".$date[0]." ".$dateJour[1]."' ";
                        }
                        else
                        {
                            $date = explode("/",$dateJour[0]);
                            $fields .= ",".$entity->Alias.".".$propertie->TableName."='".$date[2]."-".$date[1]."-".$date[0]." ".$dateJour[1]."' ";
                        }
                    }
                    //Update de tous les champs
                    else if(get_class($propertie)=="Core\Entity\Entity\Property" && $propertie->Update)
                    {
                        if($fields=="")
                                $fields .= $entity->Alias.".".$propertie->TableName."='".Format::EscapeString($propertie->Value)."' ";
                        else
                                $fields .= ",".$entity->Alias.".".$propertie->TableName."='".Format::EscapeString($propertie->Value)."' ";

                            //Enregistrement des champs
                        $entity->Fields[$propertie->TableName] = $propertie->Value;
                    }
                    else if(get_class($propertie)=="LangProperty")
                    {
                        $elementlang = new $entity->LangClass($this->Core);
                        $elementlang->SaveElement($entity->Core->GetLang("code"), $entity->IdEntite, $entity->Libelle->Value, isset($entity->Description)?$entity->Description->Value:"");
                    }
                }
            }
        }
        $update .= $entity->TableName." AS ".$entity->Alias." SET ".$fields;

        $entity->Tables = $entity->TableName;

        return $update;
    }
    
    /*
     * Create delelete statement
     */
    public static function Delete($entity)
    {
        $delete ="";
        $delete .= "DELETE FROM "  .$entity->TableName ;
        
        if($entity->IdEntite != "")
        {
            $delete .= " WHERE Id =".$entity->IdEntite ;
        }
        
        return $delete;
    }
}
