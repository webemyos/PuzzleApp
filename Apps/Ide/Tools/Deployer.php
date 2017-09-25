<?php
/**
 * Outil pour deployer l'application sur Webemyos
 */
class Deployer extends Tools
{
    //Affiche le control
    public function Render()
    {
        $this->Icone = "fa fa-share";
        $this->Title = $this->Core->GetCode("Deploy");
        $this->OnClick = "IdeTool.Deploy();";
        
        return parent::Render();
    }
}
