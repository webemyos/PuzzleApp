<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Utility\Email;

class Email
{
    private $Template;
    private $Body;
    private $From;
    private $Sender;
    private $User;

    /**
     * Constructeur
     * */
    function __construct()
    {
    }

    //Envoi du mail
    function Send($To)
    {
        //Recuperation du template
        $template = new $this->Template();
        $template->User = $this->User;
        $template->Title = $this->Title;
        $template->Body = $this->Body;

        //Entete du mail
        //$headers ='From:"'.$this->From.'"<'.$this->Sender.'>'."\n";
//$headers .='Content-Type: text/html; charset="iso-8859-1"'."\n";
//$headers .='Content-Transfer-Encoding: 8bit';

        if($this->From == '' || !isset($this->From)) $this->From = 'WebEmyos';
        if($this->Sender == '' || !isset($this->Sender)) $this->From = 'noreply@webemyos.com';

        $expediteur = $this->From.' <'.$this->Sender.'>';

        $headers  = 'MIME-Version: 1.0' . "\r\n"; // Version MIME
        $headers .= 'Content-type: text/html; charset="UTF-8"'."\r\n"; // l'en-tete Content-type pour le format HTML
        $headers .= 'Content-Transfer-Encoding: 8bit';
        $headers .= "X-Sender: <".$_SERVER['HTTP_HOST'].">\r\n";
        $headers .= "X-auth-smtp-user: ".$expediteur."\r\n";
        $headers .= "X-abuse-contact: spam@webemyos.fr\r\n";
        $headers .= "Reply-To: ".$expediteur."\r\n"; // Mail de reponse
        $headers .= "From: webemyos\r\n"; // Expediteur

        //Envoi
        mail($To,$this->Title,$template->Show(),$headers);
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
