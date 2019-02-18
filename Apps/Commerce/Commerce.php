<?php
/**
 * Application de type E Commerce
 * */
namespace Apps\Commerce;

use Apps\Base\Base;
use Core\Core\Request;

use Apps\Commerce\Module\Commerce\CommerceController;
use Apps\Commerce\Helper\CommerceHelper;

class Commerce extends Base
{
	/**
	 * Auteur et version
	 * */
	public $Author = 'Eemmys';
	public $Version = '1.0.0';
    public static $Directory = "../Apps/EeCommerce";

	/**
	 * Constructeur
	 * */
	function __construct($core)
	{
	 	parent::__construct($core, "Commerce");
	 	$this->Core = $core;
    }

	/**
	 * Execution de l'application
	 */
	function Run()
	{
       echo parent::RunApp($this->Core, "Commerce", "Commerce");
	}
        
    /**
     * Pop in d'ajout d'un ecommerce
     */
    function ShowAddCommerce()
    {
        $commerceController = new CommerceController($this->Core);
        echo $commerceController->ShowAddCommerce();
    }
        
    /**
     * Enregistrement d'un commerce
     */
    function SaveCommerce()
    {
        CommerceHelper::SaveCommerce($this->Core,
                                    Request::GetPost("tbNameCommerce"),
                                    Request::GetPost("tbTitleCommerce"),
                                    Request::GetPost("tbSmallDescription"),
                                    Request::GetPost("tbLongDescription")
                );
        
        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }

    /*
    * Charge les commerces de l'utilisateur
    */
    function LoadMyCommerce()
    {
        $commerceController = new CommerceController($this->Core);($this->Core);
        echo $commerceController->LoadMyCommerce();
    }
        
    /**
     * Charge un commerce
     */
    public function LoadCommerce()
    {
        $commerceController = new CommerceBlock($this->Core);
        echo $commerceController->LoadCommerce(Request::GetPost("CommerceId"), Request::GetPost("commerceName"));
    }
        
    /**
     * Met à jour les information du commerce
     */
    public function UpdateCommerce()
    {
        if(Request::GetPost("Name"))
        {
                CommerceHelper::UpdateCommerce($this->Core, Request::GetPost("idCommerce"), 
                                            Request::GetPost("Name"), 
                                            Request::GetPost("Title"),
                                            Request::GetPost("SmallDescription"),
                                            Request::GetPost("LongDescription")
                        ); 
                
                echo "<span id='lbResult' class='success'>".$this->Core->GetCode("SaveOk")."</span>";
        }
        else
        {
                echo "<b id='lbResult' class='error'>".$this->Core->GetCode("Error")."</span>";
        }
    }
        
