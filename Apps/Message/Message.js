var Message = function() {};

	/*
	* Chargement de l'application
	*/
	Message.Load = function(parameter)
	{
		this.LoadEvent();
                
                MessageAction.LoadInBox();
       };

	/*
	* Chargement des �venements
	*/
	Message.LoadEvent = function()
	{
		DashBoard.AddEventAppMenu(Message.Execute, "", "Message");
		DashBoard.AddEventWindowsTool("Message");
	};

   /*
	* Execute une fonction
	*/
	Message.Execute = function(e)
	{
		//Appel de la fonction
		DashBoard.Execute(this, e, "Message");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Message.Comment = function()
	{
		DashBoard.Comment("Message", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Message.About = function()
	{
		DashBoard.About("Message");
	};

	/*
	*	Affichage de l'aide
	*/
	Message.Help = function()
	{
		DashBoard.OpenBrowser("Message","{$BaseUrl}/Help-App-Message.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Message.ReportBug = function()
	{
		DashBoard.ReportBug("Message");
	};

	/*
	* Fermeture
	*/
	Message.Quit = function()
	{
		DashBoard.CloseApp("","Message");
	};
        
        /**
         * Evenement
         * @returns {undefined}
         */
        MessageAction = function(){};
        
        /**
         * Pop in d'envoi de message
         * @type type
         */
        MessageAction.ShowSendMessage = function()
        {
             var param = Array();
                param['App'] = 'Message';
                param['Title'] = 'Message.ShowSendMessage';
              
                DashBoard.OpenPopUp('Message','ShowSendMessage', '','','', 'MessageAction.RefreshNumberMessage()', serialization.Encode(param));
        };
        
        /**
         * Ajoute l'utilisateur dans le champ 
         * @returns {undefined}
         */
        MessageAction.SelectUser = function()
        {
            //Recuperation des user selectionne 
            var dvResult = document.getElementById("divResult");
            var dvUser = document.getElementById("dvUser");
            var controls = dvResult.getElementsByTagName("input");
            
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked)
                {
                   spUser = document.createElement("span");
                   spUser.id = controls[i].id;
                   spUser.className = "userSelected";
                   spUser.innerHTML = controls[i].name;
                   spUser.innerHTML += "<i class='icon-remove' onclick='MessageAction.RemoveUser(this)'>&nbsp;</i>";
                  
                  dvUser.appendChild(spUser); 
                }
            }
            
            if(dvResult != null)
            {
                document.body.removeChild(dvResult);
            }
            else
            {
              ClosePopUp();
            }
        };
        
        /**
         * Supprime un utilisateur
         * 
         * @param {type} control
         * @returns {undefined}
         */
        MessageAction.RemoveUser = function(control)
        {
           control.parentNode.parentNode.removeChild(control.parentNode); 
            
        };
        
        /**
         * Envoi le message
         * 
         * @returns 
         */
        MessageAction.Send = function(appName, entityName, entityId )
        {
           //Recuperation des control
           var jbMessage = document.getElementById("jbMessage");
           var tbObjet = document.getElementById("tbObjet");
           var tbMessage = document.getElementById("tbTextMessage");
           
           
           //Recuperation des utilisateurs
            var dvUser = document.getElementById("dvUser");
            var controls = dvUser.getElementsByTagName("span");
            var userId = Array();
            
           for(i = 0; i < controls.length; i++)
           {
              userId.push(controls[i].id);
           } 
           
           if(tbObjet.value != "" && tbMessage.value != "" && userId.length > 0)
           {
              jbMessage.innerHTML = "<img src='../Images/loading/load.gif' />";
         
             var JAjax = new ajax();
                    JAjax.data = "Class=Message&App=Message&Methode=Send";
                    JAjax.data += "&objet=" + tbObjet.value;
                    JAjax.data += "&message=" + tbMessage.value;
                    JAjax.data += "&userId=" + userId.join(";");
                    
                    //App lié
                    JAjax.data += "&appName=" + appName;
                    JAjax.data += "&entityName=" + entityName;
                    JAjax.data += "&entityId=" + entityId;
                    
                    //Execution
                    jbMessage.innerHTML = JAjax.GetRequest("Ajax.php");
                    
                    ClosePopUp();
            }
            else
            {
                    alert('Vous devez renseigner un objet, un message et ajouter un ou plusieurs contacts');   
            }
        };
        
        /**
         * Charge la boite de reception
         */
        MessageAction.LoadInBox = function()
        {
           var data = "Class=Message&Methode=LoadInBox&App=Message";
               DashBoard.LoadControl("dvDesktop", data, "" , "div", "Message");
        };
        
        /**
         * Charge la boite de reception
         */
        MessageAction.LoadOutBox = function()
        {
           var data = "Class=Message&Methode=LoadOutBox&App=Message";
               DashBoard.LoadControl("dvDesktop", data, "" , "div", "Message");
        };    
        
        /**
         * Affiche le détail du message
         * @param {type} messageId
         * @returns {undefined}
         */
        MessageAction.ShowDetail = function(messageId, control)
        {
            var param = Array();
                param['App'] = 'Message';
                param['Title'] = 'Message.Detail';
                param['messageId'] = messageId;
    
                DashBoard.OpenPopUp('Message','ShowDetail', '','','', 'MessageAction.RefreshNumberMessage()', serialization.Encode(param));
                
                MessageAction.UpdateMessageRead();
        };
        
        /*
         * Met a jour les nouveau messages 
         * @returns {undefined}
         */
        MessageAction.UpdateMessageRead = function()
        {
            var nbMessage = document.getElementById("nbMessage");
            
            var JAjax = new ajax();
              JAjax.data = "Class=Message&Methode=GetNumberNewMessage&App=Message" ;

             nbMessage.innerHTML =  JAjax.GetRequest("Ajax.php");
        };
        
        /**
         * Affiche le détail du message
         * @param {type} messageId
         * @returns {undefined}
         */
        MessageAction.ShowDetailSend = function(messageId, control)
        {
            var param = Array();
                param['App'] = 'Message';
                param['Title'] = 'Message.Detail';
                param['messageId'] = messageId;
    
                DashBoard.OpenPopUp('Message','ShowDetailSend', '','','', '', serialization.Encode(param));
        };
        
        /**
         * Ajout des control pour répondre
         * @returns {undefined}
         */
        MessageAction.ShowAddReponse = function()
        {
            var dvReponse = document.getElementById("dvReponse");
            dvReponse.style.display = "block";
        };
        
        /**
         * Rafrachit le nomnbre de message
         * @returns {undefined}
         */
        MessageAction.RefreshNumberMessage = function()
        {
            var btnInBox = document.getElementById("btnInBox");
            var btnOutBox = document.getElementById("btnOutBox");

             var JAjax = new ajax();
              JAjax.data = "Class=Message&Methode=GetNumberMessage&App=Message" ;

             result =  JAjax.GetRequest("Ajax.php").split(":");
             btnInBox.value = result[0];
             btnOutBox.value = result[1];
        };