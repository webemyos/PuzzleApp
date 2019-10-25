var Annonce = function() {};

	/*
	* Chargement de l'application
	*/
	Annonce.Load = function(parameter)
	{
            if(parameter.indexOf("::") > -1)
            {
                parameter = serialization.Decode(parameter);

                Annonce.annonceId = parameter['annonceId'];
                Annonce.ReturnedFunction = parameter['ReturnedFunction'];
            }
            else
            {
                Annonce.annonceId = parameter;
            }
           
            this.LoadEvent();
             
             if( Annonce.annonceId  != "" && Annonce.annonceId != "undefined")
             {
                 AnnonceAction.ShowAnnonces(Annonce.annonceId);
             }
             else
             {
                    //Charge les formulaires de l'utilisateur
                   AnnonceAction.ShowAnnonces();
             }
	};

	/*
	* Chargement des �venements
	*/
	Annonce.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Annonce.Execute, "", "Annonce");
		Dashboard.AddEventWindowsTool("Annonce");
    };

   /*
	* Execute une fonction
	*/
	Annonce.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Annonce");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Annonce.Comment = function()
	{
		Dashboard.Comment("Annonce", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Annonce.About = function()
	{
		Dashboard.About("Annonce");
	};

	/*
	*	Affichage de l'aide
	*/
	Annonce.Help = function()
	{
		Dashboard.OpenBrowser("Annonce","{$BaseUrl}/Help-App-Annonce.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Annonce.ReportBug = function()
	{
		Dashboard.ReportBug("Annonce");
	};

	/*
	* Fermeture
	*/
	Annonce.Quit = function()
	{
		Dashboard.CloseApp("","Annonce");
	};
        
        /*
         * Evenement
         */
        AnnonceAction = function(){};
        
        /**
         * Popin d'ajout d'annonce
         */
        AnnonceAction.ShowAddAnnonce = function()
        {
            var param = Array();
                param['App'] = 'Annonce';
                param['Title'] = 'Annonce.ShowAddAnnonce';
              
                Dashboard.OpenPopUp('Annonce','ShowAddAnnonce', '','','', 'AnnonceAction.ShowMyAnnonce()', serialization.Encode(param));
                
                Dashboard.SetBasicAdvancedText("tbDescription");  
        };
        
        /**
         * Charge les annonce de l'utilisateur
         */
        AnnonceAction.ShowMyAnnonce = function()
        {
           var data = "Class=Annonce&Methode=ShowMyAnnonce&App=Annonce";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Annonce");
        };
        
        /**
         * Edite une annonce
         * @returns {undefined}
         */
        AnnonceAction.EditAnnonce = function(annonceId)
        {
           AnnonceAction.annonceId = annonceId;
            
           var param = Array();
               param['App'] = 'Annonce';
               param['Title'] = 'Annonce.ShowAddAnnonce';
               param['AnnonceId'] = annonceId;
              
                Dashboard.OpenPopUp('Annonce','ShowAddAnnonce', '','','', 'AnnonceAction.RefreshAnnonce()', serialization.Encode(param));
                
                Dashboard.SetBasicAdvancedText("tbDescription");
        };
        
        /**
         * Rafrachit une annonce
         */
        AnnonceAction.RefreshAnnonce = function()
        {
             var data = "Class=Annonce&Methode=GetAnnonce&App=Annonce";
                 data += "&AnnonceId=" +AnnonceAction.annonceId;
                   
               Dashboard.LoadControl("dvAnnonce_" + AnnonceAction.annonceId, data, "" , "div", "Annonce"); 
        };
        
        /**
         * Charge les annonce de l'utilisateur
         */
        AnnonceAction.ShowAnnonces = function(annonceId)
        {
           var data = "Class=Annonce&Methode=ShowAnnonces&App=Annonce";
            
            if(typeof(annonceId) != "undefined")
            {
                data += "&annonceId="+annonceId;
            }
            
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Annonce");
        };
        
        /**
         * Popin de réponse
         * @returns {undefined}
         */
        AnnonceAction.ShowAddResponse = function(annonceId)
        {
            AnnonceAction.annonceId = annonceId;
            
                var param = Array();
               param['App'] = 'Annonce';
               param['Title'] = 'Annonce.ShowAddReponse';
               param['AnnonceId'] = annonceId;
              
             
               Dashboard.OpenPopUp('Annonce','ShowAddReponse', '','','', 'AnnonceAction.RefreshMessage()', serialization.Encode(param));
        };
        
        /**
         * Rafrachit les messages d'une annonce
         */
        AnnonceAction.RefreshMessage = function()
        {
               var data = "Class=Annonce&Methode=GetReponse&App=Annonce";
                   data += "&AnnonceId=" +AnnonceAction.annonceId;
                   
               Dashboard.LoadControl("spMessage_" + AnnonceAction.annonceId, data, "" , "td", "Annonce");
        };
        
        
        /**
         * Affiche le détail d'une annonce
         */
        AnnonceAction.ShowDetail = function(annonceId)
        {
           var param = Array();
               param['App'] = 'Annonce';
               param['Title'] = 'Annonce.ShowDetail';
               param['AnnonceId'] = annonceId;
              
               Dashboard.OpenPopUp('Annonce','ShowDetail', '','','', '', serialization.Encode(param));
        };
        
        /**
         * Edite une réponse
         * @param {type} reponseId
         * @returns {undefined}
         */
        AnnonceAction.EditReponse = function(reponseId)
        {
           var param = Array();
               param['App'] = 'Annonce';
               param['Title'] = 'Annonce.EditReponse';
               param['ReponseId'] = reponseId;
              
               Dashboard.OpenPopUp('Annonce','EditReponse', '','','', '', serialization.Encode(param));
        };