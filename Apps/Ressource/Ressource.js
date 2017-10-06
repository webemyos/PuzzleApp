var Ressource = function() {};

    /*
    * Chargement de l'application
    */
    Ressource.Load = function(parameter)
    {
            this.LoadEvent();
    };

    /*
    * Chargement des �venements
    */
    Ressource.LoadEvent = function()
    {
            Dashboard.AddEventAppMenu(Ressource.Execute, "", "Ressource");
            Dashboard.AddEventWindowsTool("Ressource");
    };

    /*
    * Execute une fonction
    */
    Ressource.Execute = function(e)
    {
            //Appel de la fonction
            Dashboard.Execute(this, e, "Ressource");
            return false;
    };

    /*
    *	Affichage de commentaire
    */
    Ressource.Comment = function()
    {
            Dashboard.Comment("Ressource", "1");
    };

    /*
    *	Affichage de a propos
    */
    Ressource.About = function()
    {
            Dashboard.About("Ressource");
    };

    /*
    *	Affichage de l'aide
    */
    Ressource.Help = function()
    {
            Dashboard.OpenBrowser("Ressource","{$BaseUrl}/Help-App-Ressource.html");
    };

    /*
    *	Affichage de report de bug
    */
    Ressource.ReportBug = function()
    {
            Dashboard.ReportBug("Ressource");
    };

    /*
    * Fermeture
    */
    Ressource.Quit = function()
    {
            Dashboard.CloseApp("","Ressource");
    };

    /*
     * Evenement
     */
    RessourceAction = function()
    {

    };

    /**
     * Recherche une ressources selon des mots clés
     * @returns {undefined}
     */
    RessourceAction.Search = function()
    {
        var tbSearch = document.getElementById("tbSearch");

        var data = "Class=Ressource&Methode=Search&App=Ressource";
            data += "&KeyWord=" + tbSearch.value;

         Dashboard.LoadControl("dvResultSearch", data, "" , "div", "Ressource");
    };