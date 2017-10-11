<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Notify;

use Core\Core\Core;
use Core\App\Application;

use Apps\Notify\Helper\NotifyHelper;

class Notify extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Notify";

	/**
	 * Constructeur
	 * */
	 function __construct()
	 {
            $this->Core = Core::getInstance();
            parent::__construct($this->Core, "Notify");
        }

	 /**
	  * Execution de l'application
	  */
	 function Run($core="", $app="", $app="")
	 {
            $textControl = parent::Run($this->Core, "Notify", "Notify");
            echo $textControl;
	 }
         
        
        /**
         * Ajoute une notification
         * 
         * @param type $userId
         * @param type $DestinataireId
         * @param type $AppName
         * @param type $EntityId
         * @param type $Code
         */
        public function AddNotify($userId, $code, $destinataireId= "", $AppName = "", $EntityId = "",  $emailSubjet ="" , $emailMessage="")
        {
            NotifyHelper::AddNotify($this->Core, $userId, $code, $destinataireId, $AppName, $EntityId, $emailSubjet, $emailMessage);
        }
        
        /**
         * Obtient les notifications des applications
         * 
         * @param type $appName
         * @param type $EntityId
         */
        public function GetNotifyApp($appName, $EntityId)
        {
             return NotifyHelper::GetNotify($this->Core, $appName, $EntityId);
        }
        
        /**
         * Affiche les dernières notifications
         * 
         * @return string
         */
        public function GetInfo()
        {
            $html ="";
            
            //Obtient les dernière notifications
            $notifications = NotifyHelper::GetLastByUser($this->Core, $this->Core->User->IdEntite);
            
            if(count($notifications )> 0 )
            {
            
                foreach($notifications as $notification)
                {
                       $html .= "<div class='notification'><a href='#' onclick='Eemmys.StartApp(\"\",\"Notify\")'>";

                       $html .= "<span class='date'>".$notification->DateCreate->Value."</span>";
                       $html .= "<span class='text'>".$this->Core->GetCode($notification->Code->Value)."</span></a>";

                      $html .= "</div>";
                }

                return $html;
            }
            else
            {
                return $this->Core->GetCode("Notify.Noti");
            }
        }
        
        /**
         * Retourne le nombre de notification
         */
        function GetCount($recent =  false)
        {
            $notify = NotifyHelper::GetByUser($this->Core, $this->Core->User->IdEntite, "", true );
            
            return count($notify);
        }
        
        /*
         * VUe par le membre
         */
        function ViewNotify()
        {
            $notify = NotifyHelper::ViewByUser($this->Core, $this->Core->User->IdEntite,"", true );
            echo $this->GetCount(true);
        }
}
?>