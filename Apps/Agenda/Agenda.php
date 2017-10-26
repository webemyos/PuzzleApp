<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Agenda;

use Apps\Agenda\Entity\AgendaEvent;
use Apps\Agenda\Entity\AgendaMember;
use Apps\Agenda\Helper\EventHelper;
use Apps\Agenda\Module\Calendar\CalendarController;
use Core\Action\ActionColumn;
use Core\Action\AjaxActionColumn;
use Core\App\Application;
use Core\Block\Block;
use Core\Control\AutoCompleteBox\AutoCompleteBox;
use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\DateTimeBox\DateTimeBox;
use Core\Control\Grid\EntityColumn;
use Core\Control\Grid\EntityGrid;
use Core\Control\ListBox\ListBox;
use Core\Control\PopUp\PopUp;
use Core\Control\TextArea\TextArea;
use Core\Control\TextBox\TextBox;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;


class Agenda extends Application
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'DashBoardManager';
	public $Version = '1.0.0';
        public static $Directory = "../Apps/Agenda";

	/**
	 * Constructeur
	 * */
	 function __construct($core)
	 {
	 	parent::__construct($core, "Agenda");
	 	$this->Core = $core;
   }

	 /**
	  * Execution de l'application
	  */
	 function Run()
	 {
	 	$textControl = parent::Run($this->Core, "Agenda", "Agenda");
	 	echo $textControl;
	 }
        
	 /**
	  * Charge une semaine
	  * */
	 function LoadWeek()
	 {
             $calendarBlock = new CalendarController($this->Core);
             echo $calendarBlock->LoadWeek(Request::GetPost('WeekNumber'));
        }

	 /*
	  * Ajout d'un évenement
	  * */
	 function AddNewEvent()
	 {
            $appName = Request::GetPost("AppName");
            $entityName = Request::GetPost("EntityName");
            $entityId = Request::GetPost("EntityId");

            //Verification si un evenement existe
            if(Request::GetPost('idEvent') || Request::GetPost('idEntity'))
            {
                    $AgendaEvent = new AgendaEvent($this->Core);
                    if(Request::GetPost('idEvent'))
                    {
                            $AgendaEvent->GetById(Request::GetPost('idEvent'));
                            $idEvent = Request::GetPost('idEvent');

                            $saveAction = "AgendaAction.SaveEvent";
                            $IdProjet = Request::GetPost('IdProjet')? Request::GetPost('IdProjet') : 'null';
                    }
                    else
                    {
                            $AgendaEvent->GetById(Request::GetPost('idEntity'));
                            $idEvent = Request::GetPost('idEntity');
                            $saveAction = "ProjetAction.SaveEvent";
                            $IdProjet = $AgendaEvent->ProjetId->Value;
                    }
                    $created = true;
            }
            else
            {
                    $created = false;
                    $idEvent = 'null';
                    //Recuperation la date et l'heure de debut
                    $date = explode('!', Request::GetPost('Date'));
                    $saveAction = "AgendaAction.SaveEvent";
                    $IdProjet = Request::GetPost('IdProjet')? Request::GetPost('IdProjet') : 'null';
            }

            $edit = (Request::GetPost('edit') != 'false');

            $blEvent = new Block($this->Core);
            $blEvent->Id = "jbEvent";
            $blEvent->Table = true;
            $blEvent->frame = false;

            //Titre
            $tbTitre = new TextBox("tbTitre");
            $tbTitre->Libelle = $this->Core->GetCode("Title");
            $tbTitre->Value = ($created)?$AgendaEvent->Title->Value : '';
            $tbTitre->Enabled = $edit;
            $blEvent->AddNew($tbTitre, 3);

            //Commentaire
            $tbCommentaire = new TextArea("tbCommentaire");
            $tbCommentaire->Libelle = $this->Core->GetCode("Commentaire");
            $tbCommentaire->AddStyle("width","300px");
            $tbCommentaire->Value = ($created)?$AgendaEvent->Commentaire->Value : '';
            $tbCommentaire->Enabled = $edit;

            $blEvent->AddNew($tbCommentaire, 3);
            $datePosted = Request::GetPost('Date');

            $cbPublic = new CheckBox("cbPublic");
            $cbPublic->Libelle = $this->Core->GetCode("Agenda.EventPublic");
            $blEvent->AddNew($cbPublic, 3);
            
            //Date de debut
            $tbDateStart = new DateBox("tbDateStart");
  $tbDateStart->Libelle = $this->Core->GetCode("DateStart");

            if($created == true)
            {
                    $dateStart = explode(' ',$AgendaEvent->DateStart->Value);
                    $tbDateStart->Value = $dateStart[0];
                    $hour = explode(":", $dateStart[1]);
                    $datePosted = $dateStart[0]."!".$hour[0];
            }
            else
            {
                    $tbDateStart->Value = $date[0];
            }

            $blEvent->AddNew($tbDateStart);

            //Heure de debut
            $lstHourStart = new DateTimeBox("lstHourStart");
            //$lstHourStart->Enabled = false;

/*            for($i=0 ; $i < 24; $i ++)
            {
                if($i < 10 )
                {
                   $lstHourStart->Add("0".$i.":00", $i); 
                }
                else
                {
                    $lstHourStart->Add($i.":00", $i);
                }
            }
            if($created == true)
            {
                    $hour = explode(':', $dateStart[1]);
                    $lstHourStart->Selected =$hour[0];
            }
            else
            {
                    $lstHourStart->Selected = $date[1];
            }
*/
            //$lstHourStart->Enabled = $edit;

            $blEvent->Add($lstHourStart);

            //Date de fin
            $tbDateEnd = new DateTimeBox("tbDateEnd");
            $tbDateEnd->Libelle = $this->Core->GetCode("DateEnd");

            if($created == true)
            {
                    $dateEnd = explode(' ',$AgendaEvent->DateEnd->Value);
                    $tbDateEnd->Value = $dateEnd[0];
            }
            else
            {
                    $tbDateEnd->Value = $date[0];
            }

            $tbDateEnd->Enabled = $edit;

            $blEvent->AddNew($tbDateEnd);

            //Heure de fin
            $lstHourEnd= new ListBox("lstHourEnd");

            for($i=0 ; $i < 24; $i ++)
            {
                if($i < 10)
                {
                    $lstHourEnd->Add("0".$i.":00", $i);
                }
                else
                {
                    $lstHourEnd->Add($i.":00", $i);
                }
            }

            if($created == true)
            {
                    $hour = explode(':', $dateEnd[1]);
                    $lstHourEnd->Selected =$hour[0];
            }
            else
            {
                    $lstHourEnd->Selected = $date[1] + 1;
            }

            $lstHourEnd->Enabled = $edit;

    //        $blEvent->Add(new Libelle($lstHourEnd->Show() . "h"));

            //Bouton de sauvegare
            $btnSave = new Button(BUTTON);
            $btnSave->Value = $this->Core->GetCode("Save");
            $btnSave->CssClass = "btn btn-success";

            $btnSave->OnClick = $saveAction.'(\''.$datePosted.'\', '.$idEvent.' , \''.$appName.'\' , \''.$entityName.'\',  \''.$entityId.'\');';
            if($edit)
            {
                    $blEvent->AddNew($btnSave, '3',ALIGNRIGHT);
            }

            echo $blEvent->Show();
	 }

	 /**
	  * Enregistre l'évenement
	  * */
	 function SaveEvent()
	 {
		$event = new AgendaEvent($this->Core);

		if(Request::GetPost('idEvent') != 'null')
	 	{
                    $event->GetById(Request::GetPost('idEvent'));
	 	}

		$event->Title->Value = Request::GetPost("Titre");
		$event->Commentaire->Value = Request::GetPost("Commentaire");
		$event->UserId->Value = $this->Core->User->IdEntite;
                
                $event->AddName->Value = Request::GetPost("AppName");
		$event->EntityName->Value = Request::GetPost("EntityName");
		$event->EntityId->Value = Request::GetPost("EntityId");
		
		//Recuperation de la date et l'heure
		$event->DateStart->Value = Request::GetPost("DateStart");
		$event->DateEnd->Value = Request::GetPost("DateEnd");

		$event->Save();
	 }

	 /**
	  * Supprime un évenement
	  * */
	 function DeleteEvent($idEvent = '')
	 {
	 	if($idEvent != '')
	 	{
	 		$idEntite = $idEvent;
	 	}
	 	else
	 	{
	 		$idEntite = Request::GetPost("EventId");
	 	}

		//Suppression des membres
		$agendaMember = new AgendaMember($this->Core);
		$agendaMember->AddArgument(new Argument("AgendaMember", "EventId", EQUAL, $idEntite));

		$members = $agendaMember->GetByArg();

		if(count($members) > 0)
		{
			foreach($members as $member)
			{
				$member->Delete();
			}
		}

		$agendaEvent = new AgendaEvent($this->Core);
		$agendaEvent->GetById($idEntite);

		$agendaEvent->Delete();
	 }


	 /**
	  * Ajout et liste les contacts de l'évenement
	  * */
	 function ShowAddUser()
	 {
            //Recuperation du groupe
            $event = new AgendaEvent($this->Core);
            $event->GetById(Request::GetPost("idEvent"));

            $TextControl = "<div class='FormUser'>";

            //Recherche d'utilisateur
            $tbContact = new AutoCompleteBox("tbContact", $this->Core);
            $tbContact->PlaceHolder = $this->Core->GetCode("SearchUser");
            $tbContact->Entity = "User";
            $tbContact->Methode = "SearchUser";
            $tbContact->Parameter = "AddAction=AgendaAction.SaveUser(".Request::GetPost("idEvent").")";
            
            $TextControl .= $this->Core->GetCode("Contact"). " " .$tbContact->Show();

            //TODO Membre du groupe
            $TextControl .= "<div id='lstContact'>";
            $TextControl .= $this->GetMembers(Request::GetPost("idEvent"));
            $TextControl .= "</div>";

            $TextControl .= "</div>";

            echo $TextControl;
	 }
         
         /**
          * 
          * @param type $idEvent
          * @return stringObtient les membres
          */
	 function GetMembers($idEvent)
	{
                $agendaMember = new AgendaMember($this->Core);
                $agendaMember->AddArgument(new Argument("AgendaMember","EventId",EQUAL,$idEvent));

                $members = $agendaMember->GetByArg();

                $TextControl .= "<div class='row'>";
            
                //Recuperation du profil utilisateur
                $eeprofil = DashBoardManager::GetApp("Profil", $this->Core);
                  
                if(sizeof($members) > 0)
                {
                        foreach($members as $member)
                        {
                                $TextControl .= "<div class='col-md-3'>";
                            
                                //Icone de suppression
                                $TextControl .= "<b class='icon-remove' id=".$member->UserId->Value." onclick='AgendaAction.DeleteMember(this ,".$idEvent.");' title='".$this->Core->GetCode("Agenda.DeleteMember")."'></b>";
                                $TextControl .= $eeprofil->GetProfil($member->User->Value);
                                
                                $TextControl .= "</div>";
                        }
                }

                $TextControl .= "</div>";

                return $TextControl;
        }

	 /**
	  * Enregistre les membres de l'évenement'
	  * */
	 function SaveUser()
	 {
            //Enregistrement
            $idContact = explode(",", Request::GetPost("IdContact"));
            $idEvent = Request::GetPost("IdEvent");

            //Recuperation de l'évenement
            $event = new AgendaEvent($this->Core);
            $event->GetById($idEvent);

            //Notification
            $eNotify = DashBoardManager::GetApp("Notify", $this->Core);
            
            foreach($idContact as $id )
            {
                if(!AgendaMember::MemberExist($this->Core, $idEvent, $id) && $id != "")
                {
                        $agendaMember = new AgendaMember($this->Core);
                        $agendaMember->EventId->Value = $idEvent;
                        $agendaMember->UserId->Value = $id;

                        $agendaMember->Save();

                        //Recuperation de l'utilisateur
                        $destinataire = new User($this->Core);
                        $destinataire->GetById($id);

                        //Envoi d'une notification
                        $subjet = $this->Core->GetCode("File.FolderSharedObjet"). " : " . $this->Core->User->GetPseudo();  
                        $message = $this->Core->GetCode("eFile.FolderSharedMessage");
            
                        $eNotify->AddNotify($this->Core->User->IdEntite, "Agenda.InvitationEvent", $id,  "Agenda", $idEvent, $subjet, $message);
                }
            }

            echo $this->GetMembers($idEvent);
	 }

	 /**
	  * Suppression de l'utilisateur
	  * */
	 function DeleteMember()
	 {
		$agendaMember = new AgendaMember($this->Core);
		$agendaMember->AddArgument(new Argument("AgendaMember", "UserId", EQUAL, Request::GetPost("UserId")));
		$agendaMember->AddArgument(new Argument("AgendaMember", "EventId", EQUAL, Request::GetPost("EventId")));

		$members = $agendaMember->GetByArg();
		$members[0]->Delete();
	 }

	 /**
	  * Accepte l'invitation
	  * */
	 function AcceptInvitation()
	 {
		$agendaMember = new AgendaMember($this->Core);
		$agendaMember->GetById(Request::GetPost('idEventMember'));
		$agendaMember->Accept->Value = true;
		$agendaMember->Save();
	
                //Notification
                $eNotify = DashBoardManager::GetApp("Notify", $this->Core);
                $eNotify->AddNotify($this->Core->User->IdEntite, "Agenda.InvitationAccepted", $agendaMember->Event->Value->UserId->Value,  "Agenda", $agendaMember->IdEvent, $this->Core->GetCode("Agenda.SubjetInvitationAccepted"),  $this->Core->GetCode("Agenda.MessageInvitationAccepted"));
         }

	 /**
	  * Refuse l'invitation
	  * */
	  function RefuseInvitation()
	  {
		$agendaMember = new AgendaMember($this->Core);
		$agendaMember->GetById(Request::GetPost('idEventMember'));
		$agendaMember->Accept->Value = false;
		$agendaMember->Save();

		                //Notification
                $eNotify = DashBoardManager::GetApp("Notify", $this->Core);
                $eNotify->AddNotify($this->Core->User->IdEntite, "Agenda.InvitationRefused", $agendaMember->Event->Value->UserId->Value,  "Agenda", $agendaMember->IdEvent, $this->Core->GetCode("Agenda.SubjetInvitationRefused"),  $this->Core->GetCode("Agenda.MessageInvitationRefused"));
	  }

	/**
	 * Récupère les évenements d'un projet
	 * Retourne une grille des évenement
  	 **/
	 function GetGridEventProjet($ProjetId)
	 {
	 	//Recuperation de l'evenement
		$gdProjectEvent = new EntityGrid("gdProjectEvent",$this->Core);
		$gdProjectEvent->Entity = "AgendaEvent";
		$gdProjectEvent->CssClass="profil";
		$gdProjectEvent->EmptyVisible = false;

		//Filtre sur l'utilisateur
		$gdProjectEvent->AddArgument(new Argument("AgendaEvent","ProjetId",EQUAL, $ProjetId));

		//Ajout des colonnes
		$gdProjectEvent->AddColumn(new EntityColumn($this->Core->GetCode("Title"),"Title"));
		$gdProjectEvent->AddColumn(new EntityColumn($this->Core->GetCode("DateStart"),"DateStart","","dateGrid"));
		$gdProjectEvent->AddColumn(new EntityColumn($this->Core->GetCode("DateEnd"),"DateEnd", "", "dateGrid"));

		//Edition d'un évenement'
		$Popup = new PopUp("Agenda", "AddNewEvent");
		$Popup->AddArgument("App","Agenda");
		$Popup->Title = $this->Core->GetCode("DetailEvent");

		//Suppression
		$gdProjectEvent->AddColumn(new ActionColumn("",$Popup,"",$this->Core->GetCode("Edit"), "icon-edit"));
	    $gdProjectEvent->AddColumn(new AjaxActionColumn("","Projet","DeleteEvent","App=Projet&ProjetId=".$ProjetId,"",$this->Core->GetCode("Delete"),"lstProjectEvents",true, "icon-remove"));

		 return $gdProjectEvent;
	 }
         
        /**
         * Obtient les rendez-vous lié à l'app
         */
        public function GetByApp($appName, $entityName, $entityId)
        {
            return EventHelper::GetByApp($this->Core, $appName, $entityName, $entityId);
        }
        
        /**
        * Obtient les derniers evenement de la boite de reception
        */
       public function GetInfo()
       {
           $html ="";
            
            //Obtient les dernière evenements
            $events = EventHelper::GetLast($this->Core);
            
            foreach($events as $event)
            {
                   $html .= "<div class='event'><a href='#' onclick='DashBoardManager.StartApp(\"\",\"Agenda\")'>";
                    
                   $html .= "<span class='date'>".Date::FormatFrench($event->DateStart->Value)."</span>";
                   $html .= "<span class='text'>".$event->Title->Value."</span></a>";
                 
                  $html .= "</div>";
            }
            
            return $html;
       }
}
?>