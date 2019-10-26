<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Article;

use Apps\Blog\Entity\BlogArticle;
use Apps\Blog\Entity\BlogComment;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Image\Image;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\View\View;

class ArticleController extends Controller
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
   function ShowAddArticle($blogId, $articleId)
   {
       $jbArticle = new AjaxFormBlock($this->Core, "jbDetailArticle");
       $jbArticle->App = "Blog";
       $jbArticle->Action = "SaveArticle";

       $jbArticle->AddArgument("blogId", $blogId);
       $jbArticle->AddArgument("articleId", $articleId);

       if($articleId != "")
       {
           $article = new BlogArticle($this->Core);
           $article->GetById($articleId);
       }

         //Image de presentation
       if($articleId == "")
       {

       $jbArticle->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbArticleName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($articleId != "") ? $article->Name->Value : ""),
                                     array("Type"=>"TextBox", "Name"=> "tbArticleKeywork", "Libelle" => $this->Core->GetCode("KeyWord"),"Value"=> ($articleId != "") ? $article->KeyWork->Value : ""),
                                     array("Type"=>"TextArea", "Name"=> "tbArticleDescription", "Libelle" => $this->Core->GetCode("Description"), "Value"=> ($articleId != "") ? $article->Description->Value : ""),
                                     array("Type"=>"EntityListBox", "Name"=> "lstCategory", "Libelle" => $this->Core->GetCode("Category"), "Entity" => "Apps\Blog\Entity\BlogCategory", "Value"=> ($articleId != "") ? $article->CategoryId->Value : "",
                                           "Argument" => (new Argument("Apps\Blog\Entity\BlogCategory", "BlogId", EQUAL, $blogId))

                                         ),

                                     array("Type"=>"CheckBox", "Name"=> "cbActif", "Libelle" => $this->Core->GetCode("Actif"), "Value"=> ($articleId != "") ? $article->Actif->Value : ""),

                                     array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass"=>"btn btn-success", "Value" => $this->Core->GetCode("Save")),
                         )
               );
       }
       else
       {
       $jbArticle->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbArticleName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($articleId != "") ? $article->Name->Value : ""),
                                     array("Type"=>"TextBox", "Name"=> "tbArticleKeywork", "Libelle" => $this->Core->GetCode("KeyWord"),"Value"=> ($articleId != "") ? $article->KeyWork->Value : ""),
                                     array("Type"=>"TextArea", "Name"=> "tbArticleDescription", "Libelle" => $this->Core->GetCode("Description"), "Value"=> ($articleId != "") ? $article->Description->Value : ""),
                                     array("Type"=>"EntityListBox", "Name"=> "lstCategory", "Libelle" => $this->Core->GetCode("Category"), "Entity" => "Apps\Blog\Entity\BlogCategory", "Value"=> ($articleId != "") ? $article->CategoryId->Value : "",
                                           "Argument" => (new Argument("Apps\Blog\Entity\BlogCategory", "BlogId", EQUAL, $article->BlodId->Value))

                                         ),

                                     array("Type"=>"CheckBox", "Name"=> "cbActif", "Libelle" => $this->Core->GetCode("Actif"), "Value"=> ($articleId != "") ? $article->Actif->Value : ""),
                                     array("Type"=>"Button", "Name"=> "BtnSave" ,  "CssClass"=>"btn btn-success", "Value" => $this->Core->GetCode("Save")),
                                     array("Type"=>"Libelle", "Value"=> "<div id='dvImageArticle'>".$this->GetImageArticle($article->BlogId->Value, $articleId)."</div>" ),
                                     array("Type"=>"Upload", "App"=> "Blog" , "IdEntite" => $articleId, "CallBack"=> "BlogAction.RefreshImageArticle()", "Action"=>"SaveImageArticle"),
                             )
               );
       }

       return $jbArticle->Show();
   }

   /**
    * Permet d'ecrire de modifier un article
    */
   function EditArticle($articleId)
   {
       //Recuperation du contenu
       $article = new BlogArticle($this->Core);
       $article->GetById($articleId);

       $jbArticle = new AjaxFormBlock($this->Core, "jbArticle");
       $jbArticle->App = "Blog";
       $jbArticle->Action = "SaveContentArticle";

       $jbArticle->AddArgument("ArticleId", $articleId);

       $jbArticle->AddControls(array(
                                     array("Type"=>"Hidden", "Name"=> "hdContentArticle" , "Value" => $articleId),
                                     array("Type"=>"TextArea", "Name"=> "tbContentArticle_".$articleId , "Value" => $article->Content->Value),
                                   //  array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbArticle->Show();
   }

  /**
   * Récupere l'image de article
   */          
  function GetImageArticle($blogId, $articleId)
  {
      $directory = "Data/Apps/Blog/".$blogId."/";
      $fileName = $directory.$articleId."_96.png";

      if(file_exists($fileName))
      {
          $img = new Image($fileName."?rnd=".rand(1, 9999));
          return $img->Show();
      }
      else
      {
          return "";
      }
  }

  /**
          * Affiche les commentaires sur un article
          * @param type $articleId
          */
          function ShowComment($articleId)
          {
              $comment = new BlogComment($this->Core);
              $comment->AddArgument(new Argument("Apps\Blog\Entity\BlogComment", "ArticleId", EQUAL, $articleId));
              $comments = $comment->GetByArg();
              
              $html = "";
              
              if(count($comments) > 0)
              {
                  foreach($comments as $comment)
                  {
                     $html .= "<div class='comment'>";
                     $html .= $comment->Message->Value;
                     
                     if($comment->Actif->Value == false)
                     {
                         $btnPublish = new Button(BUTTON);
                         $btnPublish->CssClass = "btn btn-primary";
                         $btnPublish->Value = $this->Core->GetCode("Blog.Publish");
                         $btnPublish->OnClick = "BlogAction.Publish(this, ".$comment->IdEntite.", 1)";
                         $html .= $btnPublish->Show();
                     }   
                     else
                     {
                         $btnDePublish = new Button(BUTTON);
                         $btnDePublish->CssClass = "btn btn-primary";
                         $btnDePublish->Value = $this->Core->GetCode("Blog.UnPublish");
                         $btnDePublish->OnClick = "BlogAction.Publish(this, ".$comment->IdEntite.", 0)";
                         $html .= $btnDePublish->Show();
                         
                     }
                     $html .= "</div>";
                  }
                  
                  return $html;
              }
              else
              {
                  return $this->Core->GetCode("EeBlog.NoComment");
              }
          }
}
