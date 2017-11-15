var Membre = function (){};

/*
 * * Chargement de l'application
*/
Membre.Load = function(parameter)
{
    Dashboard.AddEventById("lkProfil", "click", Membre.StartProfil );
    Dashboard.AddEventById("lkMessage", "click", Membre.StartMessage );
    Dashboard.AddEventById("lkTask", "click", Membre.StartTask );
    
    //Dashboard.StartApp("","EeApp");
};

/*
 * * Chargement de l'application
*/
Membre.StartProfil = function(parameter)
{
    Dashboard.StartApp("","Profil");
};

Membre.StartTask = function(parameter)
{
    Dashboard.StartApp("","Task");
};

Membre.StartMessage = function(parameter)
{
    Dashboard.StartApp("","Message");
};

Membre.Load();