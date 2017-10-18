<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Profil\Module\Information;

use Apps\Profil\Profil;
use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Button\Button;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\ToolTip\ToolTip;
use Core\Control\Upload\Upload;
use Core\Controller\Controller;



 class InformationController extends Controller
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

   /*
   * Charge les informations du profil
   */
   function Load($showTemplate)
   {
       if($showTemplate)
       {
          $this->SetTemplate(__DIR__ . "/View/Load.tpl");

          $this->AddParameters(array('!detail' => $this->GetInformation() ));

          return $this->Render();
       }
       else
       {
           return $this->GetInformation();
       }
   }

   /**
    * Affiche les champs des informations
    */
   function GetInformation()
   {
       //Module d'info
       $jbInfo = new Block($this->Core, "jbInfo");
       $jbInfo->Frame =false;
       $jbInfo->Table  = true;

       //info de l'utilisateur
       $jbInfo->AddNew($this->Core->User->FirstName);
       $jbInfo->AddNew($this->Core->User->Name);

       $jbInfo->AddNew($this->Core->User->Description);

       //Ville
       $tbCity = new AutoCompleteBox("tbCity",$this->Core);
       $tbCity->Libelle = $this->Core->GetCode("City");
       $tbCity->Entity = "City";
       $tbCity->Methode = "SearchCity";
       $tbCity->Value = $this->Core->User->City->Value->Name->Value;
       $tbCity->AutoComplete = false;
       $tbCity->AddStyle("width","180px");
       $jbInfo->AddNew($tbCity);

       //Sauvegarde
       $action = new AjaxAction("Profil", "SaveInformation");
       $action->AddArgument("App", "Profil");
       $action->ChangedControl = "jbInfo";
       $action->AddControl($this->Core->User->FirstName->Control->Id);
       $action->AddControl($this->Core->User->Name->Control->Id);
       $action->AddControl($this->Core->User->Description->Control->Id);

       $action->AddControl("tbCity");

       //Bouton de sauvegarde
       $btnSave = new Button(BUTTON); 
       $btnSave->CssClass = "btn btn-primary";
       $btnSave->Value = $this->Core->GetCode("Save");
       $btnSave->OnClick = $action;

       $jbInfo->AddNew($btnSave, 2, ALIGNRIGHT); 

       //Separation
       $jbInfo->AddNew(new Libelle("<div class='separation'></div>" ), 2);

       //Image du profil
       $jbInfo->AddNew($this->GetImage($this->Core->User->IdEntite, true, "", true));

       //Ajout de la photo de profil
       $uploadAjax = new Upload("Profil", $this->Core->User->IdEntite, "ProfilAction.LoadInformation()", "SaveImageProfil");
       $jbInfo->AddNew($uploadAjax, 2);

       return $jbInfo->Show();
   }

   /**
    * Récupere l'image d'un profil
    * @param type $userId
    * @param type $mini
    */
   function GetImage($userId, $mini, $width ="", $rand= false)
   {
       $setWidth = false;

          //Repertoire des données
          if(Profil::InFront())
          {
             $directory = "Data/Apps/Profil/";
          }
          else
          {
             $directory = "../Data/Apps/Profil/";
          }

          if(file_exists($directory."/".$userId.".jpg"))
          {
              if($mini)
              {
                 $file = $directory."/".$userId."_96.jpg";
              }
              else
              {
                 $file = $directory."/".$userId.".jpg";

                 $setWidth = true;
              }
          }
          else
          {
            $file =   "Images/noprofil.png";
          }
          if($rand)
          {
              $file .= "?rand=".rand(0,1999);
          }
          $img = new Image($file);
          $img->ToolTip = new ToolTip("Profil", "ShowDetail", $userId);

          if($setWidth)
          {
             $img->AddStyle("width", $width); 
          }

          return $img;
   }
}?>