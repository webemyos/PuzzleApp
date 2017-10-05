<?php
/*
 * 
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Pad\Module\Document;

use Apps\Downloader\Entity\PadDocument;
use Apps\Pad\Helper\DocumentHelper;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ShareIcone;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\TabStrip\TabStrip;
use Core\Controller\Controller;
use Core\Dashboard\DashBoardManager;
use Core\Entity\Entity\Argument;


class DocumentController extends Controller
{
     /**
    * Constructeur
    */
   function __constructeur($core="")
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
    * POp in de creation de document
    */
   function ShowAddDoc($appName, $entityName, $entityId)
   {
       $html ="";

       $jbFile = new AjaxFormBlock($this->Core, "jbFile");
       $jbFile->App = "Pad";
       $jbFile->Action = "SaveDoc";

        //App liée
       $jbFile->AddArgument("AppName", $appName);
       $jbFile->AddArgument("EntityName", $entityName);
       $jbFile->AddArgument("EntityId", $entityId);

       $jbFile->AddControls(array(
                         array("Type"=>"TextBox", "Name"=> "tbDocName", "Libelle" => $this->Core->GetCode("Name") ),
                         array("Type"=>"Button", "CssClass"=> "btn btn-primary",  "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
             )
       );

       return $jbFile->Show();
   }

   /**
    * Charge les documents de l'utilisateur
    */
   function LoadMyDoc()
   {
       //Creation d'un tabstrip
       // Afin de pouvoir ouvrir plusieurs fichier en même temps
       $tbDocuments = new TabStrip("tbDoc", "Pad");

        //Recuperation des documents
       $document = new PadDocument($this->Core);
       $document->AddArgument(new Argument("PadDocument", "UserId", EQUAL, $this->Core->User->IdEntite));
       $documents = $document->GetByArg();

       //Ajout des onglets
       $tbDocuments->AddTab($this->Core->GetCode("Doc"), $this->GetTabDocuments($documents, "LoadMyDoc"));

       return $tbDocuments->Show();
   }

   /**
    * Charge les documents de l'utilisateur
    */
   function LoadSharedDoc()
   {
       //Creation d'un tabstrip
       // Afin de pouvoir ouvrir plusieurs fichier en même temps
       $tbDocuments = new TabStrip("tbDoc", "Pad");

       $documents = DocumentHelper::GetSharedDoc($this->Core);

       //Ajout des onglets
       $tbDocuments->AddTab($this->Core->GetCode("Doc"), $this->GetTabDocuments($documents, "LoadSharedDoc"));

       return $tbDocuments->Show();
   }


   /**
    * Obtient tout les documents de l'utilisateur
    */
   function GetTabDocuments($documents, $callBack)
   {
       $html="";

       if(count($documents) > 0)
       {
           //Ligne D'entete
           $html .= "<div class='document titleBlue'>";
           $html .= "<div >".$this->Core->GetCode("App")."</div>";
           $html .= "<div >".$this->Core->GetCode("Pad.Name")."</div>";
           $html .= "<div >".$this->Core->GetCode("Pad.Date")."</div>";
           $html .= "<div >".$this->Core->GetCode("Pad.User")."</div>";

           $html .= "</div>"; 
           $i = 0;

           foreach($documents as $document)
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

                $html .= "<div class='document $class'>";

                $html .= "<div class='name'>".$document->Name->Value."</div>";

                if($document->AppName->Value != "")
                {
                    $img = new Image("../Apps/".$document->AppName->Value. "/images/logo.png");
                    $img->Title = $document->AppName->Value;

                    $html .= "<div>".$img->Show()."</div>";
                }
                else
                {
                    $html .= "<div></div>";
                }

                $html .= "<div >".$document->DateCreated->Value."</div>";

                //Partage
                $html .= "<div>".$this->GetUser($document->IdEntite, false)."</div>";

                //Lien pour afficher le détail
                $icEdit = new EditIcone();
                $icEdit->OnClick = "PadAction.EditDocument(".$document->IdEntite.", '".$document->Name->Value."');";

                //Partage d'un document
                $icShare = new ShareIcone();
                $icShare->OnClick = "PadAction.ShowShareDocument(".$document->IdEntite.", '".$callBack."');";

                $html .= "<div >".$icEdit->Show().$icShare->Show()."</div>";

              //$html .= "<div> ".$lkDetail->Show() ."</div>";
              $html .= "</div>";
           }
       }
       else
       {
           $html .= $this->Core->GetCode("Pad.NoDocument");
       }

       return new Libelle($html);
   }

   /**
    * Edite un document
    * @param type $documentId
    */
   function EditDocument($documentId)
   {
       //Recuperation du contenu
       $document = new PadDocument($this->Core);
       $document->GetById($documentId);

       $jbDocument = new AjaxFormBlock($this->Core, "jbDocument");
       $jbDocument->App = "Blog";
       $jbDocument->Action = "SaveContentArticle";

       $jbDocument->AddArgument("DocumentId", $documentId);

       $jbDocument->AddControls(array(
                                     array("Type"=>"Hidden", "Name"=> "hdContentDocument" , "Value" => $documentId),
                                     array("Type"=>"TextArea", "Name"=> "tbContentDocument_".$documentId , "Value" => $document->Content->Value),
                                   //  array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                         )
               );

       return $jbDocument->Show();
   }

   /*
    * Pop in de partage de document
    */
   function ShowShareFile($DocId)
   {
         $html ="";

      //Recherche d'utilisateur
      $tbContact = new AutoCompleteBox("tbContact", $this->Core);
      $tbContact->PlaceHolder = $this->Core->GetCode("SearchUser");
      $tbContact->Entity = "User";
      $tbContact->Methode = "SearchUser";
      $tbContact->Parameter = "AddAction=PadAction.SelectUser(".$DocId.")";

      $html .= $tbContact->Show();

      $html .= $this->GetUser($DocId);

      return $html;
   }

    /**
   * Obtient les utilisateurs d'un dossier
   */
  function GetUser($DocId, $all =true)
  {
      if($all)
      {
         $html = "<div id='dvFolderUserShared'>";
      }

      $users = DocumentHelper::GetUser($this->Core, $DocId);

      if(count($users) > 0)
      {
          $eprofil = DashBoardManager::GetApp("Profil", $this->Core);

          foreach($users as $user)
          {
              //Probleme d'affichage avec les photo utilisateur
              if($all && 1==2)
              {
                 $html .= "<span class='col-md-2' style='border:1px solid grey;'>" .$eprofil->GetProfil($user->User->Value);
              }
              else
              {
                  $html .= "<span>".$user->User->Value->GetPseudo();
              }

              //Bouton de suppression
               $html .= "<i class='icon-remove' id='".$user->IdEntite."' title='".$this->Core->GetCode("File.RemoveUser")."' onclick='PadAction.RemoveUser(this)'  >&nbsp</i>";
               $html .=  "</span>";
          }
      }
      else
      {
          $html .= $this->Core->GetCode("File.NoPartage");
      }

      if($all)
      {
         $html .= "</div>";
      }
      return $html;
  }
}
