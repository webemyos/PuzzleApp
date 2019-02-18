<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\Devis\Module\Category;

use Apps\Devis\Entity\DevisPrestationCategory;
use Core\Block\AjaxFormBlock\AjaxFormBlock;

class CategoryController
{
     /**
    * Constructeur
    */
   function __construct($core="")
   {
         $this->Core = $core;
   }

   /**
    * Creation
    */
   function Create()
   {
   }

   /**
    * Initialisation
    */
   function Init()
   {
   }

   /**
    * Affichage du module
    */
   function Show($all=true)
   {
   }

   /**
    * Popin de création de article
    */
   function ShowAddCategory($projetId, $categoryId)
   {
       $jbCategory = new AjaxFormBlock($this->Core, "jbArticle");
       $jbCategory->App = "Devis";
       $jbCategory->Action = "SaveCategory";

       $jbCategory->AddArgument("projetId", $projetId);
       $jbCategory->AddArgument("categoryId", $categoryId);

       if($categoryId != "")
       {
         $category = new DevisPrestationCategory($this->Core);
         $category->GetById($categoryId);
       }

       $jbCategory->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbCategoryLibelle", "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($categoryId != "") ? $category->Libelle->Value : "") ),
                                     array("Type"=>"TextArea", "Name"=> "tbCategoryDescription", "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($categoryId != "") ? $category->Description->Value : "") ),
                                     array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbCategory->Show();
   }
}
