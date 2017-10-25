<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Mooc\Module\Mooc;

use Apps\Mooc\Entity\MoocLesson;
use Apps\Mooc\Entity\MoocMooc;
use Apps\Mooc\Helper\MoocHelper;
use Core\App\Application;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Libelle\Libelle;
use Core\Control\ListBox\ListBox;
use Core\Control\TabStrip\TabStrip;
use Core\Control\Text\Text;
use Core\Control\TextBox\TextBox;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\View\View;

 class MoocController extends Controller
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
         * Module de création de Mooc
         */
        function LoadPropose()
        {
              $tabMooc = new TabStrip("tabMooc", "Mooc");
              $tabMooc->AddTab($this->Core->GetCode("Mooc.MyMooc"), $this->GetTabMyMooc());

              return $tabMooc->Show();
        }

        /*
         * Mooc de l'utilisateur
         */
        function GetTabMyMooc()
        {
          $modele = new View(__DIR__ . "/View/GetTabMyMooc.tpl", $this->Core); 

          //Recuperation des mooc de l'utilisateur
          $moocs = MoocHelper::GetByUser($this->Core, true);
          $modele->AddElement($moocs);

          //Libelle sur les icones
          $modele->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Mooc.DetailMooc")));

          return new Libelle($modele->Render());
      }

        /*
         * Pop in d'ajout d'un mooc
         */
        function ShowAddMooc($moocId)
        {
            $jbMooc = new AjaxFormBlock($this->Core, "jbMooc");
            $jbMooc->App = "Mooc";
            $jbMooc->Action = "SaveMooc";

            $jbMooc->AddArgument("moocId", $moocId);

            if($moocId != "")
            {
              $mooc = new MoocMooc($this->Core);
              $mooc->GetById($moocId);
            }

            $jbMooc->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbMoocName", "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($moocId != "") ? $mooc->Name->Value : "") ),
                                          array("Type"=>"TextArea", "Name"=> "tbMoocDescription", "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($moocId != "") ? $mooc->Description->Value : "") ),
                                          array("Type"=>"EntityListBox", "Name"=> "lstCategory", "Libelle"=>$this->Core->GetCode("Category"), "Entity"=>"Apps\Mooc\Entity\MoocCategory", "Value" => ( ($moocId != "") ? $mooc->CategoryId->Value : "") ),
                                          array("Type"=>"Button", "CssClass" => "btn btn-success", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                              )
                    );

            return $jbMooc->Show();
        }

        /**
         * Charge les leçons d'un Mooc
         * @param type $moocId
         */
        function EditMooc($moocId)
        {
          $modele = new View(__DIR__ . "/View/EditMooc.tpl", $this->Core); 

          //Recuperation des formulaire du projet
          $moocs = MoocHelper::GetLesson($this->Core, $moocId, true);

          $modele->AddElement(new Text("moocId", false, $moocId));
          $modele->AddElement(new Libelle($this->Core->GetCode("Name"), "lbName" ));

          $modele->AddElement($moocs);

          //Ajout des formulaires
          $eform = DashBoardManager::GetApp("Form", $this->Core);
          $forms = $eform->GetByApp("Mooc", "MoocMooc", $moocId);

          //Mise en form
          foreach($forms as $form)
          {
            $html = "<div class='mooc lineFonce'>";
            $html .= $form->Libelle->Value."</div> ";
            $html .=" <div> ";
            $html .=" <span class='icon-edit' onclick='MoocAction.EditQuiz(".$moocId.", ".$form->IdEntite.");' title='".$this->Core->GetCode("Mooc.ShowAddQuiz")."' ></span> ";
            $html .="</div> ";
            $html .="</div> ";
          }
           $modele->AddElement(new Text("lstForm", false, $html));

          //Libelle sur les icones
          $modele->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Mooc.DetailMooc")));

          return $modele->Render();
        }

        /*
         * Pop in d'ajout/Modification d'une lesson
         */
        function ShowAddLesson($moocId, $lessonId)
        {
            $jbLesson = new AjaxFormBlock($this->Core, "jbLesson_". $lessonId);
            $jbLesson->App = "Mooc";
            $jbLesson->Action = "SaveLesson";

            $jbLesson->AddArgument("moocId", $moocId);

            if($lessonId != "")
            {
              $lesson = new MoocLesson($this->Core);
              $lesson->GetById($lessonId);

              $jbLesson->AddArgument("lessonId", $lessonId);

            }

            $jbLesson->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbLessonName_".$lessonId, "Libelle" => $this->Core->GetCode("Name"), "Value" => ( ($lessonId != "") ? $lesson->Name->Value : "") ),
                                          array("Type"=>"TextBox", "Name"=> "tbLessonVideo_".$lessonId, "Libelle" => $this->Core->GetCode("video"), "Value" => ( ($lessonId != "") ? $lesson->Video->Value : "") ),
                                          array("Type"=>"CheckBox", "Name"=> "cbActif_".$lessonId, "Libelle" => $this->Core->GetCode("Actif"), "Value" => ( ($lessonId != "") ? $lesson->Actif->Value : "") ),
                                          array("Type"=>"TextArea", "Name"=> "tbLessonDescription_".$lessonId, "Libelle" => $this->Core->GetCode("description"), "Value" => ( ($lessonId != "") ? $lesson->Description->Value : "") ),
                                          array("Type"=>"TextArea", "Name"=> "tbLessonContent_".$lessonId, "Libelle" => $this->Core->GetCode("content"), "Value" => ( ($lessonId != "") ? $lesson->Content->Value : "") ),
                                          array("Type"=>"Button", "CssClass" => "btn btn-success", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save"), "OnClick" => "MoocAction.SaveLesson(".$moocId.", ".$lessonId.")"),
                              )
                    );


            return "<br/><h2>Lesson</h2>" .$jbLesson->Show() . $this->GetElements($lessonId);
        }


        /*
         * Obtient les élements liées à la lesson
         * Soit un formulaire/ des vidéo des fichiers.
         */
        function GetElements($lessonId, $show = true)
        {
            if($show)
            {
              $html = "<div id='dvElement_".$lessonId."' >";
            }

            $html .= "<h3>".$this->Core->GetCode("Elements")."</h3>";

            $btnAddElement = new Button(BUTTON);
            $btnAddElement->Value = $this->Core->GetCode("AddElement");
            $btnAddElement->CssClass = "btn btn-info";
            $btnAddElement->OnClick = "MoocAction.ShowAddElement(".$lessonId.")";

            $html .= $btnAddElement->Show();

            //Obtient les formulaire
            $eForm = DashBoardManager::GetApp("Form", $this->Core);
            $forms = $eForm->GetByApp("Mooc", "MoocLesson", $lessonId);

            $html .= "<ul>";

            if(count($forms) > 0)
            {
                foreach($forms as $form)
                {
                   $html .= "<li onclick='MoocAction.EditQuiz(".$lessonId.", ".$form->IdEntite.")' >".$form->Libelle->Value."</li>" ;
                }
            }

            $html.= "</ul>";

            if($show)
            {
              $html .= "</div>";
            }

            return $html;
        }

        /*
         * Pop in d'ajout d'element
         */
        function ShowAddElement($lessonId)
        {
            $html = "<div id='dvAddElement' >";

            $lstType = new ListBox("lstTypeElement");
            $lstType->Add($this->Core->GetCode("Form"), 0);
            $html .= $lstType->Show();

            $tbName = new TextBox("tbNameElement");
            $html .= $tbName->Show();

            $btnSave = new Button(BUTTON);
            $btnSave->Value = $this->Core->GetCode("Save");
            $btnSave->CssClass = "btn btn-success";
            $btnSave->OnClick = "MoocAction.AddElement(".$lessonId.")";
            $html .= $btnSave->Show();

            $html .= "</div>";
            return $html;
        }

        /*
         * Lance un mooc
         */
        function StartMooc($moocId, $front = false)
        {
         $modele = new View(__DIR__ . "/View/StartMooc.tpl", $this->Core); 

          //Lien pour ovurir le mooc dans un nouvel onglet
          $modele->AddElement(new Text("lkNewWindow" , false, "../app-Mooc-".$moocId.".html"));

          //Recuperation des lessons
          $lessons = MoocHelper::GetLesson($this->Core, $moocId, true, true);
          $modele->AddElement($lessons);

          $mooc = new MoocMooc($this->Core);
          $mooc->GetById($moocId);

           //Ajout des formulaires
          $eform = DashBoardManager::GetApp("Form", $this->Core);
          $forms = $eform->GetByApp("Mooc", "MoocMooc", $moocId);

          //Mise en form
          foreach($forms as $form)
          {

             $html = "<li title='".$form->Libelle->Value."' > ";
             $html .= "<a href='#' onclick='MoocAction.LoadQuiz(".$form->IdEntite.");' > ".$form->Libelle->Value."  </a>";
             $html .= "</li> ";
          }

          $modele->AddElement(new Text("lstForm", false, $html));

          $modele->AddElement(new Text("MoocName", false, $mooc->Name->Value));
          $modele->AddElement(new Text("MoocDescription", false, $mooc->Description->Value));

          //Lecon Un
          $modele->AddElement(new Text("lessonOne", false, $this->LoadLesson($lessons[0]->IdEntite)));

          return $modele->Render();
        }

        /*
         * Charge une lesson
         */
        public function LoadLesson($lessonId)
        {
            $lesson = new MoocLesson($this->Core);
            $lesson->GetById($lessonId);

            $html = "  <h4>".$this->Core->GetCode("Mooc.Lesson")."  : ".$lesson->Name->Value."</h4>";

            if(Application::InFront())
            {
              $html .= str_replace("../Data/", "Data/", $lesson->Content->Value);
            }
            else
            {
              $html .= $lesson->Content->Value;
            }
            //Recuperation des formulaires
            $eform = DashBoardManager::GetApp("Form", $this->Core);
            $forms = $eform->GetByApp("Mooc", "MoocLesson", $lessonId);

            if(count($forms) > 0)
            {
                $html .= "<h3>".$this->Core->GetCode("Quiz")."</h3>";

                foreach($forms as $form)
                {
                  $eform->IdEntity = $form->IdEntite;
                  $html .= $eform->Display();
                }
            }
            return $html;
        }

        /**
       * Pop in d'ajout de quizz (Form)
       * @param type $quizId
       */
      public function ShowAddQuiz($moocId)
      {
            $jbForm = new AjaxFormBlock($this->Core, "jbForm");
            $jbForm->App = "Mooc";
            $jbForm->Action = "SaveQuiz";

            //Ajout du group
            $jbForm->AddArgument("MoocId", $moocId);

            $jbForm->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbFormLibelle", "Libelle" => $this->Core->GetCode("Title") ),
                                          array("Type"=>"TextArea", "Name"=> "tbFormCommentaire", "Libelle" => $this->Core->GetCode("Description")),
                                          array("Type"=>"Button", "CssClass"=>"btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                              )
                    );

            return $jbForm->Show();
      }

        /*action*/
          
 }?>