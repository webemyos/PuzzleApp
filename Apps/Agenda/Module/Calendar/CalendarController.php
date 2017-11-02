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
        echo  $StartDate  = Date::GetFirstDay($week, $year);

          //Affichage de la semaine et des controles de selection
          $html = $this->GetTool($week);

          $html .= "<div class='content-panel'>";
          //Tableau de la semaine
          $html .= "<table id='taAgenda' class='calendar'>";

          //Entete
          $html .= '<tr>';
          $html .= '<td class="subTitle"></td>';

          //
          $dateDay = array();
          foreach($days as $day)
          {
              //Creation de la date actuelle
              $dateDay[] = $StartDate;

              $html .=	'<th class="subTitle">'.$this->Core->GetCode($day);
              $html .= '<span class="calendar date">'.$StartDate.'</span>';
              $html .= '</th>';

              $StartDate = Date::AddDay($StartDate, 1);
          }

          //Creation des lignes
          $html .= '</tr>';

          //recuperation des evenements de l'utilisateur
          echo "DateStart : " . $DateStart = Date::AddDay($dateDay[0],-1, true);
          echo "Date End :"  . $DateEnd = Date::AddDay($dateDay[0],7, true);

          $AgendaEvent = new AgendaEvent($this->Core);
          $AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "UserId", EQUAL, $this->Core->User->IdEntite));
          $AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "DateStart", MORE, $DateStart));
          $AgendaEvent->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "DateEnd", LESS, $DateEnd));
          $EventsUser = $AgendaEvent->GetByArg();

          //Recuperation Des évenement ou l'utilisateur est invités
          $EventInvits = AgendaEvent::GetInvitation($this->Core, $this->Core->User->IdEntite, $DateStart, $DateEnd);

          for($hours=0; $hours < 24; $hours++)
          {
                  $html .= '<tr>';

                  if($hours < 10)
                  {
                      $hours = "0".$hours;
                  }

                  $html .= '<td>'.$hours.':00</td>';

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
                                      echo "DATE :" . $event->DateStart->Value  . "" . $dateDay[$d].' '.$hours.':00:00';
                                      
                                          //Evenement qui commence dans la cellule
                                          if($event->DateStart->Value == $dateDay[$d].' '.$hours.':00:00' )
                                          {
                                              //Dimension de l'evenement
                                              $rowSpan = DateHelper::GetDiffHour($event->DateStart->Value, $event->DateEnd->Value);
                                              $colSpan = DateHelper::GetDiffDay($event->DateStart->Value, $event->DateEnd->Value);


                                              //Affichage de la cellule
                                              $html .=	 '<td id="'.$dateDay[$d].'!'.$hours.'" >';
                                              $html .= $this->GetEvent($event, $colSpan, $rowSpan);
                                              $html.='</td>';

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
                                              //$html .=	 '<td id="'.$day.'!'.$hours.'"  colspan="'.$colSpan.'" rowspan="'.$rowSpan.'" >';
                                              $html .=	 '<td id="'.$dateDay[$d].'!'.$hours.'" >';

                                              $html .=	$this->GetInvit($event, $colSpan, $rowSpan);
                                              $html.='</td>';

                                              $drawCell = false;
                                          }
                                  }
                          }

                          //La cellule n'a pas d'évenement
                          if($drawCell)
                          {
                                  $html .=	 '<td id="'.$dateDay[$d].'!'.$hours.'"></td>';
                          }
                  }

                  $html .= '</tr>';
          }
          $html .= "</table'>";

          $html .= "</div>";

          echo $html;
    }

    /**
     * Obtient la barre d'outil
     */
    function GetTool($week)
    {
        $html = "<div id='Week'>";

        $html .= "<img src='../Apps/Agenda/Images/logo.png' />";

         $imgBefore = new Libelle("<b onclick='AgendaAction.LoadWeekBefore($week);' class='icon-arrow-left'  title='".$this->Core->GetCode("Agenda.WeekBefore")."' ></b>");
         $html .= $imgBefore->show()." ";

         $imgAfter = new Libelle("<b onclick='AgendaAction.LoadWeekAfter($week);' class='icon-arrow-right' title='".$this->Core->GetCode("Agenda.WeekBefore")."' ></b>");
         $html .= " ".$imgAfter->Show();


         //Semaine selectionnée
         $html .= $this->Core->GetCode("Week") .' : ';

         $lstWeek = new ListBox("lstWeek");

         //Ajout des semaines
         for($i= 1 ; $i< 53; $i++)
         {
                 $lstWeek->Add($i, $i);
         }

         $lstWeek->Selected = $week;
         $lstWeek->OnChange = 'AgendaAction.LoadWeek(this)';
         $html .= $lstWeek->Show();

         //Legend 
         $html .=  "<i class='legendEvent'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.MyEvent")."</i>";
         $html .=  "<i class='legendInvit'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.MyInvit")."</i>";
         $html .=  "<i class='legendApp'>&nbsp;</i><i>".$this->Core->GetCode("Agenda.EventApp")."</i>";

         $html .= "</div><br/></div>";

         return $html;
    }

    /*
     * Obtient un évenement
     */

    function GetEvent($event, $col, $row)
    {
        $html ="";

          if($event->AppName->Value != "")
          {
                  $html .= "<div class='eventApp' id='".$event->IdEntite."' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' >".$event->Title->Value."<br/>";
                  $img = new Image("../Apps/".$event->AppName->Value."/images/logo.png");
                  $img->Title = $event->AppName->Value;

                  $html .= $img->Show();


          }
          else
          {
                  $html .= "<div class='event' id='".$event->IdEntite."' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' >".$event->Title->Value."<br/>";
                  //Affichage des controles
          }

          $btnEdit = new EditIcone();
          $btnEdit->Title = $this->Core->GetCode("Edit");
          $btnEdit->Color ="green";
          $btnEdit->OnClick = "AgendaAction.Edit(".$event->IdEntite.", true)";
          $html .= $btnEdit->Show();

          $btnUser = new GroupIcone();
          $btnUser->Title = $this->Core->GetCode("AddUser");
          $btnUser->Color ="green";
          $btnUser->OnClick = "AgendaAction.ShowAddUser(".$event->IdEntite.")";
          $html .= $btnUser->Show();

          $btnDelete = new DeleteIcone();
          $btnDelete->Title = $this->Core->GetCode("Delete");
          $btnDelete->OnClick = "AgendaAction.DeleteEvent(this, ".$event->IdEntite.")";
          $html .= $btnDelete->Show();

          $html .= "</div>";

          return $html;
    }

    /**
     * Récupere les invitation
     */
    function GetInvit($event, $col, $row)
    {
          if($event->Event->Value->ProjetId->Value != 0)
          {
                  $html .= "<div class='eventProjet' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' id='".$event->IdEntite."' >".$event->Event->Value->Title->Value;
                  $html .= "<br/>".$this->Core->GetCode('ProjetTitle'). " : ".$event->Event->Value->ProjetTitle->Value;
                  $html .= "</div>";
          }
          else
          {
                  $html .= "<div class='eventInvit' style='width:".(150 * $col) ."px; height:".(50 * $row)."px' id='".$event->IdEntite."' >".$event->Event->Value->Title->Value;
          }

         // $html .="(".$event->Event->Value->User->Value->GetPseudo().")";

          //Detail de l'évenement
          $imgEdit = new Libelle("<span class='icon-edit' title='". $this->Core->GetCode('Edit')."' onclick='AgendaAction.Edit(".$event->EventId->Value.", false);' ></span>");

          //Bouton D'ajout ou de refus
          if($event->Accept->Value != 1)
          {
                  $imgAccept = new Libelle("<span class='icon-check' title='". $this->Core->GetCode('Accept')."' onclick='AgendaAction.AcceptInvitation(this, ".$event->IdEntite.");' ></span>");
                  $imgRefuse = new Libelle("<span class='icon-remove' title='". $this->Core->GetCode('Refuse')."' onclick='AgendaAction.RefuseInvitation(this, ".$event->IdEntite.");' ></span>");

                  $html .= "<br/><span class='action'>".$imgEdit->Show().' '.$imgAccept->Show(). ' '.$imgRefuse->Show()."</span>" ;
          }

          $html .= "</div>";

          return $html;
    }
}

?>
