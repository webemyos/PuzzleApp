<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Home;

use Apps\Forum\Entity\ForumForum;
use Core\App\App;
use Core\Control\Button\Button;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\View\View;


 class HomeBlock extends Controller
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
          $modele = new View(__DIR__ . "/View/HomeBlock.tpl", $this->Core);

          $btnMyForum = new Button(BUTTON, "btnForum");
          $btnMyForum->Value = $this->Core->GetCode("Forum.MyForum");
          $btnMyForum->CssClass = "btn btn-info";
          $btnMyForum->OnClick = "ForumAction.ShowDefaultForum();";
          $modele->AddElement($btnMyForum);

          DashBoardManager::GetApp("App", $this->Core);

          if(App::isAdmin($this->Core, "App", $this->Core->UserId))
          {
              $btnAdmin = new Button(BUTTON, "btnAdmin");
              $btnAdmin->Value = "App.Admin";
              $btnAdmin->CssClass = "btn btn-danger";
              $btnAdmin->OnClick = "ForumAction.LoadAdmin();";
              $modele->AddElement($btnAdmin);
          }
          else
          {
              $modele->AddElement(new Text("btnAdmin"));
          }


              return $modele->Render();

          //Bouton pour créer un blog
          $btnNewForum = new Button(BUTTON);
          $btnNewForum->Value = $this->Core->GetCode("Forum.NewForum");
          $btnNewForum->OnClick = "ForumAction.ShowAddForum();";



          //Passage des parametres à la vue
          $this->AddParameters(array('!titleHome' => $this->Core->GetCode("Forum.TitleHome"),
                                      '!messageHome' => $this->Core->GetCode("Forum.MessageHome"),
                                      '!btnNewForum' =>  $btnNewForum->Show(),                     
                                      '!btnMyForum' => $btnMyForum->Show(),
                                      ));

          $this->SetTemplate(Forum::$Directory . "/Blocks/HomeBlock/View/HomeBlock.tpl");

          return $this->Render();
        }


      /*
      *Expliquer la fonction de cette action
      */
       function ShowHome()
      {
               $this->SetTemplate(__DIR__. "/View/ShowHome.tpl");
               $this->AddParameters(array("!title" => $this->Core->GetCode("Forum.Title") ));
               return $this->Render();
      }
      /*action*/
 }?>