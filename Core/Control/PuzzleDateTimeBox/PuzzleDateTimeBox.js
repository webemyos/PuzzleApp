var PuzzleDateTimeBox = new PuzzleDateTimeBox();

function PuzzleDateTimeBox()
{

	/**
	 * Init the event on the PuzzleDateTimeBox
	 * @param control
	 * @constructor
	 */
	this.Init = function(control)
	{
		var puzzleDateTimeBox = document.getElementsByClassName("puzzleDateTimeBox");

		
		for(var i = 0; i < puzzleDateTimeBox.length; i++)
		{
			PuzzleDateTimeBox.AddEvent(puzzleDateTimeBox[i], "click", PuzzleDateTimeBox.Open);
		}
	};

	this.AddEvent = function (control, event, methode)
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

	this.Open = function(e)
	{
		//Date Mini si définie
		var control = e.srcElement;
		this.minDate = control.dataset.mindate;
		
		var puzzleDateTimeBox = document.getElementById("puzzleDateTimeBox");

		if(puzzleDateTimeBox == undefined) {
			PuzzleDateTimeBox.control = e.srcElement;

			this.content = document.createElement('div');
			this.content.id = "puzzleDateTimeBox";
			this.content.style.position = 'absolute';
			this.content.style.width = "600px";
			this.content.style.height = "320px";
			this.content.style.overflow = "hidden";
			this.content.style.border = '1px solid black';
			this.content.style.left = e.clientX + "px";
			this.content.style.top =  e.pageY + 10 + "px";
			this.content.style.backgroundColor = "white";
			this.content.style.zIndex = "999999";
			this.content.innerHTML = PuzzleDateTimeBox.getTable();

			document.body.appendChild(this.content);

			var btnSelect = document.getElementById("btnSelect");

			PuzzleDateTimeBox.AddEvent(btnSelect, "click", PuzzleDateTimeBox.select);
			PuzzleDateTimeBox.AddEventControl();
			PuzzleDateTimeBox.AddEventControlTime();

			//Si on a dèjà selectionné une date
			var selected = document.getElementById("selected");
			selected.innerHTML = e.srcElement.value;
		}
		else
		{
			document.body.removeChild(puzzleDateTimeBox);
		}
	};

	this.AddEventControl = function()
	{
		var previous = document.getElementsByClassName("previous");
		this.AddEvent(previous[0], "click", PuzzleDateTimeBox.previous);

		var next = document.getElementsByClassName("next");
		this.AddEvent(next[0], "click", PuzzleDateTimeBox.next);

		var cells = document.getElementsByClassName("day");

		for(var i =0; i < cells.length; i++)
		{
			this.AddEvent(cells[i], "click", PuzzleDateTimeBox.selectDate);
		}
	};

	this.AddEventControlTime = function()
	{
		var hoursLess = document.getElementsByClassName("hoursLess");
		this.AddEvent(hoursLess[0], "click", PuzzleDateTimeBox.hoursLess);
		var minuteLess = document.getElementsByClassName("minuteLess");
		this.AddEvent(minuteLess[0], "click", PuzzleDateTimeBox.minuteLess);

		var hoursMore = document.getElementsByClassName("hoursMore");
		this.AddEvent(hoursMore[0], "click", PuzzleDateTimeBox.hoursMore);
		var minuteMore = document.getElementsByClassName("minuteMore");
		this.AddEvent(minuteMore[0], "click", PuzzleDateTimeBox.minuteMore);

	};


	this.getTable = function()
	{
		PuzzleDateTimeBox.ActualDate =  new Date();

		html = "<table class='calendar' style='width:100%'>";
		html += "<tr><td class='title' >Selectionnez une date</td><td class='title'>Selectionnez une horaire</td></tr>";
		html += "<tr>";
		html += "<td>" +PuzzleDateTimeBox.getCalendar() + "</td>";
		html += "<td class='time'>" +PuzzleDateTimeBox.getTime() + "</td>";
		html += "</tr>";
		html += "<tr><td colspan='4' id='calendarError' style='color:red'></td></tr>";
		html += "<tr style='border-top:1px solid grey;padding:5px'><td class='title' style='padding:5px' ><button class='btn btn-success' id='btnSelect' >selectionner </button></td><td id='selected' class='title' style='text-align:center;font-size:20px'></td></tr>";
		html += "</table>";

		return html;
	};

	this.getTime =function()
	{
		var html = "<table>";
			html += "<tr><td class='hoursMore' >+</td><td></td><td class='minuteMore' >+</td></tr>";
			html += "<tr><td id='hours'>12</td><td>:</td><td id='minutes'>00</td></tr>";
			html += "<tr><td class='hoursLess'>-</td><td></td><td class='minuteLess'>-</td></tr>";

		html += "</table>";

		return html;
	};

	this.previous = function()
	{
		var body = document.getElementById("cal_body");
		PuzzleDateTimeBox.ActualDate.setDate(PuzzleDateTimeBox.ActualDate.getDate() - 31);
		body.innerHTML = PuzzleDateTimeBox.getCalendar();
		PuzzleDateTimeBox.AddEventControl();
	};

	this.next = function()
	{
		var body = document.getElementById("cal_body");
		PuzzleDateTimeBox.ActualDate.setDate(PuzzleDateTimeBox.ActualDate.getDate() +31);
		body.innerHTML = PuzzleDateTimeBox.getCalendar();
		PuzzleDateTimeBox.AddEventControl();
	};

	this.getCalendar = function()
	{
		var date = PuzzleDateTimeBox.ActualDate;
		var jour = date.getDate();
		var moi = date.getMonth();
		var annee = date.getYear();
		var html = "";

		if(annee<=200)
		{
			annee += 1900;
		}
		mois = new Array('Janvier', 'Fevrier', 'Mars', 'Avril', 'Mai', 'Juin', 'Juillet', 'Aout', 'Septembre', 'Octobre', 'Novembre', 'Decembre');
		jours_dans_moi = new Array(31,28,31,30,31,30,31,31,30,31,30,31);
		if(annee%4 == 0 && annee!=1900)
		{
			jours_dans_moi[1]=29;
		}
		total = jours_dans_moi[moi];
		var date_aujourdui = jour+' '+mois[moi]+' '+annee;
		dep_j = date;
		dep_j.setDate(1);
		if(dep_j.getDate()==2)
		{
			dep_j=setDate(0);
		}
		dep_j = dep_j.getDay();
		html +=  '<table class="cal_calendrier" ><tbody id="cal_body"><tr><th class="previous" ><</th><th colspan="5">'+ '<span id="actual" style="margin-right:5px;">' + jour+  '</span><span id="actualMontYear">' +mois[moi]+' '+annee +'</span></th><th class="next">></th></tr>';
		html += '<tr class="cal_j_semaines"><th>Dim</th><th>Lun</th><th>Mar</th><th>Mer</th><th>Jeu</th><th>Ven</th><th>Sam</th></tr><tr>';
		sem = 0;
		for(i=1;i<=dep_j;i++)
		{
			html += '<td class="day">'+(jours_dans_moi[moi-1]-dep_j+i)+'</td>';
			sem++;
		}
		for(i=1;i<=total;i++)
		{
			if(sem==0)
			{
				html +='<tr>';
			}
			if(jour==i)
			{
				html +='<td class="day cal_aujourdhui">'+i+'</td>';
			}
			else
			{
				html +='<td class="day">'+i+'</td>';
			}
			sem++;
			if(sem==7)
			{
				html +='</tr>';
				sem=0;
			}
		}
		for(i=1;sem!=0;i++)
		{
			html +='<td class="day">'+i+'</td>';
			sem++;
			if(sem==7)
			{
				html +='</tr>';
				sem=0;
			}
		}
		
		html +='</tbody></table>';
		//opacite(document.getElementById('cal_body'),70);
		return html;
	};

	this.hoursLess = function()
	{
		var hours = document.getElementById("hours");

		if(parseInt(hours.innerHTML) > 0)
		{
			hours.innerHTML = parseInt(hours.innerHTML) - 1;
		}

		PuzzleDateTimeBox.selectDate();
	};

	this.hoursMore = function()
	{
		var hours = document.getElementById("hours");

		if(parseInt(hours.innerHTML) < 23)
		{
			hours.innerHTML = parseInt(hours.innerHTML) + 1;
		}

		PuzzleDateTimeBox.selectDate();
	};

	this.minuteLess = function()
	{
		var minutes = document.getElementById("minutes");

		if(parseInt(minutes.innerHTML) > 0)
		{
			if(parseInt(minutes.innerHTML) < 10)
			{
				minutes.innerHTML =  parseInt( minutes.innerHTML) - 1;

			}
			else
			{
				minutes.innerHTML = parseInt(minutes.innerHTML) - 1;
			}
		}

		PuzzleDateTimeBox.selectDate();
	};

	this.minuteMore = function()
	{
		var minutes = document.getElementById("minutes");

		if(parseInt(minutes.innerHTML) < 59)
		{
			if(parseInt(minutes.innerHTML) < 10)
			{
				minutes.innerHTML = parseInt(minutes.innerHTML) + 1;
			}
			else
			{
				minutes.innerHTML = parseInt(minutes.innerHTML) + 1;
			}
		}
		PuzzleDateTimeBox.selectDate();
	};

	this.selectDate = function(e)
	{
		if(e != undefined)
		{
			puzzleDateTimeBox.day = e.srcElement.innerHTML;
		}

		if(puzzleDateTimeBox.day  == undefined)
		{
			var date = PuzzleDateTimeBox.ActualDate;
			var jour = date.getDate();

			puzzleDateTimeBox.day = jour;
		}

		var selected = document.getElementById('selected');
		var actualMontYear = document.getElementById("actualMontYear");
		var actualMontYear = document.getElementById("actualMontYear");
		var hours = document.getElementById("hours");
		var minutes = document.getElementById("minutes");

		selected.innerHTML = puzzleDateTimeBox.day + " " + actualMontYear.innerHTML + " " +hours.innerHTML + ":" +  minutes.innerHTML;
	};

	this.select = function()
	{
		var puzzleDateTimeBox = document.getElementById("puzzleDateTimeBox");
		var selected = document.getElementById('selected');

		if( PuzzleDateTimeBox.verifDate(PuzzleDateTimeBox.control.dataset.mindate))
		{

			PuzzleDateTimeBox.control.value = selected.innerHTML;
			document.body.removeChild(puzzleDateTimeBox);
		}
	};

	/**
	 * Vérifie la date 
	 */
	this.verifDate = function(minDate)
	{
		var calendarError = document.getElementById("calendarError");
		calendarError.innerHTML = "";

		if(minDate == undefined) {
			return true;
		}

		var date = PuzzleDateTimeBox.ActualDate;

		dateMin = minDate.split("/");
		dateMinDay = dateMin[2];
		dateMinMonth = dateMin[1];
		dateMinYear = dateMin[0];

		var jour = puzzleDateTimeBox.day;
		var mois = date.getMonth() + 1;
		var annee = date.getFullYear();
		var error = false;

		if(annee <dateMinYear )
		{
			error = true;
		}

		if(parseInt(mois) < parseInt(dateMinMonth))
		{
			error = true;
		}

		if(mois == dateMinMonth &&  parseInt(jour) <= parseInt(dateMinDay) )
		{
			error = true;
		}

		if(error == true)
		{
			calendarError.innerHTML = "Veuillez selectionner une date supérieur à la date du jour !";
		}

		return !error;
	};

};


setTimeout(PuzzleDateTimeBox.Init, 500);


