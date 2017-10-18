<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Form\Module\Form;

use ActionColumn;
use AjaxActionColumn;
use Apps\Form\Entity\FormForm;
use Apps\Form\Entity\FormQuestion;
use Apps\Form\Entity\FormResponse;
use Apps\Form\Helper\FormHelper;
use Apps\Form\Helper\QuestionHelper;
use Core\Action\Action;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\Icone\UserIcone;
use Core\Controller\Controller;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Grid\EntityColumn;
use Core\Control\Grid\EntityGrid;
use Core\Control\Icone\GroupIcone;
use Core\Control\Icone\HelpIcone;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\ListBox\ListBox;
use Core\Control\PopUp\PopUp;
use Core\Control\RadioButton\RadioButton;
use Core\Control\TabStrip\TabStrip;
use Core\Control\TextArea\TextArea;
use Core\Control\TextBox\TextBox;


 class FormController extends Controller
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
           * Charge les formulaire de l'utilisateur
           */
          function LoadForm()
          {
                 $forms = $this->GetForms();

                $html = "";

                if(sizeof($forms) > 0)
                {
                    //Entete
                    $html .= "<div class='folder titleBlue'  >";
                    $html .= "<b class=''>&nbsp;</b>" ;
                    $html .= "<span class='' ><b>".$this->Core->GetCode("Form.App")."</b></span>" ;
                    $html .= "<span class='' ><b>".$this->Core->GetCode("Form.Name")."</b></span>" ;
                    $html .= "<span class='' ><b>".$this->Core->GetCode("Form.NumberReponse")."</b></span>" ;
                  
                    $html .= "</span>";  
                    $html .= "</div>" ;

                    $i=0;
                     
                    foreach($forms as $form)
                    {
                        if($i==1)
                        {
                             $i=0;
                             $class='lineClair';
                         }
                         else
                         {
                             $i=1;
                             $class='lineFonce';
                         }
                     
                      $html .= "<div class='folder $class'  >";

                     
                      $appName = $form->AppName->Value;
                                
                      //Si le formulaire vient d'une application
                      if($appName != "")
                      {
                          $img = new Image("../Apps/".$appName."/images/logo.png" );
                          $img->Title = $appName;
                          $html .="<span>".$img->Show()."</span>"; 
                      }
                      else
                      {
                          $html .="<span></span>"; 
                      }
                      
                       $html .= "<span class='name'>".$form->Libelle->Value."</span>";

                      //Nombre de répondant
                      $html .= '<span>'.FormHelper::GetNumberUserResponse($this->Core, $form->IdEntite)."</span>";

                      
                      //Edition du formulaie
                      $Edit = new EditIcone();
                      $Edit->Title = $this->Core->GetCode("Form.Edit");
                      $Edit->OnClick= "FormAction.EditForm(".$form->IdEntite.")";
                      $html .= "<span class='action'><b>".$Edit->Show()."</b>";

                      //Gestion des questions;
                      $Edit = new HelpIcone();
                      $Edit->Title = $this->Core->GetCode("Form.EditQuestion");
                      $Edit->OnClick= "FormAction.LoadQuestionReponse(this, ".$form->IdEntite.")";
                      $html .= "<b>".$Edit->Show()."</b>";

                      $Delete = new DeleteIcone();
                      $Delete->OnClick= "FormAction.DeleteForm(".$form->IdEntite.")";
                      $html .= "<b>".$Delete->Show()."</b></span>";

                      $html .= "</div>";
                    }
                  }
                  else
                  {
                    $html .= $this->Core->GetCode("Form.NoForms");
                  }

                return $html;
          }
        /**
        * Récupere les fomulaires de l'utilisateur
        */
        function GetForms()
        {
         $form = new FormForm($this->Core);
         $form->AddArgument(new Argument("FormForm", "UserId", EQUAL, $this->Core->User->IdEntite));
         $form->AddOrder("Id");
        
         return $form->GetByArg();
        }
  
           /**
        * Affiche les formulaire en cours
        */
       function GetForm($showPopin = true)
       {
         $Forms = new eForm($this->Core);
         //Todo récuperer que les questionnaire non répondut
         $Forms->AddArgument(new Argument("eForm","Actif", EQUAL, "1"));
         $forms = $Forms->GetByArg();

         $TextControl ="";

         if(count($forms) > 0)
         {
           $TextControl = '<ul>';

           foreach($forms as $form)
           {

             //on ajoute pas kes questionnaire remplie par l'utilisateur
             $userAvantage = new UserAvantage($this->Core);

             if($this->Core->User->IdEntite !="")
             {
                 $userAvantage->AddArgument(new Argument("UserAvantage","UserId",EQUAL, $this->Core->User->IdEntite));
                 $userAvantage->AddArgument(new Argument("UserAvantage","FormId",EQUAL, $form->IdEntite));

                 $Avantage = $userAvantage->GetByArg();
             }
             else
             {
                 $Avantage = false;
             }


             if($Avantage ==false || count($Avantage) == 0)
             {
                 if($showPopin)
                 {
                   $lkForm = new Link($form->Libelle->Value, "#");
                   $lkForm->OnClick = 'DashBoard.ShowForm('.$form->IdEntite.')';
                 }
                 else
                 {
                   $lkForm = new Link($form->Libelle->Value, "app-Form-".$form->IdEntite.".html" );
                 }
                 $lkForm->Title = Format::EscapeString($form->Commentaire->Value, true);
                 $lkForm->CssClass = "violet";

                 $TextControl .= "<li><i class='icon-edit-sign' style='color:#bebebe'></i>".$lkForm->Show()."</li>";
             }
         }

           $TextControl .= '</ul>';
         }

         return $TextControl;
       }
       
       /**
        * Edition d'un formulaire
        *
        */
       function DetailForm()
       {
        $jbForm = new Block($this->Core, 'jbForm');
        $jbForm->Table = true;
        $jbForm->Frame = false;

        $form = new FormForm($this->Core);

        //Recuperation du formulaire
        if(Request::GetPost('idEntity'))
        {
          $form->GetById(Request::GetPost('idEntity'));
        }

        $jbForm->AddNew(new Libelle("<span id='lbResultForm'></span>"));
        $jbForm->AddNew($form->Libelle);
        $jbForm->AddNew($form->Commentaire);
        $jbForm->AddNew($form->Actif);

        //Action
        $action = new AjaxAction("Form","SaveForm");
        $action->AddArgument("App","Form");

        if(Request::GetPost('idEntity'))
        {
          $action->AddArgument("idEntity", Request::GetPost('idEntity'));
        }

        $action->ChangedControl = "jbForm";
        $action->AddControl($form->Libelle->Control->Id);
        $action->AddControl($form->Commentaire->Control->Id);
        $action->AddControl($form->Actif->Control->Id);

        //Bouton de sauvagarde
        $btnSave = new Button(BUTTON);
        $btnSave->CssClass = "btn btn-primary";
        $btnSave->Value = $this->Core->GetCode("Save");
        $btnSave->OnClick = $action;
        $jbForm->AddNew($btnSave, 2 , ALIGNRIGHT);

        return $jbForm->Show();
       }
       
       /**
        * Charge les questions et réponses
        * @param type $idEntity
        * @return type
        */
       function LoadQuestionReponse($idEntity)
       {
            $tbQuestion = new TabStrip('tbQuestion', 'Form');

            //Charge les questions réponses
            $tbQuestion->AddTab($this->Core->GetCode("Questions"), $this->GetTabQuestion($idEntity));

            //Diffusion du questionnaire
            $tbQuestion->AddTab($this->Core->GetCode("Diffusion"), $this->GetTabSend($idEntity));

            //Reponse
            $tbQuestion->AddTab($this->Core->GetCode("Responses"), $this->GetTabResponseUser($idEntity));

            return $tbQuestion->Show();
       }
       
       /**
   * Récupere toutes les questions du formulaire
   * */
  function GetTabQuestion($idForm)
  {
    $jbQuestion = new Block($this->Core, 'jbQuestion');
    $jbQuestion->Frame = false;
    $jbQuestion->Table = false;

    $btnAdd = new Button(BUTTON);
    $btnAdd->CssClass = "btn btn-primary";
    $btnAdd->Value = $this->Core->GetCode("AddQuestion");
    $btnAdd->OnClick = "FormAction.DetailQuestion(".$idForm.");";
    $btnAdd->AddStyle("width","150px");
    $jbQuestion->AddNew($btnAdd);

    $jbQuestion->AddNew(new Libelle("<br/>"));

    $gdQuestion = new EntityGrid("gdQuestion",$this->Core);
    $gdQuestion->Entity = "FormQuestion";
    $gdQuestion->CssClass="grid";
    $gdQuestion->EmptyVisible = true;

    //Filtre sur l'utilisateur
    $gdQuestion->AddArgument(new Argument("FormQuestion", "FormId", EQUAL, $idForm));

    //Detail d'une question
    $popup = new PopUp("Form", "DetailQuestion");
    $popup->AddArgument("App", "Form");
    $popup->AddAction("OnClose" , "FormAction.RefreshQuestion();");

    //Ajout des colonnes
    $gdQuestion->AddColumn(new EntityColumn($this->Core->GetCode("Libelle"),"Libelle"));
   //$gdQuestion->AddColumn(new EntityColumn($this->Core->GetCode("Type"),"Type"));
    $gdQuestion->AddColumn(new ActionColumn("",$popup,"",$this->Core->GetCode("Edit"), "icon-edit"));
    $gdQuestion->AddColumn(new AjaxActionColumn("","Form","DeleteQuestion","App=Form","",$this->Core->GetCode("Delete"),"jbQuestion",true, "icon-remove"));
 
    $jbQuestion->Add($gdQuestion);

    return $jbQuestion;
  }
  
  /**
   * Diffusion du questionnaire
   *
   * */
  function GetTabSend($idForm)
  {
    $jbSend = new Block($this->Core, 'jbSend');
    $jbSend->Table = true;
    $jbSend->Frame = false;
   
    //bouton D'envoi
    $btnTest = new Button(BUTTON);
    $btnTest->CssClass = "btn btn-primary";
    $btnTest->Value = $this->Core->GetCode("Try");
    $btnTest->OnClick = "FormAction.TryForm(".$idForm.");";
    $jbSend->AddNew($btnTest, 2, "Style='text-align:left;'");

    $jbSend->Add(new Libelle("<span id='lbResultSend'>".$this->Core->GetCode("Form.AddListeEmailSeparation")."</span><br/>"));

    //Envoi par Email
    $tbEmail = new TextBox('tbEmail');
    $tbEmail->AddStyle('width', '450px');
    $tbEmail->Libelle = $this->Core->GetCode("ListEmail");
    $jbSend->AddNew(new Libelle('<br/>'));
    $jbSend->AddNew($tbEmail, 2);

    //Action
    $Action = new AjaxAction("Form","SendForm");
    $Action->AddArgument("App","Form");
    $Action->ChangedControl = 'lbResultSend';
    $Action->AddControl('tbEmail');
    $Action->AddArgument("FormId", $idForm);
    

    //bouton D'envoi
    $btnSend = new Button(BUTTON);
    $btnSend->CssClass = "btn btn-primary";
    $btnSend->Value = $this->Core->GetCode("Send");
    $btnSend->OnClick = $Action;

    $jbSend->AddNew($btnSend, 2, ALIGNRIGHT);

    return $jbSend;
  }
  
  /**
   * Affiche les réponses utilisateurs
   */
  function GetTabResponseUser($idForm, $idUser = null)
  {

      //Ajout d'un bandeau avec les différentes vues possible
       
        $groupIcon = new GroupIcone($this->Core);
        $groupIcon->Title = $this->Core->GetCode("Form.ShowByGroup");
        $groupIcon->OnClick = "FormAction.ShowByGroup(".$idForm.")";
        
        //$saveIcon->OnClick = $action;
        $userIcon = new UserIcone($this->Core);
        $userIcon->Title = $this->Core->GetCode("Form.ShowByUser");
        $userIcon->OnClick = "FormAction.ShowByUser(".$idForm.")";
        
        $TextControl = "<div class='tools'>".$groupIcon->Show().$userIcon->Show()."</div>";
   
      
    $jbResponse = new Block($this->Core, 'jbResponse');

        $Reponses = QuestionHelper::GetResponseUser($this->Core, $idForm, $idUser);

        $TextControl .= "<div><table class='grid' style='text-align: left'>";
        $questionId = '';
        $user = '';
        $i = 0;

        foreach($Reponses as $reponse)
        {
            if($reponse["UserId"] != null)
            {
                if($reponse["UserId"] != $user)
                {
                    $user = $reponse["UserId"];
                    $member = new User($this->Core);
                    $member->GetById($user);
                            
                    $TextControl .= "<tr><th colspan='2' class='tools'>".$member->GetPseudo()."</th></tr>";
                }
            }
                if($questionId != $reponse['QuestionId'])
                {
                   $TextControl .= "<tr><th colspan='2' class='question'>".Format::ReplaceString($reponse['LibelleQuestion'])."</th></tr>";
                }

        $questionId = $reponse['QuestionId'];

     	//Affichage des réponses
            if($reponse['LibelleReponse'])
            {
                    $TextControl .= '<tr><td>'.Format::ReplaceString($reponse['LibelleReponse']) . '</td><td>' . $reponse['NombreReponse'].'</td></tr>';
            }
            else
            {
                $TextControl .= "<tr><td colspan='2'>".Format::ReplaceString($reponse['LibelleReponseUser'])."</td></tr>";
            }
            $i++;
	}

	$TextControl .= '</table></div>';

	$jbResponse->AddNew(new Libelle($TextControl));

	return $jbResponse;
  }

  /**
   * Récupere un tableau des formulaire d'un projet
   *
   */
  function GetGridFormProjet($ProjetId)
   {
     //Recuperation de l'evenement
    $gdProjectEvent = new EntityGrid("gdProjectForm",$this->Core);
    $gdProjectEvent->Entity = "FormForm";
    $gdProjectEvent->CssClass="grid";
    $gdProjectEvent->EmptyVisible = false;

    //Filtre sur l'utilisateur
    $gdProjectEvent->AddArgument(new Argument("Apps\Form\Entity\FormForm","ProjetId",EQUAL, $ProjetId));

    //Ajout des colonnes
    $gdProjectEvent->AddColumn(new EntityColumn($this->Core->GetCode("Libelle"),"Libelle"));

    //Edition d'un évenement'
    $Popup = new PopUp("Form", "DetailResponse");
    $Popup->AddArgument("App","Form");
    $Popup->Title = $this->Core->GetCode("DetailReponse");

    //Ouverture de Form pour editer le questionnaire
    $editAction = new Action('StartApp', 'Form', array('idForm' => 'dd'));
  	//$editAction->AddArgument("idForm", );


    //Suppression
    //$gdProjectEvent->AddColumn(new ActionColumn("",$Popup,"Images/edit.png",$this->Core->GetCode("Edit")));
    $gdProjectEvent->AddColumn(new ActionColumn("",$editAction,"",$this->Core->GetCode("EditQuestion"), "icon-edit"));
    $gdProjectEvent->AddColumn(new ActionColumn("",$Popup,"",$this->Core->GetCode("EditResponses"), "icon-list-ul"));

    //  $gdProjectEvent->AddColumn(new AjaxActionColumn("","Projet","DeleteEvent","App=Projet&ProjetId=".$ProjetId,"Images/delete.png",$this->Core->GetCode("Delete"),"lstProjectEvents",true));

     return $gdProjectEvent;
   }
   
   function TryForm($idForm, $show = true)
   {
       $TextControl = "<div class='FormForm' style='width:600px;' id='dvForm'>";

    //Recuperation du formulaire
    $form = new FormForm($this->Core);
    $form->GetById($idForm);

    //Entête
    $TextControl .= '<h1>Questionnaire : '.$form->Libelle->Value.'</h1>';
    $TextControl .= $form->Commentaire->Value;

    //Les questions
    $Question = new FormQuestion($this->Core);
    $Question->AddArgument(new Argument("Apps\Form\Entity\FormQuestion", "FormId", EQUAL, $idForm));
    $questions = $Question->GetByArg();
    $i = 0;

    if(count($questions) > 0)
    {
      foreach($questions as $question)
      {
        $TextControl .= '<br/><h3>Question '.$i.'</h3>';
        $TextControl .= $question->Libelle->Value;

        //Choix possible
        $responses = new FormResponse($this->Core);
        $responses->AddArgument(new Argument("FormResponse","QuestionId", EQUAL, $question->IdEntite));
        $responses->AddArgument(new Argument("FormResponse","Actif", EQUAL, 1));

        $Reponses = $responses->GetByArg();

        //Reponse
        switch($question->Type->Value)
        {
          case 0:
            $tbReponse = new TextBox("tb_".$question->IdEntite);
            $TextControl .= "<br/>".$tbReponse->Show();
          break;
          case 1:
            $tbReponse = new TextArea("tb_".$question->IdEntite);
            $tbReponse->AddStyle('width', '500px');
            $TextControl .= "<br/><div>".$tbReponse->Show().'</div><br/>';
          break;
          case 2 :

          if(count($Reponses) > 0)
          {
            foreach($Reponses as $reponse)
            {
              $radio = new RadioButton('rb_'.$question->IdEntite);
              $radio->Value = $reponse->IdEntite;
              $TextControl .= "<br/>".$radio->Show(). ' ' .$reponse->Value->Value;
            }
          }
          break;
          case 3 :

          if(count($Reponses) > 0)
          {
            foreach($Reponses as $reponse)
            {
              $radio = new CheckBox('cb_'.$question->IdEntite.'_'.$reponse->IdEntite);
              $radio->Value = $reponse->IdEntite;
              $TextControl .= "<br/>".$radio->Show(). ' ' .$reponse->Value->Value;
            }
          }
          break;

          case 4 :

          if(count($Reponses) > 0)
          {
            $lstReponse = new ListBox('lst_'.$question->IdEntite);
            foreach($Reponses as $reponse)
            {
              $lstReponse->Add($reponse->Value->Value, $reponse->IdEntite);
            }

            $TextControl .= "<br/>".$lstReponse->Show();
          }
          break;
        }

        $i++;
      }
    }


    //Enregistrement
    if(Request::GetPost('CanComplete') == true || 1==1)
    {
      $btnSend = new Button(BUTTON);
      $btnSend->CssClass = "btn btn-success";
      $btnSend->Value = $this->Core->GetCode('Send');
      $btnSend->OnClick = "DashBoard.SendForm(".$idForm.")";
      $TextControl .= "<br/>".$btnSend->Show();
    }

    $TextControl .= "</div>";

    if($show)
    {
        echo $TextControl;
    }
    else
    {
        return $TextControl;
    }
   }
 }?>