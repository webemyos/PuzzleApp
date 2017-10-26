<?php

namespace Apps\Message;

use Apps\Message\Helper\MessageHelper;
use Apps\Message\Module\Message\MessageController;
use Core\App\Application;
use Core\Core\Request;

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class Message extends Application
{
    /**
     * Auteur et version
     * */
    public $Author = 'Eemmys';
    public $Version = '1.0.0';
    public static $Directory = "../Apps/Message";

    /**
     * Constructeur
     * */
     function __construce($core)
     {
            parent::__construct($core, "Message");
            $this->Core = $core;
     }

     /**
      * Execution de l'application
      */
     function Run()
     {
            $textControl = parent::Run($this->Core, "Message", "Message");
            echo $textControl;
     }

    /**
     * Pop in d'envoi de message
     */
    public function ShowSendMessage($userId = "")
    {
        $messageController = new MessageController($this->Core);
        echo $messageController->ShowSendMessage( Request::GetPost('AppName'),
                                             Request::GetPost('EntityName'),
                                             Request::GetPost('EntityId'),
                                             $userId
                                             );
    }

    /**
     * Envoi le message
     */
    public function Send()
    {
       MessageHelper::Send($this->Core, 
                           Request::GetPost("objet"),
                           Request::GetPost("message"),
                           Request::GetPost("userId"),

                           Request::GetPost("appName"),
                           Request::GetPost("entityName"),
                           Request::GetPost("entityId")

                            );

       echo "<span class='success'>".$this->Core->GetCode("Message.SendedOk")."</span>";
    }

    /*
     * Envoi un message depuis un app
     */
    public function SendByApp($sujet, $message, $userId, $appName, $entityName, $entityId, $code)
    {
        MessageHelper::SendByApp($this->Core, 
                $sujet,
                $message,
                $userId, 
                $appName,
                $entityName,
                $entityId, 
                $code
                 );
    }

    /**
     * Charge la boite de reception
     */
    public function LoadInBox($app = "", $show = true)
    {
        $messageController = new MessageController($this->Core);

        if($show)
        {
            echo $messageController->LoadInBox($app);
        }
        else
        {
            return $messageController->LoadInBox($app);
        }
    }

    /**
     * Charge les message envoyés
     */
    public function LoadOutBox()
    {
        $messageController = new MessageController($this->Core);
        echo $messageController->LoadOutBox();
    }

    /**
     * Affiche le détail d'un message
     */
    public function ShowDetail()
    {
       $messageId = Request::GetPost("messageId");

       //Marque le message comme lu.
       MessageHelper::SetRead($this->Core, $messageId); 

       $messageController = new MessageController($this->Core);
       echo $messageController->ShowDetail($messageId);
    }

    /**
     * Affiche le détail d'un message envoyé
     */
    public function ShowDetailSend()
    {
       $messageId = Request::GetPost("messageId");

       $messageController = new MessageController($this->Core);
       echo $messageController->ShowDetailSend($messageId);
    }

    /*
     * Envoi une réponse
     */
    public function AddReponse()
    {
       $messageId = Request::GetPost("MessageParentId");
       $reponse = Request::GetPost("tbReponse");

       MessageHelper::AddReponse($this->Core, $messageId, $reponse); 

       echo "<span class='success'>".$this->Core->GetCode("Message.ReponseSendedOk")."</span>";
    }

    /**
     * Obtient le nombre de message emit et recus
     */
    public function GetNumberMessage()
    {
        $html = $this->Core->GetCode("Message.InBox")."(".MessageHelper::GetNumberInBox($this->Core).")";
        $html .= ":".$this->Core->GetCode("Message.OutBox"). "(".MessageHelper::GetNumberOutBox($this->Core).")";
        echo $html;
    }

   /**
    * Retourne les message d'une applciation
    * @param type $appName
    * @param type $entityId
    */
   public function GetByApp($appName, $entityName, $entityId)
   {
       return MessageHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
   }

   /**
    * Obtient les derniers message de la boite de reception
    */
   public function GetInfo()
   {
       $html ="";

        //Obtient les dernière messages
        $messages = MessageHelper::GetLastReceived($this->Core);

        if(count($messages) > 0)
        {    
            foreach($messages as $message)
            {
                   $html .= "<div class='message'><a href='#' onclick='DashBoard.StartApp(\"\",\"Message\")'>";

                   $html .= "<span class='date'>".$message->Message->Value->DateCreated->Value."</span>";
                   $html .= "<span class='text'>".$message->Message->Value->Subjet->Value."</span></a>";

                  $html .= "</div>";
            }

            return $html;
        }
        else
        {
            return $this->Core->GetCode("Message.NoMessage");
        }
   }

   /**
    * Obtient le nombe de message recu non lu
    */
   function GetCount($all = true)
   {
       return MessageHelper::GetNumberInBox($this->Core, $all);
   }

   /**
    * Nouveau message
    */
   function GetNumberNewMessage()
   {
       echo $this->GetCount(false);
   }
}
?>