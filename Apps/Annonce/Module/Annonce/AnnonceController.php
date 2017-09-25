<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Annonce\Module\Annonce;

use Apps\Annonce\Entity\AnnonceAnnonce;
use Apps\Annonce\Helper\AnnonceHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\ZoomInIcone;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Utility\Format\Format;
use Core\View\View;
use Core\Control\Icone\EditIcone;
use Core\Control\Link\Link;
use Core\Control\Text\Text;
use Core\Control\TextArea\TextArea;


 class AnnonceController extends Controller
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
     * Popin d'ajout d'annonce
     */
    function ShowAddAnnonce($annonceId)
    {
        $jbAnnonce = new AjaxFormBlock($this->Core, "jbAnnonce");
        $jbAnnonce->App = "Annonce";
        $jbAnnonce->Action = "SaveAnnonce";

        if($annonceId != null)
        {
           $annonce = new AnnonceAnnonce($this->Core); 
           $annonce->GetById($annonceId);

           $jbAnnonce->AddArgument("annonceId", $annonceId);
        }

        $jbAnnonce->AddControls(array(
                                      array("Type"=>"TextBox", "Name"=> "tbTitle", "Libelle" => $this->Core->GetCode("Title") , "Value" => ($annonceId != "")?$annonce->Title->Value :""),
                                      array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => ($annonceId != "")?$annonce->Description->Value :""),
                                      array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save"), "CssClass" =>"btn btn-primary" ),
                          )
                );

        return $jbAnnonce->Show();
    }

    /**
     * Affiche les annnonces de l'utilisateur
     */
    function ShowMyAnnonce()
    {
      $modele = new View(__DIR__. "/View/LoadAnnonce.tpl", $this->Core);

      $annonces = AnnonceHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
      $eeprofil = DashBoardManager::GetApp("Profil", $this->Core);

      if(count($annonces) > 0)
      {
          foreach($annonces as $annonce)
          {
             $html .= $this->RenderAnnonce($annonce, $eeprofil, true);
          }
      }
      else
      {
          $html .= $this->Core->GetCode("Annonce.NoAnnonce");
      }

      $modele->AddElement(new Text("lines", false, $html ));
      return $modele->Render();
    }

    /**
     * Affiches les annonces
     */
    function ShowAnnonces($annonceId)
    {
      $modele = new View(__DIR__ . "/View/LoadAnnonce.tpl", $this->Core);
      $eeprofil = DashBoardManager::GetApp("Profil", $this->Core);

        if($annonceId != "")
        {
          $annonces = AnnonceHelper::GetById($this->Core, $annonceId);
        }
        else
        {
          $annonces = AnnonceHelper::GetByArg($this->Core, $this->Core->User->IdEntite);
        }

      if(count($annonces) > 0)
      {
          foreach($annonces as $annonce)
          {
             $html .= $this->RenderAnnonce($annonce, $eeprofil, true);
          }
      }
      else
      {
          $html .= $this->Core->GetCode("Annonce.NoAnnonce");
      }

      $modele->AddElement(new Text("lines", false, $html ));
      return $modele->Render();

  }

    /**
     * Affiche l'annonce
     * @param type $annonce
     */
    function RenderAnnonce($annonce, $eeprofil, $showAll= true, $class="")
    {
       if($showAll)
       {
          $html .= "<tr class='annonce ".$class."' id='dvAnnonce_".$annonce->IdEntite."'  >";
       }

       $html .= "<td>".$eeprofil->GetProfil($annonce->User->Value)."</td>";


        //Reponses
        $reponses = AnnonceHelper::GetReponse($this->Core, $annonce);

        $html .= "<td class='lstMessage' id='spMessage_".$annonce->IdEntite."' >";
            //Lien pour afficher le détail
         $lkDetail = new Link($annonce->Title->Value, "#");
         $lkDetail->OnClick ="AnnonceAction.ShowDetail(".$annonce->IdEntite.", this)";
         $html .= $lkDetail->Show();

        if(count($reponses) > 0)
        {
            foreach($reponses as $reponse)
            {
                $html .= "<div class='reponse'>";
                $html .= $eeprofil->GetProfil($reponse->User->Value);
                $html .= "<div class='date'>".$reponse->DateCreated->Value."</div>";

                $html .= "<div class='reponse'>".  Format::Tronquer($reponse->Reponse->Value, 150)."</div>";

               if($annonce->UserId->Value == $this->Core->User->IdEntite)
               {
                   $icEdit = new ZoomInIcone();
                   $icEdit->Title = $this->Core->GetCode("Read");
                   $icEdit->OnClick = "AnnonceAction.EditReponse(".$reponse->IdEntite.")";
                   $html .= $icEdit->Show();
               }

                $html .= "</div>";
            }
         }

         $html .= "</td>";


        //Si c'est le créateur il peit modifier ou supprimer le message
        if($annonce->UserId->Value == $this->Core->User->IdEntite)
        {
            $icEdit = new EditIcone();
            $icEdit->Title = $this->Core->GetCode("Modify");
            $icEdit->OnClick = "AnnonceAction.EditAnnonce(".$annonce->IdEntite.")";
            $html .= "<td>".$icEdit->Show()."</td>";
        }
        else
        {
            $btnReponse = new Button(BUTTON);
            $btnReponse->Value = $this->Core->GetCode("Annonce.AddResponse");
            $btnReponse->OnClick = "AnnonceAction.ShowAddResponse(".$annonce->IdEntite.")";

            $html .= "<td>".$btnReponse->Show()."</td>";
        }

         if($showAll)
         {
          $html .= "</tr>";
         }

         return $html;
    }

    /*
     * pop in d'ajout de reponse
     */
    function ShowAddResponse($annonceId)
    {
        $jbAnnonce = new AjaxFormBlock($this->Core, "jbAnnonce");
        $jbAnnonce->App = "Annonce";
        $jbAnnonce->Action = "SaveReponse";

        $jbAnnonce->AddArgument("AnnonceId", $annonceId);

        $jbAnnonce->AddControls(array(
                                      array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Message"), "Value" => ($annonceId != "")?$annonce->Description->Value :""),
                                      array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save"), "CssClass" => "btn btn-primary"),
                          )
                );

        return $jbAnnonce->Show();
    }

    /**
     * Obtient les réponses à une annonce
     * @param type $annonceId
     */
    function GetReponse($annonceId)
    {
        $html = "";

        //Reponses
        $reponses = AnnonceHelper::GetReponse($this->Core, $annonceId);
        $eeprofil = DashBoardManager::GetApp("Profil", $this->Core);

        if(count($reponses) > 0)
        {
            foreach($reponses as $reponse)
            {
                $html .= "<div class='reponse'>";
                $html .= $eeprofil->GetProfil($reponse->User->Value);
                $html .= "<div class='date'>".$reponse->DateCreated->Value."</div>";

                $html .= "<div class='reponse'>".Format::Tronquer($reponse->Reponse->Value, 150)."</div>";
                $html .= "</div>";
            }
         }

         return $html;
    }

    /**
     * Affiche le détail d'un annonce
     * @param type $annonceId
     */
    function ShowDetail($annonceId)
    {
        $annnonce = new AnnonceAnnonce($this->Core);
        $annnonce->GetById($annonceId);

        $html .= "<div style='text-align:left'> ";
        $html .= "<h4><b class='blueOne' >".$this->Core->GetCode("Title")." : </b>". $annnonce->Title->Value."</h4>";
        $html.= "<p><h4 class='blueOne' >".$this->Core->GetCode("Description")." : </h4>".$annnonce->Description->Value."</p>";
        $html.= "</div>";

        return $html;
    }

    /**
     * Affiche lde détail d'une reponse avec la possibilité d'envoyer un message
     */
    function GetDetailReponse($reponseId)
    {
        $html = "";

        $html .= AnnonceHelper::GetDetailReponse($this->Core, $reponseId);

        //Champ pour envyer un messahe
        $html .= "<div id='dvMessageAnnonce'><h3>".$this->Core->GetCode("Annonce.SendMessage")."</h3>";

        //Message
        $tbMessage = new TextArea("tbMessageAnnonce");
        $html .= $tbMessage->Show();

        //Action ajax
        $action = new AjaxAction("Annonce", "SendMessage");
        $action->AddArgument("App", "Annonce");
        $action->AddArgument("ReponseId", $reponseId);

        $action->ChangedControl = "dvMessageAnnonce";
        $action->AddControl($tbMessage->Id);

        //Bouton 
        $btnSend = new Button(BUTTON);
        $btnSend->CssClass = "btn btn-primary";
        $btnSend->Value = $this->Core->GetCode("Send");
        $btnSend->OnClick = $action;

        $html .= $btnSend->Show();

        $html .= "</div>";

        return $html;
    }
 }?>