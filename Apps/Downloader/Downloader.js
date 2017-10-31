var Downloader = function() {};

	/*
	* Chargement de l'application
	*/
	Downloader.Load = function(parameter)
	{
		this.LoadEvent();

                DownloaderAction.LoadMyRessource();
	};

	/*
	* Chargement des �venements
	*/
	Downloader.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Downloader.Execute, "", "Downloader");
		Dashboard.AddEventWindowsTool("Downloader");
	};

   /*
	* Execute une fonction
	*/
	Downloader.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Downloader");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Downloader.Comment = function()
	{
		Dashboard.Comment("Downloader", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Downloader.About = function()
	{
		Dashboard.About("Downloader");
	};

	/*
	*	Affichage de l'aide
	*/
	Downloader.Help = function()
	{
		Dashboard.OpenBrowser("Downloader","{$BaseUrl}/Help-App-Downloader.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Downloader.ReportBug = function()
	{
		Dashboard.ReportBug("Downloader");
	};

	/*
	* Fermeture
	*/
	Downloader.Quit = function()
	{
		Dashboard.CloseApp("","Downloader");
	};

        /*
         * Evenement
         */
        DownloaderAction = function(){};

        /*
         * Pop in d'ajout/ Edition d'une ressources
         */
        DownloaderAction.ShowAddRessource = function(ressourceId)
        {
            var param = Array();
                param['App'] = 'Downloader';
                param['Title'] = 'Downloader.ShowAddRessource';

                if(ressourceId != undefined)
                {
                    param['RessourceId'] = ressourceId;
                }

                Dashboard.OpenPopUp('Downloader','ShowAddRessource', '','','', 'DownloaderAction.LoadMyRessource()', serialization.Encode(param));
        };

        /*
         * Charge mes ressources
         */
        DownloaderAction.LoadMyRessource = function()
        {
            var data = "Class=Downloader&Methode=LoadMyRessource&App=Downloader";
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Downloader");
        };

        /**
         * Affichage d'un champ Emaiil de collecte
         * @param {type} ressourceId
         * @param {type} control
         * @returns {undefined}
         */
        DownloaderAction.ShowEmailDownload = function(ressourceId, control)
        {
            var conteneur = control.parentNode;

            //Suppression du lien
            conteneur.removeChild(control);

            //Champ email
            conteneur.innerHTML = "<input id='tbRessourceEmail' class='form-control newsletter-home' type='email' placeholder='Entrer votre adresse mail'>";

            //Bouotn
            btnSend = "<input type='button' class='btn btn-primary' onclick='DownloaderAction.SaveEmail("+ressourceId+", this)' value= 'Télécharger' > ";

            conteneur.innerHTML+= btnSend;
        };

        /**
         * Enregistre l'email
         * @param {type} ressourcesId
         * @returns {undefined}
         */
        DownloaderAction.SaveEmail = function(ressourcesId, control)
        {
          $tbEmail = document.getElementById("tbRessourceEmail");

           if($tbEmail.value != "")
           {
              var JAjax = new ajax();
                  JAjax.data = "App=Downloader&Methode=SaveEmail";
                  JAjax.data += "&ressourceId=" + ressourcesId;

                  //Recuperation du champ
                  JAjax.data += "&email=" + $tbEmail.value;

                  var url = JAjax.GetRequest("Ajax.php");

                  control.parentNode.innerHTML = "Merci";
                  
                  window.location.href = url;
          }
          else
          {
            alert("L'email saisi n'est pas correct!");
          }
        };

        /**
         * Affiche les email des contacts
         * @returns {undefined}
         */
        DownloaderAction.LoadContact = function(ressourceId)
        {
                  var param = Array();
                param['App'] = 'Downloader';
                param['Title'] = 'Downloader.ShowContact';
                param['RessourceId'] = ressourceId;

                Dashboard.OpenPopUp('Downloader','ShowContact', '','','', '', serialization.Encode(param));
        };
