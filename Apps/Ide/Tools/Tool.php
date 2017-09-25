<?php
/**
 * Classe de base pour les outils
 */
class Tools
{
    //Propriete
    protected $Core;
    protected $Icone;
    protected $Title;
    protected $OnClick;
    
    function Tools($core)
    {
       $this->Core = $core; 
    }
    
    /**
     * Rendu html du control
     * @return string
     */
    public function Render()
    {
        return "<span class='".$this->Icone."' title='".$this->Title."' onclick=".$this->OnClick." >&nbsp;&nbsp;</span>";
    }
}