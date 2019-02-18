<?php


/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Devis\Helper;

use Apps\Devis\Entity\DevisAsk;
use Apps\Devis\Entity\DevisProjet;
use Core\Utility\Date\Date;
 
class ProjetHelper
{
    /**
     * Crée un nouveau projet
     * @param type $core
     * @param type $name
     * @param type $description
     */
    public static function Save($core, $libelle, $description)
    {
        $projet = new DevisProjet($core);
        $projet->UserId->Value = $core->User->IdEntite;
        $projet->Libelle->Value = $libelle;
        $projet->Description->Value = $description;

        $projet->Save();

        return true;
    }
    
    /*
     * Sauvegarde une demande de devis
     */
    public static function SaveAskDevis($core, $prestationId, $name, $email, $phone, $description)
    {
        $ask = new DevisAsk($core);
        $ask->PrestationId->Value = $prestationId;
        $ask->Name->Value = $name;
        $ask->Email->Value = $email;
        $ask->Phone->Value = $phone;
        $ask->Description->Value = $description;
        $ask->DateCreated->Value = Date::Now();
        
        $ask->Save();
    }
}
