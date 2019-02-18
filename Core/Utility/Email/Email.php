<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\Email;

use Core\View\ElementView;
use Core\View\View;

class Email
{
    private $Template;
    private $Body;
    private $From;
    private $Sender;
    private $User;
    private $Core;
    
    /**
     * Constructeur
     * */
    function __construct($core)
    {
        $this->Core = $core;
    }

    //Envoi du mail
    function Send($To)
    {
        //Recuperation de la view
        $view = new View("../View/Core/Email/email.tpl", $this->Core);
        
        //Récuperation depuis la config
        $sender = $this->Core->Config->GetKey("EMAILSENDER");
        $from = $this->Core->Config->GetKey("EMAILFROM");
        $reply = $this->Core->Config->GetKey("EMAILREPLYTO");


        if($this->From == '') 
        {
             $this->From = ( $from != "" ) ?  $from : 'PuzzleApp' ;
        };
        if($this->Sender == '' ) { $this->Sender = ($sender != ""  ) ? $sender : 'puzzleApp.com' ;};

        $expediteur = $this->From.' <'.$this->Sender.'>';

        //Entete du mail
        $headers  = 'MIME-Version: 1.0' . "\r\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset="UTF-8"'."\r\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Content-Transfer-Encoding: 8bit';
        $headers .= "X-Sender: <".$_SERVER['HTTP_HOST'].">\r\n";
        $headers .= "X-auth-smtp-user: ".$expediteur."\r\n";
        $headers .= "Reply-To: ".$reply."\r\n"; // Mail de reponse
        $headers .= "From: $expediteur \r\n"; // Expediteur

        $view->AddElement(new ElementView("Title", $this->Title));
        $view->AddElement(new ElementView("Body", $this->Body));
        
        //Envoi
    mail($To, $this->Title, $view->Render() /*,$headers*/);
    }

    //Envoi au administrateur
    function SendToAdmin()
    {
        $this->Send("contact@webemyos.com");
    }

    function SendUserAndAdmin($To)
    {
        $this->Send($To);
        $this->SendToAdmin();
    }


    //Assecceurs
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name,$value)
    {
        $this->$name=$value;
    }
}
?>
