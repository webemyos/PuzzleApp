var Forum = function() {};

	/*
	* Chargement de l'application
	*/
	Forum.Load = function(parameter)
	{
            this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Forum.LoadEvent = function()
	{
            Dashboard.AddEventAppMenu(Forum.Execute, "", "Forum");
            Dashboard.AddEventWindowsTool("Forum");

            ForumAction.ShowDefaultForum();
	};

   /*
	* Execute une fonction
	*/
	Forum.Execute = function(e)
	{
            //Appel de la fonction
            Dashboard.Execute(this, e, "Forum");
            return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Forum.Comment = function()
	{
            Dashboard.Comment("Forum", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Forum.About = function()
	{
            Dashboard.About("Forum");
	};

	/*
	*	Affichage de l'aide
	*/
	Forum.Help = function()
	{
            Dashboard.OpenBrowser("Forum","{$BaseUrl}/Help-App-Forum.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Forum.ReportBug = function()
	{
            Dashboard.ReportBug("Forum");
	};

	/*
	* Fermeture
	*/
	Forum.Quit = function()
	{
            Dashboard.CloseApp("","Forum");
	};
        
        /**
         * Evenement
         */
        ForumAction = function(){};
        
        /**
         * Pop in d'ajout de forum
         * @returns {undefined}
         */
        ForumAction.ShowAddForum = function()
        {
            var param = Array();
                param['App'] = 'Forum';
                param['Title'] = 'Forum.ShowAddForum';
              
                Dashboard.OpenPopUp('Forum','ShowAddForum', '','','', 'ForumAction.LoadMyForum()', serialization.Encode(param));
        };
        
         /**
         * Chage les forums de l'utilisateur
         * @returns {undefined}
         */
        ForumAction.LoadMyForum = function()
        {
           var data = "Class=Forum&Methode=LoadMyForum&App=Forum";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Forum"); 
        };
        
         /**
         * Chage le forums de l'utilisateur
         * @returns {undefined}
         */
        ForumAction.ShowDefaultForum = function(forum, categoryId, $messageId)
        {
           var data = "Class=Forum&Methode=ShowDefaultForum&App=Forum";
           
           if(categoryId != undefined)
           {
                data += "&categoryId="+categoryId;
           }
           
           if($messageId != undefined)
           {
                data += "&messageId="+$messageId;
           }
          
            Dashboard.LoadControl("dvDesktop", data, "" , "div", "Forum"); 
        };
        
        /**
         * Charge un forum
         * @param {type} forumId
         * @returns {undefined}
         */
        ForumAction.LoadForum = function(forumId)
        {
          var data = "Class=Forum&Methode=LoadForum&App=Forum";
              data += "&forumId=" + forumId ;
              Dashboard.LoadControl("dvDesktop", data, "" , "div", "Forum"); 
              
              ForumAction.Tab = new Array();
              
              //Memorisation du forum
              ForumAction.ForumId = forumId;
        };
        
        /**
         * Pop in d'ajout de catégorie
         */
        ForumAction.ShowAddCategory = function(forumId, categoryId)
        {
            var param = Array();
                param['App'] = 'Forum';
                param['Title'] = 'Forum.ShowAddCategory';
                param['forumId'] = forumId;
                param['CategoryId'] = categoryId;
              
                Dashboard.OpenPopUp('Forum','ShowAddCategory', '','','', 'ForumAction.RefreshCategory('+forumId+')', serialization.Encode(param));
        };
        
        /**
         * Recharge les catégories du forum
         **/
        ForumAction.RefreshCategory = function(forumId)
        {
           var data = "Class=Forum&Methode=RefreshCategory&App=Forum";
               data += "&forumId=" + forumId;
           
               Dashboard.LoadControl("tab_1", data, "" , "div", "Forum"); 
        };
        
        /*
         * Supprime une categorie
         */
        ForumAction.DeleteCategory =function(control, categoryId)
        {
            if(Dashboard.Confirm("delete"))
            {
                           
            //Sauvagarde ajax
            var JAjax = new ajax();
                JAjax.data = "App=Forum&Methode=DeleteCategory";
                JAjax.data += "&categoryId=" + categoryId;
  
                JAjax.GetRequest("Ajax.php");
                
                control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
            }
        };
        
        /**
         * Pop in de création de message
         * @param {type} categoryId
         * @returns {undefined}
         */
        ForumAction.ShowAddSujet = function(categoryId)
        {
            var param = Array();
                param['App'] = 'Forum';
                param['Title'] = 'Forum.ShowAddSujet';
                param['CategoryId'] = categoryId;
              
                Dashboard.OpenPopUp('Forum','ShowAddSujet', '','','', 'ForumAction.RefreshMessage('+categoryId+')', serialization.Encode(param));
                
                Dashboard.SetBasicAdvancedText("tbMessage");
        };
     
        /**
         * Rafrachit la liste des message de la categorie
         * @param {type} categoryId
         * @returns {undefined}
         */
        ForumAction.RefreshMessage = function(categoryId)
        {
            var dvMessage = document.getElementById("dvMessage");
        
            var JAjax = new ajax();
                JAjax.data = "Class=Forum&Methode=RefreshMessage&App=Forum";
                JAjax.data += "&categoryId="+categoryId;
          
               dvMessage.innerHTML =  JAjax.GetRequest("Ajax.php");
        };

        /**
         * Pop in d'ajout de reponse
         * @param {type} sujetId
         * @returns {undefined}ShowAddReponse
         */
        ForumAction.ShowAddReponse = function (sujetId)
        {
            var param = Array();
                param['App'] = 'Forum';
                param['Title'] = 'Forum.ShowAddReponse';
                param['SujetId'] = sujetId;
              
                Dashboard.OpenPopUp('Forum','ShowAddReponse', '','','', 'ForumAction.RefreshReponse('+sujetId+')', serialization.Encode(param));
                
                Dashboard.SetBasicAdvancedText("tbMessage");
        };
        
        /**
         * Rafrachit la liste des reponses d'un message
         * @param {type} categoryId
         * @returns {undefined}
         */
        ForumAction.RefreshReponse = function(sujetId)
        {
            var dvReponse = document.getElementById("dvReponse");
        
            var JAjax = new ajax();
                JAjax.data = "Class=Forum&Methode=RefreshReponse&App=Forum";
                JAjax.data += "&sujetId="+sujetId;
          
               dvReponse.innerHTML =  JAjax.GetRequest("Ajax.php");
        };
        
        /*
         * Charge la parti administration du forum
         */
        ForumAction.LoadAdmin = function()
        {
            var data = "Class=Forum&Methode=LoadAdmin&App=Forum";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Forum"); 
        };
        
        /*
         * Pop In d'ajout de forum
         */
        ForumAction.ShowAddForum = function()
        {
        };