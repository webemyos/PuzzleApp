var Agenda = function() {};

  /*
  * Chargement de l'application
  */
  Agenda.Load = function(parameter)
  {
    parameter = serialization.Decode(parameter);
 	Agenda.IdProjet = parameter['IdProjet'];
 	Agenda.ReturnedFunction = parameter['ReturnedFunction'];

	if(typeof(Agenda.IdProjet) != 'undefined')
	{
		var center = Dashboard.GetElement("appCenter","div","Agenda");
		Dashboard.ResizeElement(center, "800px");
	}

    this.LoadEvent();
  };

  /*
  * Chargement des �venements
  */
  Agenda.LoadEvent = function()
  {
    Dashboard.AddEventAppMenu(Agenda.Execute, "", "Agenda");
    Dashboard.AddEventWindowsTool("Agenda");

    //Chargement de la semaine courante
    Agenda.LoadWeek('current');
  };

   /*
  * Execute une fonction
  */
  Agenda.Execute = function(e)
  {
    //Appel de la fonction
    Dashboard.Execute(this, e, "Agenda");
    return false;
  };

  /*
  * Chargement de la semaine courante
  */
  Agenda.LoadWeek = function(WeekNumber)
  {
    var data = 'App=Agenda&Methode=LoadWeek';
    data += '&WeekNumber='+ WeekNumber;

    Dashboard.LoadControl('appCenter', data,'','div','Agenda');

    //Ajoute les evement javascript sur les cellules
    var taAgenda = Dashboard.GetElement('taAgenda','table','Agenda');
    var cell = taAgenda.getElementsByTagName('td');

    for(i = 0; i < cell.length; i++)
    {
      if(cell[i].innerHTML == '')
      {
      	Dashboard.AddEvent(cell[i], 'click', Agenda.cellOnClick);
      }
    }

	Agenda.resize();

  };

  /*
  * redimenssione le tableau correctement
  */
  Agenda.resize = function()
  {
	   //Initialisation de cellule sur deux ou trois celles
	    //Mettre de rowsSpan et des Colspan correct et supprimer les cellule sen trops
	    var taAgenda = Dashboard.GetElement('taAgenda','table','Agenda');
	    var cell = taAgenda.getElementsByTagName('td');

	    for(i= 0; i<cell.length; i++)
	    {
	    	content = cell[i].innerHTML;

			events = cell[i].getElementsByTagName("div");

			//Si la cellule contient un evenement
			if(content != '' && events.length >0)
	    	{
	    	//TODO Gerer la taille des cellules correctementw
	    		/*alert(cell[i].id);
	    		cell[i].setAttribute('colspan','2');
	    		cell[i].colspan="2";
	    		cell[i].setAttribute('rowspan','2');
	    		cell[i].rowspan = "3";

	    		//Suppression des cellules en double
	    		var date = cell[i].id.split("/");
	    		var day = date[0];

				idCellule = (day++) + "/" + date[1] + "/" + date[2];
				alert(idCellule);
				var celluleDroite = document.getElementById(date[0] + 1 + "/" + date[1] + "/" + date[2]);
				celluleDroite.parentNode.removeChild(celluleDroite);
				*/
			}
	    }
  };

  Agenda.cellOnClick = function(event)
  {
    //Recuperation de la cellule
      if(event.srcElement)
      {
        var cell = event.srcElement;
      }
      else
      {
        var cell = this;
      }

    //ouverture d'un popup de saisie d'un �venements
    var params = Array();
    params['App'] = 'Agenda';
    params['Date'] = cell.id;
    params['Title'] = 'AddEvent';
	params['IdProjet'] = Agenda.IdProjet;

    //Recuperation de l'evenemet cr�e
    if(cell.innerHTML != '')
    {
      var spEvent = cell.getElementsByTagName('div');
      params['idEvent'] = spEvent[0].id;
    }
	else
	{
	  params['idEvent'] = '';
 	  Dashboard.OpenPopUp('Agenda','AddNewEvent', '','','', '', serialization.Encode(params), 'DetailEvent');
        }
  };

  /*
  *	Affichage de a propos
  */
  Agenda.About = function()
  {
    Dashboard.About("Agenda");
  };

  /*
  *	Affichage de l'aide
  */
  Agenda.Help = function()
  {
    Dashboard.OpenBrowser("Agenda","{$BaseUrl}/Help-App-Agenda.html");
  };

  /*
   *	Affichage de commentaire
   */
   Agenda.Comment = function()
   {
   	Dashboard.Comment("Agenda", "1");
   };

   /*
  *	Affichage de report de bug
  */
  Agenda.ReportBug = function()
  {
    Dashboard.ReportBug("Agenda");
  };

  /*
  * Fermeture
  */
  Agenda.Quit = function()
  {
    Dashboard.CloseApp("","Agenda");
  };

//Action
var AgendaAction = function(){};

