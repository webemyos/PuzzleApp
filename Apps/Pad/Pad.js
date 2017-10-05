var Pad = function() {};

	/*
	* Chargement de l'application
	*/
	Pad.Load = function(parameter)
	{
             parameter = serialization.Decode(parameter);
	 	
             Pad.documentId = parameter['DocumentId'];
             Pad.documentName = parameter['DocumentName'];
         
             this.LoadEvent();
             
	};

	/*
	* Chargement des �venements
	*/
	Pad.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Pad.Execute, "", "Pad");
		Dashboard.AddEventWindowsTool("Pad");
                
                PadAction.LoadMyDoc();
	};

   /*
	* Execute une fonction
	*/
	Pad.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Pad");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Pad.Comment = function()
	{
		Dashboard.Comment("Pad", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Pad.About = function()
	{
		Dashboard.About("Pad");
	};

	/*
	*	Affichage de l'aide
	*/
	Pad.Help = function()
	{
		Dashboard.OpenBrowser("Pad","{$BaseUrl}/Help-App-Pad.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Pad.ReportBug = function()
	{
		Dashboard.ReportBug("Pad");
	};

	/*
	* Fermeture
	*/
	Pad.Quit = function()
	{
		Dashboard.CloseApp("","Pad");
	};
        
        /**
         * Evenement
         * @returns {undefined}
         */
        PadAction = function(){};
        
        /**
         * Pop in de création de doc
         * @return
         */
        PadAction.ShowAddDoc = function()
        {      
            var param = Array();
                param['App'] = 'Pad';
                param['Title'] = 'Pad.Detail';
               
                Dashboard.OpenPopUp('Pad','ShowAddDoc', '','','', 'PadAction.LoadMyDoc()', serialization.Encode(param));
        };
        
        /**
         * Ouvre le nouveau doc dans un nouvel onglet
         * @returns {undefined}
         */
        PadAction.OpenNewDoc = function()
        {
           // vzr 
            
            var tbDocName = document.getElementById("tbName");
            
        };

        /**
         * 
         * @returns {undefined}Charge mes documents
         */
        PadAction.LoadMyDoc = function()
        {
           var data = "Class=Pad&Methode=LoadMyDoc&App=Pad";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Pad");
               
               PadAction.Tab = Array();
               
                if(typeof(Pad.documentId) != 'undefined')
                {
                    PadAction.EditDocument(Pad.documentId, Pad.documentName);
                }
                
                  //Charge les image du blog
               PadAction.ReloadImage();
        };
        
        /**
         * Charge les dossiers et fichiers partagés de l'utilisateur
         */
        PadAction.LoadSharedDoc = function()
        {
           var data = "Class=Pad&Methode=LoadSharedDoc&App=Pad";
                   
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Pad");
               
        };
        
        /**
         * Edite un document dans un nouvek onglet afin de pouvoir ouvrir plusieurs doc
         */
        PadAction.EditDocument = function(documentId, name)
        {
               //Verification que l'on ne la pas déjà ajouter
               for (i=0 ; i < PadAction.Tab.length ; i++ )
               {
                   if(PadAction.Tab[i] == name)
                   {
                       return;
                   }
               }

               //Recuperation du tabStrip
               var tsFile = document.getElementById("tbDoc");
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
                  JAjax.data = "App=Pad&Methode=EditDocument";
                  JAjax.data += "&DocumentId=" + documentId;

               var contenu = JAjax.GetRequest("Ajax.php");
               div.innerHTML = PadAction.FormatDataForClient(contenu);

               tsFile.appendChild(div);

               TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Pad");

                PadAction.Tab.push(name);


              //Initialisation dez l'editeur
             //   CKEDITOR.disableAutoInline = true;
               var editor = CKEDITOR.replace( 'tbContentDocument_' + documentId  );

             CKEDITOR.setApp("PadAction");
        };
        
                /**
         * Retrouve l'ongelt actif
         * @returns {undefined}
         */
        PadAction.findTabSelected = function()
        {
            var tb = document.getElementById('tbDoc');
            
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
                dvDocument = document.getElementById("dvDocument");
                
                return dvDocument;
            }
        };
        
        /**
         * Sauvegarde le contenu
         * @returns {undefined}
         */
        PadAction.saveContent = function()
        {
            //Recuyeration de l'onglet selectionné
            dvContent = PadAction.findTabSelected();
            
            //Recuêration du contenu
            txtContent = dvContent.getElementsByTagName("textarea");
            content = eval("CKEDITOR.instances." + txtContent[0].id+".getData()");
            
            //Recuperation de l'identifiant dez l'article
            controls = dvContent.getElementsByTagName("input");
            
            for(i= 0; i < controls.length; i++)
            {
                if(controls[i].type == "hidden")
                {
                    var documentId = controls[i].value;
                }
            }
           
            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Pad&Methode=UpdateContent";
               JAjax.data += "&DocumentId=" + documentId;
               JAjax.data += "&content=" +  PadAction.FormatDataForServeur(content);
          
            alert(JAjax.GetRequest("Ajax.php"));
        };
        
        
        /**
         * Remplace les caractères spéciaux
         */
        PadAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");
    
            return data;
        };
        
        /**
         * Remplace les caractères speciaux
         */
        PadAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");
       
            return data;
        };
        
          /**
         * 
         * @returns {String}Obitent le bouton de telechargement de fichier
         */
        PadAction.getUploadButton = function()
        {
            var spUpload = "<span id='spUploadAjaxControl'>";
                spUpload +=" <b id='spUploadAjaxValide' class='FormUserValid' style='display:none'>Enregistrement Réussie</b>";
                spUpload +="<b id='spUploadAjaxError' class='FormUserError' style='display:none'>Erreur</b>";
                spUpload +="<br>";
                spUpload +="<input id='hdAppfileToUpload' type='hidden' value='Pad'>";
                spUpload +="<input id='hdIdElementfileToUpload' type='hidden' value=''>";
                spUpload +="<input id='hdActionfileToUpload' type='hidden' value='UploadImageBlog'>";
                spUpload +="<input id='fileToUpload' class='input' type='file' name='fileToUpload' size='45'>";
                spUpload +="<button id='buttonUpload' class='cke_dialog_ui_button' onclick='PadAction.upload();'>Envoyer</button>";
                spUpload +="</span>";
    
                return spUpload;
        };
        
        /**
         * 
         * @returns {undefined}enoit l'image sur le serveur
         */
        PadAction.upload = function()
        {
            UploadAjaxFile.Upload('PadAction.ReloadImage()', 'fileToUpload');
        };
        
         /**
         * Recharge la bibliothèque d'image
         * @returns {undefined}
         */
        PadAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=Pad&Methode=GetImages";
              
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
         
         /*
          * Pop in pour partager un document
          */
         PadAction.ShowShareDocument = function(docId, callBack)
         {
            var param = Array();
                param['App'] = 'Pad';
                param['Title'] = 'Pad.ShareFile';
                param['DocId'] = docId;
             
                Dashboard.OpenPopUp('Pad','ShowShareFile', '','','', 'PadAction.'+callBack+'()', serialization.Encode(param));

         };
         
         /*
          * Selectiond'un ou plusieurs utilisateurs
          */
         PadAction.SelectUser = function(docId)
         {
                var dvFolderUserShared = document.getElementById("dvFolderUserShared");
            var dvResult = document.getElementById("divResult");
            var controls = dvResult.getElementsByTagName("input");
            var UserId = Array();
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked)
                {
                  UserId.push(controls[i].id);
                }
            }
 
            var JAjax = new ajax();
                JAjax.data = "Class=Pad&Methode=AddUserDoc&App=Pad&DocId="+ docId + "&UsersId="+ UserId.join(";") ;

            dvFolderUserShared.innerHTML = JAjax.GetRequest("Ajax.php");
            
            if(dvResult != null)
            {
                document.body.removeChild(dvResult);
            }
            else
            {
              ClosePopUp();
            
             }
         };
         
        /**
         * Supprime un utilisateur du partage
         */
        PadAction.RemoveUser = function(control)
        {
            if(Dashboard.Confirm("Delete"))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=Pad&Methode=RemoveUser&App=Pad&ShareId="+ control.id ;

                    var result = JAjax.GetRequest("Ajax.php");

                    if(result.indexOf("success") > -1)
                    {
                        control.parentNode.parentNode.removeChild(control.parentNode);
                    }
            } 
        };
        
        