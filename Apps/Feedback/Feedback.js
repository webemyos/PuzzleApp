var Feedback = function() {};

	/*
	* Chargement de l'application
	*/
	Feedback.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Feedback.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Feedback.Execute, "", "Feedback");
		Dashboard.AddEventWindowsTool("Feedback");

		EntityGrid.Initialise('gdFeedback');
	};

   /*
	* Execute une fonction
	*/
	Feedback.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Feedback");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Feedback.Comment = function()
	{
		Dashboard.Comment("Feedback", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Feedback.About = function()
	{
		Dashboard.About("Feedback");
	};

	/*
	*	Affichage de l'aide
	*/
	Feedback.Help = function()
	{
		Dashboard.OpenBrowser("Feedback","{$BaseUrl}/Help-App-Feedback.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Feedback.ReportBug = function()
	{
		Dashboard.ReportBug("Feedback");
	};

	/*
	* Fermeture
	*/
	Feedback.Quit = function()
	{
		Dashboard.CloseApp("","Feedback");
	};

	/**
	 * Init Feedback Button
	 */
	Feedback.initWidget = function(){

		var btnFeedback = document.getElementById("btnFeedback");

		if(btnFeedback != null)
		{
			Dashboard.AddEvent(btnFeedback, "click", Feedback.showAddFeed);
		}
	};

	/**
	 * Pop in Add FeedBack
	 * @param {*} e 
	 */
	Feedback.showAddFeed = function(e)
	{
		e.preventDefault();
		var param = Array();
		param['App'] = 'Feedback';
		param['Title'] = 'Feedback.AddFeedback';

		Dashboard.OpenPopUp('Feedback','showAddFeed', '','','', '', serialization.Encode(param));
	};

	Feedback.initWidget();

    //Evenement
	FeedbackAction = function(){};

	/**Affiche le détail d'un feedback */
	FeedbackAction.EditFeedback = function(feedbackId)
	{
		var param = Array();
		param['App'] = 'Feedback';
		param['Title'] = 'Feedback.EditFeedback';

		if(feedbackId != undefined)
		{
			param['entityId'] = feedbackId;
		}

		Dashboard.OpenPopUp('Feedback','EditFeedback', '','','', '', serialization.Encode(param));
	};