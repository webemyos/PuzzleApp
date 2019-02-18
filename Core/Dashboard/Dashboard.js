/*
*--------------------------- Fonction Global -------------------------------------------------------
*/
// Gestion des evenements
document.onkeypress = press;

function press(e)
{
    Dashboard.keyPress(e);
};

/*
*------------------------------ Fonction EEmmys ----------------------------------------------------
*/

//Creation de l'objet principale
var Dashboard = function(){};


/**
Chargement de l'application
*/
Dashboard.Load = function()
{

       //Chargement des evenements
  this.LoadEvent();

  //Chargement de �lements multilingue

    //Div de d�marrage
    var parameters = Array();
        parameters["Class"] = 'DashBoardManager';
        parameters["Methode"] = 'GetImageLoading';
        parameters["Argument"] = 'Array';
        parameters["Action"] = 'Array';
        parameters["SourceControl"] = 'Array';
        parameters["Name"] = 'popup';
        parameters["SourceControl"] = 'popup';
        parameters["Title"] = 'Login';
        parameters["Width"] = '600px';
        parameters["Height"] = '400px';
        parameters["Opacity"] = '50';
        parameters["BackGroundColor"] = 'White';
        parameters["ShowBack"] = '1';
        parameters["Top"] = '';
        parameters["Left"] = '';
        parameters["Type"] = 'true';

  var popup = new PopUp(serialization.Encode(parameters),serialization.Encode(parameters),'','');
  popup.Open();

   //Charge le tableau de bord
  this.LoadNew();

  //Fermeture de la div lorsque tout est charg�
  ClosePopUp();

  return false;
};

/*
* Gestion des �venements
*/
Dashboard.LoadEvent = function()
{
  //Ajout des évents sur les élements du menu de gauche
  this.AddEventById("btnStart", "click", Dashboard.LoadNew);
  this.AddEventById("btnProfil", "click", Dashboard.StartAppBase);
  this.AddEventById("btnProjet", "click", Dashboard.StartAppBase);
  this.AddEventById("btnAnnonce", "click", Dashboard.StartAppBase);
  this.AddEventById("btnForm", "click", Dashboard.StartAppBase);
  this.AddEventById("btnNotify", "click", Dashboard.StartAppBase);
  this.AddEventById("btnIde", "click", Dashboard.StartAppBase);
  this.AddEventById("btnAdmin", "click", Dashboard.StartAppBase);
  this.AddEventById("btnFile", "click", Dashboard.StartAppBase);
  this.AddEventById("btnContact", "click", Dashboard.StartAppBase);
  this.AddEventById("btnMessage", "click", Dashboard.StartAppBase);
  this.AddEventById("btnAgenda", "click", Dashboard.StartAppBase);
  this.AddEventById("btnCommunity", "click", Dashboard.StartAppBase);
  this.AddEventById("btnApp", "click", Dashboard.StartAppBase);

  return false;
};

/*
* Charge un tableau des �lements traduits
*/
Dashboard.LoadLanguage = function()
{
	var LangElement = Array();

	var JAjax = new ajax();
	JAjax.data = 'Class=DashBoardManager&Methode=LoadLanguage';

	var elements = JAjax.GetRequest("Ajax.php");

	codes = serialization.Decode(elements);

	for(code in codes)
	{
		LangElement[code] = codes[code];
	}

	this.LangElement = LangElement;
};

/**
* Ajoute les �venements au menu
*/
Dashboard.AddEventMenu = function()
{
  var dvMenu = document.getElementById("dvMenu");

  var Row = dvMenu.getElementsByTagName("tr");

  for(i= 0 ; i <Row.length;i++)
  {
    this.AddEvent(Row[i],"click",Dashboard.StartApp);
  }
};

/*
* Ajoute les �venements au menu de l'application
*/
Dashboard.AddEventAppMenu = function(appFunction, widget, app )
{
  //Gestion des evnement sur le menu
  if(typeof(widget) != "undefined" && widget != "")
  	var menu = Dashboard.GetElement("widgetMenu", "div", widget, true);
  else
  	var menu = document.getElementById("appMenu"+ app);

  if(menu != null)
  {
    var item = menu.getElementsByTagName("a");
    if(item.length > 0 )
    {
      for(i= 0; i < item.length; i++)
      {
        Dashboard.AddEvent(item[i],"click",appFunction);
      }
    }
  }
};

/*
* Ajoute les evenements au menu du widget
*/
Dashboard.AddEventWidgetMenu = function (appFunction, widget)
{
	Dashboard.AddEventAppMenu(appFunction, widget, "");
};

