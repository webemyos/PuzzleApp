<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader\Module\Ressource;

use Apps\Downloader\Entity\DownloaderRessource;
use Apps\Downloader\Entity\DownloaderRessourceContact;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Upload\Upload;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\View\View;

class RessourceController extends Controller
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
     * Ajout d'une ressources
     */
    function ShowAddRessource($ressourceId = "")
    {
        $jbRessource = new AjaxFormBlock($this->Core, "jbRessource");
        $jbRessource->App = "Downloader";
        $jbRessource->Action = "SaveRessource";
        
        if($ressourceId != "")
        {
            $ressource = new DownloaderRessource($this->Core);
            $ressource->GetById($ressourceId);
            $jbRessource->AddArgument("RessourceId", $ressourceId);
        }
        
        $controls = array(
                            array("Type"=>"TextBox", "Name"=> "tbRessourceName", "Libelle" => $this->Core->GetCode("Name"), "Value"=> ($ressource != "") ? $ressource->Name->Value : ""),
                            array("Type"=>"TextArea", "Name"=> "tbRessourceDescription", "Libelle" => $this->Core->GetCode("Description"),"Value"=> ($ressource != "") ? $ressource->Description->Value : ""),
                            array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")));
     
        if($ressourceId != "")
        {
             $upload = new Upload("Downloader", $ressourceId, "DownloaderAction.LoadMyRessource()", "UploadRessource", "EeFileUpload");

            $controls[] =    array("Type"=>"Libelle", "Libelle" => $this->Core->GetCode("Dowload"), "Value"=> $upload->Show(true));
        }     
        
        $jbRessource->AddControls($controls);
                   
        return $jbRessource->Show();
    }

    /**
     * Charge les ressources de l'utilisateur
     */
    function LoadMyRessource()
    {
        $ressource = new DownloaderRessource($this->Core);
        $ressource->AddArgument(new Argument("Apps\Downloader\Entity\DownloaderRessource", "UserId", EQUAL, $this->Core->User->IdEntite));
        $ressources = $ressource->GetByArg();

        $view = new View(__DIR__."/View/loadMyRessource.tpl", $this->Core);
        
        $view->AddElement($ressources);
        
        return $view->Render();
    }
    
    /*
     * Affiche les contact d'une ressource
     */
    function ShowContact($ressourceId)
    {
       $contact = new DownloaderRessourceContact($this->Core);
       $contact->AddArgument(new Argument("Apps\Downloader\Entity\DownloaderRessourceContact", "RessourceId", EQUAL, $ressourceId));
       $contacts = $contact->GetByArg();
       
       $view = new View(__DIR__."/View/showContact.tpl", $this->Core);
       $view->AddElement($contacts);
        
       return $view->Render();
    }

    /*action*/
 }?>
