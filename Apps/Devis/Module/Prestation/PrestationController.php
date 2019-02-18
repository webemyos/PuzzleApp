<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\Devis\Module\Prestation;

use Apps\Devis\Entity\DevisPrestation;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Controller\Controller;

 class PrestationController extends Controller
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
     * Popin de création de prestation
     */
    function ShowAddPrestation($categoryId, $prestationId)
    {
        $jbPrestation = new AjaxFormBlock($this->Core, "jbArticle");
        $jbPrestation->App = "Devis";
        $jbPrestation->Action = "SavePrestation";

        $jbPrestation->AddArgument("categoryId", $categoryId);

        if($prestationId != "")
        {
          $prestation = new DevisPrestation($this->Core);
          $prestation->GetById($prestationId);

          $jbPrestation->AddArgument("prestationId", $prestationId);

        }

        $jbPrestation->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbPrestationLibelle", "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($prestationId != "") ? $prestation->Libelle->Value : "") ),
                                      array("Type"=>"TextArea", "Name"=> "tbPrestationDescription", "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($prestationId != "") ? $prestation->Description->Value : "") ),
                                      array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                          )
                );

        return $jbPrestation->Show();
    }

    /*action*/
 }?>