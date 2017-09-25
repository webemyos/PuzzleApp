<?php
/**
 * Outil pour rafraichir l'application
 */
class Refresh extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "fa fa-share";
        $this->Title = $this->Core->GetCode("Refresh");
        $this->OnClick = "IdeTool.Refresh();";
        
        return parent::Render();
    }
}
