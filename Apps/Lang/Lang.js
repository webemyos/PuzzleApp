var Lang = function() {};

	/*
	* Chargement de l'application
	*/
	Lang.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Lang.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Lang.Execute, "", "Lang");
		Dashboard.AddEventWindowsTool("Lang");
                
                LangAction.LoadElement(0);
	};

   /*
	* Execute une fonction
	*/
	Lang.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Lang");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Lang.Comment = function()
	{
		Dashboard.Comment("Lang", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Lang.About = function()
	{
		Dashboard.About("Lang");
	};

	/*
	*	Affichage de l'aide
	*/
	Lang.Help = function()
	{
		Dashboard.OpenBrowser("Lang","{$BaseUrl}/Help-App-Lang.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Lang.ReportBug = function()
	{
		Dashboard.ReportBug("Lang");
	};

	/*
	* Fermeture
	*/
	Lang.Quit = function()
	{
		Dashboard.CloseApp("","Lang");
	};
        
        /*
         * Evenements
         */
        LangAction = function()
        {
        
        };
        
        /*
         * Charge les Elements courantes
         */
        LangAction.LoadElement = function(page)
        {
            var data = "Class=Lang&Methode=LoadElement&App=Lang";
                data += "&page=" + page;
                
            Dashboard.LoadControl("dvDesktop", data, "" , "div", "Lang");
            
            var desktop = document.getElementById("appRunLang");
            var input = desktop.getElementsByTagName("input");
            
            for(i=0; i < input.length; i++)
            {
                Dashboard.AddEvent(input[i], "blur", LangAction.UpdateElement);
            }
            //Ajout des evenement de sauvegarde et de suppression
           /* $("#Id tr .icon-edit ").click(function(){LangAction.EditElement(this) });
            $("#Id tr .icon-save ").click(function(){LangAction.SaveElement(this) });
            
            $("#Id tr .fa-remove").click(function(){LangAction.RemoveElement(this) });
            $("#Id tr input").blur(function(){LangAction.UpdateElement(this) });*/
        };
        
        LangAction.EditElement = function(e)
        {
            var container = e.parentNode.parentNode;
            var control = container.getElementsByTagName("input");

            
            //MOde POP up
            var param = Array();
            param['App'] = 'Lang';
            param['Title'] = 'Lang.EditElement';
            param['elementId'] = control[0].id;

            Dashboard.OpenPopUp('Lang','EditElement', '','','', 'LangAction.RefreshElement()', serialization.Encode(param));

          Dashboard.SetBasicAdvancedText("tbLibelle");
        };
        
        /*
         * Enregistre l'element
         * @param {type} e
         * @returns {undefined}
         */
        LangAction.SaveElement = function(e)
        {
               var container = e.parentNode.parentNode;
               var control = container.getElementsByTagName("input");
               
              
              alert(control[0].value);
        };
        
        /*
         * Delete a element
         */
        LangAction.RemoveElement = function(e)
        {
            var idElement = e.parentNode.parentNode.childNodes[0].nextSibling.innerHTML;
            
            var JAjax = new ajax();
                JAjax.data = "App=Lang&Methode=RemoveElement";
                JAjax.data += "&idElement="+idElement;
                
           JAjax.GetRequest("Ajax.php");
            
            e.parentNode.parentNode.parentNode.removeChild(e.parentNode.parentNode);
        };
        
          /*
         * Delete a element
         */
        LangAction.UpdateElement = function(e)
        {
            var idElement = e.srcElement.parentNode.parentNode.childNodes[0].nextSibling.innerHTML;
           
            var JAjax = new ajax();
                JAjax.data = "App=Lang&Methode=UpdateElement";
                JAjax.data += "&idElement="+idElement;
                JAjax.data += "&value="+e.srcElement.value;
                
           JAjax.GetRequest("Ajax.php");
       };