/*
* Ajoute les evenements au toolbar
*/
Dashboard.AddEventAppTool = function(appFunction)
{
  //Gestion des evnement sur le menu
  var menu = document.getElementById("appTool");

  if(menu != null)
  {
    var item = menu.getElementsByTagName("img");
    if(item.length > 0 )
    {
      for(i= 0; i < item.length; i++)
      {
        Dashboard.AddEvent(item[i],"click",appFunction);
      }
    }
  }
};

/*
* Ajoute un evenement aux controls d'un conteneur
*/
Dashboard.AddEventControls = function(conteneur, typeControl , functionToExecute)
{
	var cont = document.getElementById(conteneur);
	var controls = cont.getElementsByTagName(typeControl);

	for(i=0; i< controls.length; i++)
	{
		Dashboard.AddEvent(controls[i], "click", functionToExecute);
	}
};

/*
* Deconnect l'utilisateur
*/
Dashboard.Deconnect = function()
{
	if(Dashboard.Confirm("deconect"))
	{
	  location.href = "disconnect.php";
   }
};

/*
* Inclu le fichier javascript
*/
Dashboard.IncludeJs = function(application, widget, url, source, module)
{
    var script = document.createElement('script');
    script.setAttribute('type','text/javascript');

  if(typeof(source) != 'undefined')
  {
     script.setAttribute('src', source);
  }
  if(typeof(url) != 'undefined')
  {
     script.setAttribute('src', url + "/" + application +".js");
  }
  else if(typeof(module) != 'undefined')
  {
	script.setAttribute('src', '../script.php?a=' + application + "&m="+module) ;
  }
  else if(widget)
  {
    script.setAttribute('src', '../Widgets/' + application + "/" + application +".js");
  }
  
  else
  {
     script.setAttribute('src', '../script.php?a=' + application);
  }
  document.body.appendChild(script);
  //TODO Verifier que le script existe
};

/*
* Inclu le fichier css
*/
 Dashboard.IncludeCss = function(application, widget, url)
{
    var script = document.createElement('link');
    script.setAttribute('type','text/css');

  if(typeof(url) != 'undefined')
  {
     script.setAttribute('href', url + "/" + application +".css");
  }
  else if(widget)
  {
    script.setAttribute('href', '../Widgets/' + application + "/" + application +".css");
  }
  else
  {
    script.setAttribute('href', '../style.php?a=' + application);
  }
  script.setAttribute('rel', 'stylesheet');
  document.body.appendChild(script);
  //TODO Verifier que le script existe
};

/*
* Supprime le fichier javasript
*/
Dashboard.RemoveJs = function(application)
{
        /*var scripts = document.getElementsByTagName("script");

	for(i = 0; i < scripts.length ; i ++)
	{
		if(scripts[i].src.indexOf(application) > -1)
		{
		  document.body.removeChild(scripts[i]);
		}
	}*/
};

/**
* Execute une fonction d'une application
*/
Dashboard.Execute = function (element, event, appName)
{
  if(event.srcElement)
  {
    var app = event.srcElement.id;

    if(app == '')
      app = event.srcElement.id;
  }
  else
  {
    var app = element.id;
  }

  //Execution de la fonction
  eval(appName+ "."+app+"();");
};

/**
* Ajoute un evenement sur un control grace a son identifiant
*/
Dashboard.AddEventById= function(element, event, methode, app, balise)
{
    
 if(element == '')
 {
    return;
 }

 if(typeof(app) == "undefined")
 {
	// console.log(element, event, methode);
    var control = document.getElementById(element);
    this.AddEvent(control, event, methode);
  }
  else
  {
    var divRun = document.getElementById("appRun" + app);

    if(typeof(balise) != "undefined" && divRun != undefined)
    {
        var controls = divRun.getElementsByTagName(balise);

        for(i=0; i<controls.length; i++)
        {
                if(controls[i].id == element)
                {
                         this.AddEvent(controls[i], event, methode);
                }
        }
    }
  }
};

/**
Ajoute un evenement
*/
Dashboard.AddEvent = function(control, event, methode)
{
    if(control != null)
    {
        if(control.addEventListener)
        {
          control.addEventListener(event, methode, false);
        }
        else
        {
         control.attachEvent("on"+event,methode);
        }
    }
};

