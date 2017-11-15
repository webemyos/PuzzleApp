<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Forum;

use Apps\Forum\Entity\ForumCategory;
use Apps\Forum\Entity\ForumForum;
use Apps\Forum\Entity\ForumMessage;
use Apps\Forum\Helper\MessageHelper;
use Apps\Forum\Modele\MessageModele;
use Apps\Forum\Modele\ReponseModele;
use Apps\Profil\Profil;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;
use Core\View\ElementView;
use Core\View\View;


 class ForumController extends Controller
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
         * Popin de création de forum
         */
        function ShowAddForum($forumId, $appName, $entityName, $entityId)
        {
            $jbForum = new AjaxFormBlock($this->Core, "jbForum");
            $jbForum->App = "Forum";
            $jbForum->Action = "SaveForum";

            if($forumId != "")
            {
                $jbForum->AddArgument("ForumId", $forumId);
                
            }
            
            //App liée
            $jbForum->AddArgument("AppName", $appName);
            $jbForum->AddArgument("EntityName", $entityName);
            $jbForum->AddArgument("EntityId", $entityId);

            $jbForum->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name")),
                                          array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description")),
                                          array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                              )
                    );

            return $jbForum->Show();
        }

        /**
         * Charge les forums de l'utilisateur
         */
        function LoadMyForum()
        {
            $html ="";

            $forum = new ForumForum($this->Core); 
            $forum->AddArgument(new Argument("Apps\Forum\Entity\ForumForum", "UserId", EQUAL, $this->Core->User->IdEntite));
            $forums = $forum->GetByArg();

            if(count($forums)> 0)
            {
                //Ligne D'entete
                $html .= "<div class='forum'>";
                $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Forum.Name")."</b></div>";
                $html .= "</div>"; 

                foreach($forums as $forum)
                {
                   $html .= "<div class='forum'>";

                   //Lien pour afficher le détail
                   $lkDetail = new Link($forum->Name->Value, "#");
                   $lkDetail->OnClick ="ForumAction.LoadForum(".$forum->IdEntite.", this)";

                   $html .= "<div> ".$lkDetail->Show() ."</div>";
                   $html .= "</div>";
                }
            }
            else
            {
                $html = $this->Core->GetCode("Forum.NoForum");
            }

            return $html;
        }

        /**
         * Affiche le forum
         */
        function LoadForum($forumId)
        {
            $forum = new ForumForum($this->Core);
            $forum->GetById($forumId);

            //Creation d'un tabstrip
            $tbForum = new TabStrip("tbForum", "Forum");

            //Ajout des onglets
            $tbForum->AddTab($this->Core->GetCode("Property"), $this->GetTabProperty($forum, $forumId));
            $tbForum->AddTab($this->Core->GetCode("Category"), $this->GetTabCategory($forum, $forumId));
           // $tbForum->AddTab($this->Core->GetCode("Lecteur"), $this->GetTabLecteur($forum));
           // $tbForum->AddTab($this->Core->GetCode("Articles"), $this->GetTabArticles($forum));

            return $tbForum->Show();
        }

         /**
         * Obtient les propriétés du forum
         */
        function GetTabProperty($forum, $forumId)
        {
            $jbForum = new AjaxFormBlock($this->Core, "jbForum");
            $jbForum->App = "Forum";
            $jbForum->Action = "UpdateForum";

            if($forum == "")
            {
               $forum  = new ForumForum($this->Core);
               $forum->GetById($forumId);
            }

            $jbForum->AddArgument("forumId", $forum->IdEntite); 

            $jbForum->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name"), "Value" => $forum->Name->Value),
                                          array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => $forum->Description->Value),
                                          array("Type"=>"Button", "CssClass"=>"btn btn-primary",  "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                              )
                    );

            return new Libelle($jbForum->Show());
        }

        /**
         * Obtient toutes les catégorie du forum
         * @param type $forum
         */
        function GetTabCategory($forum, $forumId)
        {
            $html = "";

            //Ajout d'article
            $btnNew = new Button(BUTTON);
            $btnNew->Value = $this->Core->GetCode("Forum.NewCategory");
            $btnNew->CssClass = "btn btn-info";
            $btnNew->OnClick = "ForumAction.ShowAddCategory(". $forumId.");";

            $html .= $btnNew->Show();

            //Recuperation des articles
            $category = new ForumCategory($this->Core);
            $category->AddArgument(new Argument("Apps\Forum\Entity\ForumCategory", "ForumId", EQUAL,  $forumId ));
            $categorys = $category->GetByArg();

            if(count($categorys) > 0)
            {
                //Ligne D'entete
                $html .= "<div class='forum'>";
                $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Forum.Name")."</b></div>";

                $html .= "</div>"; 

                foreach($categorys as $category)
                {
                     $html .= "<div class='forum'>";
                     $html .= "<div >".$category->Name->Value."</div>";

                     //Lien pour afficher le détail
                     $icEdit = new EditIcone();
                     $icEdit->OnClick = "ForumAction.ShowAddCategory(".$forum->IdEntite.", '".$category->IdEntite."');";

                     $html .= "<div >".$icEdit->Show()."</div>";

                     //Suppression
                     $icDelete = new DeleteIcone();
                     $icDelete->OnClick = "ForumAction.DeleteCategory(this, '".$category->IdEntite."')";
                     $html .= "<div >".$icDelete->Show()."</div>";

                     $html .= "</div>";
                }
            }

            return new Libelle($html);
        }

        /**
         * Affiche un forum
         * @param type $forum
         * @param type $idEntite
         * @param type $category
         */
        function ShowForum($name, $idEntite, $category, $sujet, $front = true)
        {
            if($sujet != "")
            {
                return $this->ShowMessage($sujet, $front);
            }
            else if($category != "" )
            {
                if(!$front)
                {
                  return $this->ShowMessages("", $category, false, $front);
                }
                else
                {
                  return $this->ShowMessages($category, null, true, $front);
                }
            }
            else
            {
               return $this->ShowCategorie($name, $front);
            }
        }

        /**
         * Affiche les categorie du forum ainsi que le nombre de message
         * @return type
         */
        function ShowCategorie($name, $front)
        {
            $view = new View(__DIR__."/View/ShowCategory.tpl", $this->Core);
            
            //Recuperation du forum
            $forum = new ForumForum($this->Core);
            $forum = $forum->GetByName($name);

            //Titre et description
            if($front)
            {
                $this->Core->MasterView->Set("Title", "Forum");
                $this->Core->MasterView->Set("Title", $forum->Description->Value);
            }
     
            $view->AddElement(new ElementView("Forum", $forum));
            
            //Affichage des categories avec le nombre de message
            $categorie = new ForumCategory($this->Core);
            $categorie->AddArgument(new Argument("Apps\Forum\Entity\ForumCategory", "ForumId", EQUAL, $forum->IdEntite));
            $categories = $categorie->GetByArg();

            $view->AddElement(new ElementView("Category", $categories));
            
            return $view->Render();
        }

        /*
         * Affiche les messages d'une categorie
        */
        function ShowMessages($categorieName, $categorieId = null, $showTitle = true, $front =false)
        {
            //Recupertion de la catégorie
            $categorie = new ForumCategory($this->Core);

            if($categorieId != null)
            {
               $categorie->GetById($categorieId); 
            }
            else
            {
               $categorie = $categorie->GetByCode($categorieName);
            }
            
            //Titre et description on The Front page
            if($showTitle && $front)
            {
                $this->Core->MasterView->Set("Title", "Forum - categorie : " . $categorie->Name->Value);
                $this->Core->MasterView->Set("Title", $categorie->Description->Value);
            }
            
            $view = new View(__DIR__."/View/ShowMessages.tpl", $this->Core);
            $view->AddElement(new ElementView("Category", $categorie));
            $view->AddElement(new ElementView("Messages", MessageHelper::GetByCategory($this->Core, $categorie->IdEntite )));
            
            return $view->Render();
        }

       /*
      * Affiche un message et les réponses
      */
      function ShowMessage($sujet, $front)
      {
          //Recuperation du message
          $message = new ForumMessage($this->Core);
          $message->GetById($sujet);

          if($front)
          {
            $this->Core->MasterView->Set("Title", "Forum - Discussion : " . $message->Title->Value);
            $this->Core->MasterView->Set("Description", $message->Message->Value);
          }
          
          $view = new View (__DIR__ . "/View/ShowMessage.tpl", $this->Core);
          $view->AddElement(new ElementView("Message", $message));
          $view->AddElement(new ElementView("Connected", $this->Core->IsConnected()));
          
          //Modele for add Reponse
          $modele = new ReponseModele($this->Core);
          $modele->SetSujetId($message->IdEntite);
          $view->SetModel($modele);
          
          $view->AddElement(new ElementView("Reponses", MessageHelper::GetReponse($this->Core, $message->IdEntite)));
 
          return $view->Render();
      }

      /*
       * Affiche un message
       */
      function ShowMessageBlock($message, $eProfil, $front)
      {
          if($front)
          {
            $this->Core->MasterView->Set("Title", "Forum : " . $message->Title->Value);
            $this->Core->MasterView->Set("Title", $message->Message->Value);
          }

          $html = "<div class='forum'>";

           //Profile
          $html .= $eProfil->GetProfil($message->User->Value, "profil");

          $html .= "<div class='detail'>";
          $html .= "<div class='title'>";
          $html .= "<span>".$this->Core->GetCode("Form.Sujet"). " : " .$message->Title->Value . "</span>";
          $html .= "<span>".$this->Core->GetCode("Form.Date"). " : " .$message->DateCreated->Value . "</span>";
          $html .= "</div>";      

          $html .= "<div class='text'>".$message->Message->Value . "</div>";

          $html .= "</div>";      
          $html .= "</div>";      

          return $html ;
      }

      /*
       * Affiche les réponses
       */
      function ShowReponses($sujet, $eProfil)
      {
          $reponses = MessageHelper::GetReponse($this->Core, $sujet);

          foreach($reponses as $reponse)
          {
              $html .= "<div class='forum'>";

               //Profile
              $html .= $eProfil->GetProfil($reponse->User->Value, "profil");

              $html .= "<div class='detail'>";
              $html .= "<div class='title'>";
              $html .= "<span>".$this->Core->GetCode("Form.Date"). " : " .$reponse->DateCreated->Value . "</span>";
              $html .= "</div>";      

              $html .= "<div class='text'>".$reponse->Message->Value . "</div>";

              $html .= "</div>";      
              $html .= "</div>";      
          }

          return $html ;
      }

      /**
       * Affiche les boutons d'actions disponibles
       * @param type $sujet
       */
      function ShowBtnActions($sujet)
      {
          $html ="";

          $btnAddReponse = new Button(BUTTON);
          $btnAddReponse->CssClass = "btn btn-info";
          $btnAddReponse->OnClick ="ForumAction.ShowAddReponse(".$sujet.")";
          $btnAddReponse->Value = $this->Core->GetCode("Forum.AddReponse");

          $html .= $btnAddReponse->Show();

          return $html;
      }
      
      /*
       * Add A discussion
       */
      function NewDiscussion($params)
      {
          $view = new View(__DIR__."/View/newDiscussion.tpl", $this->Core);
         
          //Recuperation de la catégorie
          $category = new ForumCategory($this->Core);
          $category = $category->GetByCode($params);
          
          $view->AddElement(new ElementView("Category", $category));
          $view->AddElement(new ElementView("Connected", $this->Core->IsConnected()));
           
          //Add Message Modele
          $modele = new MessageModele($this->Core);
          $modele->SetCategory($category);
          $view->SetModel($modele);
          
          return $view->Render();
      }

          /*action*/
 }?>