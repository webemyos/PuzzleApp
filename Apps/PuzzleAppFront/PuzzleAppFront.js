var PuzzleAppFront = function() {};

	/*
	* Chargement de l'application
	*/
	PuzzleAppFront.Load = function(parameter)
	{
		this.LoadEvent();
		Dashboard.LoadModule("PuzzleAppFront", "Home");
	};

	/*
	* Chargement des �venements
	*/
	PuzzleAppFront.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(PuzzleAppFront.Execute, "", "PuzzleAppFront");
		Dashboard.AddEventWindowsTool("PuzzleAppFront");

		var menus = document.getElementsByTagName("li");
		for(i=0; i < menus.length; i++)
		{
			if(menus[i].dataset.module != undefined)
			{
				Dashboard.AddEvent(menus[i], "click", PuzzleAppFront.Navigate);
			}
		}
	};

	/*
	* Charge le bon module
	*/
	PuzzleAppFront.Navigate = function(e)
	{
		Dashboard.LoadModule("PuzzleAppFront", e.srcElement.dataset.module);
	};

   /*
	* Execute une fonction
	*/
	PuzzleAppFront.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "PuzzleAppFront");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	PuzzleAppFront.Comment = function()
	{
		Dashboard.Comment("PuzzleAppFront", "1");
	};

	/*
	*	Affichage de a propos
	*/
	PuzzleAppFront.About = function()
	{
		Dashboard.About("PuzzleAppFront");
	};

	/*
	*	Affichage de l'aide
	*/
	PuzzleAppFront.Help = function()
	{
		Dashboard.OpenBrowser("PuzzleAppFront","{$BaseUrl}/Help-App-PuzzleAppFront.html");
	};

   /*
	*	Affichage de report de bug
	*/
	PuzzleAppFront.ReportBug = function()
	{
		Dashboard.ReportBug("PuzzleAppFront");
	};

	/*
	* Fermeture
	*/
	PuzzleAppFront.Quit = function()
	{
		Dashboard.CloseApp("","PuzzleAppFront");
	};