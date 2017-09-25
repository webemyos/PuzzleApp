<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */


namespace Apps\Agenda\Module\Calendar;

use Apps\Agenda\Entity\AgendaEvent;
use Apps\Blog\Helper\DateHelper;
use Core\Control\Icone\DeleteIcone;
use Core\Control\Icone\EditIcone;
use Core\Control\Icone\GroupIcone;
use Core\Control\Image\Image;
use Core\Control\Libelle\Libelle;
use Core\Control\ListBox\ListBox;
use Core\Controller\Controller;
use Core\Entity\Entity\Argument;
use Core\Utility\Date\Date;


/*
 * Module de gestion du calendrier
 */
class CalendarController extends Controller
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
           * Charge une semaine du calendrier
           * @param type $weekNumber
           */
          function LoadWeek($WeekNumber)
          {
                //Construction du tableau
	 	$days = array('lundi', 'mardi', 'mercredi', 'jeudi', 'vendredi','samedi','dimanche');

		 //Semaine en cours
		$week =  ($WeekNumber == 'current')? date('W') : $WeekNumber;
		$year = date('Y');
		$StartDate  = Date::GetFirstDay($week, $year);

		//Affichage de la semaine et des controles de selection
                $TextControl = $this->GetTool($week);
		
                $TextControl .= "<div class='content-panel'>";
		//Tableau de la semaine
	 	$TextControl .= "<table id='taAgenda' class='calendar'>";

		//Entete
		$TextControl .= '<tr>';
		$TextControl .= '<td class="subTitle"></td>';

		//
		$dateDay = array();
		foreach($days as $day)
		{
                    //Creation de la date actuelle
                    $dateDay[] = $StartDate;

                    $TextControl .=	'<th class="subTitle">'.$this->Core->GetCode($day);
                    $TextControl .= '<span class="calendar date">'.$StartDate.'</span>';
                    $TextControl .= '</th>';

                    $StartDate = Date::AddDay($StartDate, 1);
		}

		//Creation des lignes
		$TextControl .= '</tr>';

		//recuperation des evenements de l'utilisateur
	 	$DateStart = Date::FormatMysql(Date::AddDay($dateDay[0],-1, true));
	 	$DateEnd = Date::FormatMysql(Date::AddDay($dateDay[0],7, true));

	 	$AgendaEvent = new AgendaEvent($this->Core);
	 	$AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "UserId", EQUAL, $this->Core->User->IdEntite));
	 	$AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "DateStart", MORE, $DateStart));
		$AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "DateEnd", LESS, $DateEnd));
		$EventsUser = $AgendaEvent->GetByArg();

		//Recuperation Des évenement ou l'utilisateur est invités
		$EventInvits = AgendaEvent::GetInvitation($this->Core, $this->Core->User->IdEntite, $DateStart, $DateEnd);

		for($hours=0; $hours < 24; $hours++)
		{
			$TextControl .= '<tr>';
			
			if($hours < 10)
			{
                            $hours = "0".$hours;
			}

                        $TextControl .= '<td>'.$hours.':00</td>';

                       //Parcourt des jours
			//foreach($dateDay as $day)
			for($d = 0; $d < count($dateDay) ; $d++ )
                        {
				//Charge un tableau avec touts les rendez-vous
				$drawCell = true;

				//Parcourt des rendez-vous de l'utilisateur
				if(count($EventsUser) > 0)
				{
					foreach($EventsUser as $event)
					{
						//Evenement qui commence dans la cellule
						if($event->DateStart->Value == $dateDay[$d].' '.$hours.':00:00' )
						{
                                                    //Dimension de l'evenement
                                                    $rowSpan = DateHelper::GetDiffHour($event->DateStart->Value, $event->DateEnd->Value);
                                                    $colSpan = DateHelper::GetDiffDay($event->DateStart->Value, $event->DateEnd->Value);
                                                    
                                                    
                                                    //Affichage de la cellule
                                                    $TextControl .=	 '<td id="'.$dateDay[$d].'!'.$hours.'" >';
                                                    $TextControl .= $this->GetEvent($event, $colSpan, $rowSpan);
                                                    $TextControl.='</td>';
                                            
                                                    $drawCell = false;
						}
					}
				}

				//Evenements invités
				if(count($EventInvits) > 0)
				{
					foreach($EventInvits as $event)
					{
						//Evenement qui commence dans la cellule
						if($event->Event->Value->DateStart->Value == $dateDay[$d].' '.$hours.':00:00' )
						{
                                                    //Dimension de l'evenement
                                                    $rowSpan = DateHelper::GetDiffHour($event->Event->Value->DateStart->Value, $event->Event->Value->DateEnd->Value);
                                                    $colSpan = DateHelper::GetDiffDay($event->Event->Value->DateStart->Value, $event->Event->Value->DateEnd->Value);
                                                    
                                                    //Affichage de la cellule
                                                    //$TextControl .=	 '<td id="'.$day.'!'.$hours.'"  colspan="'.$colSpan.'" rowspan="'.$rowSpan.'" >';
                                                    $TextControl .=	 '<td id="'.$dateDay[$d].'!'.$hours.'" >';
                                                    
                                                    $TextControl .=	$this->GetInvit($event, $colSpan, $rowSpan);
                                                    $TextControl.='</td>';

                                                    $drawCell = false;
						}
					}
				}

				//La cellule n'a pas d'évenement
				if($drawCell)
				{
					$TextControl .=	 '<td id="'.$dateDay[$d].'!'.$hours.'"></td>';
				}
			}

			$TextControl .= '</tr>';
		}
		$TextControl .= "</table'>";
                
                $TextControl .= "</div>";

		echo $TextControl;
          }
          
          /**
           * Obtient la barre d'outil
           */
          function GetTool($week)
          {
              $TextControl = "<div id='Week'>";
              
              $TextControl .= "<img src='../Apps/Agenda/Images/logo.png' />";

               $imgBefore = new Libelle("<b onclick='AgendaAction.LoadWeekBefore($week);' class='icon-arrow-left'  title='".$this->Core->GetCode("Agenda.WeekBefore")."' ></b>");
               $TextControl .= $imgBefore->show()." ";

               $imgAfter = new Libelle("<b onclick='AgendaAction.LoadWeekAfter($week);' class='icon-arrow-right' title='".$this->Core->GetCode("Agenda.WeekBefore")."' ></b>");
               $TextControl .= " ".$imgAfter->Show();

               
               //Semaine selectionnée
               $TextControl .= $this->Core->GetCode("Week") .' : ';

               $lstWeek = new ListBox("lstWeek");

               //Ajout des semaines
               for($i= 1 ; $i< 53; $i++)
               {
                       $lstWeek->Add($i, $i);
               }

               $lstWeek->Selected = $week;
               $lstWeek->OnChange = 'AgendaAction.LoadWeek(this)';
               $TextControl .= $lstWeek->Show();

               //Legend 
               $TextControl .=  "<i class='legendEvent'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.MyEvent")."</i>";
               $TextControl .=  "<i class='legendInvit'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.MyInvit")."</i>";
               $TextControl .=  "<i class='legendApp'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.EventApp")."</i>";

               $TextControl .= "</div><br/></div>";
               
               return $TextControl;
          }
          
          /*
           * Obtient un évenement
           */
          
          function GetEvent($event, $col, $row)
          {
              $TextControl ="";
              
              	if($event->AppName->Value != "")
                {
                        $TextControl .= "<div class='eventApp' id='".$event->IdEntite."' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' >".$event->Title->Value."<br/>";
                        $img = new Image("../Apps/".$event->AppName->Value."/images/logo.png");
                        $img->Title = $event->AppName->Value;
                                
                        $TextControl .= $img->Show();
                        
                        
                }
                else
                {
                        $TextControl .= "<div class='event' id='".$event->IdEntite."' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' >".$event->Title->Value."<br/>";
                        //Affichage des controles
                }

                $btnEdit = new EditIcone();
                $btnEdit->Title = $this->Core->GetCode("Edit");
                $btnEdit->Color ="green";
                $btnEdit->OnClick = "AgendaAction.Edit(".$event->IdEntite.", true)";
                $TextControl .= $btnEdit->Show();

                $btnUser = new GroupIcone();
                $btnUser->Title = $this->Core->GetCode("AddUser");
                $btnUser->Color ="green";
                $btnUser->OnClick = "AgendaAction.ShowAddUser(".$event->IdEntite.")";
                $TextControl .= $btnUser->Show();

                $btnDelete = new DeleteIcone();
                $btnDelete->Title = $this->Core->GetCode("Delete");
                $btnDelete->OnClick = "AgendaAction.DeleteEvent(this, ".$event->IdEntite.")";
                $TextControl .= $btnDelete->Show();

                $TextControl .= "</div>";
                
                return $TextControl;
          }
          
          /**
           * Récupere les invitation
           */
          function GetInvit($event, $col, $row)
          {
                if($event->Event->Value->ProjetId->Value != 0)
                {
                        $TextControl .= "<div class='eventProjet' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' id='".$event->IdEntite."' >".$event->Event->Value->Title->Value;
                        $TextControl .= "<br/>".$this->Core->GetCode('ProjetTitle'). " : ".$event->Event->Value->ProjetTitle->Value;
                        $TextControl .= "</div>";
                }
                else
                {
                        $TextControl .= "<div class='eventInvit' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' id='".$event->IdEntite."' >".$event->Event->Value->Title->Value;
                }

               // $TextControl .="(".$event->Event->Value->User->Value->GetPseudo().")";

                //Detail de l'évenement
                $imgEdit = new Libelle("<span class='icon-edit' title='". $this->Core->GetCode('Edit')."' onclick='AgendaAction.Edit(".$event->EventId->Value.", false);' ></span>");

                //Bouton D'ajout ou de refus
                if($event->Accept->Value != 1)
                {
                        $imgAccept = new Libelle("<span class='icon-check' title='". $this->Core->GetCode('Accept')."' onclick='AgendaAction.AcceptInvitation(this, ".$event->IdEntite.");' ></span>");
                        $imgRefuse = new Libelle("<span class='icon-remove' title='". $this->Core->GetCode('Refuse')."' onclick='AgendaAction.RefuseInvitation(this, ".$event->IdEntite.");' ></span>");

                        $TextControl .= "<br/><span class='action'>".$imgEdit->Show().' '.$imgAccept->Show(). ' '.$imgRefuse->Show()."</span>" ;
                }

                $TextControl .= "</div>";
                
                return $TextControl;
          }
}

?>
