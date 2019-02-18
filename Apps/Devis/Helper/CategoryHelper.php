<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Devis\Helper;

use Apps\Devis\Entity\DevisPrestation;
use Apps\Devis\Entity\DevisPrestationCategory;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;

class CategoryHelper
{   
    /**
     * Sauvagarde une catégorie
     */
    public static function Save($core, $libelle, $description, $projetId, $categoryId)
    {
        $category = new DevisPrestationCategory($core);
        
        if($categoryId != "")
        {
            $category->GetById($categoryId);
        }
        
        $category->Libelle->Value = $libelle;
        $category->Code->Value = Format::ReplaceForUrl($category->Libelle->Value);
        $category->Description->Value = $description;
        $category->ProjetId->Value = $projetId;
        $category->Save();   
    }
   
    /*
     * Supprime une catégorie
     */
    public static function Delete($core, $categoryId)
    {
        //Verificatipn si il n'y a pas des prestation lié
        $prestation = new DevisPrestation($core);
        $prestation->AddArgument(new Argument("DevisPrestation", "CategoryId", EQUAL, $categoryId));
        
        if(count($prestation->GetByArg()) == 0 )
        {
           //Suppression de la categorie
           $categorie = new DevisPrestationCategory($core);
           $categorie->GetById($categoryId);
           $categorie->Delete();
           
           return true;
        }
        else
        {
            return false;
        }
    }
    
    /*
     * Get The category ofthe projet
     */
    public static function GetByProjet($core, $projet)
    {
        $category = new DevisPrestationCategory($core);
        $category->AddArgument("Apps\Devis\Entity\DevisPrestationCategory", "ProjetId", EQUAL, $projet->IdEntite );
        
        return $category->GetByArg();
    }
 }


?>
