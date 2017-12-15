<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Front;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogBlog;
use Apps\Blog\Entity\BlogCategory;
use Apps\Blog\Helper\ArticleHelper;
use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CommentHelper;
use Apps\Blog\Module\Front\Model\BlogModel;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\EmailBox\EmailBox;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Core\Core;
use Core\View\CacheManager;
use Core\View\ElementView;
use Core\View\View;
use Apps\Blog\Modele\UserNewLetterModele;

/**
 * Front Controller
 *
 * @author jerome
 */
class FrontController extends Controller
{
   
    private $Blog;
    
    function __construct($core = "")
    {
        parent::__construct($core);
     
        $this->Blog = BlogHelper::GetDefault($core);
        
        $this->Model = new BlogModel($this->Core);
    }
   /*
    * Get le master modele
    */
   function GetMasterView()
   {
      $template = __DIR__."/View/master.tpl";
      $storeTemplate = CacheManager::Find($template);
      
      if($storeTemplate == null)
      {
        $view = new View(__DIR__."/View/master.tpl", $this->Core);

        //nfo blog 
        $view->AddElement(new ElementView("Blog", $this->Blog));

        //Add categorie of the blog
        $view->AddElement(new ElementView("Category", $this->Model->GetCategoryByBlog($this->Core, $this->Blog->IdEntite)));

        //Add Last Article
        $view->AddElement(new ElementView("Article", $this->Model->GetLastArticle($this->Core, $this->Blog)));
        
        //Inscription NewsLetter
        $view->AddElement(new ElementView("{{newletterBlock}}", $this->GetNewletterBlock()));
        
        CacheManager::Store($template, $view->Render());
      }
      else
      {
          $view = new View($storeTemplate);
      }
      
      return $view;
   }
   
    /*
     * Home page
     */
    public function Index()
    {
        //Information Page
        $this->Core->MasterView->Set("Title", "Blog");
        $this->Core->MasterView->Set("Description", $this->Blog->Description->Value);
        
        $masterView = $this->GetMasterView();
        
        //Page View
        $view = new View(__DIR__."/View/index.tpl", $this->Core);
        
        $view->AddElement(new ElementView("Article", BlogHelper::GetLast($this->Core, $this->Blog)));
        
        //Render the master modele white the modele
        $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $masterView->Render();
    }
    
    /*
     * Category page
     */
    public function Category($code)
    {
        $masterView = $this->GetMasterView();
        
        $view = new View(__DIR__."/View/categorie.tpl", $this->Core);
        
        $categorie = new BlogCategory(Core::getInstance());
        $categorie = $categorie->GetByCode($code);
        
        $this->Core->MasterView->Set("Title", $categorie->Name->Value );
        $this->Core->MasterView->Set("Description", $categorie->Description->Value);
        
        $view->AddElement(new ElementView("Category", $categorie));
         
        $view->AddElement(new ElementView("Article", ArticleHelper::GetByCategoryId($this->Core, $categorie->IdEntite)));
        
        $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $masterView->Render();
    }
    
     /*
     * Article page
     */
    public function Article($code)
    {
        $masterView = $this->GetMasterView();
        
        $view = new View(__DIR__."/View/article.tpl", $this->Core);
        
        $article = new BlogArticle(Core::getInstance());
        $article = $article->GetByCode($code);
        
        $this->Core->MasterView->Set("Title", $article->Name->Value );
        $this->Core->MasterView->Set("Description", $article->Description->Value);
        
        $view->AddElement(new ElementView("Article", $article));
        $view->AddElement(new ElementView("Articles", ArticleHelper::GetSimilare($this->Core,$article)));
        $view->AddElement(new ElementView("Comments", CommentHelper::GetByArticle($this->Core,$article->IdEntite, true)));
        
        $masterView->AddElement(new Text("content", false, $view->Render()));
        
        return $masterView->Render();
    }
    
    /*
     * 
     */
    public function GetNewletterBlock()
    {
        $block = new Block();
        
        $tbEmail = new EmailBox("tbEmailNews");
        $tbEmail->PlaceHolder = $this->Core->GetCode("Email");
        $block->Add($tbEmail);
        
        $btnInscription = new Button(BUTTON);
        $btnInscription->Value = $this->Core->GetCode("Inscription");
        $btnInscription->OnClick = "Blog.AddEmailNews(".$this->Blog->IdEntite.")";
        $block->AddNew($btnInscription);
        
        return $block->Show();
    }
    
    /*
     * Inscription to the newletters
     */
    public function Subscribe()
    {
        $this->Core->MasterView->Set("Title", $this->Core->GetCode("Blog.Subscribe") );
        
        $view = new View(__DIR__."/View/subscribe.tpl", $this->Core);

        //Add Message Modele
        $modele = new UserNewletterModele($this->Core);
        $view->SetModel($modele);

        return $view->Render();
    }
}
