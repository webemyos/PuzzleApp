var Profil = function() {};

    /*
    * Chargement de l'application
    */
    Profil.Load = function(parameter)
    {
        this.LoadEvent();

        ProfilAction.LoadInformation();
    };

    /*
    * Chargement des �venements
    */
    Profil.LoadEvent = function()
    {
        Dashboard.AddEventAppMenu(Profil.Execute, "", "Profil");
        Dashboard.AddEventWindowsTool("Profil");
    };

/*
    * Execute une fonction
    */
    Profil.Execute = function(e)
    {
        //Appel de la fonction
        Dashboard.Execute(this, e, "Profil");
        return false;
    };

    /*
    *	Affichage de commentaire
    */
    Profil.Comment = function()
    {
        Dashboard.Comment("Profil", "1");
    };

    /*
    *	Affichage de a propos
    */
    Profil.About = function()
    {
        Dashboard.About("Profil");
    };

    /*
    *	Affichage de l'aide
    */
    Profil.Help = function()
    {
        Dashboard.OpenBrowser("Profil","{$BaseUrl}/Help-App-Profil.html");
    };

    /*
    *	Affichage de report de bug
    */
    Profil.ReportBug = function()
    {
        Dashboard.ReportBug("Profil");
    };

    /*
    * Fermeture
    */
    Profil.Quit = function()
    {
        Dashboard.CloseApp("","Profil");
    };

    // Evenement
    ProfilAction = function(){};

    /**
     * Charge les informations du profil
     */
    ProfilAction.LoadInformation = function()
    {
        var data = "Class=Profil&Methode=LoadInformation&App=Profil";
        Dashboard.LoadControl("dvDesktop", data, "" , "div", "Profil");
    };

    /**
     * Charge les compétences du profil
     */
    ProfilAction.LoadCompetence = function()
    {
        var data = "Class=Profil&Methode=LoadCompetence&App=Profil";
        Dashboard.LoadControl("dvDesktop", data, "" , "div", "Profil");
    };

    /*
     * Load Administration
     */
    ProfilAction.LoadAdmin = function()
    {
        var data = "Class=Profil&Methode=LoadAdmin&App=Profil";
        Dashboard.LoadControl("dvDesktop", data, "" , "div", "Profil");
    };
    
    /**
     * Sauvagarde les compétences de l'utilisateur
     */
    ProfilAction.SaveCompetence = function()
    {
        //Recuperation des controles
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

         var data = "Class=Profil&Methode=SaveCompetence&App=Profil";
             data += "&competenceId=" + idCompetences.join(";");

        Dashboard.LoadControl("dvDesktop", data, "" , "div", "Profil");
    };
    
    /*
     * Add Category
     */
    ProfilAction.ShowAddCategory = function(categoryId)
    {
        var param = Array();
        param['App'] = 'Profil';
        param['Title'] = 'Profil.ShowAddCategory';
        
        if(categoryId != undefined)
        {
            param["entityId"] = categoryId;
        }

        Dashboard.OpenPopUp('Profil','ShowAddCategory', '','','', 'ProfilAction.RefreshTabCategory()', serialization.Encode(param));
    };
    
    /*
     * Add Competence
     */
    ProfilAction.ShowAddCompetence = function(competenceId)
    {
        var param = Array();
        param['App'] = 'Profil';
        param['Title'] = 'Profil.ShowAddCompetence';
        
        if(competenceId != undefined)
        {
            param["entityId"] = competenceId;
        }

        Dashboard.OpenPopUp('Profil','ShowAddCompetence', '','','', 'ProfilAction.RefreshTabCompetence()', serialization.Encode(param));
    };
    
    
        