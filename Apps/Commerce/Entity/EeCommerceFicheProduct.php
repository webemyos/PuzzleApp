<?php 
/* 
*Description de l'entite
*/
class EeCommerceFicheProduct extends JHomEntity  
{
    //Constructeur
    function EeCommerceFicheProduct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="EeCommerceFicheProduct"; 
        $this->Alias = "EeCommerceFicheProduct"; 

        $this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  false, $this->Alias); 
        $this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
        $this->Code = new Property("Code", "Code", TEXTBOX,  true, $this->Alias); 
        $this->KeyWord = new Property("KeyWord", "KeyWord", TEXTAREA,  true, $this->Alias); 
        $this->ShortDescription = new Property("ShortDescription", "ShortDescription", TEXTAREA,  false, $this->Alias); 
        $this->LongDescription = new Property("LongDescription", "LongDescription", TEXTAREA,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Obtient l'image du premier produit
     */
    function GetImage()
    {
        //Obtient les images par défaut de chaque produit de la fiche
        $ficheProduct = new EeCommerceFicheProductProduct($this->Core);
        $ficheProduct->AddArgument(new Argument("EeCommerceFicheProductProduct", "FicheId", EQUAL, $this->IdEntite));
        $products = $ficheProduct->GetByArg();
            
        $html = "<div>";
        
        foreach($products as $product)
        {
           $img = new Image($product->Product->Value->ImageDefault->Value);
           $img->Alt = $img->Title = $product->Product->Value->NameProduct->Value;
           
           $html .= "<div class='col-md-4' >" . $img->Show()."</div>";  
        }
        
        $html .= "</div>";
        
        return $html;
        
    }
}
?>