/**
supprime un evenement
*/
Dashboard.RemoveEvent = function(control, event)
{
	if(control != null)
	{
		  if(control.addEventListener)
		  {
		    control.removeEventListener(event, '');
		  }
		  else
		  {
		    control.removeEvent("on"+event);
		  }
  	}
};
/**
* Ajoute les evenements des fenetres
*/
Dashboard.AddEventWindowsTool = function(app)
{
  this.AddEventById("btnMinimize", "click", Dashboard.MnimizeApp, app, "i");
  this.AddEventById("btnClose", "click", Dashboard.CloseApp, app, "i");

  var name =  "appRun"+app ;

  this.AddEventById(name, "click", Dashboard.HideWidget);

  this.AddEventById("appToolTip", "mousedown", Dashboard.Mousseon, app, "td");
  this.AddEventById("appToolTip", "mousemove", Dashboard.Moussemouve, app, "td");
  this.AddEventById("appToolTip", "mouseup", Dashboard.Mousseout, app, "td");
};

/*
* Deplacement de la sourie
*/
Dashboard.Mousseon = function(e)
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

   Dashboard.Capture = true;
   Dashboard.appRun = element;
   Dashboard.appRun.style.position = "fixed";

   Dashboard.Focus(element);
};

/*
* Donne le focus sur une application
*/
Dashboard.Focus = function(appRun)
{
	//On repasse les autre app en dessous
  	for(i = 0; i < Dashboard.applications.length; i ++)
	{
		var app = document.getElementById("appRun" + Dashboard.applications[i]);
		if(app != null)
			app.style.zIndex = 9970;
	}

	//Recuperation de l'application
    appRun.style.zIndex = 9980;
};

Dashboard.Mousseout = function(e)
{
	 Dashboard.Capture = false;

	 if(e.srcElement)
	   	element = e.srcElement;
  	else
  		element =  this;

	//On remonte jusqu'a la div de base
	while(element.id.indexOf("appRun") == -1)
	{
		element = element.parentNode;
	}
};

Dashboard.Moussemouve = function(e)
{
	if(e.srcElement)
	   	element = e.srcElement;
  	else
  		element =  this;

  		element.style.cursor = "move";
//e.cursor = "hand";
  if(Dashboard.Capture == true)
  {
    Dashboard.appRun.style.left = e.clientX - 500 + "px";
    Dashboard.appRun.style.top = e.clientY - 25 +  "px";
  }
};

/*
* Gestionnaire du clavier
*/
Dashboard.keyPress = function(e)
{
	var code = "";
	if(e != null)
		code = e.which;
	else
	{
		code = event.keyCode;
	}

	if(Dashboard.keyPressFunction)
	{
		Dashboard.keyPressCode = code;
		setTimeout(Dashboard.keyPressFunction,100);
	}
};

/*
* Retourne la position d'une element
*/
Dashboard.GetPosition = function(element)
{
	var left = 0;
	var top = 0;
	/*On r�cup�re l'�l�ment*/
	var e = element;
	/*Tant que l'on a un �l�ment parent*/
	while (e.offsetParent != undefined && e.offsetParent != null)
	{
		/*On ajoute la position de l'�l�ment parent*/
		left += e.offsetLeft + (e.clientLeft != null ? e.clientLeft : 0);
		top += e.offsetTop + (e.clientTop != null ? e.clientTop : 0);
		e = e.offsetParent;
	}
	return new Array(left ,top + 50);
};

/**
Chargement des outils
*/
Dashboard.LoadTool = function()
{
  this.LoadDiv('dvTool' , 'LoadTool');
};

/**
Chargement des news dans la partie central
*/
Dashboard.LoadNew = function()
{
    var dvLoading = document.getElementById("dvLoading");

    if(dvLoading == null)
    {
            var dvLoading = document.createElement("div");
                dvLoading.innerHTML += "<img src='images/loading/loading16.gif' alt='loading' ></img>";
                dvLoading.id = "dvLoading";

            var div = document.getElementById('dvCenter');
            div.appendChild(dvLoading);

            if(Dashboard.AppStarted != null)
        {
          Dashboard.MnimizeApp();
        }
      Dashboard.LoadDiv('dvCenter' , 'LoadNew', '', '' );

      //Initialise les evenements sur les clik des liens
      $(".dropdown-menu li").click(function(){EeProjetAction.LoadProjetDashboard(""+this.id+"");
       $(".elementDashboard").click(function(){EeProjetAction.OpenTabProjet(""+this.id+"");});

      });
      $(".ressources li").click(function(){Dashboard.StartApp('', ""+this.id+"",'');});
      $(".elementDashboard").click(function(){EeProjetAction.OpenTabProjet(""+this.id+"");});
    }
};

