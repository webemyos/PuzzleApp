<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Devis\Helper;

use Apps\Devis\Entity\DevisAsk;
use Apps\Devis\Entity\DevisPrestation;
use Apps\Devis\Entity\DevisPrestationCategory;
use Core\Entity\Entity\Argument;


class PrestationHelper
{
    /**
     * Obtient les applications actives
     */
    public static function GetActif($core)
    {
         $app = new DevisPrestation($core);
         return $app->GetAll();
    }
    
    /**
     * Obtient les applications actives
     */
    public static function GetByCategory($core, $category)
    { 
        //Recuperation de la categorie par son nom
        $prestationCategory = new DevisPrestationCategory($core);
        $prestationCategory = $prestationCategory->GetByCode($category);
        
         $app = new DevisPrestation($core);
         $app->AddArgument(new Argument("Apps\Devis\Entity\DevisPrestation", "CategoryId", EQUAL, $prestationCategory->IdEntite));
         
         return $app->GetByArg();
    }
    
      /**
     * Obtient les applications actives
     */
    public static function GetByCategoryId($core, $categoryId)
    { 
         $app = new DevisPrestation($core);
         $app->AddArgument(new Argument("Apps\Devis\Entity\DevisPrestation", "CategoryId", EQUAL, $categoryId));
         
         return $app->GetByArg();
    }
    
    /**
     * Retourne es catégories des applications
     * @param type $core
     */
    public static function GetCategory($core)
    {
        $category = new DevisPrestationCategory($core);
        return $category->GetAll();
    }
    
    /**
     * Retourne une app depuis son Id
     * @param type $core
     * @param type $id
     */
    public static function GetById($core, $id)
    {
         $app = new DevisPrestation($core);
         $app->GetById($id);
         
         return $app;
    }
    
    /**
     * Retourne une app depuis son nom
     * @param type $core
     * @param type $id
     */
    public static function GetByLibelle($core, $libelle)
    {
         $prestation = new DevisPrestation($core);
         $libelle = str_replace('_', ' ', $libelle);
         $prestation->AddArgument(new Argument("DevisPrestation", "Libelle", EQUAL, $libelle));
         $prestations = $prestation->GetByArg();
         
         return $prestations[0];
    }
    
     /**
     * Sauvagarde une prestation
     */
    public static function Save($core, $libelle, $description, $categoryId, $prestationId)
    {
        $prestation = new DevisPrestation($core);
        
        if($prestationId != "")
        {
            $prestation->GetById($prestationId);
        }
        
        $prestation->Libelle->Value = $libelle;
        $prestation->Description->Value = $description;
        $prestation->CategoryId->Value = $categoryId;
        $prestation->Save();   
    }
    
    /**
     * Obtient les demandes de devis par projet
     * @param type $core
     * @param type $projet
     */
    public static function GetAskByProjet($core, $projet)
    {
        $request = "SELECT ask.Id FROM DevisAsk AS ask
                    JOIN DevisPrestation AS prestation ON ask.PrestationId = prestation.Id
                    JOIN DevisPrestationCategory as category ON category.Id = prestation.CategoryId
                    WHERE category.ProjetId = ". $projet->IdEntite;
        
        $result = $core->Db->GetArray($request);    
        $asks = array(); 
       
        foreach($result as $res)
        {
            $ask = new DevisAsk($core);
            $ask->GetById($res["Id"]);
            $asks[] = $ask;
        }

        return $asks;
    }
}