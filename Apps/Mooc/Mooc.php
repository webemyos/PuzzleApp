<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */
namespace Apps\Mooc;

use Apps\Mooc\Helper\CategoryHelper;
use Apps\Mooc\Helper\MoocHelper;
use Apps\Mooc\Module\Admin\AdminController;
use Apps\Mooc\Module\Mooc\MoocController;
use Apps\Mooc\Module\Search\SearchController;
use Apps\Mooc\Module\Front\FrontController;
use Core\App\Application;
use Core\Control\Image\Image;
use Core\Core\Request;
use Core\Dashboard\DashBoard;
use Core\Utility\File\File;

/**
 * Application de gestion des Cours 
 * */

class Mooc extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Mooc";

    /**
     * Constructeur
     * */
     function __construct($core)
     {
            parent::__construct($core, "Mooc");
            $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
    function Run()
    {
            $textControl = parent::Run($this->Core, "Mooc", "Mooc");
            echo $textControl;
    }

     /*
      * Show Home Page
      */
    public function Index()
    {  
         $frontConroller = new FrontController($this->Core);
         
         return $frontConroller->Index();
    } 
    
    /*
     * Charge la partie administration
     */
    public function LoadAdmin()
    {
        $adminController = new AdminController($this->Core);
        echo $adminController->Show();
    }

    /**
     * Pop in d'ajout de catégorie
     */
    function ShowAddCategory()
    {
        $categoryController = new AdminController($this->Core);
        echo $categoryController->ShowAddCategory(Request::GetPost("CategoryId"));
    }

    /**
     * Sauvegarde une catégorie
     */
    function SaveCategory()
    {
        $name = Request::GetPost("tbCategoryName");

        if($name != "")
        {
            CategoryHelper::Save($this->Core,
                                Request::GetPost("tbCategoryName"),
                                Request::GetPost("tbCategoryDescription"),
                                Request::GetPost("CategoryId")
                    );

            echo "<span class='success'>".$this->Core->GetCode("Mooc.CategorySaved")."</span>";
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("Mooc.ErrorCategory")."</span>";

            $this->ShowAddCategory();
        }
    }

    /**
     * Rafraichit les catégories
     */
    function RefreshCategory()
    {
         $categoryController = new AdminController($this->Core);
         echo $categoryController->GetTabCategory()->Show();
    }

    /*
     * Charge l'écran de proposition de Mooc
     */
    public function LoadPropose()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->LoadPropose();
    }

    /*
     * Popin d'ajout de mooc
     */
    public function ShowAddMooc()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->ShowAddMooc(Request::GetPost("MoocId"));
    }

    /*
     * Sauvegarde un mooc
     */
    public function SaveMooc()
    {
        $name = Request::GetPost("tbMoocName");

        if($name != "")
        {
            MoocHelper::SaveMooc($this->Core,
                                Request::GetPost("tbMoocName"),
                                Request::GetPost("tbMoocDescription"),
                                Request::GetPost("lstCategory"),
                                Request::GetPost("moocId")
                    );

            echo "<span class='success'>".$this->Core->GetCode("Mooc.MoocSaved")."</span>";
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("Mooc.ErrorMooc")."</span>";

            $this->ShowAddMooc();
        }
    }

    /*
     * Edite les lessons d'un Mooc
     */
    function EditMooc()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->EditMooc(Request::GetPost("moocId"));
    }

     /*
     * Popin d'ajout/Edition de lesson
     */
    public function ShowAddLesson()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->ShowAddLesson(Request::GetPost("moocId"), Request::GetPost("lessonId"));
    }

    /*
     * Sauvegarde une lesson
     */
    public function SaveLesson()
    {
        $lessonId= Request::GetPost("lessonId");
        $name = Request::GetPost("name");

        if($name != "")
        {
            MoocHelper::SaveLesson($this->Core,
                                Request::GetPost("name"),
                                Request::GetPost("video"),
                                Request::GetPost("description"),
                                Request::GetPost("content"),
                                Request::GetPost("lessonId"),
                                Request::GetPost("moocId"),
                                Request::GetPost("actif")?1:0
                    );

            echo "<span class='success'>".$this->Core->GetCode("Mooc.LessonSaved")."</span>";

            $this->ShowAddLesson();
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("Mooc.ErrorLesson")."</span>";

            $this->ShowAddLesson();
        }
    }

    /*
     * Pop in d'ajout d'element
     */
    function ShowAddElement()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->ShowAddElement(Request::GetPost("lessonId"));
    }

    /*
     * Ajoute un element à une lesson
     */
    function AddElement()
    {
        MoocHelper::AddElement($this->Core,
                               Request::GetPost("lessonId"),
                               Request::GetPost("typeElement"),
                               Request::GetPost("nameElement")
                            );

        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }

    /*
     * Rafraichit les elements
     */
    function RefreshElement()
    {
          $moocController = new MoocController($this->Core);
          echo $moocController->GetElements(Request::GetPost("lessonId"), false);
    }

    /*
     * Charge l'écran de recherche
     */
    public function LoadSearch()
    {
        $searchController = new SearchController($this->Core);
        echo $searchController->Show();
    }

    /*
     * Rechercher les mooc 
     */
    public function Search()
    {
        $searchController = new SearchController($this->Core);
        echo $searchController->Search(Request::GetPost("categoryId"));
    }

    /*
     * Lance un Mooc
     */
    public function StartMooc()
    {
        //Memorise le Mooc pour l'utilisateur
        MoocHelper::Memorise($this->Core, $this->Core->User->IdEntite, Request::GetPost("moocId"));

        $moocController = new MoocController($this->Core);
        echo $moocController->StartMooc(Request::GetPost("moocId"));
    }

    /*
     * Charge une lecon
     */
    public function LoadLesson()
    {
         $moocController = new MoocController($this->Core);
        echo $moocController->LoadLesson(Request::GetPost("lessonId"));
    }

    /**
     * Pop in d'ajout de formulaire
     */
    function ShowAddQuiz()
    {
        $moocController = new MoocController($this->Core);
        echo $moocController->ShowAddQuiz(Request::GetPost("MoocId"));
    }

     /**
     * Enregistre le nouveau formulaire
     */
    function SaveQuiz()
    {
        $libelle = Request::GetPost("tbFormLibelle");

        if($libelle != "")
        {
              MoocHelper::SaveQuiz($this->Core, $libelle, Request::GetPost("tbFormCommentaire"), Request::GetPost("MoocId") );
              echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("FieldEmpty")."</span>";
            $this->ShowAddForm();
        }
    }

    /**
     * Charge un quiz
     */
    function LoadQuiz()
    {
       $eform = DashBoard::GetApp("Form", $this->Core);
       $eform->IdEntity  = Request::GetPost("quizId");

       echo $eform->Display();
    }

    /*
     * Charge les Mooc de l'utilisateur
     */
    function LoadMyLesson()
    {
        $searchController = new SearchController($this->Core);
        echo $searchController->LoadMyLesson();
    }

    function Display()
    {
        $html = "<div id='appRunMooc'>";
        $html .= "<div id='dvLesson'>";

        $moockController = new MoocController($this->Core);
        $html .= $moockController->StartMooc(Request::Get("Id"), true);

        $html .= "</div></div>";

        return $html;
    }

   /**
     * Obtient les images du blogs
     * format niormal et mini
     */
    function GetImages()
    {
      echo MoocHelper::GetImages(Request::GetPost("moocId"));
    }

     /**
     * Sauvegare les images de presentation
     */
    function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
    {
       //Ajout de l'image dans le repertoire correspondant
       $directory = "Data/Apps/Mooc/";
       
       File::CreateDirectory("Data/Apps/Mooc");
       File::CreateDirectory($directory. $idElement);
       
        //Sauvegarde
        move_uploaded_file($tmpFileName, $directory.$idElement."/".$fileName);

        //Crée un miniature
        $image = new \Core\Utility\ImageHelper\ImageHelper();
        $image->load($directory.$idElement."/".$fileName);
        $image->fctredimimage(48, 0,$directory.$idElement."/".$fileName."_96.jpg");
    }
}
?>