/**
Chargement des donnees dans une div
*/
Dashboard.LoadDiv = function(searchDiv, methode, parameter, url, mode)
{
   var JAjax = new ajax();
   JAjax.data = "Class=DashBoardManager&Methode=" + methode;
   JAjax.data += "&Parameter=" + parameter;

   if(typeof(url) != 'undefined')
   {
        JAjax.data += "&Url=" + url;
   }

   var div = document.getElementById(searchDiv);

   if(typeof(mode) != 'undefined')
   {
        JAjax.mode = mode;

        JAjax.Control = div;
        JAjax.GetRequest("../Ajax.php");
   }
   else
   {
        div.innerHTML = JAjax.GetRequest("../Ajax.php");
   }
};

/*
* Recupere un element d'une application
*/
Dashboard.GetElement= function(element, type, appName, widget)
{
	if(typeof(widget) != "undefined")
		var divRun = document.getElementById("widgetRun" + appName);
	else
		var divRun = document.getElementById("appRun" + appName);

	if(typeof(type) != "undefined")
	{
		if(divRun != null)
		{
			var controls = divRun.getElementsByTagName(type);

			for(i=0; i<controls.length; i++)
			{
				if(controls[i].id == element)
				{
					 var dvControl = controls[i];
				}
			}
		}
	}

	return dvControl;
};

/**
* Charge les donn�es dans un control
*/
Dashboard.LoadControl = function (searchDiv, data, height, balise, appName, mode)
{
   	//Recuperation depuis la div parente
	if(typeof(appName) != "undefined")
	{
		var dvControl = Dashboard.GetElement(searchDiv, balise, appName);
	}
	else
	{
		var dvControl = document.getElementById(searchDiv);
	}

	dvControl.innerHTML = "<img src='Images/loading/load.gif'/>";

	var JAjax = new ajax();
		JAjax.data = data;

		if(mode == 'A')
		{
			JAjax.mode = 'A';
			JAjax.Control = dvControl;
			JAjax.GetRequest("Ajax.php");
		}
		else
		{
                  	dvControl.innerHTML = JAjax.GetRequest("../Ajax.php");
                }

	if(typeof(height) != "undefined")
		dvControl.style.height = height;
	else
		dvControl.style.height = "250px";
            
        
};

/**
ouvre le menu
*/
Dashboard.ShowMenu = function()
{
 var dvMenu = document.getElementById("dvMenu");
 dvMenu.style.height = '250px';
 dvMenu.style.width = '200px';

 $('#dvMenu').show('200');

  //Cache les eventuel widget demar�
  Dashboard.CloseDvWidgetApp();
  Dashboard.CloseTchat();
};

Dashboard.CloseAll = function()
{
  Dashboard.CloseDvWidgetApp();
  Dashboard.CloseMenu();
};

/*
*Affiche les information des base
*/
Dashboard.ShowInfo = function()
{
	var parametres = new Array();
	parametres['Type'] = 'All';

	Dashboard.StartApp('','EeInfo', serialization.Encode(parametres));
};

Dashboard.StartAppBase = function(e)
{
	if(e.srcElement)
		   	element = e.srcElement;
		  else
		  	element =  this;
        switch(element.id)
	{
                case 'btnStart' : var app = 'EeInfo'; break;
                case 'btnNotify': var app = 'EeNotify';break;
                case 'btnAdmin' : var app = 'EeAdmin';break;
                case 'btnIde' :var app = 'EeIde'; break ;
		case 'btnProfil' :var app = 'EeProfil';break;
                case 'btnContact' :var app = 'EeContact';break;
                case 'btnExplorer' :var app = 'EeExplorer';break;
                case 'btnParameter' : var app = 'EeParameter';break;
                case 'btnCommunity' : var app = 'EeComunity';break;
                case 'btnMessage' :	var app = 'EeMessage'; break;
                case 'btnAgenda' :var app = 'EeAgenda';	break;
                case 'btnAddWidget' :var app = 'EeWidget';break;
                case 'btnAddApp' :var app = 'EeApp';break;
                case 'btnFile' : var app = 'EeFile';break;
                case 'btnProjet' :var app = 'EeProjet';break;
                case 'btnAnnonce' :var app = 'EeAnnoncer';break;
                case 'btnFile' : var app = 'EeFile';break;
                case 'btnApp' : var app = 'EeApp';break;
         	case 'btnForm' : var app = 'EeForm';break;
       }

	Dashboard.StartApp('',app, '');
};