AgendaAction.SaveEvent = function(date, idEvent, appName, entityName, entityId)
{
  //Recuperation des controles
  tbTitre = document.getElementById('tbTitre');
  tbCommentaire = document.getElementById('tbCommentaire');
  cbPublic = document.getElementById("cbPublic");
  tbDateStart = document.getElementById('tbDateStart');
  tbDateEnd = document.getElementById('tbDateEnd');

  tbHourStart = document.getElementById('tbHourStart');
  tbtHourEnd = document.getElementById('tbHourEnd');

  if(tbTitre.value != '')
  {
    var data = 'App=Agenda&Methode=SaveEvent';
        data += '&Date='+ date;
        data += '&Titre='+ tbTitre.value;
        data += '&Commentaire='+ tbCommentaire.value;
        data += '&public='+cbPublic.value;
        data += '&DateStart='+ tbDateStart.value + " " +tbHourStart.value;
        data += '&DateEnd='+ tbDateEnd.value + " " + tbtHourEnd.value;
        data += '&idEvent='+idEvent;
        
        data += '&AppName='+ appName;
        data += '&EntityName='+ entityName;
        data += '&EntityId='+ entityId;
        
      
      //Requetre ajax 
        var JAjax = new ajax();
            JAjax.data += data;
            JAjax.GetRequest('Ajax.php');
      
      
      //Fermeture de la div
      //Recuperation de la semaine selectionnée
      if(appName == "")
      {
        Close("NaN","Agenda","undefined");
          
        var lstWeek = document.getElementById("lstWeek");
        Agenda.LoadWeek(lstWeek.value);
      }
      else
      {
          var jbEvent = document.getElementById("jbEvent");
          jbEvent.innerHTML = "<span class='success'>Enregistrement valide</span>";
      }
  }
  else
  {
    alert(Dashboard.GetCode('FieldEmpty'));
  }
};

/*
* Charge la semaine d'avant
*/
AgendaAction.LoadWeekBefore= function(week)
{
	Agenda.LoadWeek(week - 1);
};

/*
* Charge la semaine suivante
*/
AgendaAction.LoadWeekAfter= function(week)
{
	Agenda.LoadWeek(week + 1);
};

/*
* Charge la semaine sp�cifique
*/
AgendaAction.LoadWeek = function(control)
{
	Agenda.LoadWeek(control.value);
};

/*
* Edite un �venement
*/
AgendaAction.Edit = function(idEvent, edit)
{
    var params = Array();
    params['App'] = 'Agenda';
    params['Title'] = 'AddEvent';
 	params['idEvent'] = idEvent;
	params['edit'] = edit;

    Dashboard.OpenPopUp('Agenda','AddNewEvent', '','','', '', serialization.Encode(params), 'DetailEvent'); 
};

/*
* Ajout de contact
*/
AgendaAction.ShowAddUser = function(idEvent)
{
	var params = Array();
    params['App'] = 'Agenda';
    params['Title'] = 'AddContact';
 	params['idEvent'] = idEvent;

    Dashboard.OpenPopUp('Agenda','ShowAddUser', '','','', '', serialization.Encode(params), 'AddContact');

	return false;
};


/*
* Enregistrer les membres de l'�venement
*/
AgendaAction.SaveUser = function(idEvent)
{
        var divResult = document.getElementById("divResult");
	var controls = divResult.getElementsByTagName("input");
	idContact = Array();

	for(i=0; i< controls.length;i++)
	{
         	if(controls[i].type == "checkbox" && controls[i].checked)
		{
			 idContact[i] = controls[i].id;
		}
	}
	//Rafraichissement de la zone
	var data = "App=Agenda&Methode=SaveUser";
		data += "&IdEvent="+idEvent;
		data += "&IdContact="+ idContact.join(",");

		Dashboard.LoadControl("lstContact", data, "", "Comunity");

	Dashboard.CloseSearch();
};

/*
* Suppression d'un contact
*/
AgendaAction.DeleteMember = function(user, idEvent)
{
	if(Dashboard.ConfirmDelete())
	{
   		var JAjax = new ajax();
    		JAjax.data = 'App=Agenda&Methode=DeleteMember';
			JAjax.data += '&UserId=' + user.id;
			JAjax.data += '&EventId=' + idEvent;

			JAjax.GetRequest('Ajax.php');

		 user.parentNode.parentNode.removeChild(user.parentNode);
	}
};

/*
* Suppression d'un �venement
*/
AgendaAction.DeleteEvent = function(img, idEvent)
{
	if(Dashboard.ConfirmDelete())
	{
	 		var JAjax = new ajax();
    		JAjax.data = 'App=Agenda&Methode=DeleteEvent';
			JAjax.data += '&EventId=' + idEvent;

			JAjax.GetRequest('Ajax.php');

		 img.parentNode.parentNode.parentNode.removeChild(img.parentNode.parentNode);
	}
};

/*
* Accept l'invitation
*/
AgendaAction.AcceptInvitation = function(img, idEventMember)
{
	var JAjax = new ajax();
	JAjax.data = 'App=Agenda&Methode=AcceptInvitation';
	JAjax.data += '&idEventMember=' + idEventMember;

	JAjax.GetRequest('Ajax.php');

	//Suppression des boutons
	img.parentNode.parentNode.removeChild(img.parentNode);
};

/*
* Refuse Invitation
*/
AgendaAction.RefuseInvitation = function(img, idEventMember)
{
	var JAjax = new ajax();
	JAjax.data = 'App=Agenda&Methode=RefuseInvitation';
	JAjax.data += '&idEventMember=' + idEventMember;

	JAjax.GetRequest('Ajax.php');

	//Suppression de tout l'�venement
	img.parentNode.parentNode.parentNode.removeChild(img.parentNode.parentNode);

};