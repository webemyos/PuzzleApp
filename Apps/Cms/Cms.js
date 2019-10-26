var Cms = function() {};

	/*
	* Chargement de l'application
	*/
	Cms.Load = function(parameter)
	{
		this.LoadEvent();
                 CmsAction.LoadMyCms();
	};

	/*
	* Chargement des �venements
	*/
	Cms.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Cms.Execute, "", "Cms");
		Dashboard.AddEventWindowsTool("Cms");
	};

   /*
	* Execute une fonction
	*/
	Cms.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Cms");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Cms.Comment = function()
	{
		Dashboard.Comment("Cms", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Cms.About = function()
	{
		Dashboard.About("Cms");
	};

	/*
	*	Affichage de l'aide
	*/
	Cms.Help = function()
	{
		Dashboard.OpenBrowser("Cms","{$BaseUrl}/Help-App-Cms.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Cms.ReportBug = function()
	{
		Dashboard.ReportBug("Cms");
	};

	/*
	* Fermeture
	*/
	Cms.Quit = function()
	{
		Dashboard.CloseApp("","Cms");
	};

        /*
         * Evenement
         */
        CmsAction = function(){};

        /**
         * Pop in d'ajout de cms
         * @returns {undefined}
         */
        CmsAction.ShowAddCms = function()
        {
            var param = Array();
                param['App'] = 'Cms';
                param['Title'] = 'Cms.ShowAddCms';

                Dashboard.OpenPopUp('Cms','ShowAddCms', '','','', 'CmsAction.LoadMyCms()', serialization.Encode(param));
        };

        /**
         * Chage les cms de l'utilisateur
         * @returns {undefined}
         */
        CmsAction.LoadMyCms = function()
        {
           var data = "Class=Cms&Methode=LoadMyCms&App=Cms";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Cms");
        };

        /**
         * Charge un cms
         * @param {type} cmsId
         * @returns {undefined}
         */
        CmsAction.LoadCms = function(cmsId)
        {
          var data = "Class=Cms&Methode=LoadCms&App=Cms";
              data += "&cmsId=" + cmsId ;
              Dashboard.LoadControl("dvDesktop", data, "" , "div", "Cms");

              CmsAction.Tab = new Array();

              //Memorisation du cms
              CmsAction.CmsId = cmsId;

              //Charge les image du cms
               CmsAction.ReloadImage();
        };

        /**
         * Popin de creation d'page
         * @returns {undefined}
         */
        CmsAction.ShowAddPage = function(CmsId)
        {
            var param = Array();
                param['App'] = 'Cms';
                param['Title'] = 'Cms.ShowAddPage';
                param['CmsId'] = CmsId;

                Dashboard.OpenPopUp('Cms','ShowAddPage', '','','', 'CmsAction.LoadPage('+CmsId+')', serialization.Encode(param));
        };

         /**
         * Edite les propriete d'un cms
         * @type type
         */
        CmsAction.EditPropertyPage =function(cmsId, pageId)
        {
            CmsAction.PageId = pageId;

            var param = Array();
                param['App'] = 'Cms';
                param['Title'] = 'Cms.ShowAddPage';
                param['pageId'] = pageId;

                Dashboard.OpenPopUp('Cms','ShowAddPage', '','','', 'CmsAction.LoadPage('+cmsId+')', serialization.Encode(param));
        };

        //Rafhaichit les page du cms
        CmsAction.LoadPage = function(cmsId)
        {
            var data = "Class=Cms&Methode=LoadPage&App=Cms";
              data += "&cmsId=" + cmsId ;
              Dashboard.LoadControl("tab_1Cms", data, "" , "div", "Cms");
        };

        /**
         * Edite un page
         * @param {type} pageId
         * @returns {undefined}
         */
        CmsAction.EditPage = function(pageId, name)
        {
            //ouvre l'page dans une pop up
            if(typeof(CmsAction.Tab) == "undefined")
            {
                var param = Array();
                    param['App'] = 'Cms';
                    param['Title'] = 'Cms.OPenPage';
                    param['pageId'] = pageId;
                    param['Top'] = "100px";

                Dashboard.OpenPopUp('Cms','OpenPage', '','800','600', '', serialization.Encode(param));
            }
            else
            {
                //Verification que l'on ne la pas déjà ajouter
               for (i=0 ; i < CmsAction.Tab.length ; i++ )
               {
                   if(CmsAction.Tab[i] == name)
                   {
                       return;
                   }
               }

               //Recuperation du tabStrip
               var tsFile = document.getElementById("tbCms");
               var th = tsFile.getElementsByTagName("th");

               //Recuperation du dernier onglet
               var lastTab = th[th.length-1];

               var idTab = lastTab.id.split("_");
               var id = idTab[1].replace("Cms","");
             
               id++;

               console.log(id);
               
               var newTab = document.createElement("th");

               newTab.innerHTML = name  ;
               newTab.name = name ;
               newTab.id = "index_" + id+"Cms";
               newTab.className = "TabStripDisabled";
               newTab.title = name ;
               //Ajout de l'onglet
               (th[0]).parentNode.appendChild(newTab);

               var click = function(){ TabStrip.ShowTab(newTab,'tab_'+id+'Cms',10, "Cms");};
               Dashboard.AddEvent(newTab, "click", click);

              
               //Ajout de la div correspondante
               var div = document.createElement("div");
               div.id = "tab_"+id+"Cms";
               div.className= "TabContent";

               div.innerHTML = "Loading ...";
               var JAjax = new ajax();
                  JAjax.data = "App=Cms&Methode=EditPage";
                  JAjax.data += "&PageId=" + pageId;

               var contenu = JAjax.GetRequest("Ajax.php");
               div.innerHTML = CmsAction.FormatDataForClient(contenu);

               tsFile.appendChild(div);

               TabStrip.ShowTab(newTab, 'tab_'+id+'Cms', 10, "Cms");

                CmsAction.Tab.push(name);
            }

             //Initialisation dez l'editeur
             var editor = CKEDITOR.replace('tbContentPage_' + pageId);

             CKEDITOR.setApp("CmsAction");
        };

        /**
         * Retrouve l'ongelt actif
         * @returns {undefined}
         */
        CmsAction.findTabSelected = function()
        {
            var tb = document.getElementById('tbCms');

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
                dvPage = document.getElementById("dvPage");

                return dvPage;
            }
        };

        /**
         * Sauvegarde le contenu
         * @returns {undefined}
         */
        CmsAction.saveContent = function()
        {
            //Recuyeration de l'onglet selectionné
            dvContent = CmsAction.findTabSelected();

            //Recuêration du contenu
            txtContent = dvContent.getElementsByTagName("textarea");
            content = eval("CKEDITOR.instances." + txtContent[0].id+".getData()");

            //Recuperation de l'identifiant dez l'page
            controls = dvContent.getElementsByTagName("input");

            for(i= 0; i < controls.length; i++)
            {
                if(controls[i].type == "hidden")
                {

                    var pageId = controls[i].value;
                }
            }

            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Cms&Methode=UpdateContent";
               JAjax.data += "&PageId=" + pageId;
               JAjax.data += "&content=" + CmsAction.FormatDataForServeur(content);

            alert(JAjax.GetRequest("Ajax.php"));
        };

        /**
         *
         * @returns {String}Obitent le bouton de telechargement de fichier
         */
        CmsAction.getUploadButton = function()
        {
            $html = "<div>";

            $html +="<input type='file' id='fileUpload' name='fileUpload' />";
            $html += "<input type='button' value='Envoyer' onclick='upload.doUpload(this)' /> ";

            $html += "<input type='hidden' id='hdApp' name = 'hdApp'  value='Cms'  /> ";
            $html += "<input type='hidden' id='hdIdBaseElement' name='hdIdElement' value='"+CmsAction.CmsId+"' /> ";
            $html += "<input type='hidden' id='hdIdElement' name='hdIdElement' value='"+CmsAction.CmsId+"' /> ";
            $html += "<input type='hidden' id='hdCallBack' name='hdCallBack' value='CmsAction.ReloadImage();' /> ";
            $html += "<input type='hidden' id='hdAction' name='hdAction' value='UploadImageBlog' /> ";
            $html += "<input type='hidden' id='hdIdUpload'  name='hdIdUpload' value='' /> ";

            //Frame From Upload
            if(1== 2)
            {
                     $html += "<iframe id='frUpload' src='upload' style='display:block' >";
            }
            else
            {
                    $html += "<iframe id='frUpload' src='upload' style='display:none' >";
            }

            $html += "</iframe>";
            $html += "</div>";

            return $html;
        };

        /**
         *
         * @returns {undefined}enoit l'image sur le serveur
         */
        CmsAction.upload = function()
        {
            UploadAjaxFile.Upload('CmsAction.ReloadImage()', 'fileToUpload');

            ;
        };

        /**
         * Recharge la bibliothèque d'image
         * @returns {undefined}
         */
        CmsAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=Cms&Methode=GetImages";
               JAjax.data += "&CmsId=" + CmsAction.CmsId;

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
        CmsAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");

            return data;
        };

        /**
         * Remplace les caractères speciaux
         */
        CmsAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");

            return data;
        };

        /**
         * Rafraichit l'image de l'page
         * @returns {undefined}
         */
        CmsAction.RefreshImagePage = function()
        {
            var dvImagePage = document.getElementById("dvImagePage");

            var JAjax = new ajax();
                JAjax.data = "App=Cms&Methode=GetImagePage";
                JAjax.data += "&PageId=" + CmsAction.PageId;

             dvImagePage.innerHTML = JAjax.GetRequest("Ajax.php");
         };