/**
* Affiche la fen�tre de Tchat
*/
Dashboard.ShowTchat = function()
{
 var dvTchat = document.getElementById("dvTchat");
 dvTchat.style.height = '250px';
 dvTchat.style.width = '200px';

	$('#dvTchat').show('200');
	  //Cache les eventuel widget demar�
	  Dashboard.CloseDvWidgetApp();
	  Dashboard.CloseMenu();

	  //Rafrachit le tchat
	  var data = "Class=DashBoardManager&Methode=GetTchat";
	  Dashboard.LoadControl("dvTchat", data, "250px","div");
};

/*
* R�cupere les message du tchat
*/
Dashboard.GetMessageTchat = function(link)
{
	 //Rafrachit le tchat
	  var data = "Class=DashBoardManager&Methode=GetMessageTchat";
	  	  data += "&UserId = " + link.id;

	  //Enregistrement du contact en cours
	  Dashboard.IdContactTchat = link.id;

	  Dashboard.LoadControl("dvMessageTchat", data, "250px","div");
};

/*
* Envoi un nouveau message
*/
Dashboard.SendMessageTchat = function()
{
	var lstMessageTchat = document.getElementById("lstMessageTchat");
	var tbNewMessageTchat = document.getElementById("tbNewMessageTchat");
	var message = tbNewMessageTchat.value;

	lstMessageTchat.innerHTML += "<br/> Me : " + message;
	tbNewMessageTchat.value = '';
	alert(Dashboard.IdContactTchat);

	var JAjax = new ajax();
        JAjax.data = 'App=Dashboard&Methode=SendMessageTchat';
        JAjax.data += '&IdContactTchat=' + Dashboard.IdContactTchat;
        JAjax.data += "&Message=" + message;
		JAjax.GetRequest('Ajax.php');
};

/**
Ferme le menu
*/
Dashboard.CloseMenu = function(event)
{
};

/**
Ferme le menu
*/
Dashboard.CloseTchat = function(event)
{
};

/*
* Ferme les popup de recherche
*/
Dashboard.CloseSearch = function()
{
	var divResult = document.getElementById("divResult");

	if(divResult != null)
		document.body.removeChild(divResult);
};

/*
* Ouvre une popup
*/
Dashboard.OpenPopUp = function(classe, methode, url, width, height, RefreshFunction, param, title)
{
	
	
		var parameters = Array();
			parameters["Argument"] = 'Array';
			parameters["Action"] = 'Array';
			parameters["SourceControl"] = 'Array';
			//parameters["Name"] = 'popup';
			parameters["SourceControl"] = 'popup';

			if(title)
			{
				parameters["Title"] = title;
			}

			parameters["Width"] = width;
			parameters["Height"] = height;
			parameters["Opacity"] = '50';
			parameters["BackGroundColor"] = 'White';
			parameters["ShowBack"] = '1';
			parameters["Top"] = '';
			parameters["Left"] = '';
			parameters["Type"] = 'true';

		var actions = Array();
			actions["OnClose"] = RefreshFunction;

	if(url != "" && url != undefined)
	{
			parameters["Url"] = url;
			var popup = new PopUp(serialization.Encode(parameters) + param, serialization.Encode(parameters) + param, serialization.Encode(actions),'');

			popup.Open(serialization.Encode(parameters) + param);
	}
	else if(typeof(classe) == "object")
	{
		console.log("Nouvelle gestion des popup");
		for(prop in classe)
		{
			parameters[prop] = classe[prop];
		}
		var popup = new PopUp(serialization.Encode(parameters), serialization.Encode(parameters), serialization.Encode(actions), ''  );

		popup.Open();		
	}
	else
	{
		parameters["Class"] = classe;
		parameters["Methode"] = methode;
		parameters["App"] = classe;

		var popup = new PopUp(serialization.Encode(parameters) + param, serialization.Encode(parameters) + param, serialization.Encode(actions),'');

		popup.Open();
	}
  	//TODO gestion des popup avec class et methode
};

/*
* Chargement des outils
*/
Dashboard.LoadApp = function()
{
  this.LoadDiv('dvApp' , 'LoadApp');
  setTimeout(Dashboard.AddEventApp, 500);
};

/*
* Ajoute les �venements au applications
*/
Dashboard.AddEventApp = function()
{
  //Ajout des evenements
  var dvApp = document.getElementById("dvApp");
  var apps = dvApp.getElementsByTagName("img");

  for(i = 0;i < apps.length ; i++)
  {
  	Dashboard.AddEventById(apps[i].id,"click", Dashboard.StartApp);
  }
};

