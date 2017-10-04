var File = function() {};

	/*
	* Chargement de l'application
	*/
	File.Load = function(parameter)
	{
		this.LoadEvent();
                
                FileAction.LoadMyFile();
	};

	/*
	* Chargement des �venements
	*/
	File.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(File.Execute, "", "File");
		Dashboard.AddEventWindowsTool("File");
	};

   /*
	* Execute une fonction
	*/
	File.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "File");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	File.Comment = function()
	{
		Dashboard.Comment("File", "1");
	};

	/*
	*	Affichage de a propos
	*/
	File.About = function()
	{
		Dashboard.About("File");
	};

	/*
	*	Affichage de l'aide
	*/
	File.Help = function()
	{
		Dashboard.OpenBrowser("File","{$BaseUrl}/Help-App-File.html");
	};

   /*
	*	Affichage de report de bug
	*/
	File.ReportBug = function()
	{
		Dashboard.ReportBug("File");
	};

	/*
	* Fermeture
	*/
	File.Quit = function()
	{
		Dashboard.CloseApp("","File");
	};
        
        /**
         * Gestionnaire d'evenements
         * @returns {undefined}
         */
        FileAction = function(){}; 
        
        /**
         * Charge les dossier et fichier de l'utilisateur
        */
        FileAction.LoadMyFile = function()
        {
           FileAction.FolderId = "";
             
           var data = "Class=File&Methode=LoadMyFile&App=File";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "File");
               
           //Ajoute les evements
           FileAction.AddEvent();
        };
        
        /**
         * Rafraichit le repertoire courant
         */
        FileAction.RefreshFolder = function()
        {
            //S'execut'e juste lorsque l'application File est lancé
            var appRunFile = document.getElementById("appRunFile");
            
            
            if(appRunFile != null)
            {
                if(FileAction.FolderId == "")
                {
                    FileAction.LoadMyFile();
                }
                else
                {
                   var data = "Class=File&Methode=OpenFolder&App=File";
                       data += "&FolderId=" +  FileAction.FolderId;

                   Dashboard.LoadControl("dvDesktop", data, "" , "div", "File");

                   //Ajoute les evements
                   FileAction.AddEvent(); 
                }
            }
        };
        
        /**
         * Ajoute les events sur les liens
         */
        FileAction.AddEvent = function()
        {
            $(".folder .name").click(FileAction.OpenFolder);
            $(".file .name").click(FileAction.OpenFile);
        };
        
        /**
         * Ouvre un dossier
         **/
        FileAction.OpenFolder = function(e)
        {
           if(e.srcElement)
            {
              var folderId = e.srcElement.id;
            }
            else
            {
              var folderId = this.id;
            }
            
            //Memorisation du dossier courant
            FileAction.FolderId = folderId;
           
           var data = "Class=File&Methode=OpenFolder&App=File";
               data += "&FolderId=" +  FileAction.FolderId;
                   
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "File");
               
           //Ajoute les evements
           FileAction.AddEvent();
        };
        
        /**
         * Ouvre un fichier
         **/
        FileAction.OpenFile = function(e)
        {
            if(e.srcElement)
            {
              var fileId = e.srcElement.id;
            }
            else
            {
              var fileId = this.id;
            }
            
          FileAction.FileId = fileId;
            
          var param = Array();
                param['App'] = 'File';
                param['Title'] = 'File.DetailFile';
                param['FileId'] = FileAction.FileId;
             
                Dashboard.OpenPopUp('File','OpenFile', '','','', '', serialization.Encode(param));         
        };
        
        /**
         * Pop in de création de dossier
         **/
        FileAction.ShowCreateFolder = function()
        {
              var param = Array();
                param['App'] = 'File';
                param['Title'] = 'File.NewFolder';
                param['FolderId'] = FileAction.FolderId;
             
                Dashboard.OpenPopUp('File','ShowCreateFolder', '','','', 'FileAction.RefreshFolder()', serialization.Encode(param));
        };
        
        /**
         *Affiche une popin de partage du dossier
         */
        FileAction.ShareFolder = function(control)
        {
             var param = Array();
                param['App'] = 'File';
                param['Title'] = 'File.ShareFolder';
                param['FolderId'] = control.id;
             
                Dashboard.OpenPopUp('File','ShowShareFolder', '','','', 'FileAction.RefreshFolder()', serialization.Encode(param));
        };
        
        /**
         *Affiche une popin de partage du fichier
         */
        FileAction.ShareFile = function(control)
        {
             var param = Array();
                param['App'] = 'File';
                param['Title'] = 'File.ShareFile';
                param['FileId'] = control.id;
             
                Dashboard.OpenPopUp('File','ShowShareFile', '','','', 'FileAction.RefreshFolder()', serialization.Encode(param));
        };
        
        /**
         * Selection d'un utilisateur
         */
        FileAction.SelectUser = function(folderId)
        {
            var dvFolderUserShared = document.getElementById("dvFolderUserShared");
            var dvResult = document.getElementById("divResult");
            var controls = dvResult.getElementsByTagName("input");
            var UserId = Array();
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked)
                {
                  UserId.push(controls[i].id);
                }
            }
 
            var JAjax = new ajax();
                JAjax.data = "Class=File&Methode=AddUserFolder&App=File&FolderId="+ folderId + "&UsersId="+ UserId.join(";") ;

            dvFolderUserShared.innerHTML = JAjax.GetRequest("Ajax.php");
            
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
         * Selection d'un utilisateur
         */
        FileAction.SelectUserFile = function(fileId)
        {
            var dvFolderUserShared = document.getElementById("dvFolderUserShared");
            var dvResult = document.getElementById("divResult");
            var controls = dvResult.getElementsByTagName("input");
            var UserId = Array();
            
            for(i=0; i < controls.length; i++)
            {
                if(controls[i].type == "checkbox" && controls[i].checked)
                {
                  UserId.push(controls[i].id);
                }
            }
 
            var JAjax = new ajax();
                JAjax.data = "Class=File&Methode=AddUserFile&App=File&FileId="+ fileId + "&UsersId="+ UserId.join(";") ;

            dvFolderUserShared.innerHTML = JAjax.GetRequest("Ajax.php");
            
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
         * Supprime un utilisateur du partage
         */
        FileAction.RemoveUser = function(control)
        {
            if(Dashboard.Confirm("Delete"))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=File&Methode=RemoveUser&App=File&ShareId="+ control.id ;

                    var result = JAjax.GetRequest("Ajax.php");

                    if(result.indexOf("success") > -1)
                    {
                        control.parentNode.parentNode.removeChild(control.parentNode);
                    }
            } 
        };
        
        /**
         * Supprime un dossier et tout son contenue
         */
        FileAction.RemoveFolder = function(control)
        {
            if(Dashboard.Confirm("Delete"))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=File&Methode=RemoveFolder&App=File&FolderId="+ control.id ;

                    var result = JAjax.GetRequest("Ajax.php");

                    if(result.indexOf("success") > -1)
                    {
                        FileAction.RefreshFolder();
                    }
                    else
                    {
                        Dashboard.Alert("File.CannotDeleteDirectory");
                    }
            }
        };
        
        /**
         * Popin de telechargement ou de création de fichier
         */
        FileAction.ShowAddFile = function(folderId)
        {
             var param = Array();
                param['App'] = 'File';
                param['Title'] = 'File.NewFile';
                param['FolderId'] = FileAction.FolderId;
             
                Dashboard.OpenPopUp('File','ShowAddFile', '','','', 'FileAction.RefreshFolder()', serialization.Encode(param));
        };
        
                
        /**
         * Supprime un fichier
         */
        FileAction.RemoveFile = function(control)
        {
            if(Dashboard.Confirm("Delete"))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=File&Methode=RemoveFile&App=File&FileId="+ control.id ;

                    var result = JAjax.GetRequest("Ajax.php");
                       
                    if(result.indexOf("success") > -1)
                    {
                        control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
                    }
            }
        };
        
        /**
         * Charge les dossiers et fichiers partagés de l'utilisateur
         */
        FileAction.LoadSharedFile = function()
        {
           var data = "Class=File&Methode=LoadSharedFile&App=File";
               data += "&FolderId=" +  FileAction.FolderId;
                   
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "File");
               
           //Ajoute les evements
           FileAction.AddEvent();
        };