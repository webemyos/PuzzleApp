<?php
/**
 * Application de gestion des page paramétrables
 * */

namespace Apps\Cms;

use Core\Core\Core;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Utility\ImageHelper\ImageHelper;

use Apps\Base\Base;
use Apps\Cms\Entity\CmsCms;
use Apps\Cms\Entity\CmsPage;
use Apps\Cms\Helper\CmsHelper;
use Apps\Cms\Helper\PageHelper;
use Apps\Cms\Module\Cms\CmsController;
use Apps\Cms\Module\Page\PageController;



class Cms extends Base
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Cms";

	/**
	 * Constructeur
	 * */
	 function __construct()
	 {
            $this->Core = Core::getInstance();
            parent::__construct($this->Core, "Cms");
	 }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
        echo parent::RunApp($this->Core, "Cms", "Cms");
	 }

        /**
         * Pop in d'ajout de cms
         */
        function ShowAddCms()
        {
            $cmsController = new CmsController($this->Core);
            echo $cmsController->ShowAddCms();
        }

        /**
         * Enregistre un nouveau cms
         */
        function SaveCms()
        {
            if(Request::GetPost("tbName")!= "" &&   CmsHelper::Save($this->Core,
                                                 Request::GetPost("tbName"),
                                                 Request::GetPost("tbDescription"),
                                                 Request::GetPost("AppName"),
                                                 Request::GetPost("EntityName"),
                                                 Request::GetPost("EntityId")
                    ))
            {
                echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Cms.ErrorCreate")."</span>";
                echo $this->ShowAddCms();
            }
        }

        /**
         * Met a jour les propriété d'un cms
         */
        function UpdateCms()
        {
           if(Request::GetPost("tbName") != "")
           {
               CmsHelper::Update($this->Core,
                                    Request::GetPost("cmsId"),
                                    Request::GetPost("tbName"),
                                    Request::GetPost("tbDescription"));

           }

           $cmsController = new CmsController($this->Core);
           echo $cmsController->GetTabProperty( "", Request::GetPost("cmsId"))->Show();
        }

         /**
         * Charge les cms de l'utilisateur
         */
        function LoadMyCms()
        {
            $CmsController = new CmsController($this->Core);
            echo $CmsController->LoadMyCms();
        }

        /**
         * Charge les pages du Cms
         */
        function LoadPage()
        {
            $CmsController = new CmsController($this->Core);

            $cms = new CmsCms($this->Core);
            $cms->GetById(Request::GetPost("cmsId"));

            echo $CmsController->GetTabPages($cms)->Show();
        }

        /**
         * Charge un cms
         */
        function LoadCms($cmsName = "")
        {
           $cmsController = new CmsController($this->Core);

	   if($cmsName != "")
	   {
	      $cms = new CmsCms($this->Core);
	      $cms = $cms->GetByName($cmsName);

	      return $cmsController->LoadCms($cms->IdEntite);
	   }
	   else
	   {
              echo $cmsController->LoadCms(Request::GetPost("cmsId"));
	   }
        }

        /**
         * Pop in d'ajout de page
         */
        function ShowAddPage()
        {
            $pageController = new PageController($this->Core);
            echo $pageController->ShowAddPage(Request::GetPost("CmsId"), Request::GetPost("pageId"));
        }

        /**
         * Enregistre une page
         */
        function SavePage()
        {
            $title = Request::GetPost("tbPageTitle");

            if($title != "")
            {
                PageHelper::Save($this->Core,
                                    Request::GetPost("cmsId"),
                                    Request::GetPost("pageId"),
                                    Request::GetPost("tbPageName"),
                                    Request::GetPost("tbPageTitle"),
                                    Request::GetPost("tbPageDescription")
                        );

                echo "<span class='success'>".$this->Core->GetCode("Cms.PageSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Cms.ErrorPage")."</span>";

                $this->ShowAddPage();
            }
        }

         /**
         * Charge un page
         */
        function EditPage()
        {
             $pageController = new PageController($this->Core);
             echo $pageController->EditPage(Request::GetPost("PageId"));
        }

        /**
         * Met à jour le contenu
         */
        function UpdateContent()
        {
            PageHelper::SaveContent($this->Core, Request::GetPost("PageId"), Request::GetPost("content"));

            echo $this->Core->GetCode("SaveOK");
        }

        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "Data/Apps/Cms/";

            File::CreateDirectory($directory. $idElement);

           switch($action)
           {

               case SaveImagePage :

                   //Recuperaion de l'page afin d'avoir le dossier du cms
                   $page = new CmsPage($this->Core);
                   $page->GetById($idElement);
                   $folder = $page->CmsId->Value;

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
         * Obtien l'image de l'page
         */
        function GetImagePage()
        {
            $page = new CmsPage($this->Core);
            $page->GetById(Request::GetPost("PageId"));

            $pageController = new PageController($this->Core);
            echo $pageController->GetImagePage($page->CmsId->Value, $page->IdEntite);
        }

        /**
         * Obtient les images du cmss
         * format niormal et mini
         */
        function GetImages()
        {
            echo CmsHelper::GetImages($this->Core, Request::GetPost("CmsId"));
        }

        /**
         * Affiche une page du cms
         * @param type $cms
         * @param type $page
         */
        function ShowPage($page)
        {
            $pageController = new PageController($this->Core);
            return $pageController->ShowPage($page);
        }
}
?>