    /*
        * Pop in d'ajout de categorie de produit
        */
    public function ShowAddCategorie()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowAddCategory(Request::GetPost("commerceId"), Request::GetPost("categoryId"));
    }
       
    /**
     * Sauvegarde une catégorie
     */
    public function SaveCategory()
    {
            CommerceHelper::SaveCategory($this->Core,
                                    Request::GetPost("commerceId"),
                                    Request::GetPost("tbNameCategory"),
                                    Request::GetPost("tbDescriptionCategory"),
                                    Request::GetPost("categoryId")
                                        );
        
        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }
    
        /*
        * Pop in d'ajout de fournisseur
        */
    public function ShowAddFournisseur()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowAddFournisseur(Request::GetPost("commerceId"), Request::GetPost("fournisseurId"));
    }
    
        /*
        * Pop in d'ajout de marque
        */
    public function ShowAddMarque()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowAddMarque(Request::GetPost("commerceId"), Request::GetPost("marqueId"));
    }
    
        /**
     * Sauvegarde une marque
     */
    public function SaveMarque()
    {
            CommerceHelper::SaveMarque($this->Core,
                                    Request::GetPost("commerceId"),
                                    Request::GetPost("tbNameMarque"),
                                    Request::GetPost("marqueId")
                                        );
        
        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }
    
    /*
        * Crée un compte Strip
        */
    public function CreateStripeAccount()
    {
        echo VirementHelper::CreateStripeAccount($this->Core, Request::GetPost("fournisseurId"));
    }
    
    /*
        * valide un compte Strip
        */
    public function ValideStripeAccount()
    {
        echo VirementHelper::ValideStripeAccount($this->Core, Request::GetPost("fournisseurId"));
    }
    
        /**
     * Sauvegarde un fournisseur
     */
    public function SaveFournisseur()
    {
            CommerceHelper::SaveFournisseur($this->Core,
                                    Request::GetPost("commerceId"),
                                    Request::GetPost("tbNameFournisseur"),
                                    Request::GetPost("tbContactFournisseur"),
                                    Request::GetPost("tbEmailFournisseur"),
                                    Request::GetPost("tbTelephoneFournisseur"),
                                    Request::GetPost("tbAdresseFournisseur"),
                                    Request::GetPost("tbCommissionFournisseur"),
                                    Request::GetPost("fournisseurId")
                                        );
        
        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }
    
    /*
        * Pop in d'ajout de produit
        */
    public function ShowAddProduct($productId = "")
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowAddProduct(Request::GetPost("commerceId"), $productId ? $productId: Request::GetPost("productId"));
    }
    
    /**
     * Sauvegarde un produit
     */
    public function SaveProduct()
    {  
        //Sauvegarde le produit
        if(ProductHelper::SaveProduct($this->Core,
                                    Request::GetPost("commerceId"),     
                                    Request::GetPost("productId"),     
                                    Request::GetPost("NameProduct"), 
                                    Request::GetPost("MarqueId"),
                                    Request::GetPost("Actif") == 1,     
                                    Request::GetPost("PriceBuy"),     
                                    Request::GetPost("PriceVenteMini"),     
                                    Request::GetPost("PriceVenteMaxi"), 
                                    Request::GetPost("PricePort"),     
                                    Request::GetPost("PriceDown"),  
                                    Request::GetPost("Quantity"),
                                    Request::GetPost("DeliveryDelay"),
                                    Request::GetPost("SmallDescriptionProduct"),     
                                    Request::GetPost("LongDescriptionProduct"),
                                    Request::GetPost("CategoryId"),
                                    Request::GetPost("FournisseurId"),
                                    Request::GetPost("MarqueId"),
                                    Request::GetPost("LinkFournisseur")
                                    
                                    )
                )
        { 
            
            //Recuperation de l'identifiant
            $productId = Request::GetPost("productId")? Request::GetPost("productId") : $this->Core->Db->GetInsertedId();
            
            echo "<div class='success' ><br/>".$this->Core->GetCode("SaveOk")."</div>";
            
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("SaveError")."</span>";
        }
        
        //Affiche 
        $this->ShowAddProduct($productId);
    }
    
    /**
     * Pop in d'ajout d'une seance de vente
     */
    function ShowAddSeanceVente($idSeance ="")
    {
        $saleBlock = new SaleBlock($this->Core);
        echo $saleBlock->ShowAddSeanceVente(Request::GetPost("commerceId"),$idSeance != "" ? $idSeance : Request::GetPost("seanceId"));
    }
    
    /*
        * Sauvegarde une seance
        */
    function SaveSeance()
    {
        $idSeance = SeanceHelper::SaveSeance($this->Core,
                                Request::GetPost("Libelle"),
                                    Request::GetPost("DateStart"),
                                    Request::GetPost("DateEnd"),
                                    Request::GetPost("commerceId"),
                                    Request::GetPost("seanceId")
                                    );
        
        echo "<span class='success' >".$this->Core->GetCode("SaveOk")."<span>";
        
        $this->ShowAddSeanceVente($idSeance);
    }
    
    /*
        * Obtient une liste déroulante des produits, fournisseur ou catégorie
        */
    function LoadAddByType()
    {
        $saleBlock = new SaleBlock($this->Core);
        echo $saleBlock->LoadAddByType(Request::GetPost("type"), Request::GetPost("seanceId"), Request::GetPost("field"));
    }
    
    /**
     * Ajoute une nouvelle ligne à la seance de vente
     */
    function AddLigneSeance()
    {
        SeanceHelper::AddLigne($this->Core,
                                Request::GetPost("SeanceId"),
                                Request::GetPost("type0"),
                                Request::GetPost("subType0"),
                                Request::GetPost("type1"),
                                Request::GetPost("subType1"),
                                Request::GetPost("type2"),
                                Request::GetPost("subType2")
                );
        
            $saleBlock = new SaleBlock($this->Core);
            echo $saleBlock->GetArticleLines(Request::GetPost("SeanceId"), false);
    }
    
    /*
        * Edite une seance de vente
        */
    function EditeVente()
    {
            $saleBlock = new SaleBlock($this->Core);
            echo $saleBlock->EditeVente(Request::GetPost("venteId"), false);
    }
    
    /*
        * Met à jour le produit d'une vente
        */
    function UpdateVente()
    {
        SeanceHelper::UpdateVente($this->Core, Request::GetPost("venteId"), Request::GetPost("productId"));
        
        $product = ProductHelper::GetProductQuantity($this->Core, Request::GetPost("productId")); 
        
        
        echo $product[0]["NameProduct"] . "(".$product[0]["QuantityProduct"]. ":". $product[0]["QuantityReference"] .")";
    }
    
    /*
        * Obtient les images des produits
        */
    function GetImagesProduct()
    {
        $productBlock = new ProductBlock($this->Core);
        $product = new EeCommerceProduct($this->Core);
        $product->GetById(Request::GetPost("productId"));
        
        echo $productBlock->GetImages($product);
    }
    
    /*
        * Charge la partie administration
        */
    public function LoadAdmin()
    {
        $adminBlock = new AdminBlock($this->Core);
        echo $adminBlock->Show(); 
    }
    
    /**
     * Rafrachit un onglet
     */
    function RefreshTab()
    {
        $commerce = new EeCommerceCommerce($this->Core);
        $commerce->GetById(Request::GetPost("CommerceId"));
        
        $block = Request::GetPost("Block");
        $action = Request::GetPost("Action");
        
        $tool = new $block($this->Core,  $commerce);
        echo $tool->$action($commerce)->Show(); 
    }
    
    /**
     * Sauvegare l'image de presentation
     */
    function DoUploadFile($idElement, $tmpFileName, $fileName, $action)
    {
        switch($action)
        {
            case "SaveImage" : 
            {
        
            //Ajout de l'image dans le repertoire correspondant
            $directory = "../Data/Apps/EeCommerce/".$idElement;
        
            //Creer le repertoire si il n'existe pas
            JFile::CreateDirectory($directory);
                            
            //Sauvegarde
            move_uploaded_file($tmpFileName, $directory."/presentation.png");

            //Crée un miniature
            $image = new JImage();
            $image->load($directory."/presentation.png");
            $image->fctredimimage(100, 0, $directory."/presentation_96.png"); 
            }
            break;
            case "SaveImageProduct" :
            {
                $id = explode(":", $idElement);
                //Ajout de l'image dans le repertoire correspondant
                $directory = "../Data/Apps/EeCommerce/".$id[0]."/product/";
        
                //Creer le repertoire si il n'existe pas
                JFile::CreateDirectory($directory);
                
                //Product Directory
                $directory = "../Data/Apps/EeCommerce/".$id[0]. "/product/".$id[1];
        
                //Creer le repertoire si il n'existe pas
                JFile::CreateDirectory($directory);
            
                //Rennomage du etensions des fichiers
                $fileName = str_replace(".jpe",".png", $fileName);
                $fileName = str_replace(".jpg",".png", $fileName);
                $fileName = str_replace(".jpeg",".png", $fileName);
                $fileName = str_replace(".ico",".png", $fileName);
                
                //Sauvegarde
                move_uploaded_file($tmpFileName, $directory."/".$fileName);

                //renommage du fichier
                $fileNameMini = str_replace(".png","", $fileName);
                $fileNameMini = str_replace(".jpg","", $fileNameMini);
                $fileNameMini = str_replace(".jpeg","", $fileNameMini);
                $fileNameMini = str_replace(".ico","", $fileNameMini);
                        
                //Crée un miniature
                $image = new JImage();
                $image->load($directory."/".$fileName);
                $image->fctredimimage(96, 0,$directory."/".$fileNameMini."_96.png");
                
                $image = new JImage();
                $image->load($directory."/".$fileName);
                $image->fctredimimage(0, 300, $directory."/".$fileNameMini."_300.png");
                
                $image->resize(300, 300);
                //$image->save($directory."/".$fileNameMini."_300.png");
                
                //TODO SUPPRIMER L'IMAGE DE BASE
                //JFile::Delete();
            }
            case "UploadImageMarque" :
                $directory = "../Data/Apps/EeCommerce/1/marque/";

                
                move_uploaded_file($tmpFileName, $directory."/".$idElement .".png");
                
                //Crée un miniature
                $image = new JImage();
                $image->load($directory."/".$idElement .".png");
                $image->fctredimimage(96, 0,$directory."/".$idElement."_96.png");
            
                break;
            
            case "ImportProduct" :
                
                //Upload le fichier
                $directory = "../Data/Apps/EeCommerce/".$idElement;
                move_uploaded_file($tmpFileName, $directory."/ImportProduct.csv");
                
                //Import de chaque ligne
                $row = 1;
                if (($handle = fopen($directory."/ImportProduct.csv", "r")) !== FALSE)
                {
                    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
            {
                        $num = count($data);
                        $row++;
                        
                        $product = new EeCommerceProduct($this->Core);
                        
                        $product->AddArgument(new Argument("EeCommerceProduct", "NameProduct", EQUAL, $data[0]));
                        $product->AddArgument(new Argument("EeCommerceProduct", "CommerceId", EQUAL, $idElement));
                        
                        $products = $product->GetByArg();
                        
                        if(count($products) == 0)
                        {
                            $product = new EeCommerceProduct($this->Core); 
                            $product->NameProduct->Value = $data[0];
                        }
                        else
                        {
                            $product =  $products[0];
                        }
                        
                        $product->SmallDescriptionProduct->Value = $data[1];
                        $product->LongDescriptionProduct->Value = $data[2];
                        
                        //Recupration de la categorie
                        $category = new EeCommerceProductCategory($this->Core);
                        $category->GetByName($data[3]);
                        
                        $product->CategoryId->Value = $category->IdEntite;
                        
                        $product->PriceVenteMini->Value = $data[4];
                        $product->PriceVenteMaxi->Value = $data[5];
                        
                        $product->CommerceId->Value = $idElement;
                        $product->Save();
                    }
                    fclose($handle);
                }

            break;
        }
    }
    
    /*
        * Obtient des produit de la boutique disponible à la vente
        */
    public function GetSaleProduct($shopName, $limit)
    {
        return SeanceHelper::GetSaleProduct($this->Core, $shopName, $limit);
    }
    
    /*
        * Obtient les deux prochains produit de la position
        */
    public function GetLastProduct($seanceId, $position)
    {
        return SeanceHelper::GetLastProduct($this->Core, $seanceId, $position);
    }
    
    /*
        * Définie l'image pas défaut du produit
        */
    public function SetImageDefault()
    {
        ProductHelper::SetImageDefault($this->Core, Request::GetPost("productId"), Request::GetPost("image"));
    }
    
    /*
        * Reinitialise une seance de vente
        */
    public function Reset()
    {
        return SeanceHelper::Reset($this->Core, Request::GetPost("seanceId"));
    }
    
    /*
        * Pop in d'import de produit
        * Ajout ou met a jour les produits
        */
    public function ShowImport()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowImport(Request::GetPost("commerceId"));
    }
    
    /**
     * Supprime une image
     */
    public function DeleteImage()
    {
        echo "suppression de :"  . Request::GetPost('url') ;
        unlink(Request::GetPost('url'));
        unlink(str_replace("_96.png", ".png",Request::GetPost('url')));
    }
    
    /*
        * Obtient la prochaine seance disponibles
        */
    public function GetNextSeance($shopName)
    {
        return SeanceHelper::GetNextSeance($this->Core, $shopName);
    }
    
    /*
        * Ajoute un utilisateur à un fournisseur
        */
    public function AddUserFournisseur()
    {
        FournisseurHelper::AddUser($this->Core, Request::GetPost("fournisseurId"), Request::GetPost("userId"));
    }
    
    /*
        * Supprime un utilisateur d'un fournisseur
        */
    public function RemoveUserFournisseur()
    {
        FournisseurHelper::RemoveUser($this->Core, Request::GetPost("UserFournisseurId"));
    }
    
    /*
        * Pop in d'ajout d'utilisateur
        */
    public function ShowAddUser()
    {
        $adminBlock = new AdminBlock($this->Core);
        echo $adminBlock->ShowAddUser(Request::GetPost("userId")); 
    }
    
    /*
        * Sauvegarde un utilisateur
        */
    public function SaveUser()
    {
        if(AdminHelper::SaveUser($this->Core, Request::GetPost("userId"), 
                                            Request::GetPost("tbNameUser"),
                                            Request::GetPost("tbFirstNameUser"), 
                                            Request::GetPost("tbEmailUser"), 
                                            Request::GetPost("lstGroup")
                ))
        {
            
            echo "<span class='sucess'>".$this->Core->GetCode("SaveOk")."</span>";
        }
        else
        {
            echo "<span class='error'>".$this->Core->GetCode("SaveError")."</span>";
            
            $this->ShowAddUser();
        }
    }
    
    /*
        * Ajoute une réference à un produit
        */
    function AddReference()
    {
        ProductHelper::AddReference($this->Core, Request::GetPost("productId"),
                                                    Request::GetPost("code"),   
                                                    Request::GetPost("libelle"),   
                                                    Request::GetPost("quantity")  
                );
        
        $block = new ProductBlock($this->Core);
        echo $block->GetReferencesProduct(Request::GetPost("productId"));
    }
    
    /*
        * Supprime une reference
        */
    function DeleteReference()
    {
        ProductHelper::DeleteReference($this->Core, Request::GetPost("referenceId"));
                    
        $block = new ProductBlock($this->Core);
        echo $block->GetReferencesProduct(Request::GetPost("productId"));
    }
    
    /*
        * Edite une réference
        */
    function EditReference()
    {
        $block = new ProductBlock($this->Core);
        echo $block->EditReference(Request::GetPost("productId"), Request::GetPost("referenceId"));
    }
    
    /**
     * Met à jour une réference
     */
    function UpdateReference()
    {
            ProductHelper::UpdateReference($this->Core, Request::GetPost("referenceId"),
                                                    Request::GetPost("code"),   
                                                    Request::GetPost("libelle"),   
                                                    Request::GetPost("quantity")  
                );
            
            $block = new ProductBlock($this->Core);
            echo $block->GetReference(Request::GetPost("referenceId"));
    }
    
    /*
        * Edite une commande
        */
    function EditCommande()
    {
        $commandeBlock = new FactureCommandeBlock($this->Core);
        echo $commandeBlock->EditCommande(Request::GetPost("commandeId"));
    }
    
    /*
    */
    function GenereFacture()
    {
        $commande = new EeCommerceCommande($this->Core);
        $commande->GetById(Request::GetPost("commandeId"));
        
        FactureHelper::GenerateFacture($this->Core, $commande, false);
    }
    
    /*
        * Rafraichi les commandes
        */
    function RefreshCommande()
    {
        $commandeBlock = new FactureCommandeBlock($this->Core);
        echo $commandeBlock->GetCommande(Request::GetPost("lstState"), Request::GetPost("tbNumero"));
    }
    
    /**
     * Fait évoluer l'état du bon de commande
     */
    function UpdateBonCommande()
    {
        FactureHelper::UpdateBon($this->Core, Request::GetPost("bonCommandeId"));
        
        echo $this->Core->GetCode("EeCommerce.BonCommadeUpdated");
    }
    
    /*
        * Obtient les informations du compte utilisateur
        * selon le module
        */
    function GetCompte($module)
    {
        $clientBlock = new ClientBlock($this->Core);
        return $clientBlock->GetModule($module);
    }
    
    /*
        * Rafraichit la liste des like
        */
    function RefreshLike()
    {
        $saleBlock = new SaleBlock($this->Core);
        echo $saleBlock->GetLike(Request::GetPost("seanceId"));
    }
    
    /**
     * Envoi les newsletter des like
     */
    function ShareLike()
    {
        SeanceHelper::ShareLike($this->Core, Request::GetPost("seanceId"));
    }
    
    /*
        * Effectue les différents virements pour les prestataires
        */
    function DoVirement()
    {
        echo VirementHelper::DoVirement($this->Core, Request::GetPost("commandeId"));
    }
    
    /*
        * Affiche les informations de payments stripe du fournisseur
        */
    function ShowPaymentFournisseur()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowPaymentFournisseur(Request::GetPost("fournisseurId"));
    }
    
    /*
        * Filtres les produits par fournisseurs
        */
    function ShowProductFournisseur()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowProductFournisseur(Request::GetPost("fournisseurId"));
    }
    
    /*
        * Pop in d'ajout de fiche de produit
        */
    public function ShowAddFicheProduct()
    {
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->ShowAddFicheProduct(Request::GetPost("ficheId"));
    }
    
    /**
     * Sauvegarde une fiche
     */
    public function SaveFiche()
    {
            CommerceHelper::SaveFiche($this->Core,
                                    Request::GetPost("tbNameFiche"),
                                    Request::GetPost("tbKeywordFiche"),
                                    Request::GetPost("tbShortDescriptionFiche"),
                                    Request::GetPost("tbLongDescriptionFiche"),
                                    Request::GetPost("lstCategory") ,
                                    Request::GetPost("ficheId")
                                        );
        
        echo "<span class='success'>".$this->Core->GetCode("SaveOk")."</span>";
    }
    
    /*
        * Ajoute un produit à une fiche
        */
    public function AddProductFiche()
    {
        CommerceHelper::AddProductFiche(
                                        $this->Core,
                                        Request::GetPost("ficheId"),
                                        Request::GetPost("productId")
                                        );
        
        $productBlock = new ProductBlock($this->Core);
        echo $productBlock->GetProductsFiche(Request::GetPost("ficheId"));
    }
    
    /*
        * Supprime un produit d'une fiche
        */
    public function RemoveProductFiche()
    {
        CommerceHelper::RemoveProductFiche($this->Core, Request::GetPost("ficheProductId"));
    }

    /**
     * Popin d'ajout de coupon
     */
    public function ShowAddCoupon()
    {
        $CommerceController = new CommerceController($this->Core);
        echo $CommerceController->ShowAddCoupon(Request::GetPost("CouponId"));
    }
    
    /**
     * Sauvegarde un coupon
     */
    public function SaveCoupon()
    {
        CommerceHelper::SaveCoupon($this->Core, 
                                    Request::GetPost("tbCodeCoupon"),
                                    Request::GetPost("tbLibelleCoupon"),
                                    Request::GetPost("tbDescriptionCoupon"),
                                    Request::GetPost("tbTypeCoupon"),
                                    Request::GetPost("tbReduction"),
                                    Request::GetPost("CouponId")
                                    );
    }
}  
      