/*
* Message de confirmation de suppressions
*/
Dashboard.ConfirmDelete = function()
{
	return Dashboard.Confirm('Delete');
};

/*
* Message de confirmation d'ajout
*/
Dashboard.ConfirmAdd = function()
{
	return Dashboard.Confirm("AddElement");
};

/*
* Message d'alerte
*/
Dashboard.Alert = function(code)
{
	return alert(Dashboard.GetCode(code));
};

/*
* r�cupere un code multilibgue
*/
Dashboard.GetCode = function(code)
{
  if(typeof(this.LangElement) == 'undefined')
  {
      Dashboard.LoadLanguage();
  }

	if(typeof(this.LangElement[code]) != 'undefined' )
	{
		return this.LangElement[code];
	}
	else
	{
		//Creation du code multilingue si il n'existe pas
		var JAjax = new ajax();
   		    JAjax.data = 'Class=DashBoardManager&Methode=GetCode';
		    JAjax.data += '&Code=' + code;

			return	JAjax.GetRequest(Dashboard.GetPath('Ajax.php'));
	}
};

/*
* Demande de confirmation
*/
Dashboard.Confirm = function(code)
{
    return confirm(Dashboard.GetCode(code) + '?');
};

/*
* R�cup�re le contenu d'une iframe
*/
Dashboard.GetFrameContent = function(Frame, idTextArea)
{
	IE  = window.ActiveXObject ? true : false;
	MOZ = window.sidebar       ? true : false;

  if(IE)
  {
  	edoc = Frame.document;
  	//document.getElementById('id_textarea'').value = edoc.body.innerHTML;
  }

  else if (MOZ)
   {
  	edoc = Frame.contentDocument;
  // document.getElementById('id_textarea').value = document.getElementById("id_iframe").contentDocument.body.innerHTML;
   }
	return edoc;
};

