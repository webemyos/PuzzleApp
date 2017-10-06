<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Comment;

use Apps\Comunity\Entity\ComunityComment;
use Apps\Comunity\Entity\ComunityMessage;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\ShareIcone;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;

 class PostController extends Controller
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
     * Affiche un post
     * @param type $idMessage
     */
    function ShowMessage($idMessage, $message= null, $eprofil)
    {
        $html = "<div class='post'>";

        if($message == null)
        {
          //Recuperation du message
          $message = new ComunityMessage($this->Core);
          $message->GetById($idMessage);
        }

        //Ajout des informations
        $html .= $eprofil->GetProfil($message->User->Value, "profil");
        $html .= "<span id='dvMessage".$message->IdEntite."'> ".$message->Message->Value."</span>"; 

        //Si c'est le créateur il peit modifier ou supprimer le message
        if($message->UserId->Value == $this->Core->User->IdEntite)
        {
            $icEdit = new EditIcone();
            $icEdit->Title = $this->Core->GetCode("Modify");
            $icEdit->OnClick = "ComunityAction.EditMessage(".$message->IdEntite.")";
            $html .= $icEdit->Show();

            $icRemove = new DeleteIcone();
            $icRemove->Title = $this->Core->GetCode("Remove");
            $icRemove->OnClick = "ComunityAction.RemoveMessage(".$message->IdEntite.", this)";

            $html .= $icRemove->Show();
        }

        //Bouton pour commenter
        $icShare = new ShareIcone();
        $icShare->Title = $this->Core->GetCode("Comunity.Comment");
        $icShare->OnClick = "ComunityAction.ShowAddComment(".$message->IdEntite.")";

        $html .= $icShare->Show();

        //Commentaire posté
        $html .= "<span id='lstComment".$message->IdEntite."'>".$this->GetComments($message, $eprofil)."</span>";

        //Div pour les commentaires
        $html .= "<span id='dvComment".$message->IdEntite."'></span>"; 

        $html .= "</div>";

        return $html;
    }

    /**
     * Récupere les commentaire d'un message
     * @param type $message
     */
    function GetComments($message, $eprofil)
    {
        $html= "";
        $comment = new ComunityComment($this->Core);
        $comment->AddArgument(new Argument("ComunityComment", "MessageId", EQUAL, $message->IdEntite ));
        $comments = $comment->GetByArg();

        if(count($comments) > 0 )
        {
            foreach($comments as $comment)
            {
                $html .= $this->ShowComment("", $comment, $eprofil );
            }
        }

        return $html;
    }

    /**
     * Affiche un commentaire
     */
    function ShowComment($commentId, $comment = null, $eProfil)
    {
        $html = "<div class = 'comment'>";

        if($comment == null)
        {
            $comment = new ComunityComment($this->Core);
            $comment->GetById($commentId);
        }

        $html .= $eProfil->GetProfil($comment->User->Value, "profil");
        $html .= "<span id='spMessage".$comment->IdEntite."'>".$comment->Message->Value."</span>";

        //Si c'est le créateur il peut modifier ou supprimer le message
        if($comment->UserId->Value == $this->Core->User->IdEntite)
        {
            $icEdit = new EditIcone();
            $icEdit->Title = $this->Core->GetCode("Modify");
            $icEdit->OnClick = "ComunityAction.EditComment(".$comment->IdEntite.")";
            $html .= $icEdit->Show();

            $icRemove = new DeleteIcone();
            $icRemove->Title = $this->Core->GetCode("Remove");
            $icRemove->OnClick = "ComunityAction.RemoveComment(".$comment->IdEntite.", this)";

            $html .= $icRemove->Show();
        }

        $html .= "</div>";

        return $html;

    }
 }?>