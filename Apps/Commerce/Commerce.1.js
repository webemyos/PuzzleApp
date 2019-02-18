var Commerce = function() {};

	/*
	* Chargement de l'application
	*/
	Commerce.Load = function(parameter)
	{
		this.LoadEvent(parameter);
	};

	/*
	* Chargement des �venements
	*/
	Commerce.LoadEvent = function(parameter)
	{
        Eemmys.AddEventAppMenu(Commerce.Execute, "", "Commerce");
        Eemmys.AddEventWindowsTool("Commerce");
            
                if(parameter != "" )
            {
                CommerceAction.LoadCommerce('', parameter);
            }
            else
            {
                CommerceAction.LoadMyCommerce();
            }
    };

   /*
	* Execute une fonction
	*/
	Commerce.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "Commerce");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Commerce.Comment = function()
	{
		Eemmys.Comment("Commerce", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Commerce.About = function()
	{
		Eemmys.About("Commerce");
	};

	/*
	*	Affichage de l'aide
	*/
	Commerce.Help = function()
	{
		Eemmys.OpenBrowser("Commerce","{$BaseUrl}/Help-App-Commerce.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Commerce.ReportBug = function()
	{
		Eemmys.ReportBug("Commerce");
	};

	/*
	* Fermeture
	*/
	Commerce.Quit = function()
	{
		Eemmys.CloseApp("","Commerce");
	};
        
    /*
        * Evenement utilsateur
        * @returns {undefined}
        */
    CommerceAction = function(){};
    
    /**
     * Pop in de création de Ecommerce
     * @return
     */
    CommerceAction.ShowAddCommerce = function()
    {      
        var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.Detail';
            
            Eemmys.OpenPopUp('Commerce','ShowAddCommerce', '','','', 'CommerceAction.LoadMyCommerce()', serialization.Encode(param));

        //Ajout des CKeditor
        Eemmys.SetBasicAdvancedText("tbLongDescription");
    };
            
    /*
        * Charge les commerces de l'utilisateur
        * @returns {undefined}
        */
    CommerceAction.LoadMyCommerce = function()
    {
        var data = "Class=Commerce&Methode=LoadMyCommerce&App=Commerce";
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "Commerce"); 
    };
        
    /**
     * Charge un commerce
     * @returns {undefined}
     */
    CommerceAction.LoadCommerce = function(commerceId, commerceName)
    {
        var data = "Class=Commerce&Methode=LoadCommerce&App=Commerce";
            data += "&CommerceId=" + commerceId;
            data += "&commerceName=" + commerceName;
            
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "Commerce");
            
            //Ajout des CKeditor
        Eemmys.SetBasicAdvancedText("LongDescription");
    };
    
        /**
     * Rafraichit l'image du commerce
     */
    CommerceAction.RefreshImage = function(commerceId)
    {
        var imgCommerce = document.getElementById("imgCommerce");
        
        imgCommerce.src= "../Data/Apps/Commerce/"  + commerceId + "/presentation_96.png?rand=" + Math.random;
    };
    
    /**
     * Rafrachit le contenu d'un onlget
     * @param {type} commerceId
     * @param {type} tab
     * @param {type} block
     * @returns {undefined}
     */
    CommerceAction.RefreshTab=function(commerceId, tab, block, action)
    {
                var data = "Class=Commerce&Methode=RefreshTab&App=Commerce";
                    data += "&CommerceId="+ commerceId;
                    data += "&Block="+ block;
                    data += "&Action=" + action;
            
            Eemmys.LoadControl(tab, data, "" , "div", "Commerce");
    };
    
    /*
        * Pop in d'ajout de catégorie de produit
        * @returns {undefined}
        */
    CommerceAction.ShowAddCategory = function(commerceId, categoryId)
    {
            var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailCategory';
            param['commerceId'] = commerceId;
            param['categoryId'] = categoryId;
            
            Eemmys.OpenPopUp('Commerce','ShowAddCategorie', '','','', 'CommerceAction.RefreshTabCategory('+commerceId+')', serialization.Encode(param));

        //Ajout des CKeditor
        Eemmys.SetBasicAdvancedText("tbDescriptionCategory");
    };
    
    /*
        * Rafrachissement des catégories de produits
        * @returns {undefined}
        */
    CommerceAction.RefreshTabCategory = function(commerceId)
    {
        CommerceAction.RefreshTab(commerceId, "vTProduct_vtab_1", "ProductBlock" , "GetTabProductCategory");
        
        Eemmys.SetBasicAdvancedText('tbDescriptionCategory');
    };
    
    /*
        * Rafrachissement des fournisseurs de produits
        * @returns {undefined}
        */
    CommerceAction.RefreshTabFournisseur = function(commerceId)
    {
        CommerceAction.RefreshTab(commerceId, "vTProduct_vtab_0", "ProductBlock" , "GetTabFournisseur");
    };
    
    /*
        * Rafrachissement des marque de produits
        * @returns {undefined}
        */
    CommerceAction.RefreshTabMarque = function(commerceId)
    {
        CommerceAction.RefreshTab(commerceId, "vTProduct_vtab_3", "ProductBlock" , "GetTabMarque");
    };
    /*
        * Pop in d'ajout de fournisseur
        * @returns {undefined}
        */
    CommerceAction.ShowAddFournisseur = function(commerceId, fournisseurId)
    {
            var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailFournisseur';
            param['commerceId'] = commerceId;
            param['fournisseurId'] = fournisseurId;
            
            Eemmys.OpenPopUp('Commerce','ShowAddFournisseur', '','','', 'CommerceAction.RefreshTabFournisseur('+commerceId+')', serialization.Encode(param));
    };
    
    /*
        * Pop in d'ajout de marque
        * @returns {undefined}
        */
    CommerceAction.ShowAddMarque = function(commerceId, marqueId)
    {
            var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailFournisseur';
            param['commerceId'] = commerceId;
            
            if(marqueId != undefined)
            {
                param['marqueId'] = marqueId;
            }
        
            Eemmys.OpenPopUp('Commerce','ShowAddMarque', '','','', 'CommerceAction.RefreshTabMarque('+commerceId+')', serialization.Encode(param));
    };
    
    /*
        * 
        * @param {type} fournisseurId
        * @returns {undefined}Création d'un compte Stripe
        */
    CommerceAction.CreateStripeAccount = function(fournisseurId)
    {
            var JAjax = new ajax();
                JAjax.data = "App=Commerce&Methode=CreateStripeAccount";
            JAjax.data += "&fournisseurId=" + fournisseurId;
    
            alert(JAjax.GetRequest("Ajax.php"));
    };
    
    /*
        * 
        * @param {type} fournisseurId
        * @returns validation d'un compte Stripe
        */
    CommerceAction.ValideStripeAccount = function(fournisseurId)
    {
            var JAjax = new ajax();
                JAjax.data = "App=Commerce&Methode=ValideStripeAccount";
            JAjax.data += "&fournisseurId=" + fournisseurId;
    
            alert(JAjax.GetRequest("Ajax.php"));
    };
    
    /*
        * Pop in d'ajout de produit
        * @param {type} commerceId
        * @param {type} productId
        * @returns {undefined}
        */
    CommerceAction.ShowAddProduct = function(commerceId, productId)
    {
            var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailProduct';
            param['commerceId'] = commerceId;
            param['productId'] = productId;
            
            Eemmys.OpenPopUp('Commerce','ShowAddProduct', '','','', 'CommerceAction.RefreshTabProduct('+commerceId+')', serialization.Encode(param));
    
            // Eemmys.SetBasicAdvancedText('SmallDescriptionProduct');
            Eemmys.SetBasicAdvancedText('LongDescriptionProduct');
    };
    
    /*
        * Sauvegarde un produit
        * @param {type} commerceId
        * @param {type} productId
        * @returns {undefined}
        */
    CommerceAction.SaveProduct =function (commerceId, productId)
    {
        if(productId == 0)
        {
            productId = "";
        }
        
        //Recuperation des donnée
        jbProduct = document.getElementById("jbProduct" + productId); 
        NameProduct = document.getElementById("NameProduct" + productId);
        RefProduct = document.getElementById("RefProduct" + productId);
        Actif = document.getElementById("Actif" + productId);
        PriceBuy = document.getElementById("PriceBuy" + productId);
        PriceVenteMini = document.getElementById("PriceVenteMini"+ productId);
        PriceVenteMaxi = document.getElementById("PriceVenteMaxi" + productId);
        PricePort = document.getElementById("PricePort" + productId);
        PriceDown = document.getElementById("PriceDown" + productId);
        Quantity = document.getElementById("Quantity" + productId);
        DeliveryDelay = document.getElementById("DeliveryDelay" + productId);
        SmallDescriptionProduct = document.getElementById("SmallDescriptionProduct" + productId);
        LongDescriptionProduct = document.getElementById("LongDescriptionProduct"+productId);
        lstCategory = document.getElementById("lstCategory" + productId);
        lstFournisseur = document.getElementById("lstFournisseur"+ productId);
        lstMarque = document.getElementById("lstMarque"+ productId);
        linkFournisseur = document.getElementById("LinkFournisseur"+ productId);
        
        if(NameProduct.value != "")
        {
                        //Sauvagarde ajax
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=SaveProduct";
            JAjax.data += "&commerceId=" + commerceId;
            JAjax.data += "&productId=" + productId;
            JAjax.data += "&NameProduct=" + NameProduct.value;
            JAjax.data += "&RefProduct=" + RefProduct.value;
            JAjax.data += "&MarqueId=" + lstMarque.value;
            JAjax.data += "&LinkFournisseur=" + linkFournisseur.value;
        
        
            if( Actif.checked)
                JAjax.data += "&Actif=1"
            else
                JAjax.data += "&Actif=0"
                
            if(PriceBuy != undefined)
            {
                JAjax.data += "&PriceBuy=" + PriceBuy.value;
            }
        
            JAjax.data += "&PriceVenteMini=" + PriceVenteMini.value;
            JAjax.data += "&PriceVenteMaxi=" + PriceVenteMaxi.value;
            JAjax.data += "&PricePort=" + PricePort.value;
            if(PriceBuy != undefined)
            {
                JAjax.data += "&PriceDown=" + PriceDown.value;
            }
        
            JAjax.data += "&Quantity=" + Quantity.value;
            JAjax.data += "&DeliveryDelay=" + DeliveryDelay.value;
            JAjax.data += "&SmallDescriptionProduct=" + SmallDescriptionProduct.value;
            JAjax.data += "&LongDescriptionProduct=" +  CommerceAction.FormatDataForServeur(LongDescriptionProduct.value);
            JAjax.data += "&CategoryId=" +  lstCategory.value;
            
            if(lstFournisseur != null)
            {
                JAjax.data += "&FournisseurId=" +  lstFournisseur.value;
            }
            
            jbProduct.innerHTML = JAjax.GetRequest("Ajax.php");
    
            // Eemmys.SetBasicAdvancedText('SmallDescriptionProduct');
            Eemmys.SetBasicAdvancedText('LongDescriptionProduct');
            
            alert(Eemmys.GetCode("Commerce.SaveOk"));
        }
        else
        {
            alert(Eemmys.GetCode("Commerce.ErrorProduct"));
        }
    };
    
    /*
        * Rafraichis les produits du commerce
        * @param {type} commerceId
        * @returns {undefined}
        */
    CommerceAction.RefreshTabProduct=function(commerceId)
    {
        CommerceAction.RefreshTab(commerceId, 'vTProduct_vtab_2', 'ProductBlock' , 'GetTabProduct')
    };
    
    /*
        * Pop in d'ajout d'une seance de vente
        * @param {type} commerceId
        * @returns {undefined}
        */
    CommerceAction.ShowAddSeanceVente = function(commerceId, seanceId)
    {
        var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailSeanceVente';
            param['commerceId'] = commerceId;
            param['seanceId'] = seanceId;
            
            Eemmys.OpenPopUp('Commerce','ShowAddSeanceVente', '','','', 'CommerceAction.RefreshTabSeance('+commerceId+')', serialization.Encode(param));
    
        //Ajout d'evenement pour modifier une vente
        $('.SeanceVente tr td').click(CommerceAction.EditeVente);
    };
    
    /*
        * Edite une vente
        * @returns {undefined}
        */
    CommerceAction.EditeVente = function(e)
    {
        var venteId = e.srcElement.id;
        
        if(venteId != "lstProduct" && venteId != "")
        {
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=EditeVente";
            JAjax.data += "&venteId=" + venteId;
    
            e.srcElement.innerHTML = JAjax.GetRequest("Ajax.php");
        }
    };
    
    /*
        * Met a jour la vente avec 
        * @returns {undefined}
        */
    CommerceAction.UpdateVente = function(control, venteId)
    {
        var container = document.getElementById(venteId);
        var lstProduct = control.parentNode.parentNode.parentNode.getElementsByTagName("select");    
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=UpdateVente";
            JAjax.data += "&venteId=" + venteId;
            JAjax.data += "&productId=" + lstProduct[0].value;
    
            container.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    /*
        * Sauvegarde une seance
    */
    CommerceAction.SaveSeance = function(commerceId, seanceId)
    {
        var jbVente = document.getElementById("jbVente");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=SaveProduct";
        
        //tbSeanceLibelle
        JAjax.data = "Class=Commerce&Methode=SaveSeance&App=Commerce";
        JAjax.data += "&commerceId="+ commerceId;
        JAjax.data += "&seanceId="+ seanceId;
        JAjax.data += "&Libelle="+ document.getElementById("tbSeanceLibelle").value;
        JAjax.data += "&DateStart=" + document.getElementById("DateStart").value;
        JAjax.data += "&DateEnd=" + document.getElementById("DateEnd").value;
            
        jbVente.innerHTML =  JAjax.GetRequest("Ajax.php");
    };
    
    /**
     * Rafraichit les images des produits
     * @returns {undefined}
     */
    CommerceAction.RefreshImageProduct = function(productId)
    {
        var lstImage = document.getElementById("lstImage" + productId);
        
            var JAjax = new ajax();
                JAjax.data = "App=Commerce&Methode=GetImagesProduct";
                JAjax.data += "&productId=" + productId;
            
            lstImage.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /**
     * Chage la partie admin
     * @returns {undefined}
     */
    CommerceAction.LoadAdmin = function()
    {
        var data = "Class=Commerce&Methode=LoadAdmin&App=Commerce";
            Eemmys.LoadControl("dvDesktop", data, "" , "div", "Commerce"); 
    };
    
    /**
     * Remplace les caractères spéciaux des ckEditor
     */
    CommerceAction.FormatDataForServeur = function(data)
    {
        var myRegEx=new RegExp("&", "gm");
            data= data.replace(myRegEx , "!et!");

        return data;
    };
    
    /**
     * Remplace les caractères speciaux des ckEditor
     */
    CommerceAction.FormatDataForClient = function(data)
    {
        var myRegEx=new RegExp("!et!", "gm");
            data= data.replace(myRegEx , "&");
    
        return data;
    };
    
    /**
     * Définie l'image principale
     * @param {type} control
     * @returns {undefined}
     */
    CommerceAction.SetImageDefault = function(productId, control)
    {
        var dv = control.parentNode;
        
        //Recuperationd de l'image
        var img = dv.getElementsByTagName("img");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=SetImageDefault";
            JAjax.data += "&productId=" + productId;
            JAjax.data += "&image=" + img[0].src;

            JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Charge la liste déroulante associé soit avec les produits, les fournisseurs ou les catégories
        */
    CommerceAction.LoadAddByType = function(control, seanceId)
    {
        var lstSubType = document.getElementById(control.id.replace("lstType", "dvSubType"));
        field = control.id.replace("lstType", "");
        
            var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=LoadAddByType";
            JAjax.data += "&type=" + control.value;
            JAjax.data += "&seanceId=" + seanceId;
            JAjax.data += "&field=" + field;
            
        lstSubType.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /**
     * Ajoute une ligne à une seance de vente
     * @param {type} SeanceId
     * @returns {undefined}
     */
    CommerceAction.AddLigneSeance = function(SeanceId)
    {
            var JAjax = new ajax();
                JAjax.data = "App=Commerce&Methode=AddLigneSeance";
                JAjax.data += "&SeanceId="+SeanceId;
            
        var lstArticle = document.getElementById("lstArticle"); 
        
        for(i=0; i< 3; i++)
        {
            var lstType = document.getElementById("lstType" + i);
            var lstSubType = document.getElementById("lstSubType" + i);
            
            JAjax.data += "&type"+i +"="+ lstType.value;
            JAjax.data += "&subType"+i +"="+ lstSubType.value;
        }
        
        lstArticle.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /**
     * Reinitialise une seance de vente
     * @returns {undefined}
     */
    CommerceAction.Reset = function(seanceId)
    {
            var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=Reset";
            JAjax.data += "&seanceId=" + seanceId;
            
            JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Importe une liste de produit depuis un fichier csv
        */
    CommerceAction.ShowImport = function(commerceId)
    {
                var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.ImportProduct';
            param['commerceId'] = commerceId;
            
            Eemmys.OpenPopUp('Commerce','ShowImport', '','','', 'CommerceAction.RefreshTabProduct('+commerceId+')', serialization.Encode(param));
    };
    
    /*
        * Supprime une image d'un prodit
        */
    CommerceAction.DeleteImage = function(control, productId, Url)
    {
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=DeleteImage";
            JAjax.data += "&productId=" + productId;
            JAjax.data += "&url=" + Url;
            
            JAjax.GetRequest("Ajax.php");
            
            control.parentNode.parentNode.removeChild(control.parentNode);
    };
    
    /*
        * Ajoute un utilisateur à un fournisseur
        */
    CommerceAction.AddUser = function(fournisseurId)
    {
            //Recuperation des user selectionne 
        var dvResult = document.getElementById("divResult");
        var dvUser = document.getElementById("dvUser");
        var controls = dvResult.getElementsByTagName("input");
        
        
        for(i=0; i < controls.length; i++)
        {
            if(controls[i].type == "checkbox" && controls[i].checked)
            {
                spUser = document.createElement("span");
                spUser.id = controls[i].id;
                spUser.className = "userSelected";
                spUser.innerHTML = controls[i].name;
            //   spUser.innerHTML += "<i class='icon-remove' onclick='CommerceAction.RemoveUserFournisseur(this, "+fournisseurId+" , "+ controls[i].id +")'>&nbsp;</i>";
                
                dvUser.appendChild(spUser); 
                
                var JAjax = new ajax();
                JAjax.data = "App=Commerce&Methode=AddUserFournisseur";
                JAjax.data += "&fournisseurId=" + fournisseurId;
                JAjax.data += "&userId=" + spUser.id;

                JAjax.GetRequest("Ajax.php");
                
            }
        }
        
        if(dvResult != null)
        {
            document.body.removeChild(dvResult);
        }
        else
        {
            ClosePopUp();
        }
    };
    
    /*
        * Supprime un utilisateur d'un fournisseur
        */
    CommerceAction.RemoveUserFournisseur = function (control, UserFournisseurId)
    {
        var JAjax = new ajax();
        JAjax.data = "App=Commerce&Methode=RemoveUserFournisseur";
        JAjax.data += "&UserFournisseurId=" + UserFournisseurId;
        
        JAjax.GetRequest("Ajax.php");
                
        control.parentNode.parentNode.removeChild(control.parentNode);
    };
    
    /*
        * POp in d'ajout d'utilisateur
        */
    CommerceAction.ShowAddUser = function(userId)
    {
        var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailUser';
            
            if(userId != undefined)
            {
                param['userId'] = userId;
            }
            
            Eemmys.OpenPopUp('Commerce','ShowAddUser', '','','', 'CommerceAction.RefreshTab("", "vTInfo_vtab_1", "ShopBlock" , "GetTabUser")', serialization.Encode(param));
    };
    
    /*
        * Pop in d'ajout de reference
        */
    CommerceAction.AddReference = function(productId)
    {
        var lstReference = document.getElementById("lstReference");
        var tbCodeRefence = document.getElementById("tbCodeRefence");
        var tbLibelleReference = document.getElementById("tbLibelleReference");
        var tbQuantityReference = document.getElementById("tbQuantityReference");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=AddReference";
            JAjax.data += "&productId=" + productId;
            JAjax.data += "&code=" + tbCodeRefence.value;
            JAjax.data += "&libelle=" +  tbLibelleReference.value;
            JAjax.data += "&quantity=" + tbQuantityReference.value;
            
        lstReference.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
        /*
        * Edite une reference
        */
    CommerceAction.EditReference = function(control, productId, referenceId)
    {
            
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=EditReference";
            JAjax.data += "&productId="+ productId;
            JAjax.data += "&referenceId="+ referenceId;
        
        //Passe en ligne en mode edition
        control.parentNode.parentNode.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * 
        * @param {type} control
        * @param {type} productId
        * @param {type} referenceId
        * @returns {undefined}Met ) jour la reference
        */
    CommerceAction.UpdateReference = function(control, productId, referenceId)
    {
        var tbUpdateCode = document.getElementById("tbUpdateCode" + referenceId);
        var tbUpdateLibelle = document.getElementById("tbUpdateLibelle" + referenceId);
        var tbUpdateQuantity = document.getElementById("tbUpdateQuantity" + referenceId);
        
        var JAjax = new ajax();
        JAjax.data = "App=Commerce&Methode=UpdateReference";
        JAjax.data += "&productId="+ productId;
        JAjax.data += "&referenceId="+ referenceId;
        JAjax.data += "&code=" + tbUpdateCode.value;
        JAjax.data += "&libelle=" +  tbUpdateLibelle.value;
        JAjax.data += "&quantity=" + tbUpdateQuantity.value;
        
        //Passe en ligne en mode edition
        control.parentNode.parentNode.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Supprime une reference
        */
    CommerceAction.DeleteReference = function(control, productId, referenceId)
    {
        if(confirm(Eemmys.GetCode("Commerce.DeleteReference")))
        {
            var lstReference = document.getElementById("lstReference");
            
            var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=DeleteReference";
            JAjax.data += "&productId=" + productId;
            JAjax.data += "&referenceId=" + referenceId;
            
            lstReference.innerHTML = JAjax.GetRequest("Ajax.php");
        }
    };
    
    /*
        * Edite une commande
        */
    CommerceAction.EditCommande = function(commandeId)
    {
                    var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailUser';
            param['commandeId'] = commandeId;
            
            Eemmys.OpenPopUp('Commerce','EditCommande', '','','', '', serialization.Encode(param));
    };
    
    /*
    * Genere la facture et les bons de commandes si il y a eu un soucs
    */
    CommerceAction.GenereFacture = function(commandeId)
    {
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=GenereFacture";
            JAjax.data += "&commandeId=" + commandeId;
            
            
            alert( JAjax.GetRequest("Ajax.php"));
    };
    
    /*
        * Rafraichit la liste des commande en fonction de filtes
        */
    CommerceAction.RefreshCommande = function()
    {
        var lstCommande = document.getElementById("lstCommande");
        var lstState = document.getElementById("lstState");
        var tbNumero = document.getElementById("tbNumero");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=RefreshCommande";
            JAjax.data += "&lstState=" + lstState.value;
            JAjax.data += "&tbNumero=" + tbNumero.value;
            
            lstCommande.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Rafraichit les likes
        */
    CommerceAction.RefreshLike = function(seanceId)
    {
        var lstLike = document.getElementById("lstLike");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=RefreshLike";
            JAjax.data += "&seanceId=" + seanceId;
            
            lstLike.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Envoie les Email Newsletters 
        * Pour les likes
        */
    CommerceAction.ShareLike = function(seanceId)
    {
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=ShareLike";
            JAjax.data += "&seanceId=" + seanceId;
            
            alert(JAjax.GetRequest("Ajax.php"));
    };
    
    /*
        * Effecute le virements pour les différents partenaires
        */
    CommerceAction.DoVirement = function(commandeId)
    {
        if(confirm("Attention Fransceco! As tu bien vérifié les montants.Si oui alors ca va va clique sur OK"))
        {
                var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=DoVirement";
            JAjax.data += "&commandeId=" + commandeId;
            
            alert(JAjax.GetRequest("Ajax.php"));
        }
    };
    
    /*
        * Filtre les produit des fournisseurs
        */
    CommerceAction.ShowProductFournisseur = function(control)
    {
        var lstProduct = document.getElementById("lstProduct");
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=ShowProductFournisseur";
            JAjax.data += "&fournisseurId=" + control.value;
            
            lstProduct.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Pop in d'ajout de fiche de produit
        * @returns {undefined}
        */
    CommerceAction.ShowAddFicheProduct = function(ficheId)
    {
            var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.DetailFiche';
            
            if(ficheId != undefined)
            {
                param['ficheId'] = ficheId;
            }
        
            Eemmys.OpenPopUp('Commerce','ShowAddFicheProduct', '','','', 'CommerceAction.RefreshTabFicheProduct()', serialization.Encode(param));

        //Ajout des CKeditor
        Eemmys.SetBasicAdvancedText("tbDescriptionCategory");
    };
    
    /*
        * Ajoute un produit à une fiche
        */
    CommerceAction.AddProductFiche = function(ficheId)
    {
        var lstFicheProduct = document.getElementById("lstFicheProduct");
        var dvProduct = document.getElementById("dvProduct");
        
        console.log(lstProduct);
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=AddProductFiche";
            JAjax.data += "&ficheId=" + ficheId;
            JAjax.data += "&productId=" + lstFicheProduct.value;
            
            dvProduct.innerHTML = JAjax.GetRequest("Ajax.php");
    };
    
    /*
        * Supprime le produit d'un fiche
        */
    CommerceAction.RemoveProductFiche = function(control, ficheProductId)
    {
        var container = control.parentNode;
        
        var JAjax = new ajax();
            JAjax.data = "App=Commerce&Methode=RemoveProductFiche";
            JAjax.data += "&ficheProductId=" + ficheProductId;
            
            JAjax.GetRequest("Ajax.php");
            
        
        container.parentNode.removeChild(container);
    };  
    
    /**
     * Pop in de création de coupons
     * @return
     */
    CommerceAction.ShowAddCoupon = function(couponId)
    {      
        var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.Detail';
            param['CouponId'] = couponId;

            Eemmys.OpenPopUp('Commerce','ShowAddCoupon', '','','', 'CommerceAction.RefreshTabCoupon()', serialization.Encode(param));
    };

    CommerceAction.RefreshTabCoupon = function()
    {
        CommerceAction.RefreshTab('', 'vTInfo_vtab_2', 'ShopBlock' , 'GetTabCoupon');
    };

        
     
        
        