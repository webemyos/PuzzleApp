<?php

/*
 *  PuzzleApp
 *  Webemyos
 * Jérôme Oliva
 *
 */

namespace Apps\Devis\Module\Projet;

use Apps\Devis\Entity\DevisAsk;
use Apps\Devis\Entity\DevisDevis;
use Apps\Devis\Entity\DevisPrestationCategory;
use Apps\Devis\Entity\DevisProjet;
use Apps\Devis\Helper\PrestationHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\Button\Button;
use Core\Control\Icone\AddIcone;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Control\Text\Text;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\View\View;


class ProjetController extends Controller
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
    * Popin de création d'un projet
    */
   function ShowAddProjet()
   {
       $jbProjet = new AjaxFormBlock($this->Core, "jbProjet");
       $jbProjet->App = "Devis";
       $jbProjet->Action = "SaveProjet";

       $jbProjet->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbLibelle", "Libelle" => $this->Core->GetCode("Name")),
                                     array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description")),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbProjet->Show();
   }

   /**
    * Charge les commerce de l'utilisateur
    * @param type $all
    */
   function LoadMyProjet($all=false)
   {
       $view = new View(__DIR__ . "/View/LoadMyProjet.tpl", $this->Core); 

       $projet = new DevisProjet($this->Core); 
       $projet->AddArgument(new Argument("Apps\Devis\Entity\DevisProjet", "UserId", EQUAL, $this->Core->User->IdEntite));
       $projets = $projet->GetByArg();

       $view->AddElement(new Libelle($this->Core->GetCode("Name"), "lbName" ));

       $view->AddElement($projets);

         //Libelle sur les icones
       $view->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Commerce.LoadMyCommerce")));

       return $view->Render();
   }

   /**
    * Affiche le projet
    */
   function LoadProjet($projetId)
   {
       $projet = new DevisProjet($this->Core);
       $projet->GetById($projetId);

       //Creation d'un tabstrip
       $tbProjet = new TabStrip("tbProjet", "Devis");

       //Ajout des onglets
       $tbProjet->AddTab($this->Core->GetCode("Devis.Information"), $this->GetTabProperty($projet));
       $tbProjet->AddTab($this->Core->GetCode("Devis.Modele"), $this->GetTabModele($projet));
       $tbProjet->AddTab($this->Core->GetCode("Devis.Prestations"), $this->GetTabPrestation($projet));
       $tbProjet->AddTab($this->Core->GetCode("Devis.Ask"), $this->GetTabAsk($projet));
       $tbProjet->AddTab($this->Core->GetCode("Devis.Devis"), $this->GetTabDevis($projet));

       return $tbProjet->Show();
   }

   /*
    * Obtient les devis liés au projet et au réponse
    */
   function GetTabModele($projet)
   {
     $view = new View(__DIR__ . "/View/GetTabModele.tpl", $this->Core); 

     $view->AddElement(new Text("projetId", false, $projet->IdEntite));

      //Recuperation des seances du projet
     $seance = new DevisDevis($this->Core);
     $seance->AddArgument(new Argument("Apps\Devis\Entity\DevisDevis", "ProjetId", EQUAL, $projet->IdEntite));
     $seance->AddArgument(new Argument("Apps\Devis\Entity\DevisDevis", "IsModele", EQUAL, 1));

     $seances = $seance->GetByArg(false, true);

     $view->AddElement(new Libelle($this->Core->GetCode("Libelle"), "lbLibelle" ));

     $view->AddElement($seances);

     //Libelle sur les icones
     $view->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Devis.DetailModele")));

     return new Libelle($view->Render());
   }

   /*
    * Obtient les devis liés au projet et au réponse
    */
   function GetTabDevis($projet)
   {
     $view = new View(__DIR__. "/View/GetTabDevis.tpl", $this->Core); 

     $view->AddElement(new Text("projetId", false, $projet->IdEntite));

      //Recuperation des seances du projet
     $seance = new DevisDevis($this->Core);
     $seance->AddArgument(new Argument("Apps\Devis\Entity\DevisDevis", "ProjetId", EQUAL, $projet->IdEntite));
     $seance->AddArgument(new Argument("Apps\Devis\Entity\DevisDevis", "IsModele", EQUAL, 0));

     $seances = $seance->GetByArg(false, true);

     $view->AddElement(new Libelle($this->Core->GetCode("Libelle"), "lbLibelle" ));

     $view->AddElement($seances);

     //Libelle sur les icones
     $view->AddElement(new Text("lbTitleIconeEdit", false, $this->Core->GetCode("Devis.DetailModele")));

     return new Libelle($view->Render());
   }

   /**
    * Obtient les propriétés du projet
    */
   function GetTabProperty($projet)
   {
       $jbProjet = new AjaxFormBlock($this->Core, "jbProjet");
       $jbProjet->App = "Devis";
       $jbProjet->Action = "UpdateProjet";

       $jbProjet->AddArgument("projetId", $projet->IdEntite); 

       $jbProjet->AddControls(array(
                                     array("Type"=>"TextBox", "Name"=> "tbName", "Libelle" => $this->Core->GetCode("Name"), "Value" => $projet->Libelle->Value),
                                     array("Type"=>"TextArea", "Name"=> "tbDescription", "Libelle" => $this->Core->GetCode("Description"), "Value" => $projet->Description->Value),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass"=> "btn btn-primary",  "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return new Libelle($jbProjet->Show());
   }

   /**
    * Charge les onglets des pages
    * @param type $projet
    */
   function GetTabPrestation($projet)
   {
       //Ajout d'une catégorie de prestationj
       $btnNew = new Button(BUTTON);
       $btnNew->Value = $this->Core->GetCode("Devis.NewCategory");
       $btnNew->OnClick = "DevisAction.ShowAddCategory(". $projet->IdEntite.");";

       $html .= $btnNew->Show();

           //Recuperation des articles
       $category = new DevisPrestationCategory($this->Core);
       $category->AddArgument(new Argument("Apps\Devis\Entity\DevisPrestationCategory", "ProjetId", EQUAL,  $projet->IdEntite ));
       $categorys = $category->GetByArg();

       if(count($categorys) > 0)
       {
           //Ligne D'entete
           $html .= "<div class='category'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Devis.Libelle")."</b></div>";

           $html .= "</div>"; 

           foreach($categorys as $category)
           {
                $html .= "<div class='category'>";
                $html .= "<div >".$category->Libelle->Value."</div>";

                //Lien pour afficher le détail
                $icEdit = new EditIcone();
                $icEdit->OnClick = "DevisAction.ShowAddCategory(". $projet->IdEntite.", ".$category->IdEntite.");";
                $html .= "<div >".$icEdit->Show()."</div>";

                //Ajout de prestation
                $icAdd = new AddIcone($this->Core);
                $icAdd->Title = $this->Core->GetCode("Devis.AddPrestation");
                $icAdd->OnClick = "DevisAction.ShowAddPrestation(".$category->IdEntite.");";

                $html .= "<div >".$icAdd->Show();
                $html .= $this->GetPrestation($category);        

                $html .= "</div>";

                //Suppression
                $icDelete = new DeleteIcone();
                $icDelete->OnClick = "DevisAction.DeleteCategory(this, '".$category->IdEntite."')";
                $html .= "<div >".$icDelete->Show()."</div>";

                $html .= "</div>";
           }
       }

       return new Libelle($html);
   }

   /*
    * Obtient les prestations d'une catégorie
    */
   public function GetPrestation($category)
   {
       $html .= "<div id='lstPrestation$category->IdEntite'>";

        //Prestation de la categorie
        $prestations = PrestationHelper::GetByCategoryId($this->Core, $category->IdEntite);
        if(count($prestations) > 0 )
        {
             $html .= "<ul >";
             foreach($prestations as $prestation)
             {
                 $html .= "<li onclick='DevisAction.ShowAddPrestation(".$category->IdEntite.", ".$prestation->IdEntite.");' >".$prestation->Libelle->Value."</li>";
             }

             $html .= "</ul>";
        }

        $html .= "</div>";

        return $html;
   }

   /*
    * Pop in de demande de devis
    */
   function ShowAskDevis($prestationId)
   {
       $jbDevis = new AjaxFormBlock($this->Core, "jbDevis");
       $jbDevis->App = "Devis";
       $jbDevis->Action = "SaveAskDevis";

       $jbDevis->AddArgument("prestationId", $prestationId); 

       $jbDevis->AddControls(array(
                                     array("Type"=>"BsTextBox", "Name"=> "tbName", "Title" => $this->Core->GetCode("Devis.YourName")),
                                     array("Type"=>"BsTextBox", "Name"=> "tbEmail", "Title" => $this->Core->GetCode("Devis.YourEmail")),
                                     array("Type"=>"BsTextBox", "Name"=> "tbTelephone", "Title" => $this->Core->GetCode("Devis.YourPhone")),
                                     array("Type"=>"BsTextArea", "Name"=> "tbDevisDescription", "Title" => $this->Core->GetCode("Devis.ProjetDescription")),
                                     array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass"=> "btn btn-primary",  "Value" => $this->Core->GetCode("Send")),
                         )
               );

       return new Libelle($jbDevis->Show());
   }

   /*
    * Affiche les demandes de devis pour le projet courant
    */
   function GetTabAsk($projet)
   {
       $asks = PrestationHelper::GetAskByProjet($this->Core, $projet); 


       if(count($asks) > 0)
       {
           //Ligne D'entete
           $html .= "<div class='category'>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Devis.Prestation")."</b></div>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Devis.Name")."</b></div>";
           $html .= "<div class='blueTree'><b>".$this->Core->GetCode("Devis.Email")."</b></div>";

           $html .= "</div>"; 

           foreach($asks as $ask)
           {
                $html .= "<div class='category'>";
                $html .= "<div >".$ask->Prestation->Value->Libelle->Value."</div>";
                $html .= "<div >".$ask->Name->Value."</div>";
                $html .= "<div >".$ask->Email->Value."</div>";

                //Lien pour afficher le détail
                $icEdit = new EditIcone();
                $icEdit->OnClick = "DevisAction.EditAsk(".$ask->IdEntite.");";
                $html .= "<div >".$icEdit->Show()."</div>";

                $html .= "</div>";
           }
       }

       return new Libelle($html);
   }

   /*
    * Pop in d'edition d'une demande de devis
    */
   public function EditAsk($askId)
   {
       //Recuperation de la demand de devis
       $ask = new DevisAsk($this->Core);
       $ask->GetById($askId);

     //Passage des parametres à la vue
      $this->AddParameters(array('!name' => $ask->Name->Value,
                                 '!email' =>  $ask->Email->Value,                     
                                 '!phone' =>  $ask->Phone->Value,
                                 '!description'=> $ask->Description->Value   
                              ));

      $this->SetTemplate(__DIR__ . "/View/EditAsk.tpl");

         return $this->Render();
   }
          
}
