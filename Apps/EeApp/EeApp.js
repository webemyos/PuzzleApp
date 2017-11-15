var EeApp = function() {};

	/*
	* Chargement de l'application
	*/
	EeApp.Load = function(parameter)
	{
		this.LoadEvent();

                //Chargement des app de l'utilisateur
                EeAppAction.LoadMyApp();
	};

	/*
	* Chargement des �venements
	*/
	EeApp.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(EeApp.Execute, "", "EeApp");
		Dashboard.AddEventWindowsTool("EeApp");
	};

   /*
	* Execute une fonction
	*/
	EeApp.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "EeApp");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeApp.Comment = function()
	{
		Dashboard.Comment("EeApp", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeApp.About = function()
	{
		Dashboard.About("EeApp");
	};

	/*
	*	Affichage de l'aide
	*/
	EeApp.Help = function()
	{
		Dashboard.OpenBrowser("EeApp","{$BaseUrl}/Help-App-EeApp.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeApp.ReportBug = function()
	{
		Dashboard.ReportBug("EeApp");
	};

	/*
	* Fermeture
	*/
	EeApp.Quit = function()
	{
		Dashboard.CloseApp("","EeApp");
	};

        /**
         * Evenement utilisateur
         * @returns {undefined}
         */
        EeAppAction = function(){};

        /**
         * Charge les applications de l'utilisateurs
         * @returns {undefined}
         */
        EeAppAction.LoadMyApp =function()
        {
           var data = "Class=EeApp&Methode=LoadMyApp&App=EeApp";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "EeApp");
        };

        /**
         * Charge les applications disponibles
         * @returns {undefined}
         */
        EeAppAction.LoadApps = function()
        {
           var data = "Class=EeApp&Methode=LoadApps&App=EeApp";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "EeApp");
        };

        /**
         * Ajoute une application au bureau
         * @returns
         */
        EeAppAction.Add = function(appId, control)
        {
          var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Add&App=EeApp&appId="+ appId ;

            alert(JAjax.GetRequest("Ajax.php"));

            control.parentNode.removeChild(control);

            EeAppAction.RefreshAppMenu();
        };

        //Supprime une application au bureau
        EeAppAction.Remove = function(appId, control)
        {
             if(confirm(Dashboard.GetCode("ConfirmDelete")))
             {
            var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Remove&App=EeApp&appId="+ appId ;

               JAjax.GetRequest("Ajax.php");
                control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);

                EeAppAction.RefreshAppMenu();
            }
        };

        /*
         * Refresh
         * @returns {undefined}
         */
        EeAppAction.RefreshAppMenu = function()
        {
           var JAjax = new ajax();
               JAjax.data = "Class=DashBoardManager&Methode=LoadUserApp&show=1" ;

            var lstApp = document.getElementById("lstApp");
            lstApp.innerHTML = JAjax.GetRequest("Ajax.php");
       };

        /**
         * Charge la partie Administration des app
         * @returns {undefined}
         */
        EeAppAction.LoadAdmin = function()
        {
           var data = "Class=EeApp&Methode=LoadAdmin&App=EeApp";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "EeApp");
        };

         /**
         * Popin d'ajout d'annonce
         */
        EeAppAction.ShowAddApp = function(appId)
        {
            var param = Array();
                param['App'] = 'EeApp';
                param['Title'] = 'EeApp.ShowAddApp';

								if(appId != undefined)
								{
                	param['appId'] = appId;
              	}

                Dashboard.OpenPopUp('EeApp','ShowAddApp', '','','', 'EeAppAction.LoadAdmin()', serialization.Encode(param));

                Dashboard.SetBasicAdvancedText("tbDescription");

        };

        /**
         * Pop de gestion des administrateurs
         * @param {type} appId
         * @returns
         */
        EeAppAction.ShowAdmin = function(appId)
        {
            var param = Array();
                param['App'] = 'EeApp';
                param['Title'] = 'EeApp.ShowAdmin';
                param['appId'] = appId;

                Dashboard.OpenPopUp('EeApp','ShowAdmin', '','','', 'EeAppAction.LoadAdmin()', serialization.Encode(param));
        };

        /*
         * Ajoute un administrateur
         */
        EeAppAction.AddAdmin = function(appId)
        {
            var divResult = document.getElementById("divResult");
            var controls = divResult.getElementsByTagName("input");
            var dvAdmin = document.getElementById("dvAdmin");

            idContact = Array();

            for(i=0; i< controls.length;i++)
            {
                    if(controls[i].type == "checkbox" && controls[i].checked)
                    {
                             idContact[i] = controls[i].id;
                    }
            }

            var JAjax = new ajax();
                JAjax.data = "Class=EeApp&Methode=AddAdmin&App=EeApp&appId="+ appId ;
                JAjax.data += "&contactId="+ idContact.join(",");

           dvAdmin.innerHTML = JAjax.GetRequest("Ajax.php");

            Dashboard.CloseSearch();
        };

        /**
         * Supprime un administrateur d'une application
         * @param {type} id
         * @param {type} control
         * @returns {undefined}
         */
        EeAppAction.DeleteAdmin = function(id, control)
        {
            if(Dashboard.Confirm("Delete"))
            {
             var JAjax = new ajax();
                JAjax.data = "Class=EeApp&Methode=DeleteAdmin&App=EeApp&adminId="+ id ;

                JAjax.GetRequest("Ajax.php");

                control.parentNode.parentNode.removeChild(control.parentNode);
            }
        };

        /*
        * Pop in pour Ajouter des applications
        */
        EeAppAction.ShowUploadApp = function()
        {
            var param = Array();
                param['App'] = 'EeApp';
                param['Title'] = 'EeApp.ShowUploadApp';

                Dashboard.OpenPopUp('EeApp','ShowUploadApp', '','','', 'EeAppAction.LoadAdmin()', serialization.Encode(param));
        };
        
        /*
         * Supprime une app
         */
        EeAppAction.RemoveApp = function(control)
        {
            if(confirm(Dashboard.GetCode("EeApp.RemoveApp")))
            {
             var JAjax = new ajax();
                 JAjax.data = "Class=EeApp&Methode=RemoveApp&App=EeApp&appId="+ control.id ;

                JAjax.GetRequest("Ajax.php");
                
                control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
            }
        };
