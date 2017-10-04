<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Banner;

use Apps\Banner\Entity\BannerBanner;
use Apps\Banner\Entity\BannerContent;
use Apps\Banner\Helper\BannerHelper;
use Apps\Banner\Helper\ContentHelper;
use Apps\Banner\Module\Banner\BannerController;
use Apps\Banner\Module\Content\ContentController;
use Core\App\Application;
use Core\Core\Request;
use Core\Utility\File\File;
use Core\Utility\ImageHelper\ImageHelper;

class Banner extends Application
{
	public $Author = 'DashboardManager';
	/**
	 * Auteur et version
	 * */
	public $Version = '1.0.0';
        public static $Directory = "Apps/Banner";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
            parent::__construct($core, "Banner");
            $this->Core = $core;
         }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
            $textControl = parent::Run($this->Core, "Banner", "Banner");
            echo $textControl;
	 }
      
        
        /**
         * Pop in d'ajout de banner
         */
        function ShowAddBanner()
        {
            $bannerController = new BannerController($this->Core);
            echo $bannerController->ShowAddBanner();
        }
        
        /**
         * Enregistre un nouveau banner
         */
        function SaveBanner()
        {
            if(Request::GetPost("tbName")!= "" &&   BannerHelper::Save($this->Core, 
                                                 Request::GetPost("tbName"),
                                                 Request::GetPost("AppName"),
                                                 Request::GetPost("EntityName"),
                                                 Request::GetPost("EntityId")
                    ))
            {
                echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Banner.ErrorCreate")."</span>";
                echo $this->ShowAddBanner();
            }
        }
        
        /**
         * Met a jour les propriété d'un banner
         */
        function UpdateBanner()
        {
           if(Request::GetPost("tbName") != "")
           {
               BannerHelper::Update($this->Core, 
                                    Request::GetPost("bannerId"),
                                    Request::GetPost("tbName"),
                                    Request::GetPost("cbActif"));
                                                         
           }
          
           $bannerController = new BannerController($this->Core);
           echo $bannerController->GetTabProperty( "", Request::GetPost("bannerId"))->Show();
        }
        
         /**
         * Charge les banner de l'utilisateur
         */
        function LoadMyBanner()
        {
            $BannerController = new BannerController($this->Core);
            echo $BannerController->LoadMyBanner();
        }
        
        /**
         * Charge un banner
         */
        function LoadBanner($bannerName = "")
        {
           $bannerController = new BannerController($this->Core);
	   
           if(Request::GetPost("bannerId") != "")
	   {
              echo $bannerController->LoadBanner(Request::GetPost("bannerId"));
	   }
	   else if(Request::GetPost("bannerName") != "" || $bannerName != "")
	   {
              $banner = new BannerBanner($this->Core);
	      $banner->GetByName(Request::GetPost("bannerName"));
	      
	      echo $bannerController->LoadBanner($banner->IdEntite);
	   }
        }
        
        /**
         * Pop in d'ajout de content
         */
        function ShowAddContent()
        {
            $contentController = new ContentController($this->Core);
            echo $contentController->ShowAddContent(Request::GetPost("BannerId"), Request::GetPost("contentId"));
        }
        
        /**
         * Enregistre une content
         */
        function SaveContent()
        {
            $name = Request::GetPost("tbContentName");
            
            if($name != "")
            {
                ContentHelper::Save($this->Core,
                                    Request::GetPost("bannerId"),
                                    Request::GetPost("ContentId"),
                                    Request::GetPost("tbContentName"),
                                    Request::GetPost("cbActif") == 1
                        );
                
                echo "<span class='success'>".$this->Core->GetCode("Banner.ContentSaved")."</span>";
            }
            else
            {
                echo "<span class='error'>".$this->Core->GetCode("Banner.ErrorContent")."</span>";
                
                $this->ShowAddContent();
            }
        }
        
         /**
         * Charge un content
         */
        function EditContent()
        {
             $contentController = new ContentController($this->Core);
             echo $contentController->EditContent(Request::GetPost("ContentId"));
        }
        
        /**
         * Met à jour le contenu
         */
        function UpdateContent()
        {
            ContentHelper::SaveContent($this->Core, Request::GetPost("ContentId"), Request::GetPost("content"));
            
            echo $this->Core->GetCode("SaveOK");
        }
        
        /**
         * Charge le contenu d'une banniere
         */
        function LoadContent($bannerName ="", $show = true)
        {
            //Recuperation de la banniere
            $banner = new BannerBanner($this->Core);
            
            if($bannerName != "")
            {
                $banner->GetByName($bannerName);
            }
            else
            {
                $banner->GetById(Request::GetPost("bannerId"));
            }
            
            $bannerController = new BannerController($this->Core);
            if($show)
            {
                echo $bannerController->GetTabContent($banner)->Show();
            }
            else
            {
                return $bannerController->GetTabContent($banner)->Show();
            }
        }
        
        /**
         * Sauvegare les images de presentation
         */
        function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
        {
           //Ajout de l'image dans le repertoire correspondant
           $directory = "../Data/Apps/Banner/";
        
            File::CreateDirectory($directory. $idElement);
               
           switch($action)
           {
           
               case SaveImageContent :
                   
                   //Recuperaion de l'content afin d'avoir le dossier du banner
                   $content = new BannerContent($this->Core);
                   $content->GetById($idElement);
                   $folder = $content->BannerId->Value;
                   
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
         * Obtien l'image de l'content
         */
        function GetImageContent()
        {
            $content = new BannerContent($this->Core);
            $content->GetById(Request::GetPost("ContentId"));
            
            $contentController = new ContentController($this->Core);
            echo $contentController->GetImageContent($content->BannerId->Value, $content->IdEntite);
        }
        
        /**
         * Obtient les images du banners
         * format niormal et mini
         */
        function GetImages()
        {
            echo BannerHelper::GetImages($this->Core, Request::GetPost("BannerId"));
        }
        
        /**
         * Affiche une content du banner
         * @param type $banner
         * @param type $content
         */
        function ShowContent($banner, $content)
        {
            $contentController = new ContentController($this->Core);
            return $contentController->ShowContent($banner, $content);
        }
        
        /**
         * Obtient une banniere
         */
        function GetBanner($bannerName)
        {
            $bannerController = new BannerController($this->Core);
            return $bannerController->GetBanner($bannerName);
        }
}
?>