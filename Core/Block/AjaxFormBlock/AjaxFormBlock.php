<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Core\Block\AjaxFormBlock;

use Core\Action\AjaxAction\AjaxAction;
use Core\Block\Block;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\EntityListBox\EntityListBox;
use Core\Control\Hidden\Hidden;
use Core\Control\Libelle\Libelle;
use Core\Control\Link\Link;
use Core\Control\TextArea\TextArea;
use Core\Control\TextBox\TextBox;
use Core\Control\Upload\Upload;
use Core\Control\DateBox\DateBox;

class AjaxFormBlock extends Block
{
    /*
     * Propriété
     */
    public $App;
    public $Action;
    private $Controls = array();
    private $Arguments = array();

    function __construct($core, $name)
    {
        $this->Core = $core;
        $this->Name = $name;
    }

    /**
     * Ajoute un tableau de control
     * @param type $controls
     */
    function AddControls($controls)
    {
       $this->Controls = $controls;
    }

    /**
     * Ajoute un arguments
     * @param type $argument
     */
    function AddArgument($key, $value)
    {
       $this->Arguments[$key] = $value;
    }

    /**
     * Affiche le formulaire ajax
     */
    function Show()
    {
        $block = new Block($this->Core, $this->Name);
        $block->Frame = false;
        $block->Table = true;
        $block->CssClass = "form-group";

        //Action Ajax
        $action = new AjaxAction($this->App, $this->Action);
        $action->AddArgument("App", $this->App);

         //Ajout des arguments
        foreach($this->Arguments as $argument => $value)
        {
           $action->AddArgument($argument, $value);
        }

        $action->ChangedControl = $this->Name;

        foreach($this->Controls as $control)
        {
            switch($control["Type"])
            {
                case "EntityListBox" :
                    $ctr = new EntityListBox($this->Exist($control, "Name"), $this->Core);
                    $ctr->Entity = $control["Entity"] ;
                    $ctr->ListBox->Libelle = $this->Exist($control, "Libelle");
                    $ctr->Libelle = $this->Exist($control, "Libelle");
                    $ctr->ListBox->Selected = $this->Exist($control, "Value");

                    if(isset($control["Field"]))
                    {
                        $ctr->AddField($control["Field"]);
                    }

                    if(isset($control["Argument"]))
                    {
                       $ctr->AddArgument($control["Argument"]);
                    }

                    break;
                case "ListBox" :
                    $ctr = new ListBox($this->Exist($control, "Name"));
                    $ctr->Libelle = $this->Exist($control, "Libelle");

                    foreach($this->Exist($control, "Value") as $key => $value)
                    {
                        $ctr->Add($key, $value);
                    }


                    break;
                case "AutoCompleteBox" :
                    $ctr = new AutoCompleteBox($this->Exist($control, "Name"), $this->Core);
                    $ctr->Entity = $control["Entity"] ;
                    $ctr->Methode = $control["Methode"];
                    $ctr->Libelle = $this->Exist($control, "Libelle");


                    break;
                 case "TextBox"  :
                         $ctr = new TextBox($this->Exist($control, "Name"), $this->Core);
                         $ctr->Title = $this->Exist($control, "Title");
                         $ctr->Value = $this->Exist($control, "Value");
                         $ctr->Libelle = $this->Exist($control, "Libelle");
                    break;
                case "DateBox"  :
                        $ctr = new DateBox($this->Exist($control, "Name"), $this->Core);
                        $ctr->Title = $this->Exist($control, "Title");
                        $ctr->Value = $this->Exist($control, "Value");
                        $ctr->Libelle = $this->Exist($control, "Libelle");
                   break;

                  case "TextArea"  :
                         $ctr = new TextArea($this->Exist($control, "Name"), $this->Core);
                         $ctr->Title = $this->Exist($control, "Title");
                         $ctr->Value = $this->Exist($control, "Value");
                         $ctr->Libelle = $this->Exist($control, "Libelle");
                    break;
                 case "BsEmailBox"  :
                         $ctr = new BsEmailBox($this->Exist($control, "Name"), $this->Core);
                         $ctr->Title = $this->Exist($control, "Title");
                    break;
                    case "BsPassword"  :
                         $ctr = new BsPassword($this->Exist($control, "Name"), $this->Core);
                         $ctr->Title = $this->Exist($control, "Title");
                     break;

                case "CheckBox" :
                    $ctr = new CheckBox($this->Exist($control, "Name"));
                    $ctr->Value = $this->Exist($control, "Value");
                    $ctr->Libelle = $this->Exist($control, "Libelle");
                    $ctr->CssClass = $control["CssClass"];
                    $ctr->Checked = $this->Exist($control, "Value");
                    break;
                case "Button" :
                    $ctr = new Button(BUTTON);
                    $ctr->Value = $this->Exist($control, "Value");
                    $ctr->Libelle = $this->Exist($control, "Libelle");
                    $ctr->CssClass = isset($control["CssClass"])?$control["CssClass"]:"btn btn-info";

                    if(isset($control["OnClick"]))
                    {
                         $ctr->OnClick = $control["OnClick"];
                    }
                    else
                    {
                        $ctr->OnClick = $action;
                    }

                    break;
                case "Upload" :
                    $app = $control["App"];
                    $idEntite = $control["IdEntite"];
                    $callBack = $control["CallBack"];
                    $UploadAction = $control["Action"];

                    $ctr = new Upload($app, $idEntite, $callBack, $UploadAction);

                    break;
                case "Libelle":

                    $ctr = new Libelle($this->Exist($control, "Value"));

                    break;
                case "Link" :
                    $ctr = new Link($this->Exist($control, "Libelle"), $this->Exist($control, "Value"));
                    $ctr->Target= "_blank";
                    break;
                case "Hidden" :
                    $ctr = new Hidden($this->Exist($control, "Name"));
                    $ctr->Value = $this->Exist($control, "Value");
                    break;
                default :
                    $type = $control["Type"];

                    $ctr = new $type($this->Exist($control, "Name"));
                    $ctr->Libelle = $this->Exist($control, "Libelle");
                    $ctr->PlaceHolder = $control["PlaceHolder"];

                    if($control["OnClick"] != "")
                    {
                         $ctr->OnClick = $control["OnClick"];
                    }

                    //Remplacement des caractères spéciaxu pour les ckEditor
                    $ctr->Value = $this->Exist($control, "Value");

                    break;
            }

            $action->AddControl($ctr->Id);

            if($control["Type"] == "Button"  || $control["Type"] == "UploadAjaxFile" )
            {
                $block->AddNew($ctr, 2, ALIGNRIGHT);
            }
            else
            {
                 $block->AddNew($ctr);
            }
        }

        return $block->Show();
    }
    
    /*
     * Verifie si le champ existe
     */
    private function Exist($control, $value)
    {
        return isset($control[$value])?$control[$value]:"";
    }
}
