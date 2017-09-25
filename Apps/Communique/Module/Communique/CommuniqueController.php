<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Communique\Module\Communique;

use Apps\Communique\Entity\CommuniqueCampagne;
use Apps\Communique\Entity\CommuniqueCampagneEmail;
use Apps\Communique\Entity\CommuniqueCommunique;
use Apps\Communique\Helper\CampagneHelper;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\EmailBox\EmailBox;
use Core\Controle\EntityListBox\EntityListBox;
use Core\Control\Icone\ExchangeIcone;
use Core\Control\Icone\HomeIcone;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Control\TextBox\TextBox;


class CommuniqueController extends Controller
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
    * Popin de création de blog
    */
   function ShowAddCommunique($appName, $entityName, $entityId)
   {
       $jbCommunique = new AjaxFormBlock($this->Core, "jbCommunique");
       $jbCommunique->App = "Communique";
       $jbCommunique->Action = "SaveCommunique";

       //App liée
       $jbCommunique->AddArgument("AppName", $appName);
       $jbCommunique->AddArgument("EntityName", $entityName);
       $jbCommunique->AddArgument("EntityId", $entityId);

       $jbCommunique->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbTitleCommunique", "Libelle" => $this->Core->GetCode("Name")),
                                     array("Type"=>"Button", "CssClass"=> "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbCommunique->Show();
   }

   /**
    * Charge les communique de l'utilisateur
    */
   function LoadMyCommunique()
   {
       $html ="<div class='content-panel'>";

       $communique = new CommuniqueCommunique($this->Core); 
       $communique->AddArgument(new Argument("CommuniqueCommunique", "UserId", EQUAL, $this->Core->User->IdEntite));
       $communique->AddOrder("Id");

       $communiques = $communique->GetByArg();

       if(count($communiques)> 0)
       {
           //Ligne D'entete
           $html .= "<div class='communique titleBlue'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Name")."</b></div>";
           $html .= "<div ><b>".$this->Core->GetCode("App")."</div>";

           $html .= "</div>"; 

           $i=0;
           foreach($communiques as $communique)
           {
              $html .= "<div class='communique'>";

              //Lien pour afficher le détail
              $lkDetail = new EditIcone();
              $lkDetail->Title = $this->Core->GetCode("Edit");
              $lkDetail->OnClick ="CommuniqueAction.LoadCommunique(".$communique->IdEntite.", this)";

              $html .= "<div class='name'> ".$communique->Title->Value."</div>";

              if($communique->AppName->Value != "")
              {
                  $img = new Image("../Apps/".$communique->AppName->Value."/images/logo.png");
                  $img->Title = $communique->AppName->Value;

                  $html .= "<div> ".$img->Show()."</div>";
              }
              else
              {
                  $html .= "<div> </div>";
              }

              $html .= "<div> ".$lkDetail->Show() ."</div>";
              $html .= "</div>";
           }
       }
       else
       {
           $html = $this->Core->GetCode("Communique.NoCommunique");
       }

       $html .= "</div>";
       return $html;
   }

   /**
    * Affiche le blog
    */
   function LoadCommunique($communiqueId)
   {
       $html ="";

       $communique = new CommuniqueCommunique($this->Core);
       $communique->GetById($communiqueId);

       //Creation d'un tabstrip
       $tbCommunique = new TabStrip("tbCommunique", "Communique");

       //Ajout des onglets
       $tbCommunique->AddTab($this->Core->GetCode("Property"), $this->GetTabProperty($communique, $communiqueId));
       $tbCommunique->AddTab($this->Core->GetCode("Contenu"), $this->GetTabContenu($communique));
       $tbCommunique->AddTab($this->Core->GetCode("Diffusion"), $this->GetTabDiffusion($communique));
       $tbCommunique->AddTab($this->Core->GetCode("Statistique"), $this->GetTabStatistique($communique));

      // $tbCommunique->AddTab($this->Core->GetCode("DiffusionBlog"), $this->GetTabDiffusionBlog($communique));

       return "<div class='content-panel'>".$tbCommunique->Show()."</div>";
   }

   /**
    * Obtient les propriétés du communique
    */
   function GetTabProperty($communique, $communiqueId)
   {
       $jbCommunique = new AjaxFormBlock($this->Core, "jbCommunique");
       $jbCommunique->App = "Communique";
       $jbCommunique->Action = "SaveCommunique";

       if($communique == "")
       {
          $communique  = new CommuniqueCommunique($this->Core);
          $communique->GetById($communiqueId);
       }

       $jbCommunique->AddArgument("CommuniqueId", $communique->IdEntite); 

       $jbCommunique->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbTitleCommunique", "Libelle" => $this->Core->GetCode("Title"), "Value" => $communique->Title->Value),
                                     array("Type"=>"Button",  "CssClass"=>"btn btn-primary" , "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return new Libelle($jbCommunique->Show());
   }


    /**
    * Obtient le contenu du communique
    */
   function GetTabContenu($communique)
   {
       $jbCommunique = new AjaxFormBlock($this->Core, "jbContentCommunique");
       $jbCommunique->App = "Communique";
       $jbCommunique->Action = "UpdateCommunique";

       $jbCommunique->AddArgument("CommuniqueId", $communique->IdEntite); 

       $jbCommunique->AddControls(array(
                                     array("Type"=>"TextArea", "Name"=> "tbContentCommunique", "Libelle" => $this->Core->GetCode("Content"), "Value" => str_replace("!et!", "&", $communique->Text->Value)),
                         )
               );

       return new Libelle($jbCommunique->Show());
   }


   /**
    * Diffuse le communiqué de presse a la liste des email selectionnés
    */
  function GetTabDiffusion($communique)
  {
      $html ="";


      $jbDiffusion = new Block("jbDiffusion");
      $jbDiffusion->Id = "jbDiffusion";

      //Liste disponible
      $lstList = new EntityListBox("lstList", $this->Core);
      $lstList->Entity = "CommuniqueListContact";
      $lstList->ListBox->Add($this->Core->GetCode("Communique.SelectList"),"");
      $lstList->AddArgument(new Argument("CommuniqueListContact", "UserId", EQUAL, $this->Core->User->IdEntite));
      $lstList->AddField("Name");

      $jbDiffusion->Add(new Libelle("<h3>".$this->Core->GetCode("Communique.ListDiffusion")."</h3>"));
      $jbDiffusion->Add($lstList);

      //Nom de l'expediteur
      $tbNameExpediteur = new TextBox("tbNameExpediteur");
      $tbNameExpediteur->PlaceHolder = "'" .$this->Core->GetCode("Communique.NameExpediteur")."'";
      $jbDiffusion->AddNew($tbNameExpediteur);

      //Expediteur
      $tbEmailExpediteur = new EmailBox("tbEmailExpediteur");
      $tbEmailExpediteur->PlaceHolder = "'".$this->Core->GetCode("Communique.EmailExpediteur")."'";
      $jbDiffusion->AddNew($tbEmailExpediteur);

      //Reply to
      $tbEmailReply = new EmailBox("tbEmailReply");
      $tbEmailReply->PlaceHolder =  "'".$this->Core->GetCode("Communique.EmailReplyTo")."'";
      $jbDiffusion->AddNew($tbEmailReply);

      //Action
      $action = new AjaxAction("Communique", "Diffuse");
      $action->AddArgument("App", "Communique");
      $action->AddArgument("CommuniqueId", $communique->IdEntite);

      $action->ChangedControl = "jbDiffusion";

      $action->AddControl($lstList->ListBox->Id);
      $action->AddControl($tbNameExpediteur->Id);
      $action->AddControl($tbEmailExpediteur->Id);
      $action->AddControl($tbEmailReply->Id);


      //Bouton de diffusion
      $btnDiffusion = new Button(BUTTON);
      $btnDiffusion->Value = $this->Core->GetCode("Diffuser");
      $btnDiffusion->OnClick = $action;
      $jbDiffusion->AddNew($btnDiffusion);

      return $jbDiffusion;
  }

  /*
   * Obtient les statistique d'envoie et d'ouverture d'email
   */
  function GetTabStatistique($communique)
  {
      $html = "";

      //Bouton pour rafrachir
      $btnRefresh = new ExchangeIcone();
      $btnRefresh->Title = $this->Core->GetCode("Refresh");
      $btnRefresh->OnClick = "CommuniqueAction.RefreshStatistique(".$communique->IdEntite.")";

      $html .= $btnRefresh->Show();

     //Recuperation des campagnes
      $campagne = new CommuniqueCampagne($this->Core);
      $campagne->AddArgument(new Argument("CommuniqueCampagne", "CommuniqueId", EQUAL,$communique->IdEntite ));
      $campagne->AddOrder("Id");

      $campagnes = $campagne->GetByArg();

       if(count($campagnes)> 0)
       {
           //Ligne D'entete
           $html .= "<div class='communique titleBlue'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Communique.Name")."</b></div>";
           $html .= "<div ><b>".$this->Core->GetCode("Date")."</div>";

           $html .= "<div >".$this->Core->GetCode("EmailSended")."</div>";
           $html .= "<div >".$this->Core->GetCode("EmailOpen")."</div>";
           $html .= "<div >".$this->Core->GetCode("NumberOpen")."</div>";
           $html .= "<div ></div>";

           $html .= "</div>"; 

           $i=0;
           foreach($campagnes as $campagne)
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

              $html .= "<div class='communique $class'>";
              $html .= "<div>".$campagne->Title->Value."</div>";
              $html .= "<div>".$campagne->DateSended->Value."</div>";

              //Recuperation des statistiques
              $stat = CampagneHelper::GetStatistique($this->Core, $campagne->IdEntite);

              $html .= "<div>".$stat["nbEmailSend"]."</div>";
              $html .= "<div>".$stat["nbEmailOpen"]."</div>";
              $html .= "<div>".$stat["nbOpen"]."</div>";

              //Bouton pour editer
              $btnEdit = new EditIcone();
              $btnEdit->Title = $this->Core->GetCode("Edit");
              $btnEdit->OnClick = "CommuniqueAction.EditCampagne(".$campagne->IdEntite.")";
              $html .= "<div>".$btnEdit->Show()."</div>";

              //Bouton pour supprime
              $btnDelete = new DeleteIcone();
              $btnDelete->Title = $this->Core->GetCode("Delete");
              $btnDelete->OnClick = "CommuniqueAction.DeleteCampagne(".$campagne->IdEntite.", this)";
              $html .= "<div>".$btnDelete->Show()."</div>";

              $html .= "</div>";

              }
       }
       else
       {
           $html .= $this->Core->GetCode("Communique.NoCampagne");
       }
      return new Libelle($html);
  }

  /**
   * Permet de transferer le contenu du communique 
   * sur les blog pour envoi (Page Contact) 
   * @param type $communique
   */
  function GetTabDiffusionBlog($communique)
  {
      $tbName = new TextBox("tbName");
      $tbName->PlaceHolder = $this->Core->GetCode("Name");
      $html .= $tbName->Show();

      $tbEmail = new TextBox("tbName");
      $tbEmail->PlaceHolder = $this->Core->GetCode("Email");
      $html .= $tbEmail->Show();

     //Bouton d'accueil
      $homeIcone = new HomeIcone();
      $homeIcone->OnClick = "CommuniqueAction.LoadHomeFrame()";

      $html .= $homeIcone->Show();

      $html .= "<br/><iframe src='http://bing.com' style='width:100%;height :400px' id='frBlog'></iframe>";

      return new Libelle($html);
  }

  /**
   * Affiche le détail d'un campagne
   */
  function EditCampagne($campagneId)
  {
      $email = new CommuniqueCampagneEmail($this->Core);
      $email->AddArgument(new Argument("CommuniqueCampagneEmail", "CampagneId", EQUAL, $campagneId ));
      $emails = $email->GetByArg();

      if(count($emails) > 0)
      {
          $html .= "<table style='width:500px' ><tr>";
           $html .= "<th>".$this->Core->GetCode("EmailSended")."</th>";
           $html .= "<th>".$this->Core->GetCode("DateOpen")."</th>";
           $html .= "<th>".$this->Core->GetCode("EmailOpen")."</th>";
           $html .= "</tr>"; 

           foreach($emails as $email)
           {
                $html .= "<tr>";
                 $html .= "<td>".$email->Email->Value."</td>";
                 $html .= "<td>".$email->DateOpen->Value."</td>";
                 $html .= "<td>".$email->NumberOpen->Value."</td>";

                 $html .= "</tr>"; 

           }
           $html .= "</table>";

           return $html;
      }
      else
      {
          return $this->Core->GetCode("Communique.NoEmail");
      }
  }
}
