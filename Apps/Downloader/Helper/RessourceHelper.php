<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader\Helper;

 use Core\Entity\Entity\Argument;

 use Apps\Downloader\Entity\DownloaderRessourceContact;


class RessourceHelper
{

    /**
     * Obtient le nombre d'email
     * @param type $core
     * @param type $ressourceId
     */
    public static function GetNumberEmail($core, $ressourceId)
    {
        $contact = new DownloaderRessourceContact($core);
        $contact->AddArgument(new Argument("Apps\Downloader\Entity\DownloaderRessourceContact", "RessourceId", EQUAL, $ressourceId));

        return count($contact->GetByArg());
    }
}
