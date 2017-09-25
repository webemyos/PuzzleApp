<?php
/**
 * Outil pour créer la landing Page
 */
class LandingPager extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "fa fa-comment";
        $this->Title = $this->Core->GetCode("LandingPage");
        $this->OnClick = "IdeTool.LoadLandingPage();";
        
        return parent::Render();
    }
}
