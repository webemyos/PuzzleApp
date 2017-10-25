<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Admin;

use Apps\Mooc\Entity\MoocCategory;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\Control\Icone\EditIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;


 class AdminController extends Controller
 {
    /**
     * Constructeur
     */
    function __constructeur($core="")
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
          $tabAdmin = new TabStrip("tabAdmin", "Mooc");
          $tabAdmin->AddTab($this->Core->GetCode("Mooc.Category"), $this->GetTabCategory());

          return $tabAdmin->Show();
    }

    /**
     * Obtient les catégories disponible pour les Mooc
     */
    function GetTabCategory()
    {
        $html = "";

        //Ajout d'article
        $btnNew = new Button(BUTTON);
        $btnNew->Value = $this->Core->GetCode("Mooc.NewCategory");
        $btnNew->CssClass = "btn btn-info";
        $btnNew->OnClick = "MoocAction.ShowAddCategory();";

        $html .= $btnNew->Show();

        //Recuperation des articles
        $category = new MoocCategory($this->Core);
        $categorys = $category->GetAll();

        if(count($categorys) > 0)
        {
            //Ligne D'entete
            $html .= "<div class='mooc'>";
            $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Mooc.Name")."</b></div>";

            $html .= "</div>"; 

            foreach($categorys as $category)
            {
                 $html .= "<div class='mooc'>";

                 $html .= "<div >".$category->Name->Value."</div>";

                 //Lien pour afficher le détail
                 $icEdit = new EditIcone();
                 $icEdit->OnClick = "MoocAction.ShowAddCategory('".$category->IdEntite."');";

                 $html .= "<div >".$icEdit->Show()."</div>";
               $html .= "</div>";
            }
        }

        return new Libelle($html);
    }

     /**
     * Popin de création de article
     */
    function ShowAddCategory($categoryId)
    {
        $jbCategory = new AjaxFormBlock($this->Core, "jbArticle");
        $jbCategory->App = "Mooc";
        $jbCategory->Action = "SaveCategory";

        $jbCategory->AddArgument("CategoryId", $categoryId);

        if($categoryId != "")
        {
          $category = new MoocCategory($this->Core);
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

    /*action*/
 }?>