var Sitemap = function() {};

	/*
	* Chargement de l'application
	*/
	Sitemap.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Sitemap.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Sitemap.Execute, "", "Sitemap");
		Dashboard.AddEventWindowsTool("Sitemap");
	};

   /*
	* Execute une fonction
	*/
	Sitemap.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Sitemap");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Sitemap.Comment = function()
	{
		Dashboard.Comment("Sitemap", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Sitemap.About = function()
	{
		Dashboard.About("Sitemap");
	};

	/*
	*	Affichage de l'aide
	*/
	Sitemap.Help = function()
	{
		Dashboard.OpenBrowser("Sitemap","{$BaseUrl}/Help-App-Sitemap.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Sitemap.ReportBug = function()
	{
		Dashboard.ReportBug("Sitemap");
	};

	/*
	* Fermeture
	*/
	Sitemap.Quit = function()
	{
		Dashboard.CloseApp("","Sitemap");
	};