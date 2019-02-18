<?php 
/* 
*Description de l'entite
*/
class EeCommerceProduct extends JHomEntity  
{
    protected $Category;
    protected $Marque;
    protected $Fournisseur;
    
	//Constructeur
	function EeCommerceProduct($core)
	{
		//Version
		$this->Version ="2.0.0.0"; 

		//Nom de la table 
		$this->Core=$core; 
		$this->TableName="EeCommerceProduct"; 
		$this->Alias = "EeCommerceProduct"; 

		$this->CommerceId = new Property("CommerceId", "CommerceId", NUMERICBOX,  false, $this->Alias); 
		$this->NameProduct = new Property("NameProduct", "NameProduct", TEXTBOX,  true, $this->Alias); 
		$this->RefProduct = new Property("RefProduct", "RefProduct", TEXTBOX,  true, $this->Alias); 
		$this->MarqueId = new Property("MarqueId", "MarqueId", NUMERICBOX,  false, $this->Alias); 
		$this->Marque = new EntityProperty("EeCommerceMarque", "MarqueId");
    		
                $this->Code = new Property("CodeProduct", "CodeProduct", TEXTBOX,  true, $this->Alias); 
		$this->SmallDescriptionProduct = new Property("SmallDescriptionProduct", "SmallDescriptionProduct", TEXTBOX,  true, $this->Alias); 
		$this->LongDescriptionProduct = new Property("LongDescriptionProduct", "LongDescriptionProduct", TEXTAREA,  false, $this->Alias); 
		$this->Actif = new Property("Actif", "Actif", CHECKBOX,  false, $this->Alias); 
		$this->FournisseurId = new Property("FournisseurId", "FournisseurId", NUMERICBOX,  false, $this->Alias); 
		$this->Fournisseur = new EntityProperty("EeCommerceFournisseur", "FournisseurId");
    
       	$this->CategoryId = new Property("CategoryId", "CategoryId", NUMERICBOX,  false, $this->Alias); 
		$this->Category = new EntityProperty("EeCommerceProductCategory", "CategoryId");
        $this->PriceBuy = new Property("PriceBuy", "PriceBuy", TEXTBOX,  false, $this->Alias); 
		$this->PriceVenteMini = new Property("PriceVenteMini", "PriceVenteMini", TEXTBOX,  false, $this->Alias); 
		$this->PriceVenteMaxi = new Property("PriceVenteMaxi", "PriceVenteMaxi", TEXTBOX,  false, $this->Alias); 
		$this->PricePort = new Property("PricePort", "PricePort", TEXTBOX,  false, $this->Alias); 
		$this->PriceDown = new Property("PriceDown", "PriceDown", TEXTBOX,  false, $this->Alias); 
		$this->Quantity = new Property("Quantity", "Quantity", TEXTBOX,  false, $this->Alias); 
		$this->ImageDefault = new Property("ImageDefault", "ImageDefault", TEXTBOX,  false, $this->Alias); 
        $this->DeliveryDelay = new Property("DeliveryDelay", "DeliveryDelay", TEXTBOX,  false, $this->Alias); 

        $this->LinkFournisseur = new Property("LinkFournisseur", "LinkFournisseur", TEXTBOX,  false, $this->Alias); 

		//Creation de l entité 
		$this->Create(); 
	}
      
        
        function GetName()
        {
            return JFormat::Tronquer($this->NameProduct->Value, 20);
        }
        
        function GetNameUrl()
        {
            return JFormat::ReplaceForUrl($this->NameProduct->Value);
        }
        
        function GetUrlImage()
        {
            return str_replace("_96.png", ".png" ,$this->ImageDefault->Value);
        }
        
        /*
         * Obtient l'image par défaut
         */
        function GetImage($height)
        {
            $image = new Image(str_replace("_96.png", "_300.png" ,$this->ImageDefault->Value));
            $image->Id = "imMax";
            
            if($width)
            {
                $image->AddStyle("height", $height);
            }
            //$image->AddStyle("min-height", "350px");
            
            return $image->Show();
        }
        
