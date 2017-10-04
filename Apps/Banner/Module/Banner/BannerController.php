<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Banner\Module\Banner;

use Apps\Banner\Entity\BannerBanner;
use Apps\Banner\Entity\BannerContent;
use Apps\Banner\Helper\BannerHelper;
use Apps\Banner\Helper\ContentHelper;
use Apps\Downloader\Helper\CategoryHelper;
use Apps\Banner\Module\Content\ContentController;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\CommentIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ParameterIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use const BUTTON;
use const EQUAL;


class BannerController extends Controller
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
        * Popin de création de banner
        */
       function ShowAddBanner($appName, $entityName, $entityId)
       {
           $jbBanner = new AjaxFormBlock($this->Core, "jbBanner");
           $jbBanner->App = "Banner";
           $jbBanner->Action = "SaveBanner";

           //App liée
           $jbBanner->AddArgument("AppName", $appName);
           $jbBanner->AddArgument("EntityName", $entityName);
           $jbBanner->AddArgument("EntityId", $entityId);

           $jbBanner->AddControls(array(
                                         array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name")),
                                         array("Type"=>"Button", "Name"=> "BtnSave", "CssClass"=> "btn btn-primary", "Value" => $this->Core->GetCode("Save")),
                             )
                   );

           return $jbBanner->Show();
       }

       /**
        * Charge les banners de l'utilisateur
        */
       function LoadMyBanner()
       {
           $html ="";

           $banner = new BannerBanner($this->Core); 
           $banner->AddArgument(new Argument("BannerBanner", "UserId", EQUAL, $this->Core->User->IdEntite));
           $banners = $banner->GetByArg();

           if(count($banners)> 0)
           {
               //Ligne D'entete
               $html .= "<div class='banner'>";
               $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Banner.Name")."</b></div>";
               $html .= "</div>"; 

               foreach($banners as $banner)
               {
                  $html .= "<div class='banner'>";
                 // $html .= "<div class='date'>".$banner->Name->Value."</div>";

                  //Lien pour afficher le détail
                  $lkDetail = new Link($banner->Name->Value, "#");
                  $lkDetail->OnClick ="BannerAction.LoadBanner(".$banner->IdEntite.", this)";

                  $html .= "<div> ".$lkDetail->Show() ."</div>";
                  $html .= "</div>";
               }
           }
           else
           {
               $html = $this->Core->GetCode("Banner.NoBanner");
           }

           return $html;
       }

       /**
        * Affiche le banner
        */
       function LoadBanner($bannerId)
       {
           $banner = new BannerBanner($this->Core);
           $banner->GetById($bannerId);

           //Creation d'un tabstrip
           $tbBanner = new TabStrip("tbBanner", "Banner");

           //Ajout des onglets
           $tbBanner->AddTab($this->Core->GetCode("Property"), $this->GetTabProperty($banner, $bannerId));
           $tbBanner->AddTab($this->Core->GetCode("Content"), $this->GetTabContent($banner));

           return $tbBanner->Show();
       }

       /**
        * Obtient les propriétés du banner
        */
       function GetTabProperty($banner, $bannerId)
       {
           $jbBanner = new AjaxFormBlock($this->Core, "jbBanner");
           $jbBanner->App = "Banner";
           $jbBanner->Action = "UpdateBanner";

           if($banner == "")
           {
              $banner  = new BannerBanner($this->Core);
              $banner->GetById($bannerId);
           }

           $jbBanner->AddArgument("bannerId", $banner->IdEntite); 

           $jbBanner->AddControls(array(
                                         array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name"), "Value" => $banner->Name->Value),
                                         array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary",  "Value" => $this->Core->GetCode("Save")),
                             )
                   );

           return new Libelle($jbBanner->Show());
       }
       /**
        * Charge les onglets des contents
        * @param type $banner
        */
       function GetTabContent($banner)
       {
           $html = "<div id='lstContents'>";

           //Ajout d'content
           $btnNew = new Button(BUTTON);
           $btnNew->Value = $this->Core->GetCode("Banner.NewContent");
           $btnNew->OnClick = "BannerAction.ShowAddContent(".$banner->IdEntite.");";

           $html .= $btnNew->Show();

           //Recuperation des contents
           $content = new BannerContent($this->Core);
           $content->AddArgument(new Argument("BannerContent", "BannerId", EQUAL, $banner->IdEntite ));
           $content->AddOrder("Id");
           $contents = $content->GetByArg();

           if(count($contents) > 0)
           {
               //Ligne D'entete
               $html .= "<div class='banner'>";
               $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Banner.Name")."</b></div>";

               $html .= "</div>"; 

               foreach($contents as $content)
               {
                    $html .= "<div class='banner'>";

                    $html .= "<div >".$content->Name->Value."</div>";

                    //Property 
                    $icParametre = new ParameterIcone();
                    $icParametre->Title = $this->Core->GetCode("Banner.EditContent");
                    $icParametre->OnClick = "BannerAction.EditPropertyContent(".$banner->IdEntite.", ".$content->IdEntite.", '".$content->Name->Value."');";
                    $html .= "<div >".$icParametre->Show()."</div>";

                    //Lien pour afficher le détail
                    $icEdit = new EditIcone();
                    $icEdit->Title = $this->Core->GetCode("Banner.EditContent");
                    $icEdit->OnClick = "BannerAction.EditContent(".$content->IdEntite.", '".$content->Name->Value."');";
                    $html .= "<div >".$icEdit->Show()."</div>";

                    //Lien pour afficher les commentaires
                    $icComment = new CommentIcone();
                    $icComment->Title = $this->Core->GetCode("Banner.ShowComment");
                    $icComment->OnClick = "BannerAction.ShowComment(".$content->IdEntite.");";
                   // $html .= "<div >".$icComment->Show()."</div>";

                  //$html .= "<div> ".$lkDetail->Show() ."</div>";
                  $html .= "</div>";
               }
           }

           $html .= "</div>";
           return new Libelle($html);
       }

       /**
        * Affiche le banner complet
        */
       function ShowBanner($name, $idEntite, $category)
       {
           //Recuperation du banner
           $banner = new BannerBanner($this->Core);
           $banner->GetByName($name);

           //Definition du template
            if(Banner::InFront())
            {
               $this->SetTemplate( "Apps/Banner/Blocks/BannerBlock/ShowBanner.tpl");
            }
            else
            {
               $this->SetTemplate( "../Apps/Banner/Blocks/BannerBlock/ShowBanner.tpl");
            }

           //Passage des parametres à la vue
           $this->AddParameters(array(   '!currentContent' => $this->GetCurrentContent($banner, $idEntite, $category),
                                         '!description' => $banner->Description->Value,
                                         '!newsLetterBlock' => $this->GetNewLetterBlock($banner->IdEntite),         
                                         '!lstContent' => $this->GetLast($banner),
                                         '!lstCategory' => $this->GetCategory($banner->IdEntite)    

                                         ));

             return $this->Render();
       }

       /**
        * Affiche les trois derniers contents
        */
       function GetCurrentContent($banner, $idEntite, $category)
       {
           $html ="<div class='span12'>";

           //Module pour récuperer les images
           $contentController = new ContentController($this->Core);

           if($category != "")
           {
               $contents = ContentHelper::GetByCategoryName($this->Core, $category);

               if(count($contents) > 0 )
               {
                   foreach($contents as $content)
                   {
                       $html .= "<div class='content'> ";

                        //Row
                       $html .= "<div class='row'>";

                        //Image de présentation
                       $html .= "<div class='col-md-2'>".$contentController->GetImageContent($content->BannerId->Value, $content->IdEntite)."</div>";

                       $html .= "<div class='col-md-10'><h4>".$content->Name->Value."</h4><span class='date-banner'>".$content->DateCreated->Value."</span><p>".$content->Description->Value."</p>";
                       $lkDetail = new Link($this->Core->GetCode("Banner.ReadContent"), Format::ReplaceForUrl('Content-'.$content->Name->Value.".html") );
                       $html .= $lkDetail->Show();
                       $html .= "</div>";

                        //.Row
                       $html .= "</div>";

                       //.Content
                       $html .= "</div> ";
                   }
               }
               else
               {
                  $html .= $this->Core->GetCode("Banner.NoContent"); 
               }

             //Modification de données pour le référencement de la content
             $this->Core->Content->Mastercontent->AddBlockTemplate("!Title",  str_replace("_", " ",$category) ." - Webemyos");
             $this->Core->Content->Mastercontent->AddBlockTemplate("!Description", "Retrouvez tous nos contents de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
             $this->Core->Content->Mastercontent->AddBlockTemplate("!KeyWord", "Contents startup, content entrepreneuriat, Contents création site internet");

             $this->Core->Content->Mastercontent->AddBlockTemplate("!titleContent",  "<h1>".str_replace("_", " ",$category)."</h1><br/>");
             $this->Core->Content->Mastercontent->AddBlockTemplate("!descContent",  "<p>".$content->Category->Value->Description->Value."</p>");

           }
           else
           {
             $contents = BannerHelper::GetCurrentContent($this->Core, $banner, $idEntite);

              if($idEntite == ""  )
               {
                   foreach($contents as $content)
                   {   

                       //Artcile
                       $html .= "<div class='content'> ";

                       //Row
                       $html .= "<div class='row'>";

                       //Image de présentation
                       $html .= "<div class='col-md-2'>".$contentController->GetImageContent($content->BannerId->Value, $content->IdEntite)."</div>";

                       //Extrait content
                       $html .= "<div class='col-md-10'><h4>".$content->Name->Value."</h4><span class='date-banner'>".$content->DateCreated->Value."</span><p>".$content->Description->Value."</p>";
                       $lkDetail = new Link($this->Core->GetCode("Banner.ReadContent"), Format::ReplaceForUrl('Content-'.$content->Name->Value.".html") );
                       $html .= $lkDetail->Show();
                       $html .= "</div>";

                       //.Row
                       $html .= "</div>";

                       //.Content
                       $html .= "</div> ";

                   }

                 $this->Core->Content->Mastercontent->AddBlockTemplate("!Title",  "banner - Webemyos");
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!description", "Retrouvez tous nos contents de startup, d'entrepreneuriat, de création de site internet classé par catégorie");
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!Keyword", "Contents startup, content entrepreneuriat, Contents création site internet");

                 //TODO Rendre parametrable pour chaque banner
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!titleContent", "<h1>".$this->Core->GetCode("Banner.TitleHome")."</h1><br/>");
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!descContent",  "<p>".$this->Core->GetCode("Banner.descriptionHome")."</p>");
               }
             else if(count($contents) == 1)
             {
                $html.= "<h1>".$contents->Name->Value."</h1>";
                $html.= "<p> ".$this->Core->GetCode("Banner.DiffusedDate")." : <b class='date blueTwo'>".$contents->DateCreated->Value."</b></p>";

                //Lorsque l'on est en front l'url des image est différentes
                $content = str_replace("../Data" , "Data", $this->FormatForClient($contents->Content->Value));

                $html.= "<div>".$content."</div>";

                 //BBanner de commentaire depuis Comunity
                 $ecomunity = DashBoardManager::GetAppFront("Comunity", $this->Core);
                 $html .= $ecomunity->GetCommentBlock("Banner", "BannerContent", $contents->IdEntite);

                //Contents similaires
                $html .= "<div class='row'><h2>".$this->Core->GetCode("Banner.SimilareContent")."</h2>";
                $html .= $this->GetSimilar($contents)."</div>";

                       //Modification de données pour le référencement de la content
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!Title", $contents->Name->Value. " - Webemyos");
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!description", $contents->Description->Value);
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!keyword", $contents->KeyWork->Value);

                 //Lien vers la categorie parent
                 $lkCategorie = new Link("Categorie : " .$contents->Category->Value->Name->Value, Format::ReplaceForUrl("banner-Category-".$contents->Category->Value->Name->Value) .".html");
                 $lkCategorie->Title = $content->Value->Categorie->Name->Value;

                 //TODO Rendre parametrable pour chaque banner
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!titleContent", $lkCategorie->Show() );
                 $this->Core->Content->Mastercontent->AddBlockTemplate("!descContent", "");
             }
           }

           $html.= "</div>";

           return $html;
       }

       /*
        * Obtient les trois dernier contents similaires
        */
       function GetSimilar($content)
       {
           $contents = ContentHelper::GetSimilare($this->Core, $content);

           $html ="";

           //Module pour récuperer les images
           $contentBlock = new ContentBlock($this->Core);

           foreach($contents as $content)
           {
             $html .= "<div class='col-md-4' >";

             //Image de présentation
             $html .= "<span>".$contentBlock->GetImageContent($content->BannerId->Value, $content->IdEntite)."</span>";

             $html .= "<p>".$content->Description->Value."</p>";

             $lkDetail = new Link($this->Core->GetCode("Banner.ReadContent"), Format::ReplaceForUrl('Content-'.$content->Name->Value.".html") );
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
        * obtient tou les contents
        */
       function GetLast($banner)
       {
             $contents = BannerHelper::GetLast($this->Core, $banner);

             $html = "<ul>";

             foreach($contents as $content)
             {
                $name = str_replace(" ", "_", $content->Name->Value);


                $link = new Link($content->Name->Value, Format::ReplaceForUrl("Content-".$name.".html"  ));

                $html .= "<li>".$link->Show()."</li>"; 
             }

             $html .= "</ul>";

             return $html;
       }

       /**
        * Block pour s'inscrire à la newLetters
        */
       function GetNewLetterBlock($bannerId)
       {
           $html = $this->Core->GetCode("Banner.InscriptionNewsLetter");


           $jbNews = new AjaxFormBlock($this->Core, "jbNew");
           $jbNews->App = "Banner";
           $jbNews->Action = "AddEmailNewLetter";

           $jbNews->AddArgument("BannerId", $bannerId);

           $jbNews->AddControls(array(
                             array("Type"=>"BsEmailBox", "Name"=> "tbEmail", "Title" => $this->Core->GetCode("Email")),
                             array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Inscription")),
                 )
       );

           return $html.$jbNews->Show();
       }

       /**
        * Obtient les catégories du banner avec le nombre d'contents correspondants
        */
       public function GetCategory($banner)
       {
           $html ="";

           $categories =  CategoryHelper::GetByBanner($this->Core, $banner);

           if(count($categories) > 0)
           {
               $html .= "<ul>";

               foreach($categories as $categorie)
               {
                   $name = $categorie->Name->Value ." (".CategoryHelper::GetNumberContent($this->Core, $categorie->IdEntite).")";

                   $link = new Link($name, "banner-Category-". Format::ReplaceForUrl($categorie->Name->Value) .".html");

                   $html .= "<li>".$link->Show()."</li>";
               }

                $html .= "</ul>";
           }

           $html .="";

           return $html;
       }

       /*
       * Obtient la banniere rotative
       */
       function GetBanner($bannerName)
       {
           //Recuperatob de la banniere
           $banner = new BannerBanner($this->Core);
           $banner->GetByName($bannerName);

           //Recuperation des contenu
           $content = new BannerContent($this->Core);
           $content->AddArgument(new Argument("BannerContent", "BannerId", EQUAL, $banner->IdEntite ));
           $content->AddArgument(new Argument("BannerContent", "Actif", EQUAL, 1 ));

           $contents = $content->GetByArg();

           $this->SetTemplate(str_replace("../Apps", "Apps", Banner::$Directory . "/Blocks/BannerBlock/GetBanner.tpl"));

           $items="";

         if(count($contents)> 0)
         {
             foreach($contents as $content)
             {
                 if($items == "")
                 {
                     $class= "item active";
                 }
                 else
                 {
                     $class= "item";
                 }

              $items .="<div class='".$class."'>
                   ".$content->Content->Value."
                  </div>";
             }
         }
         $this->AddParameters(array('!items' => $items ));
         return $this->Render();
       }

	/*action*/
          
}