Dashboard.LoadAppAfter = function()
{
	var dvApp = document.getElementById('dvApp');
	var dvBlockApp = dvApp.getElementsByTagName('div');

	for(i= 0; i < dvBlockApp.length ; i++)
	{
		if(dvBlockApp[i].className == 'blockAppSelected')
		{
			idSelect = dvBlockApp[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index--;

	var newDivSelect = document.getElementById("blockApp_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockAppSelected';
	}
};

Dashboard.LoadAppBefore = function()
{
	var dvApp = document.getElementById('dvApp');
	var dvBlockApp = dvApp.getElementsByTagName('div');

	for(i= 0; i < dvBlockApp.length ; i++)
	{
		if(dvBlockApp[i].className == 'blockAppSelected')
		{
			idSelect = dvBlockApp[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index++;

	var newDivSelect = document.getElementById("blockApp_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockAppSelected';
	}
};


Dashboard.LoadWidgetAfter = function()
{
	var dvWidget = document.getElementById('dvWidget');
	var dvBlockWidget = dvWidget.getElementsByTagName('div');

	for(i= 0; i < dvBlockWidget.length ; i++)
	{
		if(dvBlockWidget[i].className == 'blockWidgetSelected')
		{
			idSelect = dvBlockWidget[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index--;

	var newDivSelect = document.getElementById("blockWidget_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockWidgetSelected';
	}
};

Dashboard.LoadWidgetBefore = function()
{
	var dvWidget = document.getElementById('dvWidget');
	var dvBlockWidget = dvWidget.getElementsByTagName('div');

	for(i= 0; i < dvBlockWidget.length ; i++)
	{
		if(dvBlockWidget[i].className == 'blockWidgetSelected')
		{
			idSelect = dvBlockWidget[i].id;
			break;
		}
	}

	var index = idSelect.split('_');
	index = (index[1]);
	index++;

	var newDivSelect = document.getElementById("blockWidget_" + index);

	if(newDivSelect != null)
	{
		//Recuperation du prochain block
		var oldDivSelect = document.getElementById(idSelect);
		oldDivSelect.className = '';
		oldDivSelect.style.display = 'none';

		newDivSelect.style.display = '';
		newDivSelect.className =  'blockWidgetSelected';
	}
};

//Agrandit l'application au maximum
Dashboard.SetSizeApp = function()
{
	//Recuperation de la taille de l'�cran

};

/**
* PopIn de creation de compte

*/
Dashboard.CreateCompte = function()
{
	parameters =Array();
 	parameters["Class"] = 'Dashboard';
	parameters["Methode"] = 'AskCreateCompte';
	parameters["Title"] = 'Creation compte';

	//parameters["App"] = classe;

	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , '','');
	popup.Open();
};

Dashboard.ShowProjet = function(idProjet)
{
	parameters =Array();
 	parameters["Class"] = 'EeProjet';
	parameters["Methode"] = 'ShowProjet';
	parameters["Title"] = 'Detail projet';
	parameters["App"] = 'EeProjet';
	parameters["IdProjet"] = idProjet;
	parameters["App"] = 'EeProjet';
	parameters["ShowBack"] = '1';
	parameters["Width"] = '400';
	parameters["Height"] = '400';
	parameters["Top"] = '';
	parameters["Left"] = '';

	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , '','');
	popup.Open();
};

/*
* Edite un formulaire
*/
Dashboard.ShowForm = function(idForm)
{
        parameters =Array();
 	parameters["Class"] = 'EeForm';
	parameters["Methode"] = 'TryForm';
	parameters["Title"] = 'Questionnaire';
	parameters["App"] = 'EeForm';
	parameters["idForm"] = idForm;
	parameters["App"] = 'EeForm';
	parameters["ShowBack"] = '1';
	parameters["CanComplete"] = 'true';

	action = Array();
//	action['OnClose'] = "Dashboard.LoadNew()";

	Dashboard.IncludeCss('EeForm');
	var popup = new PopUp(serialization.Encode(parameters) , serialization.Encode(parameters) , serialization.Encode(action),'');
	popup.Open();
};

/**
* Envoi du formulaire compl�t�
*/
Dashboard.SendForm = function(idForm)
{
	var dvForm = document.getElementById('dvForm');
	var data = Array();

	//Recuperation des reponses de l'utilisateur
	var controls = document.getElementsByTagName('input');
	for(i = 0; i < controls.length; i++)
	{
		switch(controls[i].type)
		{
			case 'text' :
				data.push(controls[i].id + '-_' + controls[i].value);
			break;
			case 'radio' :
				if(controls[i].checked)
				{
					data.push(controls[i].id + '-_' + controls[i].value);
				}
			break;
			case 'checkbox' :
				if(controls[i].checked)
				{
					data.push(controls[i].id + '-_' + controls[i].value);
				}
			break;
		}
	}

	//Recuperation des liste d�roulante
	var controls = document.getElementsByTagName('select');
		for(i = 0; i < controls.length; i++)
		{
				data.push(controls[i].id + '-_' + controls[i].value);
		}

	//Recuperation des textArea
	var controls = document.getElementsByTagName('textarea');
		for(i = 0; i < controls.length; i++)
		{
				data.push(controls[i].id + '-_' + controls[i].value);
		}

	var JAjax = new ajax();
	    JAjax.data = 'App=Form&Methode=SendFormUser';
	    JAjax.data += '&idForm='+ idForm;
	    JAjax.data += '&data='+ data.join('-!');

	dvForm.innerHTML = JAjax.GetRequest('Ajax.php');
};


/*
 * Log l'utilisateur avec le compte de démo
 * @returns {undefined}
 */
Dashboard.ConnectDemo = function()
{
    var JAjax = new ajax();
        JAjax.data = 'Class=DashBoardManager&Methode=ConnectDemo';

        JAjax.GetRequest('Ajax.php');
};

/*
* Lance le bureau
*/
Dashboard.LoadDesktop = function()
{
	window.location.href='Membre/';
};

/*
 * Passe le controle en text area avancé
 */
Dashboard.SetBasicAdvancedText = function(controlId)
{
        var editor = CKEDITOR.replace(controlId,{
                            toolbar : 'Basic', /* this does the magic */
                            uiColor : '#9AB8F3'
                        });

        //Mise a jour automatique
       for (var i in CKEDITOR.instances)
       {
           CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
       }
};

/*
 * Passe le control en text avance avec toutes les options
 * @param {type} controlId
 * @returns {undefined}
 */
Dashboard.SetAdvancedText = function(controlId)
{
     var editor = CKEDITOR.replace( controlId);

    //Mise a jour automatique
       for (var i in CKEDITOR.instances)
       {
           CKEDITOR.instances[i].on('change', function() { CKEDITOR.instances[i].updateElement() });
       }
};

/**
* Permet de contacter le porteur de projet
* @param {type} projetId
* @returns {undefined}
*/
Dashboard.ShowContactUser = function(projetId, userId)
{
   var param = Array();
       param['App'] = 'EeProjet';
       param['Title'] = 'EeProjet.ShowContactUser';
       param['AppName'] = "EeProjet";
       param['EntityName'] = "EeProjetProjet";
       param['ProjetId'] = projetId;
       param['DestinataireId'] = userId;

       Dashboard.OpenPopUp('EeProjet', 'ShowContactUser', '','', '','', serialization.Encode(param));
};

Dashboard.GetPath = function(page)
{
    url = window.location.href.split("/");
  
    if(window.location.origin.indexOf("localhost") > - 1)
    {
           return "http://localhost:85/" + url[3] + "/"+page;
    }
    else
    {
            return "http://" + url[2] + "/" + page;
    }
};

/**
 * Return html upload button
 * @returns {undefined}
 */
Dashboard.GetUploadButton = function(app, idEntity, reloadAction, action, $debug)
{
    $html = "<div>";

    $html +="<input type='file' id='fileUpload' name='fileUpload' />";
    $html += "<input type='button' value='Envoyer' onclick='upload.doUpload(this)' /> ";

    $html += "<input type='hidden' id='hdApp' name = 'hdApp'  value='"+app+"'  /> ";
    $html += "<input type='hidden' id='hdIdElement' name='hdIdElement' value='"+idEntity+"' /> ";
    $html += "<input type='hidden' id='hdCallBack' name='hdCallBack' value='"+reloadAction+"' /> ";
    $html += "<input type='hidden' id='hdAction' name='hdAction' value='" + action + "' /> ";
    $html += "<input type='hidden' id='hdIdUpload'  name='hdIdUpload' value='' /> ";

    //Frame From Upload
    if($debug == true)
    {
             $html += "<iframe id='frUpload' src='upload' style='display:block' >";
    }
    else
    {
            $html += "<iframe id='frUpload' src='upload' style='display:none' >";
    }

    $html += "</iframe>";
    $html += "</div>";

    return $html;

};

/*
 * Update Model/Save Entity
 */
Dashboard.UpdateModele = function()
{
    var ajaxModel = document.getElementById("ajaxModel");
    var error = document.getElementById("error");
	var app = document.getElementById("app");
	var classe = document.getElementById("class");
	var action = document.getElementById("action");
    var callBack = document.getElementById("callBack");
	var errorMsg = "";
	
	if(callBack != undefined && callBack.value != "")
	{
		Dashboard.callBack = callBack.value;
	}
	else
	{
		Dashboard.callBack = "";
	}

    //Send Data
    var JAjax = new ajax();
    	JAjax.data = 'App=' + app.value + '&Methode=' + action.value;
		
		if(classe != '')
		{
			JAjax.data += '&Class=' + classe.value + '&Methode=' + action.value;
		}
    //Verify Required element
    var inputs = ajaxModel.getElementsByTagName("input");
    
    for(i = 0; i < inputs.length; i++)
    {
        if( inputs[i].value == "" && inputs[i].type != "hidden"   )
        {
            errorMsg += "<li>" + inputs[i].name + "</li>" ;
        }
        else
        {
            JAjax.data += "&" +  inputs[i].name  + "=" + inputs[i].value;
        }
    }
    
    var textarea = ajaxModel.getElementsByTagName("textarea");
    
    for(i = 0; i < textarea.length; i++)
    {
        if( textarea[i].value == "" )
        {
            errorMsg += "<li>" + textarea[i].name + "</li>" ;
        }
        else
        {
            JAjax.data += "&" +  textarea[i].name  + "=" + textarea[i].value;
        }
    }
    
    //Add ListBox 
    var select = ajaxModel.getElementsByTagName("select");
    
    for(i = 0; i < select.length; i++)
    {
        if( select[i].value == ""    )
        {
            errorMsg += "<li>" + select[i].name + "</li>" ;
        }
        else
        {
            JAjax.data += "&" +  select[i].name  + "=" + select[i].value;
        }
    }
    
    if(errorMsg != "")
    {
      error.innerHTML = Dashboard.GetCode("PleaseCompleteField");
      error.innerHTML += errorMsg;
    }
    else
    {
        error.innerHTML = "";
        
        Request.Post("/Ajax.php", JAjax.data).then(data=>{
		
			ajaxModel.innerHTML = data; 
				
			if(data.indexOf("errorModel") == -1)
			{
				if(Dashboard.callBack != "")
				{
					eval(Dashboard.callBack + "()");
				}
			}
		});

    }
};