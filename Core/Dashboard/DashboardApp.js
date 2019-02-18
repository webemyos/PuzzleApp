/*
*------------------- Fonction pour les applications
*/
/*
* Ouvre la div de applications
*/
Dashboard.ShowDvApp = function()
{
    Dashboard.HideDvWidget();
    Dashboard.HideWidget();
};

/*
* Cache les div des applications
*/
Dashboard.HideDvApp = function()
{	

};

Dashboard.ShowDvWidget = function()
{

};
Dashboard.HideDvWidget = function()
{

};

/*
* Ferme les div Widget et App
*/
Dashboard.CloseDvWidgetApp = function()
{
    Dashboard.HideDvWidget();
    Dashboard.HideDvApp();
};
/*
* Demarre l'application
*/
Dashboard.StartApp = function(event, appName, parameter, url)
{
	//Ferme la div des widget et le div des applications
	Dashboard.CloseDvWidgetApp();

	if(typeof(appName) != "undefined")
	{
            var app = appName;
            var automatic = true;
	}
	else
	{
		var automatic = false;
	  //IE
	  if(event.srcElement)
	  {
	    var app = event.srcElement.parentNode.id;

	    if(app == '')
	      app = event.srcElement.parentNode.parentNode.id;
	  }
	  else
	  {
	    var app = this.id;
	  }
	}

  Dashboard.CloseMenu();
  Dashboard.CloseTchat();

   //Cache les eventuel widget demar�
  Dashboard.HideWidget();

  //TODO FERMER les applications lanc�e depuis d'autre
  Dashboard.IncludeJs(app, '', url);
  Dashboard.IncludeCss(app, '', url);

  //Ajout a la liste des applications
  if(Dashboard.applications == null)
      Dashboard.applications = Array();

      var exist = false;
      var i= 0;

      for(appli in Dashboard.applications)
      {
        if(Dashboard.applications[i] == app)
      {
        exist = true;
      }
       i++;
      }

      if(!exist)
      {
        Dashboard.applications[i] = app;
      }

  //Recuperation de la div central
  if(Dashboard.AppStarted != app && !exist)
  {
    if(Dashboard.AppStarted != null)
    {
      Dashboard.MnimizeApp();
    }

    Dashboard.LoadDiv("dvCenter" , "StartApp", "App:Apps\\"+ app + "\\" + app + "&params=" + parameter , url);
    Dashboard.AppStarted = app;

    //Appel de la fonction de load apres 1 seconde
    //car sinon elle est pas pris en compte
    loading = app + ".Load('"+parameter+"')";
    setTimeout(loading, 1000);
  }
  else if(automatic == true)
  {
  	//Reouverture
  	 Dashboard.RestoreApp("", app );

	loading = app + ".Load('"+parameter+"')";
    setTimeout(loading, 1000);
  }

  //Donne le focus
  var appRun = document.getElementById("appRun"+app);
  //Dashboard.Focus(appRun);
};

/*
* Lance une application
*/
Dashboard.AppRun = function (app, parameter)
{
	//alert('Verifier que l"application n"est pas lancer');

	Dashboard.IncludeJs(app);
	Dashboard.IncludeCss(app);
	//Creation d'une nouvelle div
	var dvApp = document.createElement("div");
	dvApp.id= "dv"+app;
	dvApp.className = "subApp";
	dvApp.innerHTML = "<img src='../Images/loading.gif'>";

	document.body.appendChild(dvApp);

   	Dashboard.LoadDiv("dv"+app , "StartApp", "App:"+app);

	//Dashboard.MaximiseApp('', 'appRun'+app);

   	//Appel de la fonction de load apres 1 seconde
    
    //car sinon elle est pas pris en compte
     loading = app + ".Load('"+parameter+"')";
     setTimeout(loading, 1000);
};

/**
 * Ajoute un app au bureau  utilisateur
 * @param {type} app
 * @returns {undefined}
 */
Dashboard.AddAppUser = function(app)
{
    alert(app);
};

/**
 * Supprime une application au bureau utilisateur
 * @param {type} app
 * @returns {undefined}
 */
Dashboard.RemoveAppUser = function(app)
{
    alert(app);
};

/*
* Fermeture
*/
Dashboard.AppQuit = function(app)
{
	var divApp = document.getElementById("dv"+app);
	document.body.removeChild(divApp);
};


