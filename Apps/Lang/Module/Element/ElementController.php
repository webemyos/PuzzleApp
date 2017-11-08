<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Lang\Module\Element;

use Core\Action\UserAction\UserAction;
use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Block\LinkBlock\LinkBlock;
use Core\Control\Button\Button;
use Core\Control\Grid\Grid;
use Core\Control\Grid\Column;
use Core\Control\Grid\ControlColumn;
use Core\Control\Grid\IconColumn;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Controller\Controller;
use Core\Entity\Langs\LangsElement;
use Core\View\View;



 class ElementController extends Controller
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

function Show()
{}

/**
 * Affichage du module
 */
function LoadElement($page)
{
     $view = new View(__DIR__ . "/View/ElementBlock.tpl", $this->Core);

     $NbElement = 50;

       //Grille des element
      $this->Elements = new LangsElement($this->Core);

      $GridElements = new Grid("grid");
      $GridElements->Id="grid";
      $GridElements->CssClass ="grille";
      $this->Source = $this->Elements->GetAllByLang($this->Core->GetLang(), $page,$NbElement);

      $GridElements->DataSource = $this->Source;
      $GridElements->AddColumn(new Column($this->Core->GetCode("Identifiant"),"Id"));
      $GridElements->AddColumn(new Column($this->Core->GetCode("Code"),"Code"));
      $GridElements->AddColumn(new ControlColumn($this->Core->GetCode("Libelle"),"Libelle", TEXTBOX, array("Width:200px")));
      $GridElements->AddColumn(new IconColumn($this->Core->GetCode("Edit"), "EeLang", "Core\Control\Icone\EditIcone"));
      $GridElements->AddColumn(new IconColumn($this->Core->GetCode("Save"), "EeLang", "Core\Control\Icone\SaveIcone"));
      $GridElements->AddColumn(new IconColumn($this->Core->GetCode("Delete"), "EeLang", "Core\Control\Icone\DeleteIcone"));


      $view->AddElement($GridElements);

  //Enregistrement
      $btnSave=new Button(BUTTON, "btnSave");
      $btnSave->Value=$this->Core->GetCode("Save");
      $btnSave->OnClick=new UserAction("Save");

      $view->AddElement($btnSave);

      //Lien de recherche
      $this->NbPage = $this->Elements->GetCount();
      $this->LinkBlock = new LinkBlock("lkBreadCrumb");

      for($i=0;$i<$this->NbPage/$NbElement;$i++)
        {
            $lkPage = new Link($i,"#");
            $lkPage->OnClick = "LangAction.LoadElement($i);";

              $this->LinkBlock->Add($lkPage);
        }

        $view->AddElement(new Libelle($this->LinkBlock->Show(), "lkBreadCrumb"));

        return $view->Render();
  }

  public function EditElement($elementId)
  {

      $request ="SELECT lgel.Id,lgel.LangId,lgel.CodeId,lgel.Libelle as lgel_Libelle,lgel.LangId as lgel_LangId,lgel.CodeId as lgel_CodeId FROM ee_lang_element as lgel 
                  WHERE (1=1) AND CodeId = '".$elementId."' AND LangId = '1' " ;

      $result = $this->Core->Db->GetLine($request);


      $elt = $result["lgel_Libelle"];

      $jbElement = new AjaxFormBlock($this->Core, "jbElement");
      $jbElement->App = "EeLang";
      $jbElement->Action = "SaveElement";

      $jbElement->AddArgument("elementId", $elementId);

      $jbElement->AddControls(array(
                                    array("Type"=>"TextArea", "Name"=> "tbLibelle", "Libelle" => $this->Core->GetCode("Value"), "Value" => $elt ) ,
                                    array("Type"=>"Button", "CssClass" => "btn btn-primary", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save"))
                        )
              );

      return $jbElement->Show();
  }
 }

