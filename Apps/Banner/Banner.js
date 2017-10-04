var Banner = function() {};

	/*
	* Chargement de l'application
	*/
	Banner.Load = function(parameter)
	{
		this.LoadEvent();
                
                if(parameter != "")
                {
                    BannerAction.LoadBanner('', parameter);
                }
                else
                {
                    BannerAction.LoadMyBanner();
                }
	};

	/*
	* Chargement des �venements
	*/
	Banner.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Banner.Execute, "", "Banner");
		Dashboard.AddEventWindowsTool("Banner");
	};

   /*
	* Execute une fonction
	*/
	Banner.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Banner");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Banner.Comment = function()
	{
		Dashboard.Comment("Banner", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Banner.About = function()
	{
		Dashboard.About("Banner");
	};

	/*
	*	Affichage de l'aide
	*/
	Banner.Help = function()
	{
		Dashboard.OpenBrowser("Banner","{$BaseUrl}/Help-App-Banner.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Banner.ReportBug = function()
	{
		Dashboard.ReportBug("Banner");
	};

	/*
	* Fermeture
	*/
	Banner.Quit = function()
	{
		Dashboard.CloseApp("","Banner");
	};
        
         /*
         * Evenement
         */
        BannerAction = function(){};
        
        /**
         * Pop in d'ajout de banner
         * @returns {undefined}
         */
        BannerAction.ShowAddBanner = function()
        {
            var param = Array();
                param['App'] = 'Banner';
                param['Title'] = 'Banner.ShowAddBanner';
              
                Dashboard.OpenPopUp('Banner','ShowAddBanner', '','','', 'BannerAction.LoadMyBanner()', serialization.Encode(param));
        };
        
        /**
         * Chage les banner de l'utilisateur
         * @returns {undefined}
         */
        BannerAction.LoadMyBanner = function()
        {
           var data = "Class=Banner&Methode=LoadMyBanner&App=Banner";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Banner"); 
        };
        
        /**
         * Charge un banner
         * @param {type} bannerId
         * @returns {undefined}
         */
        BannerAction.LoadBanner = function(bannerId, bannerName)
        {
          var data = "Class=Banner&Methode=LoadBanner&App=Banner";
              data += "&bannerId=" + bannerId ;
              data += "&bannerName=" + bannerName ;
              
              Dashboard.LoadControl("dvDesktop", data, "" , "div", "Banner"); 
              
              BannerAction.Tab = new Array();
              
              //Memorisation du banner
              BannerAction.BannerId = bannerId;
              
              //Charge les image du banner
               BannerAction.ReloadImage();
        };
        
        /**
         * Popin de creation d'content
         * @returns {undefined}
         */
        BannerAction.ShowAddContent = function(BannerId)
        {
            var param = Array();
                param['App'] = 'Banner';
                param['Title'] = 'Banner.ShowAddContent';
                param['BannerId'] = BannerId;
              
                Dashboard.OpenPopUp('Banner','ShowAddContent', '','','', 'BannerAction.LoadContent('+BannerId+')', serialization.Encode(param));
        };
        
         /**
         * Edite les propriete d'un banner
         * @type type
         */
        BannerAction.EditPropertyContent =function(bannerId, contentId)
        {
            BannerAction.ContentId = contentId;
                    
            var param = Array();
                param['App'] = 'Banner';
                param['Title'] = 'Banner.ShowAddContent';
                param['contentId'] = contentId;
              
                Dashboard.OpenPopUp('Banner','ShowAddContent', '','','', 'BannerAction.LoadBanner('+bannerId+')', serialization.Encode(param));
        };
        
        /**
         * Edite un content
         * @param {type} contentId
         * @returns {undefined}
         */
        BannerAction.EditContent = function(contentId, name)
        {
            //ouvre l'content dans une pop up 
            if(typeof(BannerAction.Tab) == "undefined")
            {
                var param = Array();
                    param['App'] = 'Banner';
                    param['Title'] = 'Banner.OPenContent';
                    param['contentId'] = contentId;
                    param['Top'] = "100px";
              
                Dashboard.OpenPopUp('Banner','OpenContent', '','800','600', '', serialization.Encode(param));
            }
            else
            {
                //Verification que l'on ne la pas déjà ajouter
               for (i=0 ; i < BannerAction.Tab.length ; i++ )
               {
                   if(BannerAction.Tab[i] == name)
                   {
                       return;
                   }
               }

               //Recuperation du tabStrip
               var tsFile = document.getElementById("tbBanner");
               var th = tsFile.getElementsByTagName("th");

               //Recuperation du dernier onglet
               var lastTab = th[th.length-1];

               var idTab = lastTab.id.split("_");
               var id = idTab[1];
               id++;

               var newTab = document.createElement("th");

               newTab.innerHTML = name  ;
               newTab.name = name ;
               newTab.id = "index_" + id;
               newTab.className = "TabStripDisabled";
               newTab.title = name ;
               var click = function(){ TabStrip.ShowTab(this,'tab_'+id+'',id);};

               Dashboard.AddEvent(newTab, "click", click);

               //Ajout de l'onglet
               (th[0]).parentNode.appendChild(newTab);

               //Ajout de la div correspondante
               var div = document.createElement("div");
               div.id = "tab_"+id+"";
               div.style.overflow = 'hidden';
               div.style.display = 'none';

               div.innerHTML = "Loading ...";
               var JAjax = new ajax();
                  JAjax.data = "App=Banner&Methode=EditContent";
                  JAjax.data += "&ContentId=" + contentId;

               var contenu = JAjax.GetRequest("Ajax.php");
               div.innerHTML = BannerAction.FormatDataForClient(contenu);

               tsFile.appendChild(div);

               TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Banner");

                BannerAction.Tab.push(name);
            }
            
                            //Initialisation dez l'editeur
             //   CKEDITOR.disableAutoInline = true;
               var editor = CKEDITOR.replace( 'tbContentContent_' + contentId  );

               CKEDITOR.setApp("BannerAction");
        }
        
        /**
         * Retrouve l'ongelt actif
         * @returns {undefined}
         */
        BannerAction.findTabSelected = function()
        {
            var tb = document.getElementById('tbBanner');
            
            if(tb != "")
            {
                dv = tb.getElementsByTagName("div");

                for(i = 0; i <  dv.length; i++ )
                {
                    if(dv[i].id.indexOf("tab")   > -1  && dv[i].style.display == "block" ) 
                    {
                       return dv[i]; 
                    }
                }
            }   
            else
            {
                dvContent = document.getElementById("dvContent");
                
                return dvContent;
            }
        };
        
        /**
         * Sauvegarde le contenu
         * @returns {undefined}
         */
        BannerAction.saveContent = function()
        {
            //Recuyeration de l'onglet selectionné
            dvContent = BannerAction.findTabSelected();
            
            //Recuêration du contenu
            txtContent = dvContent.getElementsByTagName("textarea");
            content = eval("CKEDITOR.instances." + txtContent[0].id+".getData()");
            
            //Recuperation de l'identifiant dez l'content
            controls = dvContent.getElementsByTagName("input");
            
            for(i= 0; i < controls.length; i++)
            {
                if(controls[i].type == "hidden")
                {
                    
                    var contentId = controls[i].value;
                }
            }
           
            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Banner&Methode=UpdateContent";
               JAjax.data += "&ContentId=" + contentId;
               JAjax.data += "&content=" + BannerAction.FormatDataForServeur(content);
          
            alert(JAjax.GetRequest("Ajax.php"));
        };
        
        /**
         * 
         * @returns {String}Obitent le bouton de telechargement de fichier
         */
        BannerAction.getUploadButton = function()
        {
            var spUpload = "<span id='spUploadAjaxControl'>";
                spUpload +=" <b id='spUploadAjaxValide' class='FormUserValid' style='display:none'>Enregistrement Réussie</b>";
                spUpload +="<b id='spUploadAjaxError' class='FormUserError' style='display:none'>Erreur</b>";
                spUpload +="<br>";
                spUpload +="<input id='hdAppfileToUpload' type='hidden' value='Banner'>";
                spUpload +="<input id='hdIdElementfileToUpload' type='hidden' value='"+BannerAction.BannerId+"'>";
                spUpload +="<input id='hdActionfileToUpload' type='hidden' value='UploadImageBanner'>";
                spUpload +="<input id='fileToUpload' class='input' type='file' name='fileToUpload' size='45'>";
                spUpload +="<button id='buttonUpload' class='cke_dialog_ui_button' onclick='BannerAction.upload();'>Envoyer</button>";
                spUpload +="</span>";
    
                return spUpload;
        };
        
        /**
         * 
         * @returns {undefined}enoit l'image sur le serveur
         */
        BannerAction.upload = function()
        {
            UploadAjaxFile.Upload('BannerAction.ReloadImage()', 'fileToUpload');
            
            ;
        };
        
        /**
         * Recharge la bibliothèque d'image
         * @returns {undefined}
         */
        BannerAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=Banner&Methode=GetImages";
               JAjax.data += "&BannerId=" + BannerAction.BannerId;
          
            lstImage = JAjax.GetRequest("Ajax.php").split(";");
            
            var vTypeOf = typeof(CKEDITOR);
            if(vTypeOf == 'object') 
            {    
                CKEDITOR.config.tabbedimages  = lstImage[0].split(",");
                CKEDITOR.config.tabbedthumbimages = lstImage[1].split(",");
                if (typeof ReplaceDSbrowserHTML == 'function') { 
                     ReplaceDSbrowserHTML(); 
                }
            }
         };
         
                 /**
         * Remplace les caractères spéciaux
         */
        BannerAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");
    
            return data;
        };
        
        /**
         * Remplace les caractères speciaux
         */
        BannerAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");
       
            return data;
        };
        
        /**
         * Rafraichit l'image de l'content
         * @returns {undefined}
         */
        BannerAction.RefreshImageContent = function()
        {
            var dvImageContent = document.getElementById("dvImageContent");
            
            var JAjax = new ajax();
                JAjax.data = "App=Banner&Methode=GetImageContent";
                JAjax.data += "&ContentId=" + BannerAction.ContentId;

             dvImageContent.innerHTML = JAjax.GetRequest("Ajax.php");
         };
         
         /**
          * Recharge le conteu d'une banniere
          * @param {type} bannerId
          * @returns {undefined}
          */
         BannerAction.LoadContent = function(bannerId)
         {
              var data = "Class=Banner&Methode=LoadContent&App=Banner";
                  data += "&bannerId=" + bannerId;
               Dashboard.LoadControl("tab_1", data, "" , "div", "Banner"); 
         };