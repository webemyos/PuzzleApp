<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Upload;

use Core\Core\Core;
use Core\Control\IControl;
use Core\Control\Control;

class Upload extends Control implements IControl
{
    private $app;
    private $idElement;
    private $callBack;
    private $action;
    private $idUpload;


    //Constructeur
    function __construct($app, $id, $callBack, $action = false, $idUpload ="fileToUpload")
    {
        //Version
        $this->Version ="2.0.0.0";
        $this->app = $app;
        $this->idElement = $id;
        $this->callBack = $callBack;
        $this->action = $action;
        $this->idUpload = $idUpload;
    }

    /*
    * Render the control
    */
    function Show($show = false)
    {
        $core = Core::getInstance();

        $html = "<div>";

        $html .="<input type='file' id='fileUpload' name='fileUpload' />";
        $html .= "<input type='button' value='".$core->GetCode("Submit")."' onclick='upload.doUpload(this)' /> ";

        $html .= "<input type='hidden' id='hdApp' name = 'hdApp'  value='".$this->app."'  /> ";
        $html .= "<input type='hidden' id='hdIdElement' name='hdIdElement' value='".$this->idElement."'  /> ";
        $html .= "<input type='hidden' id='hdCallBack' name='hdCallBack' value='".$this->callBack."' /> ";
        $html .= "<input type='hidden' id='hdAction' name='hdAction' value='".$this->action."' /> ";
        $html .= "<input type='hidden' id='hdIdUpload'  name='hdIdUpload' value='".$this->idUpload."' /> ";

        //Frame From Upload
        if($show)
        {
           $html .= "<iframe id='frUpload' src='upload' style='display:block' >";
        }
        else
        {
          $html .= "<iframe id='frUpload' src='upload' style='display:none' >";
        }

        $html .= "</iframe>";
        $html .= "</div>";

        return $html;
    }

    /*
    * Get the Iframe Content uploader
    */
    public static function ShowUploader()
    {
        $html = "<form action='' method='POST' id='formUpload' enctype='multipart/form-data'>";
        $html .= "<h2>Uploader</h2>";
        $html .= "<input type='hidden' name='hdPost'  value='posted' >";

        $html .= "</form>";

        return $html;
    }

    /*
     * Call the DoUpload App
     */
    public static function DoUpload($appName, $idElement, $tmpFileName, $fileName, $action)
    {
        $appName = "\\Apps\\".$appName . "\\".$appName;

        $app = new $appName();
        $app->DoUploadFile($idElement, $tmpFileName, $fileName, $action);
    }
}
?>