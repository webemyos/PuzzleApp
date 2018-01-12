<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Control\Icone;

use Core\Control\IControl;
use Core\Control\Control;


class Icone extends Control implements IControl
{
    //Proprietes
    private $Directory;
    private $Src;
    private $Title;
    private $Description;
    private $Alt;
    public $Color;
    public $ToolTip;
    public $Action;
    public $IdEntite;
    public $Params;
    
    //Constructeur
    function __construct()
    {
        //Version
        $this->Version ="2.0.0.1";
    }

    //Affichage
    function Show()
    {
        $html ="\n<span ";

        $this->CssClass .= " ".$this->Color;

        $html .= $this->getProperties();
        $html .=" title='".$this->Title."'";
        $html .=" alt ='".$this->Alt."'";

        if($this->Action != "")
        {
            $html .=" data-action ='".$this->Action."'";
        }
        
        if($this->IdEntite)
        {
            $html .=" data-idEntite ='".$this->IdEntite."'";
        }
        
        if($this->Params)
        {
            $html .=" data-params ='".$this->Params."'";
        }
        if($this->ToolTip != "")
        {
           $html .= " onmouseenter=\"".$this->ToolTip->DoAction()."\"";
        }

        $html .="  >";

        $html .="</span>";

        return $html ;
    }

    //Asseceurs
    public function __get($name)
    {
        return $this->$name;
    }

    public function __set($name,$value)
    {
      $this->$name=$value;
    }
}



/*
* Icone de suppression
*/
class RemoveIcone extends Icone
{
    function RemoveIcone()
    {
        $this->CssClass = "icon-remove";
    }
}

/*
* Icone de validation
*/
class ValideIcone extends Icone
{
	function ValideIcone()
	{
		$this->CssClass = "icon-ok";
		$this->Color = "green";
	}
}

/*
* Icone de boite de recepetion
*/
class EnvelopeIcone extends Icone
{
	function EnvelopeIcone()
	{
		$this->CssClass = "icon-envelope";
	}
}

/*
* Icone de extendn
*/
class ExpandIcone extends Icone
{
	function ExpandIcone()
	{
		$this->CssClass = "icon-expand";
	}
}

/*
* Icone de rafraichissement
*/
class RefreshIcone extends Icone
{
	function RefreshIcone($core)
	{
		$this->CssClass = "icon-refresh";
                $this->Title = $core->GetCode("Refresh");
	}
}

/*
* Icone d'information
*/
class InformationIcone extends Icone
{
	function InformationIcone()
	{
		$this->CssClass = "fa fa-exclamation";
	}
}

/*
* Icone d'information
*/
class HelpIcone extends Icone
{
	function HelpIcone()
	{
		$this->CssClass = "fa fa-question";
	}
}

/*
* Icone d'information
*/
class BugIcone extends Icone
{
	function BugIcone()
	{
		$this->CssClass = "icon-bug";
	}
}

/*
* Icone de dossier
*/
class FolderIcone extends Icone
{
	function FolderIcone()
	{
		$this->CssClass = "icon-folder-open";
	}
}



/*
* Icone d'accueil
*/
class HomeIcone extends Icone
{
	function HomeIcone()
	{
		$this->CssClass = "icon-home";
	}
}

/*
* Icone Search
*/
class SearchIcone extends Icone
{
	function SearchIcone()
	{
		$this->CssClass = "icon-search";
	}
}



/*
* Icone de partage
*/
class ShareIcone extends Icone
{
	function ShareIcone()
	{
		$this->CssClass = "icon-share";
	}
}

/*
* Icone de de panier
*/
class CartIcone extends Icone
{
	function CartIcone()
	{
		$this->CssClass = "icon-shopping-cart";
	}
}

/**
 * Disquette
 */
class SaveIcone extends Icone
{
    function SaveIcone($core ="")
    {
        $this->CssClass = "icon-save";

        if($core != "" && get_class($core) == "Core")
        {
            $this->Title = $core->GetCode("Save");
        }
    }
}

/**
 * Calendrier
 */
class DateIcone extends Icone
{
    function DateIcone($core="")
    {
        $this->CssClass = "fa fa-calendar";

        if($core != null)
        {
            $this->Title = $core->GetCode("Save");
        }
    }
}

/**
 * Zoom +
 */
class ZoomInIcone extends Icone
{
    function ZoomInIcone()
    {
        $this->CssClass = "icon-zoom-in";
    }
}


?>
