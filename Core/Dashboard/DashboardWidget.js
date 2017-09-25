
/**
Chargement des widgets
*/
Dashboard.LoadWidget = function()
{
  this.LoadDiv('dvWidget' , 'LoadWidget');
  setTimeout(Dashboard.AddEventWidget, 500);
};
/*
* Ajoute les �venements au widget
*/
Dashboard.AddEventWidget = function()
{
  //Ajout des evenements
  var dvWidget = document.getElementById("dvWidget");
  var widgets = dvWidget.getElementsByTagName("img");

  for(i = 0;i < widgets.length ; i++)
  {
  	if(widgets[i].src.indexOf('after') == -1  && widgets[i].src.indexOf('before') == -1)
  	{
  		Dashboard.AddEvent(widgets[i], "click", Dashboard.StartWidget);
  	}
  }
};

/*
* Demarre un widget
*/
Dashboard.StartWidget = function(e)
{
 //Cache les eventuel widget demar�
  Dashboard.HideWidget();

  if(e.srcElement)
  {
  	img = e.srcElement;
  }
  else
  {
	img =  this;
  }

  Dashboard.WidgetStarted = img.parentNode.id;

  var widget = img.parentNode.id;

  //Si le widget a �t� d�marr�
  if(Dashboard.WidgetsStarted(widget))
  {
  	Dashboard.ShowWidget(widget);
	return;
  }

  //Creation de la div
  var widgetRun = document.createElement("div");
  widgetRun.className = "widgetRun";
  widgetRun.id = "widgetRun" + widget;

  //Gestion de la position du widget
  var position = Dashboard.GetPosition(img.parentNode);
 // widgetRun.style.position = "fixed";
 widgetRun.style.position = "absolute";
  widgetRun.style.left = position[0] + "px";
  widgetRun.style.top = position[1] + "px";


  widgetRun.style.backgrounColor = "white";

  Dashboard.IncludeJs(widget, true);
  Dashboard.IncludeCss(widget, true);

  widgetRun.innerHTML = "<img src='../Images/loading/load.gif'>";
  document.body.appendChild(widgetRun);

  Dashboard.LoadDiv("widgetRun" + widget , "StartWidget", "Widget:"+widget);
  Dashboard.AddEventWindowsTool();

   Dashboard.AddWidgetStarted(widget);

    //car sinon elle est pas pris en compte
   loading = widget + ".Load()";
   setTimeout(loading, 1000);
};

/*
* Ajout le widget a la liste des widgets
*/
Dashboard.AddWidgetStarted = function(widgetStarted)
{
	//Ajout a la liste des applications
  if(Dashboard.Widgets == null)
      Dashboard.Widgets = Array();

      var exist = false;
      var i= 0;

      for(widget in Dashboard.Widgets)
      {
        if(Dashboard.Widgets[i] == widgetStarted)
	    {
	        exist = true;
	     }
      	i++;
      }

      if(!exist)
      {
        Dashboard.Widgets[i] = widgetStarted;
      }
};

/*
* D�fini si le widget est deja d�mar�
*/
Dashboard.WidgetsStarted = function(widgetStarted)
{
	var exist = false;
    var i= 0;

	for(widget in Dashboard.Widgets)
    {
      if(Dashboard.Widgets[i] == widgetStarted)
      {
        exist = true;
      }
      	i++;
    }

    return exist;
};

Dashboard.RemoveWidgetStarted = function(widgetStarted)
{
	var widgets = Array();
 	var i = 0;
 	var j=0;

	for(widget in Dashboard.Widgets)
    {
      if(Dashboard.Widgets[i] != widgetStarted)
      {
        widgets[j] = Dashboard.Widgets[i];
        j++;
      }
      	i++;
    }

    Dashboard.Widgets = widgets;
};

/*
* cache le widget en cours
*/
Dashboard.HideWidget = function()
{
	i=0;

	for(widget in Dashboard.Widgets)
    {
    	var widgetRun = document.getElementById("widgetRun" + Dashboard.Widgets[i]);

			if(widgetRun != null)
				widgetRun.className = "widgetHide";
      i++;
    }
    Dashboard.WidgetStartedHide = true;
};
/*
* ----------------- Fonction pour les widgets -----------------------
*/


/*
* cache le widget en cours
*/
Dashboard.ShowWidget = function()
{
	//Cache les eventuel widget demar�
  	Dashboard.HideWidget();

	//Recuperation du widget
	var widgetRun = document.getElementById("widgetRun" + Dashboard.WidgetStarted);
	//widgetRun.style.display = '';
	//widgetRun.style.width = '200px';
	//widgetRun.style.height = '200px';
	Dashboard.WidgetStartedHide = false;
	widgetRun.className = "widgetRun";
};

/*
*Ferme un widget
*/
Dashboard.CloseWidget = function(widgetName)
{
	if(typeof(widgetName) != "undefined")
		var dv = document.getElementById("widgetRun"+widgetName);
	else
		var dv = document.getElementById("widgetRun"+Dashboard.WidgetStarted);
	document.body.removeChild(dv);

	Dashboard.RemoveJs(Dashboard.WidgetStarted);
	Dashboard.RemoveWidgetStarted(Dashboard.WidgetStarted);
};

/*
* Fonctions pour les gadgets en Front Office
*/

Dashboard.TryWidget = function(widget)
{
	//Fond Gris�
	var backGround = document.createElement('div');
	backGround.style.height = document.body.parentNode.scrollHeight + "px";
	backGround.id = "back";
	document.body.appendChild(backGround);

	//Div pour le widget
	var dvWidget = document.createElement("div");
		dvWidget.className = "popup";
		dvWidget.id = "dvWidget";
		dvWidget.style.left = "25%";
		dvWidget.style.top = "25%";

	document.body.appendChild(dvWidget);

	Dashboard.LoadDiv("dvWidget" , "StartWidget", "Widget:"+widget );
 };

/**
* Ouvre ou cache la div des widgets
*/
Dashboard.ShowHideWidget = function()
{
 	var dvWidget =document.getElementById('dvWidget');
 	if(dvWidget.style.display == 'none')
 	{
 		dvWidget.style.display = '';
 	}
 	else
 	{
 		dvWidget.style.display = 'none';
 	}
};

