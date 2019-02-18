<?php 
/* 
*Description de l'entite
*/
class EeCommerceMarque extends JHomEntity  
{
	//Constructeur
	function EeCommerceMarque($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceMarque"; 
		$this->Alias = "EeCommerceMarque"; 

		$this->CommerceId = new Property("CommerceId", "CommerceId", NUMERICBOX,  true, $this->Alias); 
		$this->Name = new Property("Name", "Name", TEXTBOX,  true, $this->Alias); 
		
		//Creation de l entité 
		$this->Create(); 
	}
        
        /*
         * Get the Image
         */
        function GetImage()
        {
            $directory = "../Data/Apps/EeCommerce/1/marque/";
            $file = $directory."/".$this->IdEntite."_96.png";
            
            if(file_exists($file))
            {
                $image = new Image($file);
                return $image->Show();
            }
            else
            {
                return "";
            }
        }
}
?>