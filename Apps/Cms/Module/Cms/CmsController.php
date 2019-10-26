<?php



/*
 *  Webemyos.
 *  Jérôme Oliva
 *  Module de gestion des cmss
 */
namespace Apps\Cms\Module\Cms;

use Apps\Blog\Helper\CategoryHelper;
use Apps\Cms\Entity\CmsCms;
use Apps\Cms\Entity\CmsPage;
use Apps\Helper\CmsHelper;
use Apps\Helper\PageHelper;
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

 
class CmsController extends Controller
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
    * Popin de création de cms
    */
   function ShowAddCms($appName="", $entityName="", $entityId="")
   {
       $jbCms = new AjaxFormBlock($this->Core, "jbCms");
       $jbCms->App = "Cms";
       $jbCms->Action = "SaveCms";

       //App liée
       $jbCms->AddArgument("AppName", $appName);
       $jbCms->AddArgument("EntityName", $entityName);
       $jbCms->AddArgument("EntityId", $entityId);

       $jbCms->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name")),
                                     array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description")),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbCms->Show();
   }

   /**
    * Charge les cmss de l'utilisateur
    */
   function LoadMyCms()
   {
       $html ="";

       $cms = new CmsCms($this->Core);
       $cms->AddArgument(new Argument("Apps\Cms\Entity\CmsCms", "UserId", EQUAL, $this->Core->User->IdEntite));
       $cmss = $cms->GetByArg();

       if(count($cmss)> 0)
       {
           //Ligne D'entete
           $html .= "<div class='cms'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Cms.Name")."</b></div>";
           $html .= "</div>";

           foreach($cmss as $cms)
           {
              $html .= "<div class='cms'>";
             // $html .= "<div class='date'>".$cms->Name->Value."</div>";

              //Lien pour afficher le détail
              $lkDetail = new Link($cms->Name->Value, "#");
              $lkDetail->OnClick ="CmsAction.LoadCms(".$cms->IdEntite.", this)";

              $html .= "<div> ".$lkDetail->Show() ."</div>";
              $html .= "</div>";
           }
       }
       else
       {
           $html = $this->Core->GetCode("Cms.NoCms");
       }

       return $html;
   }

   /**
    * Affiche le cms
    */
   function LoadCms($cmsId)
   {
       $cms = new CmsCms($this->Core);
       $cms->GetById($cmsId);

       //Creation d'un tabstrip
       $tbCms = new TabStrip("tbCms", "Cms");

       //Ajout des onglets
       $tbCms->AddTab($this->Core->GetCode("Property"), $this->GetTabProperty($cms, $cmsId));
       $tbCms->AddTab($this->Core->GetCode("Pages"), $this->GetTabPages($cms));

       return $tbCms->Show();
   }

   /**
    * Obtient les propriétés du cms
    */
   function GetTabProperty($cms, $cmsId)
   {
       $jbCms = new AjaxFormBlock($this->Core, "jbCms");
       $jbCms->App = "Cms";
       $jbCms->Action = "UpdateCms";

       if($cms == "")
       {
          $cms  = new CmsCms($this->Core);
          $cms->GetById($cmsId);
       }

       $jbCms->AddArgument("cmsId", $cms->IdEntite);

       $jbCms->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name"), "Value" => $cms->Name->Value),
                                     array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => $cms->Description->Value),
                                     array("Type"=>"Button", "CssClass"=> "btn btn-success" , "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return new Libelle($jbCms->Show());
   }
   /**
    * Charge les onglets des pages
    * @param type $cms
    */
   function GetTabPages($cms)
   {
       $html = "<div id='lstPages'>";


       //Ajout d'page
       $btnNew = new Button(BUTTON);
       $btnNew->Value = $this->Core->GetCode("Cms.NewPage");
       $btnNew->CssClass = 'btn btn-info';
       $btnNew->OnClick = "CmsAction.ShowAddPage(".$cms->IdEntite.");";

        $html .= $btnNew->Show();


       //Recuperation des pages
       $page = new CmsPage($this->Core);
       $page->AddArgument(new Argument("Apps\Cms\Entity\CmsPage", "CmsId", EQUAL, $cms->IdEntite ));
       $page->AddOrder("Id");
       $pages = $page->GetByArg();

       if(count($pages) > 0)
       {
           //Ligne D'entete
           $html .= "<div class='cms'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Name")."</b></div>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Title")."</b></div>";

           $html .= "</div>";

           foreach($pages as $page)
           {
                $html .= "<div class='cms'>";

                $html .= "<div >".$page->Name->Value."</div>";
                $html .= "<div >".$page->Title->Value."</div>";

                //Property
                $icParametre = new ParameterIcone();
                $icParametre->Title = $this->Core->GetCode("Cms.EditPropertyPage");
                $icParametre->OnClick = "CmsAction.EditPropertyPage(".$cms->IdEntite.", ".$page->IdEntite.");";
                $html .= "<div >".$icParametre->Show()."</div>";

                //Lien pour afficher le détail
                $icEdit = new EditIcone();
                $icEdit->Title = $this->Core->GetCode("Cms.EditPage");
                $icEdit->OnClick = "CmsAction.EditPage(".$page->IdEntite.", '".Format::EscapeString($page->Title->Value)."');";
                $html .= "<div >".$icEdit->Show()."</div>";

                //Lien pour afficher les commentaires
                $icComment = new CommentIcone();
                $icComment->Title = $this->Core->GetCode("Cms.ShowComment");
                $icComment->OnClick = "CmsAction.ShowComment(".$page->IdEntite.");";
               // $html .= "<div >".$icComment->Show()."</div>";

              //$html .= "<div> ".$lkDetail->Show() ."</div>";
              $html .= "</div>";
           }
       }

       $html .= "</div>";
       return new Libelle($html);
   }

   /**
    * Affiche le cms complet
    */
   function ShowCms($name, $idEntite, $category)
   {
       //Recuperation du cms
       $cms = new CmsCms($this->Core);
       $cms->GetByName($name);

       //Definition du template
        if(Cms::InFront())
        {
           $this->SetTemplate( "Apps/Cms/Blocks/CmsBlock/ShowCms.tpl");
        }
        else
        {
           $this->SetTemplate( "../Apps/Cms/Blocks/CmsBlock/ShowCms.tpl");
        }

       //Passage des parametres à la vue
       $this->AddParameters(array(   '!currentPage' => $this->GetCurrentPage($cms, $idEntite, $category),
                                     '!description' => $cms->Description->Value,
                                     '!newsLetterBlock' => $this->GetNewLetterBlock($cms->IdEntite),
                                     '!lstPage' => $this->GetLast($cms),
                                     '!lstCategory' => $this->GetCategory($cms->IdEntite)

                                     ));

         return $this->Render();
   }

   /**
    * Affiche les trois derniers pages
    */
   function GetCurrentPage($cms, $idEntite, $category)
   {
       $html ="<div class='span12'>";

       //Module pour récuperer les images
       $pageBlock = new PageController($this->Core);

       if($category != "")
       {
           $pages = PageHelper::GetByCategoryName($this->Core, $category);

           if(count($pages) > 0 )
           {
               foreach($pages as $page)
               {
                   $html .= "<div class='page'> ";

                    //Row
                   $html .= "<div class='row'>";

                    //Image de présentation
                   $html .= "<div class='col-md-2'>".$pageBlock->GetImagePage($page->CmsId->Value, $page->IdEntite)."</div>";

                   $html .= "<div class='col-md-10'><h4>".$page->Name->Value."</h4><span class='date-cms'>".$page->DateCreated->Value."</span><p>".$page->Description->Value."</p>";
                   $lkDetail = new Link($this->Core->GetCode("Cms.ReadPage"), Format::ReplaceForUrl('Page-'.$page->Name->Value.".html") );
                   $html .= $lkDetail->Show();
                   $html .= "</div>";

                    //.Row
                   $html .= "</div>";

                   //.Page
                   $html .= "</div> ";
               }
           }
           else
           {
              $html .= $this->Core->GetCode("Cms.NoPage");
           }

         //Modification de données pour le référencement de la page
         $this->Core->Page->Masterpage->AddBlockTemplate("!Title",  str_replace("_", " ",$category) ." - Webemyos");
         $this->Core->Page->Masterpage->AddBlockTemplate("!Description", "Retrouvez tous nos pages de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
         $this->Core->Page->Masterpage->AddBlockTemplate("!KeyWord", "Pages startup, page entrepreneuriat, Pages création site internet");

         $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent",  "<h1>".str_replace("_", " ",$category)."</h1><br/>");
         $this->Core->Page->Masterpage->AddBlockTemplate("!descContent",  "<p>".$page->Category->Value->Description->Value."</p>");

       }
       else
       {
         $pages = CmsHelper::GetCurrentPage($this->Core, $cms, $idEntite);

          if($idEntite == ""  )
           {
               foreach($pages as $page)
               {

                   //Artcile
                   $html .= "<div class='page'> ";

                   //Row
                   $html .= "<div class='row'>";

                   //Image de présentation
                   $html .= "<div class='col-md-2'>".$pageBlock->GetImagePage($page->CmsId->Value, $page->IdEntite)."</div>";

                   //Extrait page
                   $html .= "<div class='col-md-10'><h4>".$page->Name->Value."</h4><span class='date-cms'>".$page->DateCreated->Value."</span><p>".$page->Description->Value."</p>";
                   $lkDetail = new Link($this->Core->GetCode("Cms.ReadPage"), Format::ReplaceForUrl('Page-'.$page->Name->Value.".html") );
                   $html .= $lkDetail->Show();
                   $html .= "</div>";

                   //.Row
                   $html .= "</div>";

                   //.Page
                   $html .= "</div> ";

               }

             $this->Core->Page->Masterpage->AddBlockTemplate("!Title",  "cms - Webemyos");
             $this->Core->Page->Masterpage->AddBlockTemplate("!description", "Retrouvez tous nos pages de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
             $this->Core->Page->Masterpage->AddBlockTemplate("!Keyword", "Pages startup, page entrepreneuriat, Pages création site internet");

             //TODO Rendre parametrable pour chaque cms
             $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent", "<h1>".$this->Core->GetCode("Cms.TitleHome")."</h1><br/>");
             $this->Core->Page->Masterpage->AddBlockTemplate("!descContent",  "<p>".$this->Core->GetCode("Cms.descriptionHome")."</p>");
           }
         else if(count($pages) == 1)
         {
            $html.= "<h1>".$pages->Name->Value."</h1>";
            $html.= "<p> ".$this->Core->GetCode("Cms.DiffusedDate")." : <b class='date blueTwo'>".$pages->DateCreated->Value."</b></p>";

            //Lorsque l'on est en front l'url des image est différentes
            $content = str_replace("../Data" , "Data", $this->FormatForClient($pages->Content->Value));

            $html.= "<div>".$content."</div>";

             //BCms de commentaire depuis Comunity
             $ecomunity = mmys::GetAppFront("Comunity", $this->Core);
             $html .= $ecomunity->GetCommentBlock("Cms", "CmsPage", $pages->IdEntite);

            //Pages similaires
            $html .= "<div class='row'><h2>".$this->Core->GetCode("Cms.SimilarePage")."</h2>";
            $html .= $this->GetSimilar($pages)."</div>";

                   //Modification de données pour le référencement de la page
             $this->Core->Page->Masterpage->AddBlockTemplate("!Title", $pages->Name->Value. " - Webemyos");
             $this->Core->Page->Masterpage->AddBlockTemplate("!description", $pages->Description->Value);
             $this->Core->Page->Masterpage->AddBlockTemplate("!keyword", $pages->KeyWork->Value);

             //Lien vers la categorie parent
             $lkCategorie = new Link("Categorie : " .$pages->Category->Value->Name->Value, Format::ReplaceForUrl("cms-Category-".$pages->Category->Value->Name->Value) .".html");
             $lkCategorie->Title = $page->Value->Categorie->Name->Value;

             //TODO Rendre parametrable pour chaque cms
             $this->Core->Page->Masterpage->AddBlockTemplate("!titleContent", $lkCategorie->Show() );
             $this->Core->Page->Masterpage->AddBlockTemplate("!descContent", "");
         }
       }

       $html.= "</div>";

       return $html;
   }

   /*
    * Obtient les trois dernier pages similaires
    */
   function GetSimilar($page)
   {
       $pages = PageHelper::GetSimilare($this->Core, $page);

       $html ="";

       //Module pour récuperer les images
       $pageBlock = new PageController($this->Core);

       foreach($pages as $page)
       {
         $html .= "<div class='col-md-4' >";

         //Image de présentation
         $html .= "<span>".$pageBlock->GetImagePage($page->CmsId->Value, $page->IdEntite)."</span>";

         $html .= "<p>".$page->Description->Value."</p>";

         $lkDetail = new Link($this->Core->GetCode("Cms.ReadPage"), Format::ReplaceForUrl('Page-'.$page->Name->Value.".html") );
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
    * obtient tou les pages
    */
   function GetLast($cms)
   {
         $pages = CmsHelper::GetLast($this->Core, $cms);

         $html = "<ul>";

         foreach($pages as $page)
         {
            $name = str_replace(" ", "_", $page->Name->Value);


            $link = new Link($page->Name->Value, Format::ReplaceForUrl("Page-".$name.".html"  ));

            $html .= "<li>".$link->Show()."</li>";
         }

         $html .= "</ul>";

         return $html;
   }

   /**
    * Block pour s'inscrire à la newLetters
    */
   function GetNewLetterBlock($cmsId)
   {
       $html = $this->Core->GetCode("Cms.InscriptionNewsLetter");


       $jbNews = new AjaxFormBlock($this->Core, "jbNew");
       $jbNews->App = "Cms";
       $jbNews->Action = "AddEmailNewLetter";

       $jbNews->AddArgument("CmsId", $cmsId);

       $jbNews->AddControls(array(
                         array("Type"=>"BsEmailBox", "Name"=> "tbEmail", "Title" => $this->Core->GetCode("Email")),
                         array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Inscription")),
             )
   );

       return $html.$jbNews->Show();
   }

   /**
    * Obtient les catégories du cms avec le nombre d'pages correspondants
    */
   public function GetCategory($cms)
   {
       $html ="";

       $categories =  CategoryHelper::GetByCms($this->Core, $cms);

       if(count($categories) > 0)
       {
           $html .= "<ul>";

           foreach($categories as $categorie)
           {
               $name = $categorie->Name->Value ." (".CategoryHelper::GetNumberPage($this->Core, $categorie->IdEntite).")";

               $link = new Link($name, "cms-Category-". Format::ReplaceForUrl($categorie->Name->Value) .".html");

               $html .= "<li>".$link->Show()."</li>";
           }

            $html .= "</ul>";
       }

       $html .="";

       return $html;
   }
}
