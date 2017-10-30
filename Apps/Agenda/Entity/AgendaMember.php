<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Agenda\Entity;

use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;


class AgendaMember extends Entity
{
    // Propriété
    protected $User;
    protected $Event;

    function __construct($core)
    {
        //Version
        $this->Version ="2.0.1.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="AgendaMember";
        $this->Alias = "agMe";

        //Categorie
        $this->UserId = new Property("UserId","UserId",TEXTBOX,false,$this->Alias);
        $this->User = new EntityProperty("User","UserId");
        $this->UserId = new Property("Name","Name",EMAILBOX,false,$this->Alias);
        $this->UserId = new Property("FirstName","FirstName",TEXTBOX,false,$this->Alias);
        $this->UserId = new Property("Email","Email",TEXTBOX,false,$this->Alias);
        $this->EventId = new Property("EventId","EventId",TEXTBOX,false,$this->Alias);
        $this->Event = new EntityProperty("Apps\Agende\Entity\AgendaEvent","EventId");

        $this->Accept = new Property("Accept","Accept",CHECKBOX,false,$this->Alias);

        //Creation de l'entit�
        $this->Create();
    }

    /**
     * Verifie si le membre à déjà été ajouté
     * */
    function MemberExist($core, $eventId, $userId)
    {
        $request ="SELECT Id FROM Agenda_member WHERE EventId=".$eventId;
        $request .= " AND UserId = ".$userId;

        $result = $core->Db->GetLine($request);
        return $result["Id"] != "";
    }
}


?>