<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Banner\Module\Content;

use Apps\Banner\Entity\BannerBanner;
use Apps\Banner\Entity\BannerContent;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use Core\Control\Image\Image;

class ContentController
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
    * Popin de création de Content
    */
   function ShowAddContent($bannerId, $ContentId)
   {
       $jbContent = new AjaxFormBlock($this->Core, "jbDetailContent");
       $jbContent->App = "Banner";
       $jbContent->Action = "SaveContent";

       $jbContent->AddArgument("bannerId", $bannerId);
       $jbContent->AddArgument("ContentId", $ContentId);

       $Content = new BannerContent($this->Core);

       if($ContentId != "")
       {
           $Content->GetById($ContentId);
       }

       $jbContent->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbContentName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($ContentId != "") ? $Content->Name->Value : ""),
                                     array("Type"=>"CheckBox", "Name"=> "cbActif", "Libelle" => $this->Core->GetCode("Actif"), "Value"=> ($ContentId != "") ? $Content->Actif->Value : ""),
                                     array("Type"=>"Button", "CssClass" => "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbContent->Show();
   }

   /**
    * Permet d'ecrire de modifier un Content
    */
   function EditContent($ContentId)
   {
       //Recuperation du contenu
       $Content = new BannerContent($this->Core);
       $Content->GetById($ContentId);

       $jbContent = new AjaxFormBlock($this->Core, "jbContent");
       $jbContent->App = "Banner";
       $jbContent->Action = "SaveContentContent";

       $jbContent->AddArgument("ContentId", $ContentId);

       $jbContent->AddControls(array(
                                     array("Type"=>"Hidden", "Name"=> "hdContentContent" , "Value" => $ContentId),
                                     array("Type"=>"TextArea", "Name"=> "tbContentContent_".$ContentId , "Value" => $Content->Content->Value),
                                   //  array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbContent->Show();
   }

  /**
   * Récupere l'image de Content
   */          
  function GetImageContent($bannerId, $ContentId)
  {
      if(Banner::InFront())
      {
         $directory = "Data/Apps/Banner/".$bannerId."/";
      }
      else
      {
         $directory = "../Data/Apps/Banner/".$bannerId."/";
      }
      $fileName = $directory.$ContentId."_96.png";

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
   * Affiche les commentaires sur un Content
   * @param type $ContentId
   */
  function ShowComment($ContentId)
  {
      $eComunity = DashBoardManager::GetApp("Comunity", $this->Core);
      $comments = $eComunity->GetCommentByApp("Banner", "BannerContent", $ContentId);

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
                 $btnPublish->Value = $this->Core->GetCode("Banner.Publish");
                 $btnPublish->OnClick = "BannerAction.Publish(this, ".$comment->IdEntite.", 1)";
                 $html .= $btnPublish->Show();
             }   
             else
             {
                 $btnDePublish = new Button(BUTTON);
                 $btnDePublish->CssClass = "btn btn-primary";
                 $btnDePublish->Value = $this->Core->GetCode("Banner.UnPublish");
                 $btnDePublish->OnClick = "BannerAction.Publish(this, ".$comment->IdEntite.", 0)";
                 $html .= $btnDePublish->Show();

             }
             $html .= "</div>";
          }

          return $html;
      }
      else
      {
          return $this->Core->GetCode("Banner.NoComment");
      }
  }

  /**
   * Affiche la Content
   * @param type $banner
   * @param type $Content
   */
  function ShowContent($nameBanner, $ContentName)
  {
      //Recuperation du banner
      $banner = new BannerBanner($this->Core);
      $banner->GetByName(Format::GetReplaceForUrl($nameBanner, false));

      if($banner != null)
      {
      //Recuperation de la Content

          $Content = new BannerContent($this->Core);
          $Content->AddArgument(new Argument("BannerContent", "BannerId",EQUAL, $banner->IdEntite));
          $Content->AddArgument(new Argument("BannerContent", "Name",EQUAL, Format::GetReplaceForUrl($ContentName, false)));

          $Contents = $Content->GetByArg();

          if(count($Contents) > 0 )
          {
              $Content = $Contents[0];

              //Ajout des proriété title et description
              $this->Core->Content->MasterContent->AddBlockTemplate("!Title", $Content->Title->Value );
              $this->Core->Content->MasterContent->AddBlockTemplate("!description", $Content->Description->Value );

              //Remplacement des cactere et formatage des url
              $content = str_replace("../Data/", "Data/", $Content->Content->Value);
              $content = str_replace("!et!", "&", $content);

              return $content;
          }
      }
  }
}
