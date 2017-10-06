<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Publication;

use Apps\Comunity\Helper\ComunityHelper;
use Core\Block\Block;
use Core\Control\Button\Button;
use Core\Control\EntityListBox\EntityListBox;
use Core\Control\Libelle\Libelle;
use Core\Control\TextArea\TextArea;
use Core\Control\Upload\Upload;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;


 class PublicationController extends Controller
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
       // $tsPublish = new TabStrip("tsPublish", "Comunity");

        //Ajout des control
       // $tsPublish->AddTab($this->Core->GetCode("Statut"), $this->GetPublishMessage());
     //   $tsPublish->AddTab($this->Core->GetCode("Image"), $this->GetPublishFile());
        //return $this->GetPublishMessage()->Show();
        //return   "la"; // $tsPublish->Show();

        return  $this->GetPublishMessage()->Show();
    }

    /**
     * Publication d'un message
     */
    function GetPublishMessage()
    {
        $jb = new Block("jbMessage");
        $jb->Frame = false;
        $jb->Table = false;

        //Text Area
        $tbMessage = new TextArea("tbMessage");
        $tbMessage->PlaceHolder = "\"".$this->Core->GetCode("Community.AddAMessage")."\"";
        $tbMessage->AddStyle("width", "100%");
        $jb->Add($tbMessage);

        //Choix de la communauté
        $lstComunity = new EntityListBox("lstComunity", $this->Core);
        $lstComunity->Entity = "ComunityComunity";

        $lstComunity->ListBox->Add($this->Core->GetCode("Comunity.SelectComunity"),"");
        $lstComunity->AddArgument(new Argument("ComunityComunity","Id", IN,  ComunityHelper::GetRequestByUser($this->Core) ));

        $jb->Add($lstComunity);

        //Bouton d'envoi
        $btnSend = new Button(BUTTON);
        $btnSend->Value = $this->Core->GetCode("Publish");
        $btnSend->OnClick = "ComunityAction.PublishMessage()";

        $jb->Add($btnSend);

        return $jb;
    }

    /**
     * Publication d'une photo
     */
    function GetPublishFile()
    {
        $html = "";

        $upFile = new Upload("Comunity", "", "ComunityAction.PrevisualiseImage()", "AddImage");

        $html .= $upFile->Show();

        //Div de prévisualisation
        $html .= "<div id='dvPreVisu'></div>";

        return new Libelle($html);
    }
 }?>