<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Captcha;

use Core\Core\Core;
use Core\App\Application;
use Core\View\View;
use Core\View\ElementView;

use Core\Control\Hidden\Hidden;
use Core\Control\TextBox\TextBox;
use Core\Core\Request;

/**
 * Base of the App
 *
 * @author jerome
 */
class Captcha extends Application
{
        /*
     * Créate de app Base
     */
    public function __construct()
    {
        $this->Core = Core::getInstance();
    }

    /**
     * Get Captcha widget
     */
    public function GetWidget()
    {
        $view = new View(__DIR__."/View/index.tpl", $this->Core);

        $number1 = rand(1,10);
        $number2 = rand(1,10);

        $view->AddElement(new ElementView("question",  $number1 . "+" . $number2));

        //Save the code in session
        Request::SetSession("captcha",  base64_encode($number1 + $number2));

        $tbCaptcha = new TextBox("tbCaptcha");
        $tbCaptcha->Required = true;
        $view->AddElement($tbCaptcha);

        return $view->Render();
    }
    
    /**
     * Valide the Post Data
     */
    public static function IsValid()
    {
       $tbCaptcha = Request::GetPost("tbCaptcha");
       $captcha = base64_decode(Request::GetSession("captcha"));

        return $captcha == $tbCaptcha;
    }
}
    