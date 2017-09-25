var EeCommunique = function() {};

	/*
	* Chargement de l'application
	*/
	EeCommunique.Load = function(parameter)
	{
                
                 parameter = serialization.Decode(parameter);
	 	
                EeCommunique.communiqueId = parameter['CommuniqueId'];
	 	
		this.LoadEvent();

                if(typeof(EeCommunique.communiqueId)  != "undefined")
                {
                    EeCommuniqueAction.LoadCommunique(EeCommunique.communiqueId);
                }
                else
                {
                    //Charge les Communique de presse de l'utilisateur
                      EeCommuniqueAction.LoadMyCommunique();
	        }
        };

	/*
	* Chargement des �venements
	*/
	EeCommunique.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeCommunique.Execute, "", "EeCommunique");
		Eemmys.AddEventWindowsTool("EeCommunique");
	};

   /*
	* Execute une fonction
	*/
	EeCommunique.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeCommunique");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeCommunique.Comment = function()
	{
		Eemmys.Comment("EeCommunique", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeCommunique.About = function()
	{
		Eemmys.About("EeCommunique");
	};

	/*
	*	Affichage de l'aide
	*/
	EeCommunique.Help = function()
	{
		Eemmys.OpenBrowser("EeCommunique","{$BaseUrl}/Help-App-EeCommunique.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeCommunique.ReportBug = function()
	{
		Eemmys.ReportBug("EeCommunique");
	};

	/*
	* Fermeture
	*/
	EeCommunique.Quit = function()
	{
		Eemmys.CloseApp("","EeCommunique");
	};
        
        /**
         * Evenement
         */
        EeCommuniqueAction = function(){};
        
        /**
         * Pop in d'ajout de communique
         */
        EeCommuniqueAction.ShowAddCommunique = function()
        {
            var param = Array();
                param['App'] = 'EeCommunique';
                param['Title'] = 'EeCommunique.ShowAddCommunique';
              
                Eemmys.OpenPopUp('EeCommunique','ShowAddCommunique', '','','', 'EeCommuniqueAction.LoadMyCommunique()', serialization.Encode(param));
        };
        
        /**
         * Charge les communiquée de presse de l'utilisateur
         */
         EeCommuniqueAction.LoadMyCommunique = function()
         {
           var data = "Class=EeCommunique&Methode=LoadMyCommunique&App=EeCommunique";
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeCommunique"); 
         };
         
         /**
          * Charge un communique de presse 
          */
         EeCommuniqueAction.LoadCommunique = function(communiqueId)
         {
             EeCommuniqueAction.CommuniqueId = communiqueId;
                 
               var data = "Class=EeCommunique&Methode=LoadCommunique&App=EeCommunique";
                   data += "&CommuniqueId=" + communiqueId;
               
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeCommunique"); 
               
                //Initialisation dez l'editeur
              var editor = CKEDITOR.replace( 'tbContentCommunique'  );

             //Classe js appelé pour la sauvegarde
             CKEDITOR.setApp("EeCommuniqueAction");
             
             //Charge les image du communique
             EeCommuniqueAction.ReloadImage();
         };
         
         /**
          * Sauvegarde le contenu du communique de presse
          */
         EeCommuniqueAction.saveContent = function()
         {
            //Recuêration du contenu
            txtContent = document.getElementById("tbContentCommunique");
            content = eval("CKEDITOR.instances." + txtContent.id+".getData()");
            
            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=EeCommunique&Methode=UpdateContent";
               JAjax.data += "&CommuniqueId=" + EeCommuniqueAction.CommuniqueId;
               JAjax.data += "&Content=" + EeCommuniqueAction.FormatDataForServeur(content);
          
            alert(JAjax.GetRequest("Ajax.php"));
         };
         
        /**
         * Remplace les caractères spéciaux
         */
        EeCommuniqueAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");
    
            return data;
        };
        
         /**
         * Remplace les caractères speciaux
         */
        EeCommuniqueAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");
       
            return data;
        };
        
        /**
         * Charge les liste des contacts
         */
        EeCommuniqueAction.LoadListContact = function()
        {
              var data = "Class=EeCommunique&Methode=LoadListContact&App=EeCommunique";
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeCommunique"); 
        };
        
        /**
         * Pop in d'ajout de liste de contact
         */
        EeCommuniqueAction.ShowAddList = function()
        {
            var param = Array();
                param['App'] = 'EeCommunique';
                param['Title'] = 'EeCommunique.ShowAddList';
              
                Eemmys.OpenPopUp('EeCommunique','ShowAddList', '','','', 'EeCommuniqueAction.LoadListContact()', serialization.Encode(param));
        };
        
        /**
         * Charge les contact d'un liste
         */
        EeCommuniqueAction.LoadList = function(listId)
        {
           var data = "Class=EeCommunique&Methode=LoadList&App=EeCommunique";
               data += "&ListId=" + listId;
           
               Eemmys.LoadControl("dvDesktop", data, "" , "div", "EeCommunique"); 
        };
        
        /**
         * Supprime un contact d'une liste
         */
        EeCommuniqueAction.DeleteMember = function(control, memberId)
        {
            if(Eemmys.Confirm("Delete"))
            {
                  //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=EeCommunique&Methode=DeleteMember";
               JAjax.data += "&MemberId=" + memberId;
              
               JAjax.GetRequest("Ajax.php");
            
             control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);   
            }
        };
        
        /**
         * Charge la page d'accueil des recherche de blog
         */
        EeCommuniqueAction.LoadHomeFrame = function()
        {
            var frBlog = document.getElementById('frBlog');
            frBlog.src = "http://bing.com";
            
        };
        
        /**
         * Rafraichit les statistiqu d'un campagne
         * @returns {undefined}
         */
        EeCommuniqueAction.RefreshStatistique = function(communiqueId)
        {
           var data = "Class=EeCommunique&Methode=RefreshStatistique&App=EeCommunique";
               data += "&CommuniqueId=" + communiqueId;
               
               Eemmys.LoadControl("tab_3", data, "" , "div", "EeCommunique"); 
            
        };
        
        /**
         * Affiche le détail d'une campagne
         * @param {type} campagneId
         * @returns {undefined}
         */
        EeCommuniqueAction.EditCampagne = function(campagneId)
        {
            var param = Array();
                param['App'] = 'EeCommunique';
                param['Title'] = 'EeCommunique.EditCampagne';
                param['campagneId'] = campagneId;
              
                Eemmys.OpenPopUp('EeCommunique','EditCampagne', '','','', '', serialization.Encode(param));
        };
        
        /**
         * Suprime une campagne
         * @param {type} campagneId
         * @returns {undefined}
         */
        EeCommuniqueAction.DeleteCampagne = function(campagneId, control)
        {
            if(confirm(Eemmys.GetCode("ConfirmDelete")))
            {
          var JAjax = new ajax();
              JAjax.data = "Class=EeCommunique&Methode=RemoveCampagne&App=EeCommunique&campagneId="+ campagneId ;

               JAjax.GetRequest("Ajax.php");
                control.parentNode.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode.parentNode); 
            }
         };
         
         /**
          * Upoad des image
          * @returns {undefined}
          */
         EeCommuniqueAction.getUploadButton =function()
         {
            var spUpload = "<span id='spUploadAjaxControl'>";
                spUpload +=" <b id='spUploadAjaxValide' class='FormUserValid' style='display:none'>Enregistrement Réussie</b>";
                spUpload +="<b id='spUploadAjaxError' class='FormUserError' style='display:none'>Erreur</b>";
                spUpload +="<br>";
                spUpload +="<input id='hdAppfileToUpload' type='hidden' value='EeCommunique'>";
                spUpload +="<input id='hdIdElementfileToUpload' type='hidden' value='"+ EeCommuniqueAction.CommuniqueId +"'>";
                spUpload +="<input id='hdActionfileToUpload' type='hidden' value='UploadImageCommunique'>";
                spUpload +="<input id='fileToUpload' class='input' type='file' name='fileToUpload' size='45'>";
                spUpload +="<button id='buttonUpload' class='cke_dialog_ui_button' onclick='EeCommuniqueAction.upload();'>Envoyer</button>";
                spUpload +="</span>";
    
                return spUpload;
         };
         
        /**
         * 
         * @returns {undefined}enoit l'image sur le serveur
         */
        EeCommuniqueAction.upload = function()
        {
            UploadAjaxFile.Upload('EeCommuniqueAction.ReloadImage()', 'fileToUpload');
            
            ;
        };
        
         /**
          * Charge les images du communique
          */
         EeCommuniqueAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=EeCommunique&Methode=GetImages";
               JAjax.data += "&CommuniqueId=" + EeCommuniqueAction.CommuniqueId ;
          
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
          * Syncrhonise la liste avec tous les contacts Webemyos
          */
         EeCommuniqueAction.Synchronise = function(listId)
         {
           var JAjax = new ajax();
               JAjax.data = "App=EeCommunique&Methode=Synchronise";
               JAjax.data += "&listId=" + listId;
          
           alert(JAjax.GetRequest("Ajax.php"));
         };