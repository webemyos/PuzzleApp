var EeXXX = function() {};

	/*
	* Chargement de l'application
	*/
	EeXXX.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des évenements
	*/
	EeXXX.LoadEvent = function()
	{
		Eemmys.AddEventAppMenu(EeXXX.Execute, "", "EeXXX");
		Eemmys.AddEventWindowsTool("EeXXX");
	};

   /*
	* Execute une fonction
	*/
	EeXXX.Execute = function(e)
	{
		//Appel de la fonction
		Eemmys.Execute(this, e, "EeXXX");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	EeXXX.Comment = function()
	{
		Eemmys.Comment("EeXXX", "1");
	};

	/*
	*	Affichage de a propos
	*/
	EeXXX.About = function()
	{
		Eemmys.About("EeXXX");
	};

	/*
	*	Affichage de l'aide
	*/
	EeXXX.Help = function()
	{
		Eemmys.OpenBrowser("EeXXX","{$BaseUrl}/Help-App-EeXXX.html");
	};

   /*
	*	Affichage de report de bug
	*/
	EeXXX.ReportBug = function()
	{
		Eemmys.ReportBug("EeXXX");
	};

	/*
	* Fermeture
	*/
	EeXXX.Quit = function()
	{
		Eemmys.CloseApp("","EeXXX");
	};