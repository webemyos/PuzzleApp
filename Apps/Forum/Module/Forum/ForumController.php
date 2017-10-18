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
use Apps\Forum\Helper\CategoryHelper;
use Apps\Forum\Helper\MessageHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;


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
           //Recuperation du forum
            $forum = new ForumForum($this->Core);
            $forum = $forum->GetByName($name);

            //Titre et description
            if($front)
            {
              $this->Core->Page->Masterpage->AddBlockTemplate("!Title", "Forum : " . $forum->Name->Value);
              $this->Core->Page->Masterpage->AddBlockTemplate("!description", $forum->Description->Value);
            }

            //Titre et description
            $html = "<h1>".$forum->Name->Value."</h1>";
            $html .= "<p>".$forum->Description->Value."</p>";

            //Affichage des categories avec le nombre de message
            $categorie = new ForumCategory($this->Core);
            $categorie->AddArgument(new Argument("Apps\Forum\Entity\ForumCategory", "ForumId", EQUAL, $forum->IdEntite));

            $categories = $categorie->GetByArg();

            if(count($categories) > 0)
            {
                $html .= "<table class='forum'>";
                $html .= "<tr><th class='blueTree'><b>".$this->Core->GetCode("Forum.Name")."</b></th>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.Description")."</b></th>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.NbMessage")."</b></th>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.LastMessage")."</th>";

                $html .= "</tr>"; 

                foreach($categories as $categorie)
                {
                    if($front)
                    {
                      $lkDetail = new Link($categorie->Name->Value, "forum-".Format::ReplaceForUrl($categorie->Name->Value).".html");
                    }
                    else
                    {
                      $lkDetail = new Link($categorie->Name->Value, "#");
                      $lkDetail->OnClick= "ForumAction.ShowDefaultForum('', '".$categorie->IdEntite."')";
                    }

                    $html .= "<tr class='forum'>";
                    $html .= "<td >".$lkDetail->Show()."</td>";
                    $html .= "<td >".$categorie->Description->Value."</td>";
                    $html .= "<td >".CategoryHelper::GetNumberMessage($this->Core, $categorie->IdEntite)."</td>";

                     //Information du dernier message
                     $lastMessage = MessageHelper::GetLastMessage($this->Core, $categorie->IdEntite);
                     $html .= "<td class='detailMessage'>";

                     if($lastMessage != null)
                     {

                          if($front)
                          {
                              //lien direct
                              $lkSujet = new Link($lastMessage->Title->Value, "forum-sujet-".$lastMessage->IdEntite.".html");
                          }
                          else
                          {
                            $lkSujet = new Link($lastMessage->Title->Value, "#");
                            $lkSujet->OnClick= "ForumAction.ShowDefaultForum('','', '".$lastMessage->IdEntite."')";
                          }

                         $html .= "<span>".$lastMessage->User->Value->GetPseudo()."</span>";
                         $html .= "<span>".$lastMessage->DateCreated->Value."</span>";

                         $html .= "<span>".$lkSujet->Show()."</span>";
                     }
                     else
                     {
                         $html .= $this->Core->GetCode("Forum.NoMessage");
                     }
                     $html .= "</td>";

                     $html .= "</tr>";
                }
            }
            else
            {
                return $this->Core->GetCode("Forum.NoCategory");
            }

            $html .= "</table>";
            return $html; 
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
              $categorie->GetByName(str_replace("_", "-_",$categorieName));
            }
            //Titre et description
            if($showTitle && $front)
            {
              $this->Core->Page->Masterpage->AddBlockTemplate("!Title", "Forum - categorie : " . $categorie->Name->Value);
              $this->Core->Page->Masterpage->AddBlockTemplate("!description", $categorie->Description->Value);
            }

            $html ="<div id='dvMessage'>";

            //Titre et description
            $html .= "<h1>".$categorie->Name->Value."</h1>";
            $html .= "<p>".$categorie->Description->Value."</p>";

            //Lien vers la page de base
            $link = new Link("forum", "forum.html");
            $html .= "<p>".$link->Show()."</p>";


            //Bouton pour créer un sujet
            $btnAddSubjet = new Button(BUTTON);
            $btnAddSubjet->CssClass = "btn btn-info";
            $btnAddSubjet->Value = $this->Core->GetCode("Forum.CreateSujet");
            $btnAddSubjet->OnClick = "ForumAction.ShowAddSujet(".$categorie->IdEntite.")";

            $html .= "<br/>".$btnAddSubjet->Show();

            $messages = MessageHelper::GetByCategory($this->Core, $categorie->IdEntite );

            if(count($messages) > 0)
            {
                //entete
                $html .= "<table class='forum'><tr>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.Sujet")."</th></div>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.Date")."</th></div>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.NbReponse")."</th></div>";
                $html .= "<th class='blueTree'><b>".$this->Core->GetCode("Forum.LastReponse")."</th></div>";

                $html .= "</tr>"; 

                foreach($messages as $message)
                {
                     $html .= "<tr class='forum'>";

                     if($front)
                     {
                      //Lien pour afficher la discussion
                      $lkDetail = new Link($message->Title->Value, "forum-sujet-".$message->IdEntite.".html");
                     }
                     else
                     {
                          $lkDetail = new Link($message->Title->Value, "#");
                          $lkDetail->OnClick= "ForumAction.ShowDefaultForum('', '', '".$message->IdEntite."')";
                     }

                     $html .= "<td>".$lkDetail->Show()."</td>";
                     $html .= "<td>".$message->DateCreated->Value."</td>";
                     $html .= "<td>".MessageHelper::GetNumberReponse($this->Core, $message->IdEntite)."</td>";

                     $lastReponse = MessageHelper::GetLastReponse($this->Core, $message->IdEntite);

                     if($lastReponse != null)
                     {
                          $html .= "<td><span>".$lastReponse->User->Value->GetPseudo()."</span>";
                          $html .= "<span>".$lastReponse->DateCreated->Value."</span></td>";
                     }
                     else
                     {
                         $html .= "<td>".$this->Core->GetCode("Forum.NoReponse")."</td>";
                     }

                     $html .= "</tr>";
                }
            }
            else
            {
                $html .= "<br/>".$this->Core->GetCode("Forum.NoMessage");
            }

            $html .= "</table>";
            $html .= "</div>";

            return $html;
        }

       /*
      * Affiche un message et les réponses
      */
      function ShowMessage($sujet, $front)
      {
          $this->SetTemplate(__DIR__ . "/View/ShowMessage.tpl");

          //Recuperation de l'appli Profil
          $eProfil = new \Apps\Profil\Profil($this->Core);
          
          //Recuperation du message
          $message = new ForumMessage($this->Core);
          $message->GetById($sujet);

          //Lien vers la page de base
          $lkForum = new Link("forum", "forum.html");
          $filAriane = $lkForum->Show();

          //Lien vers la catégorie
          $lkCategory = new Link($message->Category->Value->Name->Value, "forum-".Format::ReplaceForUrl($message->Category->Value->Name->Value).".html");
          $filAriane .= " > " . $lkCategory->Show();

          $this->AddParameters(array(
                 '!filAriane' => $filAriane,
                 '!message' => $this->ShowMessageBlock($message, $eProfil, $front),
                 '!action' => $this->ShowBtnActions($sujet),
                 '!sujet' => $this->Core->GetCode("Forum.Sujet"),
                 '!reponses' => $this->Core->GetCode("Forum.Reponses"),
                 '!lstReponse' => $this->ShowReponses($sujet, $eProfil)
              ));
          return $this->Render();
      }

      /*
       * Affiche un message
       */
      function ShowMessageBlock($message, $eProfil, $front)
      {
          if($front)
          {
              //Titre et description
              $this->Core->Page->Masterpage->AddBlockTemplate("!Title", "Forum : " . $message->Title->Value);
              $this->Core->Page->Masterpage->AddBlockTemplate("!description", $message->Message->Value);
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

          /*action*/
 }?>