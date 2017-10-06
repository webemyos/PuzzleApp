var Comunity = function() {};

	/*
	* Chargement de l'application
	*/
	Comunity.Load = function(parameter)
	{
		this.LoadEvent();
                
                ComunityAction.LoadMyWall();
	};

	/*
	* Chargement des �venements
	*/
	Comunity.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Comunity.Execute, "", "Comunity");
		Dashboard.AddEventWindowsTool("Comunity");
	};

   /*
	* Execute une fonction
	*/
	Comunity.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Comunity");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Comunity.Comment = function()
	{
		Dashboard.Comment("Comunity", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Comunity.About = function()
	{
		Dashboard.About("Comunity");
	};

	/*
	*	Affichage de l'aide
	*/
	Comunity.Help = function()
	{
		Dashboard.OpenBrowser("Comunity","{$BaseUrl}/Help-App-Comunity.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Comunity.ReportBug = function()
	{
		Dashboard.ReportBug("Comunity");
	};

	/*
	* Fermeture
	*/
	Comunity.Quit = function()
	{
		Dashboard.CloseApp("","Comunity");
	};
        
        /**
         * Evenement
         */
        var ComunityAction = function(){};
        
        
        /**
         * Charge le mur de l'utilisateur
         */
        ComunityAction.LoadMyWall = function()
        {
           var data = "Class=Comunity&Methode=LoadMyWall&App=Comunity";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Comunity");  
        };
        
          /**
         * Charge les communautés de l'utilisateur
         */
        ComunityAction.LoadMyComunity = function()
        {
           var data = "Class=Comunity&Methode=LoadMyComunity&App=Comunity";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Comunity");   
        };
        
        /**
         * Charge l'annuaire des communautés
         */
        ComunityAction.LoadComunity = function()
        {
           var data = "Class=Comunity&Methode=LoadComunity&App=Comunity";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Comunity");   
        };
        
        /**
         * Ajoute une communauté à l'utilisateur
         */
        ComunityAction.Add = function(comunityId, control)
        {
          var JAjax = new ajax();
              JAjax.data = "Class=Comunity&Methode=Add&App=Comunity&comunityId="+ comunityId ;

            alert(JAjax.GetRequest("Ajax.php"));
            
            control.parentNode.removeChild(control);
        };
        
        //Supprime une application au bureau
        ComunityAction.Remove = function(comunityId, control)
        {
            var JAjax = new ajax();
              JAjax.data = "Class=Comunity&Methode=Remove&App=Comunity&comunityId="+ comunityId ;

               JAjax.GetRequest("Ajax.php");
                control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);     
        };
        
        /**
         * Publie un message
         * @returns {undefined}
         */
        ComunityAction.PublishMessage = function()
        {
            var tbMessage = document.getElementById("tbMessage");
            var dvMessage = document.getElementById("dvMessage");
            var lstComunity = document.getElementById("lstComunity");
            
            if(lstComunity.value == "")
            {
              alert(Dashboard.GetCode("Comunity.MustSelectComunity"));  
            }
            else if(tbMessage.value != "" )
            {
             var JAjax = new ajax();
              JAjax.data = "Class=Comunity&Methode=PublishMessage&App=Comunity" ;
              JAjax.data += "&message="  + tbMessage.value;
              JAjax.data += "&comunityId="  + lstComunity.value;
              
              newMessage = JAjax.GetRequest("Ajax.php");
              
              tbMessage.value ="";
              dvMessage.innerHTML = newMessage + dvMessage.innerHTML;
           
            }
            else
            {
                alert(Dashboard.GetCode("Comunity.MessageEmpty"));
            }
        };
        
        /**
         * Edite un message
         * @returns {undefined}
         */
        ComunityAction.EditMessage = function(messageId)
        {
            var dvComment = document.getElementById("dvMessage"+ messageId);
            var message = dvComment.innerHTML;
            
            //Editeur
            var html = "<br/><textarea id='tbEditMessage"+messageId+"' >";
                html  += message;
                html += "</textarea>";
                
             //Bouton
             html += "<input type=button class='btn btn-primary'  value='Save' onclick='ComunityAction.UpdateMessage("+messageId+")' /> ";
            
            dvComment.innerHTML = html;
        };
        
        /**
         * Met a jour un message
         * @param {type} messageId
         * @returns {undefined}
         */
        ComunityAction.UpdateMessage = function(messageId)
        {
            var tbEditMessage = document.getElementById('tbEditMessage'+messageId);
            var dvComment = document.getElementById("dvMessage"+ messageId);
            
            //Enregistrement
            var JAjax = new ajax();
              JAjax.data = "Class=Comunity&Methode=UpdateMessage&App=Comunity" ;
              JAjax.data += "&message="  + tbEditMessage.value;
              JAjax.data += "&messageId="  + messageId;
              
              JAjax.GetRequest("Ajax.php");
              
            dvComment.innerHTML = tbEditMessage.value;
           
        };
        
        /**
         * Edite un message
         * @returns {undefined}
         */
        ComunityAction.RemoveMessage = function(messageId, control)
        {
            if(confirm(Dashboard.GetCode("ConfirmDelete")))
            {
                //Suppression
                var JAjax = new ajax();
                  JAjax.data = "Class=Comunity&Methode=RemoveMessage&App=Comunity" ;
                  JAjax.data += "&messageId="  + messageId;

                  JAjax.GetRequest("Ajax.php");

                  control.parentNode.parentNode.removeChild( control.parentNode);
            }
        };
        
        /**
         * 
         * @param {type} messageId
         * @returns {undefined}
         */
        ComunityAction.ShowAddComment = function(messageId)
        {
            var dvComment = document.getElementById("dvComment"+ messageId);
            
            var html = "<br/><textarea id='tbComment"+messageId+"'></textarea>";
                html += "<input type='button' class='btn btn-primary' value='save' onclick='ComunityAction.AddComment("+messageId+", this)'>"  
                    
            dvComment.innerHTML = html;
        };
        
        /**
         * Ajoute le commentaire
         * @param {type} messageId
         * @param {type} control
         * @returns {undefined}
         */
        ComunityAction.AddComment = function(messageId, control)
        {
           var dvComment = document.getElementById("dvComment"+ messageId);
           var lstComment = document.getElementById("lstComment"+messageId);
           var tbComment = document.getElementById("tbComment"+messageId)
          
           //Enregistrement
           var JAjax = new ajax();
               JAjax.data = "Class=Comunity&Methode=AddComment&App=Comunity" ;
               JAjax.data += "&messageId="  + messageId;
               JAjax.data += "&comment="  + tbComment.value;

           lstComment.innerHTML += JAjax.GetRequest("Ajax.php");
   
           dvComment.innerHTML = "";
        };
        
        /**
         * Passe le commentaire en edition
         * @param {type} commentId
         * @returns 
         */
        ComunityAction.EditComment = function(commentId)
        {
            var spMessage = document.getElementById("spMessage" + commentId);
            
            var editMessage = "<br/><textarea id='tbMessage"+commentId+"'>"+ spMessage.innerHTML +"</textarea>";
                editMessage += "<input type='button' class='btn btn-primary' onclick='ComunityAction.UpdateComment("+commentId+")' value='save' />"
                  
            spMessage.innerHTML =  editMessage;
        };
        
        /*
         * @param {type} commentId
         * @returns {undefined}*
         * Met a jour le commentaire
         */
        ComunityAction.UpdateComment = function(commentId)
        {
             var spMessage = document.getElementById("spMessage" + commentId);
             var tbMessage = document.getElementById("tbMessage"+ commentId);
           
             var JAjax = new ajax();
                 JAjax.data = "Class=Comunity&Methode=UpdateComment&App=Comunity" ;
                 JAjax.data += "&commentId="  + commentId;
                 JAjax.data += "&comment="  + tbMessage.value;
               
                  JAjax.GetRequest("Ajax.php");
           
           
             spMessage.innerHTML = tbMessage.value;
        };
        
        /**
         * Supprime le commentaire
         * @param {type} commentId
         * @returns 
         */
        ComunityAction.RemoveComment = function(commentId, control)
        {
             if(confirm(Dashboard.GetCode("ConfirmDelete")))
            {
                var JAjax = new ajax();
               JAjax.data = "Class=Comunity&Methode=RemoveComment&App=Comunity" ;
               JAjax.data += "&commentId="  + commentId;
               
               JAjax.GetRequest("Ajax.php");

               control.parentNode.parentNode.removeChild( control.parentNode);
            }
        };
        
        /**
         * Prévisualise la dernier image uploader avant de pouvoir la poster comme message
         * @returns {undefined}
         */
        ComunityAction.PrevisualiseImage = function()
        {
            var dvPreVisu = document.getElementById("dvPreVisu");
            
           var JAjax = new ajax();
               JAjax.data = "Class=Comunity&Methode=GetLastUpload&App=Comunity" ;
               
              dvPreVisu.innerHTML = JAjax.GetRequest("Ajax.php");
        };