        /*
         * Obtient les images du produits
         */
        function GetImages()
        {
          //Product Directory
          $directory = "Data/Apps/EeCommerce/".$this->CommerceId->Value. "/product/".$this->IdEntite;
      
          if ($dh = opendir($directory))
          { $i=0;
         
             while (($file = readdir($dh)) !== false )
             {
               if($file != "." && $file != ".." && substr_count($file,"_96") == 0 && substr_count($file,"_300") == 0 )
               {
                   $nameFile[$i] = $directory."/".$file;
                   
                   $fileNameMini =str_replace(".png", "", $file);
                   $fileNameMini =str_replace(".jpg", "", $fileNameMini);
                   $fileNameMini =str_replace(".jpeg", "", $fileNameMini);
                   $fileNameMini =str_replace(".ico", "", $fileNameMini);
                     
                   $html .="<span class='col-md-4' >";
                   
                   $images = new Image($directory."/".$fileNameMini."_96.png");
                   $html .= $images->Show();
                   
                   $html .="</span>";
                   
                   $i++;
               }
             }
            }
            
            return $html;
        }
        
        /*
         * Obtient a pop in de détail d'un produit
         */
        function GetDetail()
        {
            $html =" <div class='modal fade' id='dvDetail_".$this->IdEntite."' tabindex='-1' role='dialog' aria-hidden='true'>
                <div class='modal-dialog'>
                        <div class='modal-content row'>
                                <div class='col-md-12' style='text-align:right'  onclick='VenteGivreeAction.CloseModal(\"dvDetail_".$this->IdEntite."\")' >Fermer</div>
                                <div class='col-md-8'>
                                    <p>".$this->GetImage("300px")."</p>
                                    <div class='lstImg row'>".$this->GetImages()."</div>
                                </div>
                                <div class='col-md-4'>
                                    <h2>".$this->NameProduct->Value."</h2>
                                     ".$this->GetMarque()."   
                                    <div >
                                        <p>".$this->LongDescriptionProduct->Value."</p>
                                    </div>
                                    <h3>".$this->Core->GetCode("StartPrice") ."- ".$this->PriceVenteMaxi->Value."€</h3>
                                    
                                    <div class='social-widget-wrap social-widget-none'>
                                        <a href='#' title='Facebook' target='_blank'>
                                                <i class='fa fa-facebook'></i>
                                        </a>
                                        <a href='#' title='Twitter' target='_blank'>
                                                <i class='fa fa-twitter'></i>
                                        </a>
                                        <a href='https://plus.google.com/share?url=http://ventegivree.com/product-".$this->NameProduct->Value.".html' rel='nofollow' onclick='javascript:window.open(this.href, &quot;&quot;, &quot;menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=400,width=700 ); title='Google+' target='_blank'>
                                                <i class='fa fa-google-plus'></i>
                                        </a>
                                        
                                    </div>
                               </div>
                        </div>
                </div>
        </div>
    </div> ";
            
            return $html;
            
        }
        
        /*
         * Obtient la marque si il y en a une
         */
        function GetMarque()
        {
            if($this->MarqueId->Value != "" )
            {
                //Recuperation de la marque
                $marque = new EeCommerceMarque($this->Core);
                $marque->GetById($this->MarqueId->Value);
                
                $file = "Data/Apps/EeCommerce/1/marque/".$marque->IdEntite. "_96.png";
                                  
                if(file_exists($file))
                {
                    $image = new Image($file);
                    $html = "<span>". $image->Show()."<br/>".$marque->Name->Value."</span>"; 
                }
                else
                {
                    $html = "<span>".$marque->Name->Value."</span>";
                }
                
                return $html;
            }
        }
        
        function GetFournisseur()
        {
            if($this->FournisseurId->Value != "" )
            {
                //Recuperation de la marque
                $fournisseur = new EeCommerceFournisseur($this->Core);
                $fournisseur->GetById($this->FournisseurId->Value);
                
                
                 $html = "<span>".$fournisseur->Name->Value."</span>";
                
                return $html;
            }
        }
        
        /*
         * Obtient la marque si il y en a une
         */
        function GetMarqueMini()
        {
            if($this->MarqueId->Value != "" )
            {
                //Recuperation de la marque
                $marque = new EeCommerceMarque($this->Core);
                $marque->GetById($this->MarqueId->Value);
                
                $file = "Data/Apps/EeCommerce/1/marque/".$marque->IdEntite. "_96.png";
                                  
                if(file_exists($file))
                {
                    $image = new Image($file);
                    $image->AddStyle("width", "30px");
                    $html = "<span>". $image->Show().$marque->Name->Value."</span>"; 
                }
                else
                {
                    $html = "<span>".$marque->Name->Value."</span>";
                }
                
                return $html;
            }
        }
}
?>