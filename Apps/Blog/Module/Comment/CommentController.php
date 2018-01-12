<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Comment;

use Apps\Blog\Helper\CommentHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\TextArea\TextArea;
use Core\Controller\Controller;

class CommentController extends Controller
{
    /**
     * Constructeur
     */
    function __construct($core)
    {
        $this->Core = $core;
    }
    
    function Init(){}
    
    function Show(){}
    
    /**
     * Charge les commentaires et la possibilité d'en ajouter
     * @param type $app
     * @param type $entityName
     * @param type $entityId
     * @return string
     */
    function Load($articleId, $showAddBlock)
    {
        $view = new View(__DIR__."/View/Load.tpl");
    
        //App pour recuperer les profils
        $eprofil = Dashboard::GetAppFront("EeProfil");
        
        $view->AddElement(new ElementView("ShowAddBlock", $showAddBlock));
                
        $view->AddElement(new ElementView("AddBlock", $this->GetAddBlock($articleId, $eprofil)));
        $view->AddElement(new ElementView("Comments", $this->GetComment($articleId, $eprofil)));
        
        return $view->Render();
    }
}
