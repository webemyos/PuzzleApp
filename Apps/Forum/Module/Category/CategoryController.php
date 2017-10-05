<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Category;

use Apps\Forum\Entity\ForumCategory;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Controller\Controller;


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
   function ShowAddCategory($forumId, $categoryId)
   {
       $jbCategory = new AjaxFormBlock($this->Core, "jbArticle");
       $jbCategory->App = "Forum";
       $jbCategory->Action = "SaveCategory";

       $jbCategory->AddArgument("forumId", $forumId);
       $jbCategory->AddArgument("CategoryId", $categoryId);

       if($categoryId != "")
       {
         $category = new ForumCategory($this->Core);
         $category->GetById($categoryId);
       }

       $jbCategory->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbCategoryName", "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($categoryId != "") ? $category->Name->Value : "") ),
                                     array("Type"=>"TextArea", "Name"=> "tbCategoryDescription", "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($categoryId != "") ? $category->Description->Value : "") ),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbCategory->Show();
   }
}
