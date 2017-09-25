<?php
/**
 * Outil pour sauvegarder l'application
 */
class Saver extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "fa fa-save";
        $this->Title = $this->Core->GetCode("Save");
        $this->OnClick = "IdeTool.Save();";
        
        return parent::Render();
    }
}
