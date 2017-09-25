var Notify = function() {};

	/*
	* Chargement de l'application
	*/
	Notify.Load = function(parameter)
	{
            this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Notify.LoadEvent = function()
	{
            Dashboard.AddEventAppMenu(Notify.Execute, "", "Notify");
            Dashboard.AddEventWindowsTool("Notify");

            var nbNotif= document.getElementById("nbNotify");

            var JAjax = new ajax();
                  JAjax.data = "App=Notify&Methode=ViewNotify";
            nbNotif.innerHTML = JAjax.GetRequest("Ajax.php");
	};

   /*
	* Execute une fonction
	*/
	Notify.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Notify");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Notify.Comment = function()
	{
		Dashboard.Comment("Notify", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Notify.About = function()
	{
		Dashboard.About("Notify");
	};

	/*
	*	Affichage de l'aide
	*/
	Notify.Help = function()
	{
		Dashboard.OpenBrowser("Notify","{$BaseUrl}/Help-App-Notify.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Notify.ReportBug = function()
	{
		Dashboard.ReportBug("Notify");
	};

	/*
	* Fermeture
	*/
	Notify.Quit = function()
	{
		Dashboard.CloseApp("","Notify");
	};