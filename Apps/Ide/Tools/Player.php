<?php
/**
 * Outil pour lander l'application
 */
class Player extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "fa fa-play";
        $this->Title = $this->Core->GetCode("Play");
        $this->OnClick = "IdeTool.Play();";
        
        return parent::Render();
    }
}
