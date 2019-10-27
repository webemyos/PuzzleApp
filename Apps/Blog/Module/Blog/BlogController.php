<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Blog;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Helper\ArticleHelper;
use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CategoryHelper;
use Apps\Blog\Helper\CommentHelper;
use Apps\Blog\Model\BlogModel;
use Apps\Blog\Module\Article\ArticleController;
use Apps\Blog\Module\Comment\CommentController;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\EntityGrid\EntityColumn;
use Core\Control\EntityGrid\EntityGrid;
use Core\Control\EntityGrid\EntityIconColumn;
use Core\Control\EntityGrid\EntityLinkColumn;

use Core\Control\Icone\CommentIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ParameterIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use Core\View\ElementView;
use Core\View\View;

class BlogController extends Controller
{
     /**
    * Constructeur
    */
   function __construct($core="")
   {
        $this->Core = $core;
   }

   /**
    * Popin de création de blog
    */
   function ShowAddBlog($appName, $entityName, $entityId)
   {
        $view = new View(__DIR__."/View/showAddBlog.tpl", $this->Core);
        
        //Add Message Modele
        $modele = new BlogModel($this->Core, $entityId);
                 
        // Set modele vith Ajax
        $view->SetModel($modele, true);
        $view->SetApp("Blog");
        $view->SetAction("ShowAddBlog");
        
        return $view->Render();
   }

   /**
    * Charge les blogs de l'utilisateur
    */
   function LoadMyBlog()
   {
       $view = new View(__DIR__."/View/loadMyBlog.tpl", $this->Core);
       
       $gdBlog = new EntityGrid("gdBlog", $this->Core);
       $gdBlog->Entity = "Apps\Blog\Entity\BlogBlog";
       $gdBlog->App = "Blog";
       $gdBlog->Action = "LoadMyBlog";
       
       $gdBlog->AddColumn(new EntityColumn("Name", "Name"));
       $gdBlog->AddColumn(new EntityColumn("Description", "Description"));
       $gdBlog->AddColumn(new EntityIconColumn("", 
                                                array(array("EditIcone", $this->Core->GetCode("Blog.EditTheBlog"), "BlogAction.LoadBlog"),
                                                )    
                            ));
       
       $view->AddElement($gdBlog);
       
       return $view->Render();
   }

   /**
    * Affiche le blog
    */
   function LoadBlog($blogId)
   {
       $blog = new BlogBlog($this->Core);
       $blog->GetById($blogId);

       //Creation d'un tabstrip
       $tbBlog = new TabStrip("tbBlog", "Blog");

       //Ajout des onglets
       $tbBlog->AddTab($this->Core->GetCode("Property"), $this->ShowAddBlog("","", $blogId));
       $tbBlog->AddTab($this->Core->GetCode("Category"), $this->GetTabCategory($blog));
       $tbBlog->AddTab($this->Core->GetCode("Lecteur"), $this->GetTabLecteur($blog));
       $tbBlog->AddTab($this->Core->GetCode("Articles"), $this->GetTabArticles($blog));

       return $tbBlog->Show();
   }

   /**
    * Obtient toutes les catégorie du blog
    * @param type $blog
    */
   function GetTabCategory($blog, $showAdd = true)
   {
       $view = new View(__DIR__."/View/loadCategory.tpl", $this->Core);
       
        $btnNew = new Button(BUTTON, "BtnNew");
        $btnNew->CssClass ="btn btn-info";
        $btnNew->Value = $this->Core->GetCode("Blog.NewCategory");
        $btnNew->OnClick = "BlogAction.ShowAddCategory(".$blog->IdEntite.");";

        $view->AddElement($btnNew);

        $view->AddElement(new ElementView("ShowAdd", $showAdd));
       
       $gdCategory = new EntityGrid("gdBlogCategory", $this->Core);
       $gdCategory->Entity = "Apps\Blog\Entity\BlogCategory";
       $gdCategory->AddArgument(new Argument("Apps\Blog\Entity\BlogCategory", "BlogId", EQUAL, $blog->IdEntite));
       $gdCategory->App = "Blog";
       $gdCategory->Action = "GetTabCategory";
       $gdCategory->Params = $blog->IdEntite;
       
       $gdCategory->AddColumn(new EntityColumn("Name", "Name"));
       $gdCategory->AddColumn(new EntityIconColumn("", 
                                                array(array("EditIcone", "Blog.EditCategory", "BlogAction.EditCategory"),
                                                )    
                            ));
       
       $view->AddElement($gdCategory);
       
       return $view->Render();
   }

   /**
    * Affiche les lecteurs du blog
    * @param type $blog
    */
   function GetTabLecteur($blog)
   {
       $view = new View(__DIR__."/View/loadLecteur.tpl", $this->Core);
       
       $gdLecteur = new EntityGrid("gdLecteur", $this->Core);
       $gdLecteur->Entity = "Apps\Blog\Entity\BlogUserNewLetter";
       $gdLecteur->App = "Blog";
       $gdLecteur->Action = "GetTabLecteur";
       $gdLecteur->Params = $blog->IdEntite;
      
       $gdLecteur->AddArgument(new Argument("Apps\Blog\Entity\BlogUserNewLetter", "BlogId", EQUAL, $blog->IdEntite));
   
       $gdLecteur->AddColumn(new EntityColumn("Email", "Email"));
       
       $view->AddElement($gdLecteur);
       
       return $view->Render();
   }

   /**
    * Charge les onglets des articles
    * @param type $blog
    */
   function GetTabArticles($blog, $showAdd =true)
   {
       $view = new View(__DIR__."/View/loadArticle.tpl", $this->Core);
     
       //Ajout d'article
       $btnNew = new Button(BUTTON, "BtnNew");
       $btnNew->Value = $this->Core->GetCode("Blog.NewArticle");
       $btnNew->CssClass = "btn btn-info";
       $btnNew->OnClick = "BlogAction.ShowAddArticle(".$blog->IdEntite.");";
       $view->AddElement($btnNew);
       
       $view->AddElement(new ElementView("ShowAdd", $showAdd));
       
       $gdArticle = new EntityGrid("gdArticle", $this->Core);
       $gdArticle->Entity = "Apps\Blog\Entity\BlogArticle";
       $gdArticle->App = "Blog";
       $gdArticle->Action = "GetTabArticle";
       $gdArticle->Params = $blog->IdEntite;
     
       $gdArticle->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "BlogId", EQUAL, $blog->IdEntite));
       $gdArticle->AddOrder("Id");
       
       $gdArticle->AddColumn(new EntityColumn($this->Core->GetCode("Blog.ArticleName"), "Name"));
       $gdArticle->AddColumn(new EntityColumn($this->Core->GetCode("Blog.DateCreated"), "DateCreated"));
       $gdArticle->AddColumn(new EntityLinkColumn($this->Core->GetCode("Blog.Render"), "Blog/Article"));
      
       $gdArticle->AddColumn(new EntityIconColumn("",array(
                                                           array("ParameterIcone", $this->Core->GetCode("Blog.EditParametreArticle"), "BlogAction.EditPropertyArticle", array("BlogId")),
                                                           array("EditIcone", $this->Core->GetCode("Blog.EditArticle"), "BlogAction.EditArticle", array("Code")),
                                                           array("CommentIcone", $this->Core->GetCode("Blog.ShowComment"), "BlogAction.ShowComment"))

          ));
   
       $view->AddElement($gdArticle);
       
       return $view->Render();
    }

   /**
    * Formate les donnée spour les affiché correctement pour le client
    */
   function FormatForClient($text)
   {
       $text = str_replace("!et!", "&", $text);

       return $text;
   }

}
