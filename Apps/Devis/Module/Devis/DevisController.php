<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\Devis\Module\Devis;

use Apps\Devis\Entity\DevisDevis;
use Apps\Devis\Entity\DevisDevisLine;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\View\View;


 class DevisController extends Controller
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
     * Popin de création de modele
     */
    function ShowAddModele($projetId, $devisId)
    {
        $jbModele = new AjaxFormBlock($this->Core, "jbArticle");
        $jbModele->App = "Devis";
        $jbModele->Action = "SaveModele";

        $jbModele->AddArgument("projetId", $projetId);
        $jbModele->AddArgument("isModele", true);

        if($devisId != "")
        {
          $devis = new DevisDevis($this->Core);
          $devis->GetById($devisId);

          $jbModele->AddArgument("devisId", $devisId);

        }

        $jbModele->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbNumber", "Libelle" => $this->Core->GetCode("Number"), "Value" => ( ($devisId != "") ? $devis->Number->Value : "") ),
                                      array("Type"=>"TextArea", "Name"=> "tbInformationSociete", "Libelle" => $this->Core->GetCode("Devis.InformationSociete"), "Value" => ( ($devisId != "") ? $devis->InformationSociete->Value : "") ),
                                      array("Type"=>"TextArea", "Name"=> "tbInformationClient", "Libelle" => $this->Core->GetCode("Devis.InformationClient"), "Value" => ( ($devisId != "") ? $devis->InformationClient->Value : "") ),
                                      array("Type"=>"TextArea", "Name"=> "tbInformationComplementaire", "Libelle" => $this->Core->GetCode("Devis.InformationComplementaire"), "Value" => ( ($devisId != "") ? $devis->InformationComplementaire->Value : "") ),
                                      array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                          )
                );

        return $jbModele->Show();
    }

    /*
     * Pop in d'ajout d'un devis
     */
    public function ShowAddDevis($projetId, $devisId)
    {
        $view = new View(__DIR__ . "/View/ShowAddDevis.tpl");

        $devis = new DevisDevis($this->Core);

        if($devisId != "")
        {
            $devis->GetById($devisId);
        }

        //Charge les valeurs de l'entite dans les controles
        //TODO automatise cette taches
        $view->LoadControl($devis);

        $view->AddElement(new Text("devisId", false, $devisId));
        $view->AddElement($devis->Number->Control);
        $view->AddElement($devis->InformationSociete->Control);
        $view->AddElement($devis->InformationClient->Control);
        $view->AddElement($devis->DateCreated->Control);
        $view->AddElement($devis->DatePaiment->Control);
        $view->AddElement($devis->TypePaiment->Control);
        $view->AddElement($devis->InformationComplementaire->Control);

        if($devisId != "")
        {
          //Ajout des lignes
          $line = new DevisDevisLine($this->Core);
          $line->AddArgument(new Argument("Apps\Devis\Entity\DevisDevisLine","DevisId", EQUAL, $devisId));
          $lines = $line->GetByArg();

          if(count($lines)>0)
          {
              $view->AddElement($lines);
          }
          else
          { 
              $view->AddElement(array());
          }
        }
        else
        {
             $view->AddElement(array());
        }


        //Sauvegarde
        $btnSave = new Button(BUTTON, "btnSave");
        $btnSave->Value = $this->Core->GetCode("Save");
        $btnSave->CssClass = "btn btn-success";
        
        if($devisId != "")
        {
           $btnSave->OnClick = "DevisAction.SaveDevis($projetId, $devisId);";   
        }
        else
        {
           $btnSave->OnClick = "DevisAction.SaveDevis($projetId);";   
        }
       
        $view->AddElement($btnSave);

        $btnImprime = new Button(BUTTON, "btnImprime");
        $btnImprime->Value = $this->Core->GetCode("Devis.SaveAsPdf");
        $btnImprime->CssClass = "btn btn-info";
        
        if($devisId != "")
        {
            $btnImprime->OnClick = "DevisAction.SaveAsPdf(this, ".$devisId.");";
        }
        else
        {
            $btnImprime->OnClick = "DevisAction.SaveAsPdf(this);";
        }
        
        $view->AddElement($btnImprime);

        return $view->Render();
    }

    /*action*/
 }?>

