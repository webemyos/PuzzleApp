<?php

namespace Apps\Forum;

use Apps\Forum\Entity\ForumForum;
use Apps\Forum\Helper\CategoryHelper;
use Apps\Forum\Helper\ForumHelper;
use Apps\Forum\Helper\MessageHelper;
use Apps\Forum\Helper\SitemapHelper;

use Apps\Forum\Module\Admin\AdminController;
use Apps\Forum\Module\Category\CategoryController;
use Apps\Forum\Module\Forum\ForumController;
use Apps\Forum\Module\Message\MessageController;
use Core\App\Application;
use Core\Core\Core;
use Core\Core\Request;
use Core\Utility\Format\Format;

/**
 * Application de gestion des forums
 * */
class Forum extends Application {

    /**
     * Auteur et version
     * */
    public $Author = 'DashBoardManager';
    public $Version = '1.0.0';
    public static $Directory = "Apps/Forum";

    /**
     * Constructeur
     * */
    function __construct() {
        $this->Core = Core::getInstance();
        parent::__construct($this->Core, "Forum");
    }

    /*
     * Front Home Page
     */
    function Index()
    {
        $this->Core->MasterView->Set("Title", "Forum");
        return $this->ShowDefaultForum(false);
    }
    
    /*
     * Front category page
     */
    function Category($params)
    {
        $frontController = new ForumController($this->Core);
        return $frontController->ShowMessages($params, null, true, true);
    }
    
    /*
     * Show message 
     */
    function Sujet($params)
    {
        $forumController = new ForumController($this->Core);
        $html = $forumController->ShowMessage($params, true);

        if(Request::GetPost("Message"))
        {
            $this->Core->Redirect($this->Core->GetPath("/Forum/Sujet/" .$params ));
        }
        else
        {
            return $html;
        }
    }
   
    /*
     * Add  discussion
     */
    function NewDiscussion($params)
    {
        $this->Core->MasterView->Set("Title", $this->Core->GetCode("Forum.NewDiscussion"));
        
        $forumController = new ForumController($this->Core);
        $html = $forumController->NewDiscussion($params);

        if(Request::GetPost("Title"))
        {
            $this->Core->Redirect($this->Core->GetPath("/Forum/Sujet/" .Format::ReplaceForUrl(Request::GetPost("Title"))));
        }
        else
        {
            return $html;
        }
    }
    
    /**
     * Execution de l'application
     */
    function Run() {
        echo parent::RunApp($this->Core, "Forum", "Forum");
    }

    /**
     * Pop in d'ajout de forum
     */
    function ShowAddForum() {
        $forumController = new ForumController($this->Core);
        echo $forumController->ShowAddForum(Request::GetPost("ForumId"),  Request::GetPost("AppName"), Request::GetPost("EntityName"), Request::GetPost("EntityId"));
    }

    /**
     * Enregistre un nouveau forum
     */
    function SaveForum() {
        if (Request::GetPost("tbName") != "" && ForumHelper::Save($this->Core, Request::GetPost("tbName"), Request::GetPost("tbDescription"), Request::GetPost("AppName"), Request::GetPost("EntityName"), Request::GetPost("EntityId")
                )) {
            echo "<span class='success'>" . $this->Core->GetCode("SaveOk") . "</span>";
        } else {
            echo "<span class='error'>" . $this->Core->GetCode("Forum.ErrorCreate") . "</span>";
            echo $this->ShowAddForum();
        }
    }

    /**
     * Charge les forums de l'utilisateur
     */
    function LoadMyForum() {
        $forumController = new ForumController($this->Core);
        echo $forumController->LoadMyForum();
    }

    /**
     * Charge un forum
     */
    function LoadForum($forumName = "") {
        $forumController = new ForumController($this->Core);

        if ($forumName != "") {
            $forum = new ForumForum($this->Core);
            $forum = $forum->GetByName($forumName);

            return $forumController->LoadForum($forum->IdEntite);
        } else {
            echo $forumController->LoadForum(Request::GetPost("forumId"));
        }
    }

    /**
     * Met a jour les propriété d'un forum
     */
    function UpdateForum() {
        if (Request::GetPost("tbName") != "") {

            ForumHelper::Update($this->Core, 
                                Request::GetPost("forumId"),
                                Request::GetPost("tbName"), 
                                Request::GetPost("tbDescription"), 
                                Request::GetPost("cbDefault") 
                            );
        }

        $forumController = new ForumController($this->Core);
        echo $forumController->GetTabProperty("", Request::GetPost("forumId"))->Show();
    }

