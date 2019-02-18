var EeXXX = function() {};

	/*
	* Chargement de l'application
	*/
	EeXXX.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	EeXXX.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(EeXXX.Execute, "", "EeXXX");
		Dashboard.AddEventWindowsTool("EeXXX");
	};

   /*
	* Execute une fonction
	*/
	EeXXX.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "EeXXX");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeXXX.Comment = function()
	{
		Dashboard.Comment("EeXXX", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeXXX.About = function()
	{
		Dashboard.About("EeXXX");
	};

	/*
	*	Affichage de l'aide
	*/
	EeXXX.Help = function()
	{
		Dashboard.OpenBrowser("EeXXX","{$BaseUrl}/Help-App-EeXXX.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeXXX.ReportBug = function()
	{
		Dashboard.ReportBug("EeXXX");
	};

	/*
	* Fermeture
	*/
	EeXXX.Quit = function()
	{
		Dashboard.CloseApp("","EeXXX");
	};