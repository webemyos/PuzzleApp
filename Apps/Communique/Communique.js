var Communique = function() {};

	/*
	* Chargement de l'application
	*/
	Communique.Load = function(parameter)
	{
                
                 parameter = serialization.Decode(parameter);
	 	
                Communique.communiqueId = parameter['CommuniqueId'];
	 	
		this.LoadEvent();

                if(typeof(Communique.communiqueId)  != "undefined")
                {
                    CommuniqueAction.LoadCommunique(Communique.communiqueId);
                }
                else
                {
                    //Charge les Communique de presse de l'utilisateur
                      CommuniqueAction.LoadMyCommunique();
	        }
        };

	/*
	* Chargement des �venements
	*/
	Communique.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Communique.Execute, "", "Communique");
		Dashboard.AddEventWindowsTool("Communique");
	};

   /*
	* Execute une fonction
	*/
	Communique.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Communique");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Communique.Comment = function()
	{
		Dashboard.Comment("Communique", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Communique.About = function()
	{
		Dashboard.About("Communique");
	};

	/*
	*	Affichage de l'aide
	*/
	Communique.Help = function()
	{
		Dashboard.OpenBrowser("Communique","{$BaseUrl}/Help-App-Communique.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Communique.ReportBug = function()
	{
		Dashboard.ReportBug("Communique");
	};

	/*
	* Fermeture
	*/
	Communique.Quit = function()
	{
		Dashboard.CloseApp("","Communique");
	};
        
        /**
         * Evenement
         */
        CommuniqueAction = function(){};
        
        /**
         * Pop in d'ajout de communique
         */
        CommuniqueAction.ShowAddCommunique = function()
        {
            var param = Array();
                param['App'] = 'Communique';
                param['Title'] = 'Communique.ShowAddCommunique';
              
                Dashboard.OpenPopUp('Communique','ShowAddCommunique', '','','', 'CommuniqueAction.LoadMyCommunique()', serialization.Encode(param));
        };
        
        /**
         * Charge les communiquée de presse de l'utilisateur
         */
         CommuniqueAction.LoadMyCommunique = function()
         {
           var data = "Class=Communique&Methode=LoadMyCommunique&App=Communique";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Communique"); 
         };
         
         /**
          * Charge un communique de presse 
          */
         CommuniqueAction.LoadCommunique = function(communiqueId)
         {
             CommuniqueAction.CommuniqueId = communiqueId;
                 
               var data = "Class=Communique&Methode=LoadCommunique&App=Communique";
                   data += "&CommuniqueId=" + communiqueId;
               
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Communique"); 
               
                //Initialisation dez l'editeur
              var editor = CKEDITOR.replace( 'tbContentCommunique'  );

             //Classe js appelé pour la sauvegarde
             CKEDITOR.setApp("CommuniqueAction");
             
             //Charge les image du communique
             CommuniqueAction.ReloadImage();
         };
         
         /**
          * Sauvegarde le contenu du communique de presse
          */
         CommuniqueAction.saveContent = function()
         {
            //Recuêration du contenu
            txtContent = document.getElementById("tbContentCommunique");
            content = eval("CKEDITOR.instances." + txtContent.id+".getData()");
            
            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Communique&Methode=UpdateContent";
               JAjax.data += "&CommuniqueId=" + CommuniqueAction.CommuniqueId;
               JAjax.data += "&Content=" + CommuniqueAction.FormatDataForServeur(content);
          
            alert(JAjax.GetRequest("Ajax.php"));
         };
         
        /**
         * Remplace les caractères spéciaux
         */
        CommuniqueAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");
    
            return data;
        };
        
         /**
         * Remplace les caractères speciaux
         */
        CommuniqueAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");
       
            return data;
        };
        
        /**
         * Charge les liste des contacts
         */
        CommuniqueAction.LoadListContact = function()
        {
              var data = "Class=Communique&Methode=LoadListContact&App=Communique";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Communique"); 
        };
        
        /**
         * Pop in d'ajout de liste de contact
         */
        CommuniqueAction.ShowAddList = function()
        {
            var param = Array();
                param['App'] = 'Communique';
                param['Title'] = 'Communique.ShowAddList';
              
                Dashboard.OpenPopUp('Communique','ShowAddList', '','','', 'CommuniqueAction.LoadListContact()', serialization.Encode(param));
        };
        
        /**
         * Charge les contact d'un liste
         */
        CommuniqueAction.LoadList = function(listId)
        {
           var data = "Class=Communique&Methode=LoadList&App=Communique";
               data += "&ListId=" + listId;
           
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Communique"); 
        };
        
        /**
         * Supprime un contact d'une liste
         */
        CommuniqueAction.DeleteMember = function(control, memberId)
        {
            if(Dashboard.Confirm("Delete"))
            {
                  //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Communique&Methode=DeleteMember";
               JAjax.data += "&MemberId=" + memberId;
              
               JAjax.GetRequest("Ajax.php");
            
             control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);   
            }
        };
        
        /**
         * Charge la page d'accueil des recherche de blog
         */
        CommuniqueAction.LoadHomeFrame = function()
        {
            var frBlog = document.getElementById('frBlog');
            frBlog.src = "http://bing.com";
            
        };
        
        /**
         * Rafraichit les statistiqu d'un campagne
         * @returns {undefined}
         */
        CommuniqueAction.RefreshStatistique = function(communiqueId)
        {
           var data = "Class=Communique&Methode=RefreshStatistique&App=Communique";
               data += "&CommuniqueId=" + communiqueId;
               
               Dashboard.LoadControl("tab_3", data, "" , "div", "Communique"); 
            
        };
        
        /**
         * Affiche le détail d'une campagne
         * @param {type} campagneId
         * @returns {undefined}
         */
        CommuniqueAction.EditCampagne = function(campagneId)
        {
            var param = Array();
                param['App'] = 'Communique';
                param['Title'] = 'Communique.EditCampagne';
                param['campagneId'] = campagneId;
              
                Dashboard.OpenPopUp('Communique','EditCampagne', '','','', '', serialization.Encode(param));
        };
        
        /**
         * Suprime une campagne
         * @param {type} campagneId
         * @returns {undefined}
         */
        CommuniqueAction.DeleteCampagne = function(campagneId, control)
        {
            if(confirm(Dashboard.GetCode("ConfirmDelete")))
            {
          var JAjax = new ajax();
              JAjax.data = "Class=Communique&Methode=RemoveCampagne&App=Communique&campagneId="+ campagneId ;

               JAjax.GetRequest("Ajax.php");
                control.parentNode.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode.parentNode); 
            }
         };
         
         /**
          * Upoad des image
          * @returns {undefined}
          */
         CommuniqueAction.getUploadButton =function()
         {
            return Dashboard.GetUploadButton("Communique", CommuniqueAction.CommuniqueId, "CommuniqueAction.ReloadImage()","UploadImageCommunique",true);
         };
         
        /**
         * 
         * @returns {undefined}enoit l'image sur le serveur
         */
        CommuniqueAction.upload = function()
        {
            UploadAjaxFile.Upload('CommuniqueAction.ReloadImage()', 'fileToUpload');
        };
        
         /**
          * Charge les images du communique
          */
         CommuniqueAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=Communique&Methode=GetImages";
               JAjax.data += "&CommuniqueId=" + CommuniqueAction.CommuniqueId ;
          
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
         CommuniqueAction.Synchronise = function(listId)
         {
           var JAjax = new ajax();
               JAjax.data = "App=Communique&Methode=Synchronise";
               JAjax.data += "&listId=" + listId;
          
           alert(JAjax.GetRequest("Ajax.php"));
         };