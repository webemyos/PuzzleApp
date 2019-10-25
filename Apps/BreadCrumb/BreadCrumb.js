var BreadCrumb = function() {};

	/*
	* Chargement de l'application
	*/
	BreadCrumb.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	BreadCrumb.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(BreadCrumb.Execute, "", "BreadCrumb");
		Dashboard.AddEventWindowsTool("BreadCrumb");
	};

   /*
	* Execute une fonction
	*/
	BreadCrumb.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "BreadCrumb");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	BreadCrumb.Comment = function()
	{
		Dashboard.Comment("BreadCrumb", "1");
	};

	/*
	*	Affichage de a propos
	*/
	BreadCrumb.About = function()
	{
		Dashboard.About("BreadCrumb");
	};

	/*
	*	Affichage de l'aide
	*/
	BreadCrumb.Help = function()
	{
		Dashboard.OpenBrowser("BreadCrumb","{$BaseUrl}/Help-App-BreadCrumb.html");
	};

   /*
	*	Affichage de report de bug
	*/
	BreadCrumb.ReportBug = function()
	{
		Dashboard.ReportBug("BreadCrumb");
	};

	/*
	* Fermeture
	*/
	BreadCrumb.Quit = function()
	{
		Dashboard.CloseApp("","BreadCrumb");
	};