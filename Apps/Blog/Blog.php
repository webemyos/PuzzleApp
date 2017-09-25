<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog;

use Core\App\Application;
use Core\Core\Core;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Utility\ImageHelper\ImageHelper;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Helper\ArticleHelper;
use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CategoryHelper;
use Apps\Blog\Helper\CommentHelper;
use Apps\Blog\Module\Article\ArticleController;
use Apps\Blog\Module\Blog\BlogController;
use Apps\Blog\Module\Category\CategoryController;
use Apps\Blog\Module\Front\FrontController;


class Blog extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Blog";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
	 	parent::__construct($core, "Blog");
	 	$this->Core = Core::getInstance();
         }

         /*
          * Home Page Blog
          */
         function Index()
         {
             $frontController = new FrontController($this->Core);
             return $frontController->Index();
         }

         /*
          * Get The Categorie
          */
         function Category($params)
         {
             $frontController = new FrontController($this->Core);
             return $frontController->Category($params);
         }

         /*
          * Get The Categorie
          */
         function Article($params)
         {
             $frontController = new FrontController($this->Core);
             return $frontController->Article($params);
         }

	 /**
	  * Execution de l'application
	  */
	 function Run($core, $title, $name)
	 {
            $textControl = parent::Run($this->Core, "Blog", "Blog");
            echo $textControl;
	 }

        /**
         * Pop in d'ajout de blog
         */
        function ShowAddBlog()
        {
            $blogController = new BlogController($this->Core);
            echo $blogController->ShowAddBlog(Request::GetPost("AppName"), Request::GetPost("EntityName"), Request::GetPost("EntityId") );
        }

        /**
         * Enregistre un nouveau blog
         */
        function SaveBlog()
        {
            if(Request::GetPost("tbName")!= "" &&   BlogHelper::Save($this->Core,
                                                 Request::GetPost("tbName"),
                                                 Request::GetPost("tbDescription"),
                                                 Request::GetPost("AppName"),
                                                 Request::GetPost("EntityName"),
                                                 Request::GetPost("EntityId")))
            {
                echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Blog.ErrorCreate")."</span>";
                echo $this->ShowAddBlog();
            }
        }

        /**
         * Met a jour les propriété d'un blog
         */
        function UpdateBlog()
        {
           if(Request::GetPost("tbName") != "")
           {
               BlogHelper::Update($this->Core,
                                    Request::GetPost("blogId"),
                                    Request::GetPost("tbName"),
                                    Request::GetPost("tbDescription"),
                                    Request::GetPost("tbServeurFtp"),
                                    Request::GetPost("tbLogin"),
                                    Request::GetPost("tbPassWord"));

           }

           $blogController = new BlogController($this->Core);
           echo $blogController->GetTabProperty( "", Request::GetPost("blogId"))->Show();
        }

        /**
         * Charge les blogs de l'utilisateur
         */
        function LoadMyBlog()
        {
            $blogController = new BlogController($this->Core);
            echo $blogController->LoadMyBlog();
        }

        /**
         * Charge un blog
         */
        function LoadBlog($blogName = "")
        {
           $blogController = new BlogController($this->Core);

	   if($blogName != "")
	   {
	      $blog = new BlogBlog($this->Core);
	      $blog = $blog->GetByName($blogName);

	      return $blogController->LoadBlog($blog->IdEntite);
	   }
	   else
	   {
              echo $blogController->LoadBlog(Request::GetPost("blogId"));
	   }
        }

        /**
         * Charge les articles d'un blog
         */
        function LoadArticles()
        {
            $blog = new BlogBlog($this->Core);
            $blog->GetById(Request::GetPost("blogId"));

            $blogController = new BlogController($this->Core);
            echo $blogController->GetTabArticles($blog)->Show();
        }

        /**
         * Ouvre un article
         */
        function OpenArticle()
        {
            $ArticleController = new ArticleController($this->Core);
             echo "<div id='dvArticle'>".$ArticleController->EditArticle(Request::GetPost("articleId"))."</div>";
        }

        /**
         * Affiche le blog complet
         */
        function ShowBlog($name, $idEntite, $category, $addNameBlog)
        {
           $blogController = new BlogController($this->Core);
           return $blogController->ShowBlog($name, $idEntite, $category, $addNameBlog);
        }

        /**
         * Pop in d'ajout de catégorie
         */
        function ShowAddCategory()
        {
            $categoryController = new CategoryController($this->Core);
            echo $categoryController->ShowAddCategory(Request::GetPost("blogId"), Request::GetPost("CategoryId"));
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
                                    Request::GetPost("blogId"),
                                    Request::GetPost("CategoryId")
                        );

                echo "<span class='success'>".$this->Core->GetCode("Blog.CategorySaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Blog.ErrorCategory")."</span>";

                $this->ShowAddCategory();
            }
        }

        /**
         * Rafhaichit les catégories du blog
         */
        function RefreshCategory()
        {
           $blog = new BlogBlog($this->Core);
           $blog->GetById(Request::GetPost("blogId"));

           $blogController = new BlogController($this->Core);
           echo $blogController->GetTabCategory($blog)->Show();
        }

        /**
         * Pop in d'ajout d'article
         */
        function ShowAddArticle()
        {
            $ArticleController = new ArticleController($this->Core);
            echo $ArticleController->ShowAddArticle(Request::GetPost("blogId"), Request::GetPost("articleId"));
        }

        /**
         * Enregistre un article
         */
        function SaveArticle()
        {
            $name = Request::GetPost("tbArticleName");

            if($name != "")
            {
                ArticleHelper::Save($this->Core,
                                    Request::GetPost("blogId"),
                                    Request::GetPost("articleId"),
                                    Request::GetPost("tbArticleName"),
                                    Request::GetPost("tbArticleKeywork"),
                                    Request::GetPost("tbArticleDescription"),
                                    Request::GetPost("lstCategory"),
                                    Request::GetPost("cbActif")

                        );

                echo "<span class='success'>".$this->Core->GetCode("Blog.ArticleSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Blog.ErrorArticle")."</span>";

                $this->ShowAddArticle();
            }
        }

        /**
         * Charge un article
         */
        function EditArticle()
        {
             $ArticleController = new ArticleController($this->Core);
             echo $ArticleController->EditArticle(Request::GetPost("ArticleId"));
        }

        /**
         * Met à jour le contenu
         */
        function UpdateContent()
        {
            ArticleHelper::SaveContent($this->Core, Request::GetPost("ArticleId"), Request::GetPost("content"));

            echo $this->Core->GetCode("SaveOK");
        }

         /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "Data/Apps/Blog/";

					 File::CreateDirectory($directory);

           File::CreateDirectory($directory. $idElement);

           switch($action)
           {

               case "SaveImageArticle" :

                   //Recuperaion de l'article afin d'avoir le dossier du blog
                   $article = new BlogArticle($this->Core);
                   $article->GetById($idElement);
                   $folder = $article->BlogId->Value;

               //Sauvegarde
                 move_uploaded_file($tmpFileName, $directory.$folder."/".$idElement.".png");

                 //Crée un miniature
                 $image = new ImageHelper();
                 $image->load($directory.$folder."/".$idElement.".png");
                 $image->fctredimimage(96, 0,$directory.$folder."/".$idElement."_96.png");
                   break;
               default :

                 //Sauvegarde
                 move_uploaded_file($tmpFileName, $directory.$idElement."/".$fileName);

                 //renommage du fichier
                 $fileNameMini = str_replace(".png","", $fileName);
                 $fileNameMini = str_replace(".jpg","", $fileNameMini);
                 $fileNameMini = str_replace(".jpeg","", $fileNameMini);
                 $fileNameMini = str_replace(".ico","", $fileNameMini);

                 //Crée un miniature
                 $image = new ImageHelper();
                 $image->load($directory.$idElement."/".$fileName);
                 $image->fctredimimage(48, 0,$directory.$idElement."/".$fileNameMini."_96.png");
                 break;
           }

        }

        /**
         * Obtien l'image de l'article
         */
        function GetImageArticle()
        {
            $article = new BlogArticle($this->Core);
            $article->GetById(Request::GetPost("ArticleId"));

            $ArticleController = new ArticleController($this->Core);
            echo $ArticleController->GetImageArticle($article->BlogId->Value, $article->IdEntite);
        }

        /**
         * Obtient les images du blogs
         * format niormal et mini
         */
        function GetImages()
        {
            echo BlogHelper::GetImages($this->Core, Request::GetPost("BlogId"));
        }

        /**
         * Obtient les blgo lié a une App
         */
        function GetByApp($appName, $entityName, $entityId)
        {
            return BlogHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
        }

        /**
         * Affiche le blog en front office
         * @param type $name
         */
        function Display($name)
        {
            $this->ShowBlog($name);
        }

        /**
         * Ajout un Email à la newsletter du blog
         */
        function AddEmailNews()
        {
            $email = Request::GetPost("tbEmailNews");
            $blogId = Request::GetPost("BlogId");

            if($email != "")
            {
                echo "<h4>".$this->Core->GetCode("Blog.UserNewsLetterSaved")."</h4>";

                BlogHelper::SaveUserNewLetter($this->Core, $email, $blogId);
             }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Blog.ErrorUserNews")."</span>";
                $blogController = new BlogController($this->Core);

                echo $blogController->GetNewLetterBlock($blogId);
            }
        }

        /**
         * Ajoute un commentaire à un article
         */
        function AddComment()
        {
            CommentHelper::AddComment($this->Core,
                                      Request::GetPost("code"),
                                      Request::GetPost("tbComment"),
                                      Request::GetPost("tbName"),
                                      Request::GetPost("tbEmail")
                    );

            echo "<span class='success'>".$this->Core->GetCode("Blog.CommentAdded")."</span>";
        }

        /**
         * Affiche les commentaires d'un article
         */
        function ShowComment()
        {
              $ArticleController = new ArticleController($this->Core);
              echo $ArticleController->ShowComment(Request::GetPost("articleId"));
        }

        /**
         * Publie/Depublis un commentaire
         */
        function PublishComment()
        {
           CommentHelper::Publish($this->Core, Request::GetPost("commentId"), Request::GetPost("state"));
        }

        /**
         * Synchronise le blog avec le blgo distant
         */
        function Synchronise()
        {
           echo BlogHelper::Synchronise($this->Core, Request::GetPost("BlogId"));
        }
}
?>
