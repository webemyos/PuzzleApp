<?php

/*
 *  Webemyos.
 *  Jérôme Oliva
 *  Module de gestion des page
 */

 namespace Apps\Cms\Module\Page;

use Apps\Cms\Entity\CmsCms;
use Apps\Cms\Entity\CmsPage;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Image\Image;
use Core\Controller\Controller;
use Core\Core\Core;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use Core\View\View;
use Core\View\ElementView;



class PageController extends Controller
{
     /**
    * Constructeur
    */
   function __construct($core="")
   {
        $this->Core = Core::getInstance();
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
    * Popin de création de page
    */
   function ShowAddPage($cmsId, $pageId)
   {
       $jbPage = new AjaxFormBlock($this->Core, "jbDetailPage");
       $jbPage->App = "Cms";
       $jbPage->Action = "SavePage";

       $jbPage->AddArgument("cmsId", $cmsId);
       $jbPage->AddArgument("pageId", $pageId);


       if($pageId != "")
       {
           $page = new CmsPage($this->Core);
           $page->GetById($pageId);
       }

         //Image de presentation
       if($pageId == "")
       {

       $jbPage->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbPageName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($pageId != "") ? $page->Name->Value : ""),
                                     array("Type"=>"TextBox", "Name"=> "tbPageTitle", "Libelle" => $this->Core->GetCode("Title"), "Value"=> ($pageId != "") ? $page->Title->Value : ""),
                                     array("Type"=>"TextArea", "Name"=> "tbPageDescription", "Libelle" => $this->Core->GetCode("Description"), "Value"=> ($pageId != "") ? $page->Description->Value : ""),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );
       }
       else
       {
            $cms = new CmsCms($this->Core);
            $cms->GetById($page->CmsId->Value);


       $jbPage->AddControls(array(
                                    array("Type"=>"TextBox", "Name"=> "tbPageName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($pageId != "") ? $page->Name->Value : ""),
                                    array("Type"=>"TextBox", "Name"=> "tbPageTitle", "Libelle" => $this->Core->GetCode("Title"), "Value"=> ($pageId != "") ? $page->Title->Value : ""),
                                    array("Type"=>"TextArea", "Name"=> "tbPageDescription", "Libelle" => $this->Core->GetCode("Description"), "Value"=> ($pageId != "") ? $page->Description->Value : ""),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                                     array("Type"=>"Link", "Libelle"=> $this->Core->GetCode("Show"), "Value"=> $this->Core->GetPath("/".$page->Code->Value)),

               ));
       }

       return $jbPage->Show();
   }

   /**
    * Permet d'ecrire de modifier un page
    */
   function EditPage($pageId)
   {
       //Recuperation du contenu
       $page = new CmsPage($this->Core);
       $page->GetById($pageId);

       $jbPage = new AjaxFormBlock($this->Core, "jbPage");
       $jbPage->App = "Cms";
       $jbPage->Action = "SaveContentPage";

       $jbPage->AddArgument("PageId", $pageId);

       $jbPage->AddControls(array(
                                     array("Type"=>"Hidden", "Name"=> "hdContentPage" , "Value" => $pageId),
                                     array("Type"=>"TextArea", "Name"=> "tbContentPage_".$pageId , "Value" => $page->Content->Value),
                                   //  array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbPage->Show();
   }

  /**
   * Récupere l'image de page
   */
  function GetImagePage($cmsId, $pageId)
  {
      
       $directory = "Data/Apps/Cms/".$cmsId."/";
      
       $fileName = $directory.$pageId."_96.png";

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
   * Affiche les commentaires sur un page
   * @param type $pageId
   */
  function ShowComment($pageId)
  {
      $eComunity = DashBoard::GetApp("Comunity", $this->Core);
      $comments = $eComunity->GetCommentByApp("Cms", "CmsPage", $pageId);

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
                 $btnPublish->Value = $this->Core->GetCode("Cms.Publish");
                 $btnPublish->OnClick = "CmsAction.Publish(this, ".$comment->IdEntite.", 1)";
                 $html .= $btnPublish->Show();
             }
             else
             {
                 $btnDePublish = new Button(BUTTON);
                 $btnDePublish->CssClass = "btn btn-primary";
                 $btnDePublish->Value = $this->Core->GetCode("Cms.UnPublish");
                 $btnDePublish->OnClick = "CmsAction.Publish(this, ".$comment->IdEntite.", 0)";
                 $html .= $btnDePublish->Show();

             }
             $html .= "</div>";
          }

          return $html;
      }
      else
      {
          return $this->Core->GetCode("Cms.NoComment");
      }
  }

  /**
   * Affiche la page
   * @param type $cms
   * @param type $page
   */
  function ShowPage($pageName)
  {
      //Recuperation du cms
      $cms = new CmsCms($this->Core);
      $cms = $cms->GetFirst();

      if($cms != null)
      {
      //Recuperation de la page
	      $page = new CmsPage($this->Core);
        
          $page = $page->GetByCode($pageName);

          if($page->IdEntite != "" )
          {
              $view = new View(__DIR__."/View/showPage.tpl", $this->Core);
	        
              //Ajout des proriété title et description
              $this->Core->MasterView->Set("Title", $page->Title->Value);
              $this->Core->MasterView->Set("Description", $page->Description->Value);

              //Remplacement des cactere et formatage des url
              $content = str_replace("../Data/", "Data/", $page->Content->Value);
              $content = str_replace("!et!", "&", $content);

	          $view->AddElement(new ElementView("content", $content));
	          $view->AddElement(new ElementView("page", $page));


	          return $view->Render();
          }
          else{

          }
      }
  }
}
