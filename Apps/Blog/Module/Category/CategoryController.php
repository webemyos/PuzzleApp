<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Category;

use Core\Controller\Controller;
use Apps\Blog\Entity\BlogCategory;
use Core\Block\AjaxFormBlock\AjaxFormBlock;

class CategoryController extends Controller
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
   function ShowAddCategory($blogId, $categoryId)
   {
       $jbCategory = new AjaxFormBlock($this->Core, "jbArticle");
       $jbCategory->App = "Blog";
       $jbCategory->Action = "SaveCategory";

       $jbCategory->AddArgument("blogId", $blogId);
       $jbCategory->AddArgument("CategoryId", $categoryId);

       if($categoryId != "")
       {
         $category = new BlogCategory($this->Core);
         $category->GetById($categoryId);
       }

       $jbCategory->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbCategoryName", "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($categoryId != "") ? $category->Name->Value : "") ),
                                     array("Type"=>"TextArea", "Name"=> "tbCategoryDescription", "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($categoryId != "") ? $category->Description->Value : "") ),
                                     array("Type"=>"Button", "CssClass"=>"btn btn-success" , "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbCategory->Show();
    }
}