// Resize la partie central
// Avec ou sans la partie gauche
Dashboard.Resize = function(small)
{
  var appCenter = document.getElementById("appCenter");
  var appLeft = document.getElementById("appLeft");
  
  if(appLeft.innerHTML == "" )
  {
        $(appLeft).removeClass('span2');
        $(appCenter).removeClass('span10');
        $(appCenter).addClass('span12');
   }
};

Dashboard.ResizeElement = function(element, width, height)
{
	element.style.width = width;

	if(height != '')
		element.style.height = height ;
};

/*
* Redimensionne un element
*/
Dashboard.SetSize = function (element, width, height, appName)
{
	// var appElement = document.getElementById(element);
	var appElement = Dashboard.GetElement(element,"div", appName);

	 if(width != "")
	 {
		 appElement.style.width = width;
	 }
	 if (height != "")
	 {
	 	 appElement.style.height = height;
	 }
};

/*
* Ouvre l'application au maximum
*/
Dashboard.MaximiseApp = function(e, div)
{
	  //TODO creer une foncion recursive pour trouver le bon element
	 if(e == '')
	 {
	  	element = document.getElementById(div);
	  	Dashboard.open = false;
	 }
	 else
	 {
		  if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;
	 }
	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;

  if(!Dashboard.open)
  {
    appRun.style.position = "fixed";
    appRun.style.left = "40";
    appRun.style.top = "40";

    //appRun.style.width = (window.innerWidth - 20)  + "px";
    appRun.style.height = (window.innerHeight + document.body.clientHeight  - 205) + "px";
    appRun.style.width = (document.body.clientWidth - 40)  + "px";

    //appRun.style.height = 800 + "px";

//    appRun.style.height = (  document.body.clientHeight  - 55) + "px";

    Dashboard.open = true ;

    //Div Central
    var appCenter = document.getElementById("appCenter");
    appCenter.style.width = "550px";
   // appCenter.style.height =(window.innerHeight + document.body.clientHeight  - 300) + "px";

	//appCenter.style.height =( 800  - 130) + "px";

	//On resize la partie central
    Dashboard.Resize(false);

  }
  else
  {
    appRun.style.position = "relative";
    appRun.style.width = "960px";
    appRun.style.height = "520px";
    Dashboard.open = false ;

    //Div Central
    var appCenter = document.getElementById("appCenter");
    appCenter.style.width = "550px";
    appCenter.style.height ="415px";

  	//On resize la partie central
    Dashboard.Resize(true);
  }
};
/*
* Met l'application dans la barre de menu
*/
Dashboard.MnimizeApp = function(e)
{
  //TODO creer une foncion recursive pour trouver le bon element
  if(typeof(e) != "undefined")
  {
	  if(e.srcElement)
	   	element = e.srcElement;
	  else
	  	element =  this;

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;
  }
  else
  {
  	var appRun = document.getElementById("appRun"+Dashboard.AppStarted) ;
  }
  
  if(appRun != undefined)
  {
    var context = document.getElementById("context");

    var appName = appRun.getElementsByTagName("input");

    //Verification en xml que la balise nexiste pas
    context.innerHTML += "<div  id='"+appName[0].value+"' style='display:none;'>"+appRun.innerHTML+"</div>";

    //Ajout dans la barre de menu
    var tdApp = document.getElementById("tdApp");
    tdApp.innerHTML += "<p style='display:inline' onclick='Dashboard.RestoreApp(this)'  id='"+appName[0].value+"' >" + appName[0].value +" </p>    ";    

    Dashboard.AppStarted = null;

      //Suppression si c'est une r�ouverture
    if(document.getElementById(appRun.id) != null)
    {
           appRun.parentNode.removeChild(appRun);
    }
    else
    {
          var dvCenter = document.getElementById("dvCenter");
          dvCenter.innerHTML = '';
    }
  }
};

/*
* Restore l'application
*/
Dashboard.RestoreApp = function (element, appName)
{
    //Passage de l'appli en cours dans la tool bar
    if(Dashboard.AppStarted != null)
    {
      Dashboard.MnimizeApp();
    }
    
	if(element == "")
	{
		var element = new Object();
		element.id = appName;
		Dashboard.AppStarted = element.id;
	}
	else
	{
	   Dashboard.AppStarted = element.id;
	}
        
  //Recuperation du context
  var context = document.getElementById("context");

  apps = context.getElementsByTagName("div");

  for(i=0 ; i<apps.length ; i++)
  {
    if(apps[i].id == element.id)
    {
        var dvCenter = document.getElementById("dvCenter");
        dvCenter.innerHTML = "<div id='appRun"+  element.id +"' class='App row-fluid white-panel pn'> "+ apps[i].innerHTML + "</div>";
            
        context.removeChild(apps[i]);
      break;
    }
  }

  //Suppression de la barre
  var tdApp = document.getElementById("tdApp");

  appStarted = tdApp.getElementsByTagName("p");

  for(i = 0; i <appStarted.length; i++)
  {
     if(appStarted[i].id == element.id)
    {
            tdApp.removeChild(appStarted[i]);
      break;
    }
  }
 
    //Appel de la fonction de load apres 1 seconde
    //car sinon elle est pas pris en compte
    loading = element.id + ".LoadEvent()";
    setTimeout(loading, 1000);
};

