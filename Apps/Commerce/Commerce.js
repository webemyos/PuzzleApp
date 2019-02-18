var Commerce = function() {};

	/*
	* Chargement de l'application
	*/
	Commerce.Load = function(parameter)
	{
		this.LoadEvent(parameter);
	};

	/*
	* Chargement des �venements
	*/
	Commerce.LoadEvent = function(parameter)
	{
        Dashboard.AddEventAppMenu(Commerce.Execute, "", "Commerce");
        Dashboard.AddEventWindowsTool("Commerce");
            
                if(parameter != "" )
            {
                CommerceAction.LoadCommerce('', parameter);
            }
            else
            {
                CommerceAction.LoadMyCommerce();
            }
    };

   /*
	* Execute une fonction
	*/
	Commerce.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Commerce");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Commerce.Comment = function()
	{
		Dashboard.Comment("Commerce", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Commerce.About = function()
	{
		Dashboard.About("Commerce");
	};

	/*
	*	Affichage de l'aide
	*/
	Commerce.Help = function()
	{
		Dashboard.OpenBrowser("Commerce","{$BaseUrl}/Help-App-Commerce.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Commerce.ReportBug = function()
	{
		Dashboard.ReportBug("Commerce");
	};

	/*
	* Fermeture
	*/
	Commerce.Quit = function()
	{
		Dashboard.CloseApp("","Commerce");
	};
        
    /*
        * Evenement utilsateur
        * @returns {undefined}
        */
    CommerceAction = function(){};
    
    /**
     * Pop in de création de Ecommerce
     * @return
     */
    CommerceAction.ShowAddCommerce = function()
    {      
        var param = Array();
            param['App'] = 'Commerce';
            param['Title'] = 'Commerce.Detail';
            
            Dashboard.OpenPopUp('Commerce','ShowAddCommerce', '','','', 'CommerceAction.LoadMyCommerce()', serialization.Encode(param));

        //Ajout des CKeditor
        Dashboard.SetBasicAdvancedText("tbLongDescription");
    };
            
    /*
        * Charge les commerces de l'utilisateur
        * @returns {undefined}
        */
    CommerceAction.LoadMyCommerce = function()
    {
        var data = "Class=Commerce&Methode=LoadMyCommerce&App=Commerce";
            Dashboard.LoadControl("dvDesktop", data, "" , "div", "Commerce"); 
    };
    
     
        
        