    /**
     * Pop in d'ajout de catégorie
     */
    function ShowAddCategory() {
        $categoryController = new CategoryController($this->Core);
        echo $categoryController->ShowAddCategory(Request::GetPost("forumId"), Request::GetPost("CategoryId"));
    }

    /**
     * Sauvegarde une catégorie
     */
    function SaveCategory() {
        $name = Request::GetPost("tbCategoryName");

        if ($name != "") {
            CategoryHelper::Save($this->Core, Request::GetPost("tbCategoryName"), Request::GetPost("tbCategoryDescription"), Request::GetPost("forumId"), Request::GetPost("CategoryId")
            );

            echo "<span class='success'>" . $this->Core->GetCode("Forum.CategorySaved") . "</span>";
        } else {
            echo "<span class='error'>" . $this->Core->GetCode("Forum.ErrorCategory") . "</span>";

            $this->ShowAddCategory();
        }
    }

    /**
     * Rafhaichit les catégories du forum
     */
    function RefreshCategory() {
        $forum = new ForumForum($this->Core);
        $forum->GetById(Request::GetPost("forumId"));

        $forumController = new ForumController($this->Core);
        echo $forumController->GetTabCategory($forum, Request::GetPost("forumId"))->Show();
    }

    /**
     * Supprimme une categorie ainsi que les message liées
     */
    function DeleteCategory() {
        CategoryHelper::DeleteCategory($this->Core, Request::GetPost("categoryId"));
    }

    /*
     * Affiche le forum par defaut
     */

    function ShowDefaultForum($show = true)
    {
        //TODO POuvoir parametrer un forum par défaut
        $forum = ForumHelper::GetFirst($this->Core);

        $forumController = new ForumController($this->Core);
        $html = $forumController->ShowForum($forum->Name->Value, "", Request::GetPost("categoryId"), Request::GetPost("messageId"), $show);
        
        if($show)
            echo $html; 
        else
            return $html; 
        
    }

    /*
     * Affiche un forum
     */

    function ShowForum($forum, $idEntite, $category, $sujet) {
        $forumController = new ForumController($this->Core);
        return $forumController->ShowForum($forum, $idEntite, $category, $sujet);
    }

    /**
     * Pop in d'ajout de message
     */
    function ShowAddSujet() {
        $messageController = new MessageController($this->Core);
        echo $messageController->ShowAddSujet(Request::GetPost("CategoryId"));
    }

    /**
     * Enregistrement d'un nouvell discussion
     */
    function SaveDiscussion() {
        $title = Request::GetPost("tbTitle");
        $message = Request::GetPost("tbMessage");
        $categoryId = Request::GetPost("CategoryId");

        if ($title != "" && $message != "") {
            MessageHelper::Save($this->Core, $categoryId, $title, $message);

            echo "<span class='success'>" . $this->Core->GetCode("Forum.DiscussionSaved") . "</span>";
        } else {
            echo "<span class='error'>" . $this->Core->GetCode("Forum.ErrorDiscussion") . "</span>";

            $this->ShowAddSujet();
        }
    }

    /**
     * Pop in d'ajout d'une réponse
     */
    function ShowAddReponse() {
        $messageController = new MessageController($this->Core);
        echo $messageController->ShowAddReponse(Request::GetPost("SujetId"));
    }

    /**
     * Sauvegarde la réponse
     */
    function SaveReponse() {
        $message = Request::GetPost("tbMessage");
        $sujetId = Request::GetPost("SujetId");

        if ($message != "") {
            MessageHelper::SaveReponse($this->Core, $sujetId, $title, $message);

            echo "<span class='success'>" . $this->Core->GetCode("Forum.ReponseSaved") . "</span>";
        } else {
            echo "<span class='error'>" . $this->Core->GetCode("Forum.ErrorReponse") . "</span>";

            $this->ShowAddReponse();
        }
    }

    /**
     * Rafraichit la liste des messages d'un categorie
     */
    function RefreshMessage() {
        $forumController = new ForumController($this->Core);
        echo $forumController->ShowMessages("", Request::GetPost("categoryId"), false);
    }

    /**
     * Rafraichit la listes des éponses
     */
    function RefreshReponse() {
        $forumController = new ForumController($this->Core);

        //Recuperation de l'appli Profil
        $eProfil = new Forum($this->Core);

        echo $forumController->ShowReponses(Request::GetPost("sujetId"), $eProfil);
    }

    /*
     * Charge la partie administration du forum
     */

    function LoadAdmin() {
        $adminController = new AdminController($this->Core);
        echo $adminController->Show();
    }

      /**
     * Get The siteMap 
     */
    public function GetSiteMap()
    {
        return SitemapHelper::GetSiteMap($this->Core);
    }

}

?>