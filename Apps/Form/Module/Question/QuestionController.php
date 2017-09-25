<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Module\Question;

use Apps\Form\Entity\FormQuestion;
use Apps\Form\Entity\FormResponse;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Control\Libelle\Libelle;
use Core\Control\ListBox\ListBox;
use Core\Control\TextArea\TextArea;


 class QuestionController extends Controller
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
         * Fenetre de gestion des questions
         */
        function DetailQuestion($questionId)
        {
          $jbQuestion = new Block($this->Core, 'jbForm');
          $jbQuestion->Table = true;
          $jbQuestion->Frame = false;

          $question = new FormQuestion($this->Core);

          //Recuperation du formulaire
          if($questionId != "")
          {
            $question->GetById($questionId);
          }

          $jbQuestion->AddNew(new Libelle("<span id='lbResultQuestion'></span>"));

          $question->Libelle->Control = new TextArea("Libelle");
          $question->Libelle->Control->AddStyle("height", "50px");
          $jbQuestion->AddNew($question->Libelle);

          $question->Commentaire->Control = new TextArea("Commentaire");
          $question->Commentaire->Control->AddStyle("height", "50px");
          $jbQuestion->AddNew($question->Commentaire);

          $lstType = new ListBox('lstType');
          $lstType->Libelle = $this->Core->GetCode('Type');
          $lstType->Add($this->Core->GetCode("SelectRepsonseType"), '');
          $lstType->Add($this->Core->GetCode("Text"),0);
          $lstType->Add($this->Core->GetCode("Paragraph"),1);
          $lstType->Add($this->Core->GetCode("MultipleChoice"),2);
          $lstType->Add($this->Core->GetCode("CheckBoxChoice"),3);
          $lstType->Add($this->Core->GetCode("List"),4);
          $lstType->OnChange = "FormAction.SelectResponseType();";

          $lstType->Selected = $question->Type->Value;

          $jbQuestion->AddNew($lstType);

          //Action
          $action = new AjaxAction("Form","SaveQuestion");
          $action->AddArgument("App","Form");

          if($questionId != "")
          {
            $action->AddArgument("idEntity", $questionId);
            $idEntite = $questionId;
            $idForm = 'null';
          }
          else
          {
            $action->AddArgument("idForm", Request::GetPost("idForm"));
            $idEntite = 'null';
            $idForm = Request::GetPost("idForm");
          }

          $action->ChangedControl = "lbResultQuestion";
          $action->AddControl($question->Libelle->Control->Id);
          $action->AddControl($question->Commentaire->Control->Id);
          $action->AddControl($lstType->Id);

          if($idEntite == 'null')
          {
            $jbQuestion->AddNew(new Libelle("<div id='dvResponse'></div>"), 2);
          }
          else
          {
            $jbQuestion->AddNew(new Libelle("<div id='dvResponse'>".$this->GetResponses($question)."</div>"), 2);
          }

          //Bouton de sauvagarde
          $btnSave = new Button(BUTTON);
          $btnSave->CssClass = "btn btn-primary";
          $btnSave->Value = $this->Core->GetCode("Save");
          $btnSave->OnClick = "FormAction.SaveQuestion('".$idForm."','".$idEntite."');";
          $jbQuestion->AddNew($btnSave, 2 , ALIGNRIGHT);

          return $jbQuestion->Show();
    }
    
    /**
   * Récupere les reponse d'une question
   */
  function GetResponses($question)
  {
    $TextControl = '';

    $responses = new FormResponse($this->Core);
    $responses->AddArgument(new Argument("Apps\Form\Entity\FormResponse","QuestionId", EQUAL, $question->IdEntite));
    $responses->AddArgument(new Argument("Apps\Form\Entity\FormResponse","Actif", EQUAL, 1));
   
    $Reponses = $responses->GetByArg();

    switch($question->Type->Value)
    {
      case 0:
        $TextControl .= "<input type='text' disabled='disabled' />";
      break;
      case 1:
        $TextControl .= "<textArea disabled='disabled' ></textarea>";
      break;
      case 2:
        $TextControl .= "<div id='lstResponse'>";

      if(count($Reponses) > 0)
      {
        foreach($Reponses as $response)
        {
          $TextControl .= "<span><br/><input type='Radio'  name='rb'/>";
          $TextControl .= "<input type='text' id='tbResponseText' name='".$response->IdEntite."' value='".$response->Value->Value."'/>";
          $TextControl .= "<i class='icon-remove' title='Delete' onClick = 'FormAction.DeleteResponse(this)' >&nbsp;</i></span>";
        }
      }
        $TextControl .= "</div>";
        $TextControl .= "<br/><input type='button' class='button orange' id='btnAddResponse' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"radio\")' />";
      break;
      case 3:
        $TextControl .= "<div id='lstResponse'>";

      if(count($Reponses) > 0)
      {
        foreach($Reponses as $response)
        {
          $TextControl .= "<span><br/><input type='checkbox'  name='cb'/>";
          $TextControl .= "<input type='text' id='tbResponseText' name='".$response->IdEntite."' value='".$response->Value->Value."'/>";
          $TextControl .= "<i class='icon-remove' title='Delete' onClick = 'FormAction.DeleteResponse(this)' >&nbsp;</i></span>";

        }
      }
        $TextControl .= "</div>";
        $TextControl .= "<br/><input type='button' class='button orange' id='btnAddResponse' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"check\")' />";
      break;
      case 4:
        $TextControl .= "<div id='lstResponse'>";

      if(count($Reponses) > 0)
      {
        foreach($Reponses as $response)
        {
          $TextControl .= "<span><br/>";
          $TextControl .= "<input type='text' id='tbResponseText' value='".$response->Value->Value."'/>";
          $TextControl .= "<i class='icon-remove' title='Delete' onClick = 'FormAction.DeleteResponse(this)' >&nbsp;</i></span>";

        }
      }
        $TextControl .= "</div>";
        $TextControl .= "<br/><input type='button' class='button orange' id='btnAddResponse' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"list\")' />";

      break;
    }

    return $TextControl;
  }
 }

