<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Forum\Module\Message;

use Core\Block\AjaxFormBlock\AjaxFormBlock;
use Core\Controller\Controller;
use Core\Core\Request;

 class MessageController extends Controller
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
     * Pop ajout d'image
     */
    function ShowAddSujet($categoryId)
    {
        if(!Request::IsConnected($this->Core))
        {
           // include("Blocks/AuthentificationBlock/AuthentificationBlock.php");
            $registrationBlock = new AuthentificationBlock($this->Core);

            echo $registrationBlock->GetAuthentification();
        }
        else
        {
          $jbForum = new AjaxFormBlock($this->Core, "jbForum");
          $jbForum->App = "Forum";
          $jbForum->Action = "SaveDiscussion";

          $jbForum->AddArgument("CategoryId", $categoryId);

          $jbForum->AddControls(array(
                                        array("Type"=>"TextBox", "Name"=> "tbTitle", "Libelle" => $this->Core->GetCode("Title")),
                                        array("Type"=>"TextArea", "Name"=> "tbMessage", "Libelle" => $this->Core->GetCode("Message")),
                                        array("Type"=>"Button", "CssClass"=>"btn btn-primary" ,"Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                            )
                  );

          return $jbForum->Show();
        }
    }

     /*
     * Pop ajout de réponse
     */
    function ShowAddReponse($sujetId)
    {
        if(!Request::IsConnected($this->Core))
        {
           $registrationBlock = new AuthentificationBlock($this->Core);

            echo $registrationBlock->GetAuthentification();
        }
        else
        {
          $jbReponse = new AjaxFormBlock($this->Core, "jbReponse");
          $jbReponse->App = "Forum";
          $jbReponse->Action = "SaveReponse";

          $jbReponse->AddArgument("SujetId", $sujetId);

          $jbReponse->AddControls(array(
                                        array("Type"=>"TextArea", "Name"=> "tbMessage", "Libelle" => $this->Core->GetCode("Message")),
                                        array("Type"=>"Button", "Name"=> "BtnSave" , "Value" => $this->Core->GetCode("Save")),
                            )
                  );

          return $jbReponse->Show();
        }
    }
  /*action*/
 }?>