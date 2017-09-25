<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Ide\Module\Depot;

use Core\Control\Button\Button;
use Core\Controller\Controller;
/*
 * Module de gestion des dépots
 */
class DepotController extends Controller
{
    protected $Core;
    
    /*
     * Constructeur
     */
    function __construct($core)
    {
        $this->Core = $core;
    }
        
    /*
     * Ajout de dépot
     */
    function ShowAddDepot()
    {
        $html = "<span id='spResultUpload'></span><br/>";
        
        $Depots = DepotHelper::GetDepots(); 
        
        $lstDepots = new ListBox("lstDepots");
        
        foreach($Depots as $depot)
        {
            if($depot != "." && $depot != "..")
            {
                $lstDepots->Add($depot, $depot);
            }
        }
        
        $html .= $lstDepots->Show();
        
        //Upload
        $btnUpload = new Button(BUTTON);
        $btnUpload->CssClass = "btn btn-primary";
        $btnUpload->Value = "Upload";
        $btnUpload->OnClick = "EeIdeAction.UploadDepot()";
        
        $html .= $btnUpload->Show();
        
        return $html;
    }
    
    /*
     * Suppression d'uyn dépot
     */
    function ShowDeleteDepot()
    { 
        $html = "<span id='spResultUpload'></span><br/>";
        
        $Depots = DepotHelper::GetMyDepots();
        
        $lstDepots = new ListBox("lstDepots");
        
        foreach($Depots as $depot)
        {
            if($depot != "." && $depot != "..")
            {
                $lstDepots->Add($depot, $depot);
            }
        }
        
        $html .= $lstDepots->Show();
        
        //Delete
        $btnDelete = new Button(BUTTON);
        $btnDelete->CssClass = "btn btn-primary";
        $btnDelete->Value = "Delete";
        $btnDelete->OnClick = "EeIdeAction.DeleteDepot()";
        
        $html .= $btnDelete->Show();
        
        return $html;
    }
    
    /*
     * Commit un dépot
     */
    function ShowCommitDepot()
    {
        $html = "<span id='spResultUpload'></span><br/>";
        
        $Depots = DepotHelper::GetMyProjectDepots($this->Core); 
        
        $lstDepots = new ListBox("lstDepots");
        
        foreach($Depots as $depot)
        {
            if($depot != "." && $depot != "..")
            {
                $lstDepots->Add($depot->Name->Value, $depot->Name->Value);
            }
        }
        
        $html .= $lstDepots->Show();
        
        //Upload
        $btnCommit = new Button(BUTTON);
        $btnCommit->CssClass = "btn btn-primary";
        $btnCommit->Value = "Commit";
        $btnCommit->OnClick = "EeIdeAction.CommitDepot()";
        
        $html .= $btnCommit->Show();
        
        return $html;
    }
}