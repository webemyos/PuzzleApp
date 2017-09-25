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
use Apps\Blog\Entity\BlogCategory;
use Apps\Blog\Helper\ArticleHelper;
use Apps\Blog\Helper\BlogHelper;
use Apps\Blog\Helper\CategoryHelper;
use Apps\Blog\Helper\CommentHelper;
use Apps\Blog\Helper\UserNewsLetterHelper;
use Apps\Blog\Module\Article\ArticleController;
use Apps\Blog\Module\Comment\CommentController;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\CommentIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ParameterIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;

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
           * Popin de création de blog
           */
          function ShowAddBlog($appName, $entityName, $entityId)
          {
              $jbBlog = new AjaxFormBlock($this->Core, "jbBlog");
              $jbBlog->App = "Blog";
              $jbBlog->Action = "SaveBlog";
              
              //App liée
              $jbBlog->AddArgument("AppName", $appName);
              $jbBlog->AddArgument("EntityName", $entityName);
              $jbBlog->AddArgument("EntityId", $entityId);
                            
              $jbBlog->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name")),
                                            array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description")),
                                            array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                                )
                      );
              
              return $jbBlog->Show();
          }
          
          /**
           * Charge les blogs de l'utilisateur
           */
          function LoadMyBlog()
          {
              $html ="";
              
              $blog = new BlogBlog($this->Core); 
              $blog->AddArgument(new Argument("Apps\Blog\Entity\BlogBlog", "UserId", EQUAL, $this->Core->User->IdEntite));
              $blogs = $blog->GetByArg();
              
              if(count($blogs)> 0)
              {
                  //Ligne D'entete
                  $html .= "<div class='blog'>";
                  $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Blog.Name")."</b></div>";
                  $html .= "</div>"; 
                  
                  foreach($blogs as $blog)
                  {
                     $html .= "<div class='blog'>";
                    // $html .= "<div class='date'>".$blog->Name->Value."</div>";
                     
                     //Lien pour afficher le détail
                     $lkDetail = new Link($blog->Name->Value, "#");
                     $lkDetail->OnClick ="BlogAction.LoadBlog(".$blog->IdEntite.", this)";
                     
                     $html .= "<div> ".$lkDetail->Show() ."</div>";
                     $html .= "</div>";
                  }
              }
              else
              {
                  $html = $this->Core->GetCode("Blog.NoBlog");
              }
              
              return $html;
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
              $tbBlog->AddTab($this->Core->GetCode("Property"), $this->GetTabProperty($blog, $blogId));
              $tbBlog->AddTab($this->Core->GetCode("Category"), $this->GetTabCategory($blog));
              $tbBlog->AddTab($this->Core->GetCode("Lecteur"), $this->GetTabLecteur($blog));
              $tbBlog->AddTab($this->Core->GetCode("Articles"), $this->GetTabArticles($blog));
              
              return $tbBlog->Show();
          }
          
          /**
           * Obtient les propriétés du blog
           */
          function GetTabProperty($blog, $blogId)
          {
              $jbBlog = new AjaxFormBlock($this->Core, "jbBlog");
              $jbBlog->App = "Blog";
              $jbBlog->Action = "UpdateBlog";
              
              if($blog == "")
              {
                 $blog  = new BlogBlog($this->Core);
                 $blog->GetById($blogId);
              }
              
              $jbBlog->AddArgument("blogId", $blog->IdEntite); 
              
              $jbBlog->AddControls(array(
                                            array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name"), "Value" => $blog->Name->Value),
                                            array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => $blog->Description->Value),
                                           /* array("Type"=>"TextBox", "Name"=> "tbServeurFtp", "Libelle" => $this->Core->GetCode("ServeurFtp"), "Value" => $blog->ServeurFtp->Value),
                                            array("Type"=>"TextBox", "Name"=> "tbLogin", "Libelle" => $this->Core->GetCode("Login"), "Value" => $blog->Login->Value),
                                            array("Type"=>"TextBox", "Name"=> "tbPassWord", "Libelle" => $this->Core->GetCode("PassWord"), "Value" => $blog->PassWord->Value),*/
                  
                                            array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass"=> "btn btn-primary", "Value" => $this->Core->GetCode("Save")),
                  
                                         /*   array("Type"=>"Button", "Name"=> "BtnSynchronise" , "CssClass"=> "btn btn-success", "OnClick"=> "BlogAction.Synchronise(".$blog->IdEntite.")","Value" => $this->Core->GetCode("Synchroniser"))*/
                                )
                      );
              
              return new Libelle($jbBlog->Show());
          }
          
          /**
           * Obtient toutes les catégorie du blog
           * @param type $blog
           */
          function GetTabCategory($blog)
          {
              $html = "";
              
              //Ajout d'article
              $btnNew = new Button(BUTTON);
              $btnNew->Value = $this->Core->GetCode("Blog.NewCategory");
              $btnNew->OnClick = "BlogAction.ShowAddCategory(".$blog->IdEntite.");";
              
              $html .= $btnNew->Show();
              
              //Recuperation des articles
              $category = new BlogCategory($this->Core);
              $category->AddArgument(new Argument("Apps\Blog\Entity\BlogCategory", "BlogId", EQUAL, $blog->IdEntite ));
              $categorys = $category->GetByArg();
                   
              if(count($categorys) > 0)
              {
                  //Ligne D'entete
                  $html .= "<div class='blog'>";
                  $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Blog.Name")."</b></div>";
                
                  $html .= "</div>"; 
                  
                  foreach($categorys as $category)
                  {
                       $html .= "<div class='blog'>";
                     
                       $html .= "<div >".$category->Name->Value."</div>";
                      
                       //Lien pour afficher le détail
                       $icEdit = new EditIcone();
                       $icEdit->OnClick = "BlogAction.ShowAddCategory(".$blog->IdEntite.", '".$category->IdEntite."');";
                      
                       $html .= "<div >".$icEdit->Show()."</div>";
                     
                     //$html .= "<div> ".$lkDetail->Show() ."</div>";
                     $html .= "</div>";
                  }
              }
              
              return new Libelle($html);
          }
          
          /**
           * Affiche les lecteurs du blog
           * @param type $blog
           */
          function GetTabLecteur($blog)
          {
              $html = "";
              
              $lecteurs = UserNewsLetterHelper::GetByBlog($this->Core, $blog->IdEntite);
              
              if(count($lecteurs) > 0)
              {
                  //Entete
                  //Ligne D'entete
                  $html .= "<div class='blog'>";
                  $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Blog.Email")."</b></div>";
                  $html .= "</div>"; 
                  
                  foreach($lecteurs as $lecteur)
                  {
                    $html .= "<div class='blog'>";
                    $html .= "<div >".$lecteur->Email->Value."</div>";
                    $html .= "</div>";
                  }
              }
              else
              {
                  $html = $this->Core->GetCode("Blog.NoLecteur");
              }
              
              return new Libelle($html);
          }
          
          /**
           * Charge les onglets des articles
           * @param type $blog
           */
          function GetTabArticles($blog)
          {
              $html = "<div id='lstArticles'>";
              
              //Ajout d'article
              $btnNew = new Button(BUTTON);
              $btnNew->Value = $this->Core->GetCode("Blog.NewArticle");
              $btnNew->OnClick = "BlogAction.ShowAddArticle(".$blog->IdEntite.");";
              
              $html .= $btnNew->Show();
              
              //Recuperation des articles
              $article = new BlogArticle($this->Core);
              $article->AddArgument(new Argument("Apps\Blog\Entity\BlogArticle", "BlogId", EQUAL, $blog->IdEntite ));
              $article->AddOrder("Id");
              $articles = $article->GetByArg();
                   
              if(count($articles) > 0)
              {
                  //Ligne D'entete
                  $html .= "<div class='blog'>";
                  $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Blog.Name")."</b></div>";
                  $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Blog.Date")."</b></div>";
               
                  $html .= "</div>"; 
                  
                  foreach($articles as $article)
                  {
                       $html .= "<div class='blog'>";
                     
                       $html .= "<div >".$article->Name->Value."</div>";
                       $html .= "<div >".$article->DateCreated->Value."</div>";
                     
                       //Property 
                       $icParametre = new ParameterIcone();
                       $icParametre->Title = $this->Core->GetCode("Blog.EditArticle");
                       $icParametre->OnClick = "BlogAction.EditPropertyArticle(".$blog->IdEntite.", ".$article->IdEntite.");";
                       $html .= "<div >".$icParametre->Show()."</div>";
                      
                       //Lien pour afficher le détail
                       $icEdit = new EditIcone();
                       $icEdit->Title = $this->Core->GetCode("Blog.EditArticle");
                       $icEdit->OnClick = "BlogAction.EditArticle(".$article->IdEntite.", '".Format::EscapeString($article->Name->Value)."');";
                       $html .= "<div >".$icEdit->Show()."</div>";
                       
                       //Nombre de commentaire par article
                       
                       
                       //Lien pour afficher les commentaires
                       $icComment = new CommentIcone();
                       $icComment->Title = $this->Core->GetCode("Blog.ShowComment");
                       $icComment->OnClick = "BlogAction.ShowComment(".$article->IdEntite.");";
                       $html .= "<div >".CommentHelper::GetNumber($this->Core, $article->IdEntite) . $icComment->Show()."</div>";
                     
                     //$html .= "<div> ".$lkDetail->Show() ."</div>";
                     $html .= "</div>";
                  }
              }
              
              $html .= "</div>";
              return new Libelle($html);
          }
          
          /**
           * Affiche le blog complet
           */
          function ShowBlog($name, $idEntite, $category, $addNameBlog)
          {
           //Recuperation du blog
              $blog = new BlogBlog($this->Core);
              $blog->GetByName($name);
              
              //Definition du template
               if(Blog::InFront())
               {
                  $this->SetTemplate( "Apps/Blog/Blocks/BlogBlock/ShowBlog.tpl");
               }
               else
               {
                  $this->SetTemplate( "../Apps/Blog/Blocks/BlogBlock/ShowBlog.tpl");
               }
               
              //Passage des parametres à la vue
              $this->AddParameters(array(   '!currentArticle' => $this->GetCurrentArticle($blog, $idEntite, $category,$addNameBlog, $blog),
                                            '!description' => $blog->Description->Value,
                                            '!newsLetterBlock' => $this->GetNewLetterBlock($blog->IdEntite),         
                                            '!lstArticle' => $this->GetLast($blog, $addNameBlog, $blog),
                                            '!lstCategory' => $this->GetCategory($blog->IdEntite, $addNameBlog, $blog)    
                  
                                            ));

                return $this->Render();
          }
          
          /**
           * Affiche les trois derniers articles
           */
          function GetCurrentArticle($blog, $idEntite, $category, $addNameBlog, $blogName)
          {
              $html ="<div class='span12'>";
             
              //Module pour récuperer les images
              $articleController = new ArticleController($this->Core);
              
              if($category != "")
              {
                  $articles = ArticleHelper::GetByCategoryName($this->Core, $category);
               
                  if(count($articles) > 0 )
                  {
                      foreach($articles as $article)
                      {
                          $html .= "<div class='article'> ";
                          
                           //Row
                          $html .= "<div class='row'>";
                          
                           //Image de présentation
                          $html .= "<div class='col-md-2'>".$articleController->GetImageArticle($article->BlogId->Value, $article->IdEntite)."</div>";
                          
                          $html .= "<div class='col-md-10'><h4>".$article->Name->Value."</h4><span class='date-blog'>".$article->DateCreated->Value."</span><p>".$article->Description->Value."</p>";
                          
                          if($addNameBlog )
                          {
                            $lkDetail = new Link($this->Core->GetCode("Blog.ReadArticle"), "Blog-".$blog->Name->Value."-Article-".Format::ReplaceForUrl($article->Name->Value.".html") );
                          }
                          else
                          {
                            $lkDetail = new Link($this->Core->GetCode("Blog.ReadArticle"), Format::ReplaceForUrl('Article-'.$article->Name->Value.".html") );
                          }
                          $html .= $lkDetail->Show();
                          $html .= "</div>";

                           //.Row
                          $html .= "</div>";
                          
                          //.Article
                          $html .= "</div> ";
                      }
                  }
                  else
                  {
                     $html .= $this->Core->GetCode("Blog.NoArticle"); 
                  }
                  
                //Modification de données pour le référencement de la page
                $this->Core->Page->Masterpage->AddBlockTemplate("!Title",  str_replace("_", " ",$category) ." - Webemyos");
                $this->Core->Page->Masterpage->AddBlockTemplate("!Description", "Retrouvez tous nos articles de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
                $this->Core->Page->Masterpage->AddBlockTemplate("!KeyWord", "Articles startup, article entrepreneuriat, Articles création site internet");
              
                $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent",  "<h1>".str_replace("_", " ",$category)."</h1><br/>");
                $this->Core->Page->Masterpage->AddBlockTemplate("!descContent",  "<p>".$article->Category->Value->Description->Value."</p>");
                
              }
              else
              {
                $articles = BlogHelper::GetCurrentArticle($this->Core, $blog, $idEntite);

                 if($idEntite == ""  )
                  {
                      foreach($articles as $article)
                      {   

                          //Artcile
                          $html .= "<div class='article'> ";

                          //Row
                          $html .= "<div class='row'>";
           
                          //Image de présentation
                          $html .= "<div class='col-md-2'>".$articleController->GetImageArticle($article->BlogId->Value, $article->IdEntite)."</div>";
                          
                          //Extrait article
                          $html .= "<div class='col-md-10'><h4>".$article->Name->Value."</h4><span class='date-blog'>".$article->DateCreated->Value."</span><p>".$article->Description->Value."</p>";
                          
                          if($addNameBlog)
                         {
                            $lkDetail = new Link($article->Name->Value,"Blog-".$blog->Name->Value."-Article-".Format::ReplaceForUrl($article->Name->Value.".html"  ));
                          }
                          else
                          {
                            $lkDetail = new Link($this->Core->GetCode("Blog.ReadArticle"), Format::ReplaceForUrl('Article-'.$article->Name->Value.".html") );
                          }
                          $html .= $lkDetail->Show();
                          $html .= "</div>";

                          //.Row
                          $html .= "</div>";
                          
                          //.Article
                          $html .= "</div> ";
                          
                      }
                      
                    $this->Core->Page->Masterpage->AddBlockTemplate("!Title",  "blog - Webemyos");
                    $this->Core->Page->Masterpage->AddBlockTemplate("!description", "Retrouvez tous nos articles de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
                    $this->Core->Page->Masterpage->AddBlockTemplate("!Keyword", "Articles startup, article entrepreneuriat, Articles création site internet");
       
                    //TODO Rendre parametrable pour chaque blog
                    $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent", "<h1>".$this->Core->GetCode("Blog.TitleHome")."</h1><br/>");
                    $this->Core->Page->Masterpage->AddBlockTemplate("!descContent",  "<p>".$this->Core->GetCode("Blog.descriptionHome")."</p>");
                  }
                else if(count($articles) == 1)
                {
                   $html.= "<h1>".$articles->Name->Value."</h1>";
                   $html.= "<p> ".$this->Core->GetCode("Blog.DiffusedDate")." : <b class='date blueTwo'>".$articles->DateCreated->Value."</b></p>";

                   //Lorsque l'on est en front l'url des image est différentes
                   $content = str_replace("../Data" , "Data", $this->FormatForClient($articles->Content->Value));

                   
        
                   $html.= "<div>".$content;
                   
                     //BOUTON de partage
                  $html .= " <div>   ";
                  $html .=  "<p><i>Vous avez aimé cet article ? Alors partagez-le avec vos amis en cliquant sur les boutons ci-dessous :</i></p> ";
                  $html .=  "<div>  ";
                  $html .= "<a target='_blank' title='Facebook' href='https://www.facebook.com/sharer.php?u=".Format::ReplaceForUrl('http://webemyos.com//Article-'.$articles->Name->Value.".html")."&t=".$articles->Code->Value."' rel='nofollow' onclick='javascript:window.open(this.href, \"\", \"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;\"><img src='http://webemyos.com/Images/Icone/facebook.png' alt='Facebook' /></a>";
                  $html .= "<a target='_blank' title='Twitter' href='https://twitter.com/share?url=".Format::ReplaceForUrl('http://webemyos.com//Article-'.$articles->Name->Value.".html")."&text=".$articles->Code->Value."; ?>&via=Webemyos' rel='nofollow' onclick='javascript:window.open(this.href, \"\", \"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;\"><img src='http://webemyos.com/Images/Icone//twitter.png' alt='Twitter' /></a>";
                  $html .= "<a target='_blank' title='Google' href='https://plus.google.com/share?url=".Format::ReplaceForUrl('http://webemyos.com//Article-'.$articles->Name->Value.".html")."&hl=fr' rel='nofollow' onclick='javascript:window.open(this.href, \"\", \"menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700');return false;\"><img src='http://webemyos.com/Images/Icone/google.png' alt='Google' /></a>";
                  $html .=  " </div> " ;
                  $html .= " <div> ";
                  $html .= " </div>   ";
                  $html .= "</div>  ";
                   
                  $html .= "</div>";
                   
                  //Module d'ajout de commentaitre
                  $commentController = new CommentController($this->Core);
                  $html .= "<div class='global-block-sidebar'><div class='global-sub-block-sidebar' ><br/>" . $commentController->Load($articles->IdEntite, true)."</div></div>";
        
                  
        
                   //Articles similaires
                   $html .= "<div class='row'><h2>".$this->Core->GetCode("Blog.SimilareArticle")."</h2>";
                   
                   
                   
                   $html .= $this->GetSimilar($articles, $addNameBlog, $blogName)."</div>";
                   
                          //Modification de données pour le référencement de la page
                    $this->Core->Page->Masterpage->AddBlockTemplate("!Title", $articles->Name->Value. " - Webemyos");
                    $this->Core->Page->Masterpage->AddBlockTemplate("!description", $articles->Description->Value);
                    $this->Core->Page->Masterpage->AddBlockTemplate("!keyword", $articles->KeyWork->Value);
                     
                    //Lien vers la categorie parent
                    $lkCategorie = new Link("Categorie : " .$articles->Category->Value->Name->Value, Format::ReplaceForUrl("blog-Category-".$articles->Category->Value->Name->Value) .".html");
                    $lkCategorie->Title = $article->Value->Categorie->Name->Value;
                            
                    //TODO Rendre parametrable pour chaque blog
                    $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent", $lkCategorie->Show() );
                    $this->Core->Page->Masterpage->AddBlockTemplate("!descContent", "");
                }
              }
              
              $html.= "</div>";
              
              return $html;
          }
          
          /*
           * Obtient les trois dernier articles similaires
           */
          function GetSimilar($article, $addNameBlog, $blog)
          {
              $articles = ArticleHelper::GetSimilare($this->Core, $article);
              
              $html ="";
              
              //Module pour récuperer les images
              $articleController = new ArticleController($this->Core);
              
              foreach($articles as $article)
              {
                $html .= "<div class='col-md-4' >";
                          
                //Image de présentation
                $html .= "<span>".$articleController->GetImageArticle($article->BlogId->Value, $article->IdEntite)."</span>";

                $html .= "<p>".$article->Description->Value."</p>";

                 if($addNameBlog)
                         {
                            $lkDetail = new Link($article->Name->Value,"Blog-".$blog->Name->Value."-Article-".Format::ReplaceForUrl($article->Name->Value.".html"  ));
                          }
                          else
                          {
                $lkDetail = new Link($this->Core->GetCode("Blog.ReadArticle"), Format::ReplaceForUrl('Article-'.$article->Name->Value.".html") );
                          }
                
                
                $html .= $lkDetail->Show();
                
                $html .= "</div>";
              }
              
              return $html;
          }
          
          /**
           * Formate les donnée spour les affiché correctement pour le client
           */
          function FormatForClient($text)
          {
              $text = str_replace("!et!", "&", $text);
              
              
              return $text;
          }
          
          /**
           * obtient tou les articles
           */
          function GetLast($blog, $addNameBlog, $blogName)
          {
                $articles = BlogHelper::GetLast($this->Core, $blog);
                
                $html = "<ul>";
                
                foreach($articles as $article)
                {
                   $name = str_replace(" ", "_", $article->Name->Value);
                   
                   if($addNameBlog)
                   {
                    $link = new Link($article->Name->Value,"Blog-".$blog->Name->Value."-Article-".Format::ReplaceForUrl($name.".html"  ));
                       
                   }
                   else
                   {
                    $link = new Link($article->Name->Value, Format::ReplaceForUrl("Article-".$name.".html"  ));
                   }
                   
                   $html .= "<li>".$link->Show()."</li>"; 
                }
                
                $html .= "</ul>";
                
                return $html;
          }
          
          /**
           * Block pour s'inscrire à la newLetters
           */
          function GetNewLetterBlock($blogId)
          {
              $html = $this->Core->GetCode("Blog.InscriptionNewsLetter");
              
              
              $jbNews = new AjaxFormBlock($this->Core, "jbNew");
              $jbNews->App = "Blog";
              $jbNews->Action = "AddEmailNewLetter";

              $jbNews->AddArgument("BlogId", $blogId);
              
              $jbNews->AddControls(array(
                                array("Type"=>"BsEmailBox", "Name"=> "tbEmail", "Title" => $this->Core->GetCode("Email")),
                                array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Inscription")),
                    )
          );
              
              return $html.$jbNews->Show();
          }
          
          /**
           * Obtient les catégories du blog avec le nombre d'articles correspondants
           */
          public function GetCategory($blogId, $addNameBlog, $blog)
          {
              $html ="";
              
              $categories =  CategoryHelper::GetByBlog($this->Core, $blogId);
              
              if(count($categories) > 0)
              {
                  $html .= "<ul>";
                  
                  foreach($categories as $categorie)
                  {
                      $name = $categorie->Name->Value ." (".CategoryHelper::GetNumberArticle($this->Core, $categorie->IdEntite).")";
            
                      if($addNameBlog)
                      {
                          $link = new Link($name, "Blog-".$blog->Name->Value."-Category-". Format::ReplaceForUrl($categorie->Name->Value) .".html");
                      }
                      else
                      {
                          $link = new Link($name, "blog-Category-". Format::ReplaceForUrl($categorie->Name->Value) .".html");
                      }
                      
                      $html .= "<li>".$link->Show()."</li>";
                  }
                  
                   $html .= "</ul>";
              }
              
              $html .="";
              
              return $html;
          }
          
}
