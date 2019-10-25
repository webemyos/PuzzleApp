var Avis = function() {};

	/*
	* Chargement de l'application
	*/
	Avis.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Avis.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Avis.Execute, "", "Avis");
		Dashboard.AddEventWindowsTool("Avis");

		EntityGrid.Initialise('gdAvis');
	};

   /*
	* Execute une fonction
	*/
	Avis.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Avis");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Avis.Comment = function()
	{
		Dashboard.Comment("Avis", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Avis.About = function()
	{
		Dashboard.About("Avis");
	};

	/*
	*	Affichage de l'aide
	*/
	Avis.Help = function()
	{
		Dashboard.OpenBrowser("Avis","{$BaseUrl}/Help-App-Avis.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Avis.ReportBug = function()
	{
		Dashboard.ReportBug("Avis");
	};

	/*
	* Fermeture
	*/
	Avis.Quit = function()
	{
		Dashboard.CloseApp("","Avis");
	};

	/**
	 *  Gestion des Events
	 * @constructor
	 */
	AvisAction = function(){};

	/**
    * Edite un avis
    * @constructor
    */
	AvisAction.EditAvis = function(avisId)
	{
		var param = Array();
		param['App'] = 'Avis';
		param['Title'] = 'Avis.EditAvis';
		param['entityId'] = avisId;

		Dashboard.OpenPopUp('Avis','EditAvis', '','','', 'AvisAction.RefreshAvis()', serialization.Encode(param));
	};

   /***
	 *  Rafraichit la liste des avis
	 * @constructor
	 */
	AvisAction.RefreshAvis = function()
	{
		//Rafrachit le tchat
		var data = "Class=Avis&Methode=GetAvis&App=Avis";
		Dashboard.LoadControl("dvAvis", data, "","div", "Avis");

		EntityGrid.Initialise('gdAvis');
	};