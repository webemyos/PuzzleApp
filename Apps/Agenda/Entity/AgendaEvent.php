<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Agenda\Entity;

use Apps\Agenda\Entity\AgendaMember;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class AgendaEvent extends Entity
{
    // Propriété
    protected $User;

    function __construct($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="AgendaEvent";
        $this->Alias = "agen";

        //proprietes
        $this->Title = new Property("Title","Title",TEXTBOX,false,$this->Alias);
        $this->Code = new Property("Code","Code",TEXTBOX,false,$this->Alias);

        $this->Commentaire = new Property("Commentaire","Commentaire",TEXTAREA,false,$this->Alias);

        //Categorie
        $this->UserId = new Property("UserId","UserId",TEXTBOX,false,$this->Alias);
        $this->User = new EntityProperty("Core\Entity\Entity\User","UserId");

        //Date
        $this->DateStart = new Property("DateStart", "DateStart", DATETIMEBOX, false,$this->Alias);
        $this->DateEnd = new Property("DateEnd", "DateEnd", DATETIMEBOX, false,$this->Alias);
        $this->Public = new Property("Public", "Public",TEXTBOX,false,$this->Alias);

        //Partage entre application 
        $this->AddSharedProperty();

        //Creation de l'entit�
        $this->Create();
    }

    /**
     * Récupere les évenements dont l'utilisateur fait partie
     * */
    static function GetInvitation($core, $userId, $dateStart, $dateEnd)
    {
        $request = "SELECT member.Id as Id FROM
                        AgendaEvent AS agenda
                                JOIN AgendaMember AS member ON member.EventId = agenda.Id
                                WHERE member.UserId = ".$userId."
                                AND agenda.DateStart >= '".$dateStart."'
                                AND agenda.DateEnd <= '".$dateEnd."'
                                AND ( isnull(member.Accept)  OR member.Accept = 1) ";

        $results = $core->Db->GetArray($request);
        $Events = array();

        if($results != '')
        {
                foreach($results as $result)
                {
                        $Event = new AgendaMember($core);
                        $Event->GetById($result["Id"]);
                        $Events[] = $Event;
                }
        }

        return $Events;
    }
}
?>