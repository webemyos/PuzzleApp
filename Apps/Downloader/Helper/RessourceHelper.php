<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

 namespace Apps\Downloader\Helper;

use Apps\Downloader\Entity\DownloaderRessource;
use Apps\Downloader\Entity\DownloaderRessourceContact;
use Core\Entity\Entity\Argument;
use Core\Utility\Format\Format;


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
    
    /*
     * Save the ressource
     */
    public static function SaveRessource($core, $ressourceId,  $name, $description)
    {
        $ressource = new DownloaderRessource($core);
        
        if($ressourceId != "")
        {
            $ressource->GetById($ressourceId);
        }
        
        $ressource->UserId->Value = $core->User->IdEntite;
        $ressource->Name->Value = $name;
        $ressource->Description->Value = $description;
        $ressource->Code->Value = Format::ReplaceForUrl($name);
        
        $ressource->Save();
    }
}