/*
* Ferme l'application
*/
Dashboard.CloseApp = function(e, appName)
{
	if(typeof(appName) != "undefined")
	{
		var element = document.getElementById("appRun" + appName);
	}
	else
	{
	    if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;
	}

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}

	 var appRun = element;

	var dvRun = document.getElementById(appRun.id);
	var dvParent = document.getElementById(appRun.id.replace("appRun","dv"));

	 //Suppression si c'est une r�ouverture
	 if(dvRun != null)
	 {
	 	dvRun.parentNode.removeChild(dvRun);
	 }
	 else
	 {
	  	 var dvCenter = document.getElementById("dvCenter");
	  	 dvCenter.innerHTML = '';
	 }

	//Fermeture de la div parent
	if(dvParent != null)
		dvParent.parentNode.removeChild(dvParent);

	 var newApplication = Array();
	 var i=0;
	 var j=0;

	 for(appli in Dashboard.applications)
	 {
	    if(Dashboard.applications[j] != Dashboard.AppStarted)
	    {
	      newApplication[i] = Dashboard.applications[j];
	      i++;
	     }
	    j++;
	  }

  //Suppression du fichier javascript
  Dashboard.RemoveJs(Dashboard.AppStarted);
  Dashboard.AppStarted = null;
  Dashboard.applications = newApplication;

  Dashboard.CloseSearch();
  
};

/*
* Ouvre le navigateur a une url pr�cise
*/
Dashboard.OpenBrowser = function(name, url)
{
	var parameter = Array();
	parameter["name"] = name;
	parameter["url"] = url;

	Dashboard.StartApp("","EeBrowser", ''+serialization.Encode(parameter)+'');
};

/*
* Recuperer les information A propos
*/
Dashboard.About = function(name)
{
	var parameters = Array();
		parameters["AppWidget"] = name;

	Dashboard.OpenPopUp("EeInfo","About", "","", "","",serialization.Encode(parameters) );
};

/*
* Ouvre une fenetre pour rapport� un bug
*/
Dashboard.ReportBug = function(app)
{
	var parameters = Array();
		parameters["AppWidget"] = app;

	Dashboard.OpenPopUp("EeBug","ReportBug", "","", "","",serialization.Encode(parameters) ,'bug');
};

/*
* Ouvre une fenetre pour rapport� un bug
*/
Dashboard.Comment = function(app, appWidget)
{

	var parameters = Array();
		parameters["AppWidget"] = app;
		parameters["Type"] = appWidget;

	Dashboard.OpenPopUp("EeComment","AddComment", "","", "","", serialization.Encode(parameters), "Comment" );
};

/**
 * 
 * @param {type} idApp
 * @returns {undefined}Supprile une appp du bureau
 */
Dashboard.RemoveAppUser = function(appId, control)
{
    if(confirm(Dashboard.GetCode("EeApp.RemoveApp")))
    {
        var JAjax = new ajax();
            JAjax.data = "Class=EeApp&Methode=Remove&App=EeApp&appId="+ appId ;

           JAjax.GetRequest("Ajax.php");
          control.parentNode.parentNode.removeChild(control.parentNode); 
    }
};

/**
 * 
 * @param {type} idApp
 * @returns {undefined}Supprile une appp du bureau
 */
Dashboard.AddAppUser = function(appName)
{
    if(confirm(Dashboard.GetCode("EeApp.AddToDesktopApp")))
    {
           var JAjax = new ajax();
              JAjax.data = "Class=EeApp&Methode=Add&App=EeApp&appName="+ appName ;

            alert(JAjax.GetRequest("Ajax.php"));
            
                 var JAjax = new ajax();
               JAjax.data = "Class=DashBoardManager&Methode=LoadUserApp&show=1" ;
              
            var lstApp = document.getElementById("lstApp");
            lstApp.innerHTML = JAjax.GetRequest("Ajax.php");
    }
};