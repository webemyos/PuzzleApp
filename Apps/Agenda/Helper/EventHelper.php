<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Agenda\Helper;

use Apps\Agenda\Entity\AgendaEvent;
use Core\Entity\Entity\Argument;


class EventHelper
{
    /**
     * Obtient les evenement lié a l'app
     * @param type $ore
     * @param type $appName
     * @param type $entityName
     * @param type $entityId
     */
    public static function GetByApp($core, $appName, $entityName, $entityId)
    {
        $event = new AgendaEvent($core);
        
        $event->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent","AppName", EQUAL, $appName));
        $event->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent","EntityName", EQUAL, $entityName));
        $event->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent","EntityId", EQUAL, $entityId));
        
        $event->AddOrder("DateStart");
  
        return $event->GetByArg();
    }
    
    /**
     * Obtient les dernier évenements
     * @param type $core
     */
    public static function GetLast($core)
    {
        $event = new AgendaEvent($core);
        $event->AddArgument(new Argument("Apps\Agenda\Entity\AgendaEvent", "UserId", EQUAL, $core->User->IdEntite));
        $event->AddOrder("DateStart");
        $event->SetLimit(1, 3);
        
        return $event->GetByArg();
    }
}

?>
