var Contact = function() {};

	/*
	* Chargement de l'application
	*/
	Contact.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Contact.LoadEvent = function()
	{
		DashBoard.AddEventAppMenu(Contact.Execute, "", "Contact");
		DashBoard.AddEventWindowsTool("Contact");
        };

   /*
	* Execute une fonction
	*/
	Contact.Execute = function(e)
	{
		//Appel de la fonction
		DashBoard.Execute(this, e, "Contact");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Contact.Comment = function()
	{
		DashBoard.Comment("Contact", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Contact.About = function()
	{
		DashBoard.About("Contact");
	};

	/*
	*	Affichage de l'aide
	*/
	Contact.Help = function()
	{
		DashBoard.OpenBrowser("Contact","{$BaseUrl}/Help-App-Contact.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Contact.ReportBug = function()
	{
		DashBoard.ReportBug("Contact");
	};

	/*
	* Fermeture
	*/
	Contact.Quit = function()
	{
		DashBoard.CloseApp("","Contact");
	};
        
        /**
         * Evenements
         */
        ContactAction = function(){};
        
        /**
         * Charge les contact
         */
        ContactAction.LoadContact = function()
        {
          var data = "Class=Contact&Methode=LoadContact&App=Contact";
            DashBoard.LoadControl("dvDesktop", data, "" , "div", "Contact");
        };
        
        /**
         * Charge l'ecran de recherche
         */
        ContactAction.LoadSearchContact = function()
        {
            var data = "Class=Contact&Methode=LoadSearchContact&App=Contact";
                DashBoard.LoadControl("dvDesktop", data, "" , "div", "Contact");
        };
        
        /*
         * Recherche de contact
         * @returns 
         */
        ContactAction.Search = function()
        {
            var lstContact = document.getElementById("lstContact");
            var tbSearch = document.getElementById("tbSearch");
            var dvCompetenceUser = document.getElementById("dvCompetenceUser");
            
            var controls = dvCompetenceUser.getElementsByTagName("input");
            idCompetences = Array();
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked )
                {
                    idCompetences.push(controls[i].id);
                }
            }
          
            var JAjax = new ajax();
                JAjax.data = "Class=Contact&Methode=Search&App=Contact" ;
                JAjax.data += "&tbSearch=" + tbSearch.value ;
                JAjax.data += "&competenceId=" + idCompetences.join(",");
          
             lstContact.innerHTML =  JAjax.GetRequest("Ajax.php");
        };
        
        /**
         * Popin d'envoi d'invitation
         * 
         */
        ContactAction.ShowSendInvitation = function()
        {
            //Recuperation des user selectionne
            var lstContact = document.getElementById("lstContact");
            var user = Array();
            
            controls = lstContact.getElementsByTagName("input");
            
            for( i= 0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked )
                {
                    user.push(controls[i].name);
                }
            }
            
            //Si on a selectionne des contacts
            if(user.length != 0)
            {
                 var param = Array();
                param['App'] = 'Contact';
                param['Title'] = 'Contact.ShowSendInvitation';
                param['Users'] = user.join(";");

                DashBoard.OpenPopUp('Contact','ShowSendInvitation', '','','', 'ContactAction.RefreshInvitation()', serialization.Encode(param));
            }
            else
            {
                alert("Vous devez sélectioner un ou plusieurs contacts");
            }
        };
        
        /**
         * rafraichit les invitations
         */
        ContactAction.RefreshInvitation = function()
        {
            var btnInvitation = document.getElementById("btnInvitation");
            var btnMyInvitation = document.getElementById("btnMyInvitation");
            
            var JAjax = new ajax();
              JAjax.data = "Class=Contact&Methode=GetNumberInvitation&App=Contact" ;

             result =  JAjax.GetRequest("Ajax.php").split(":");
             btnInvitation.value = result[0];
             btnMyInvitation.value = result[1];
        };
        
        /**
         * Charge les invitation 
         * Les mienens ou celles qui me sont destiné 
         * 
         */
        ContactAction.LoadInvitation = function(type)
        {
              var data = "Class=Contact&Methode=LoadInvitation&App=Contact";
                  data += "&type=" + type;
                  
                DashBoard.LoadControl("dvDesktop", data, "" , "div", "Contact");
        };
        
        /**
         * Relance une invitation
         */
        ContactAction.RelanceInvitation = function(invitationId)
        {
             var data = "Class=Contact&Methode=RelanceInvitation&App=Contact";
                  data += "&invitationId=" + invitationId;
                  
                DashBoard.LoadControl("dvInvit" + invitationId, data, "" , "div", "Contact");
        };
        
        /**
         * Pop in d'ajout de contact
         * @returns 
         */
        ContactAction.ShowAddAction = function()
        {
                  var param = Array();
                param['App'] = 'Contact';
                param['Title'] = 'Contact.ShowAddContact';
              //  param['Users'] = user.join(";");

                DashBoard.OpenPopUp('Contact','ShowAddContact', '','','', 'ContactAction.LoadContact()', serialization.Encode(param));
        };
        
        /**
         * Edite un contact
         */
        ContactAction.EditContact = function(contactId)
        {
             var param = Array();
                param['App'] = 'Contact';
                param['Title'] = 'Contact.ShowAddContact';
                param['IdContact'] = contactId;

                DashBoard.OpenPopUp('Contact','ShowAddContact', '','','', 'ContactAction.LoadContact()', serialization.Encode(param));
        };
        
        /**
         * Accepte l'invitation
         */
        ContactAction.AcceptInvitation = function(invitationId, control)
        {
          var JAjax = new ajax();
              JAjax.data = "Class=Contact&Methode=AcceptInvitation&App=Contact&invitationId="+ invitationId ;

              JAjax.GetRequest("Ajax.php");
            
            control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
            
             ContactAction.RefreshInvitation();
        };
        
        /**
         * Refuse l'invitation
         */
        ContactAction.RefuseInvitation = function(invitationId, control)
        {
          var JAjax = new ajax();
              JAjax.data = "Class=Contact&Methode=RefuseInvitation&App=Contact&invitationId="+ invitationId ;

              JAjax.GetRequest("Ajax.php");
            
            control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
            
             ContactAction.RefreshInvitation();
        };
       