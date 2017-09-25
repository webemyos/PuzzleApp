var Form = function() {};

	/*
	* Chargement de l'application
	*/
	Form.Load = function(parameter)
	{
            parameter = serialization.Decode(parameter);
	 	
                Form.formId = parameter['formId'];
	 	Form.ReturnedFunction = parameter['ReturnedFunction'];

		this.LoadEvent();

                if(typeof(Form.formId)  != "undefined")
                {
                   FormAction.LoadQuestionReponse('', Form.formId);
                }
                else
                {
                    //Charge les formulaires de l'utilisateur
                    FormAction.LoadMyForm();
                }
	};

	/*
	* Chargement des �venements
	*/
	Form.LoadEvent = function()
	{
		DashBoard.AddEventAppMenu(Form.Execute, "", "Form");
		DashBoard.AddEventWindowsTool("Form");
	};

   /*
	* Execute une fonction
	*/
	Form.Execute = function(e)
	{
		//Appel de la fonction
		DashBoard.Execute(this, e, "Form");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Form.Comment = function()
	{
		DashBoard.Comment("Form", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Form.About = function()
	{
		DashBoard.About("Form");
	};

	/*
	*	Affichage de l'aide
	*/
	Form.Help = function()
	{
		DashBoard.OpenBrowser("Form","{$BaseUrl}/Help-App-Form.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Form.ReportBug = function()
	{
		DashBoard.ReportBug("Form");
	};

	/*
	* Fermeture
	*/
	Form.Quit = function()
	{
		DashBoard.CloseApp("","Form");
	};

    /*
	* Cr�e un nouveau document
	*/
	Form.New = function()
	{
	 	var params = Array();
                params['Title'] = "Form.New";

   		DashBoard.OpenPopUp('Form','DetailForm', '','','', 'FormAction.RefreshForm();', serialization.Encode(params), '');
	};

// Action Utilisateur
FormAction = function(){};

/**
 * Charge les formulaire de l'utilisateur
 * @returns {undefined}
 */
FormAction.LoadMyForm = function()
{
    FormAction.FormId = "";

    var data = "Class=Form&Methode=LoadForm&App=Form";
        DashBoard.LoadControl("dvDesktop", data, "" , "div", "Form");

    //Ajoute les evements
    //FormAction.AddEvent();
};
/*
* Rafraichit la liste des formulaires
*/
FormAction.RefreshForm = function()
{
	var data = 'App=Form&Methode=LoadForm';
        DashBoard.LoadControl("dvDesktop", data, "" , "div", "Form");
                
	//TODO
	if(typeof(Form.IdProjet) != 'undefined')
	{
		eval(Form.ReturnedFunction);
	}
};

/**
* Charge toutes les donn�es du formulaire

*/
FormAction.LoadForm = function(control, idForm)
{
var data = 'App=Form&Methode=LoadForm';
	data += '&idForm='+control.id;
	data += '&idForm='+ idForm;

	FormAction.FormId = idForm;

	DashBoard.LoadControl("dvDesktop", data, "" , "div", "Form");
};

/*
* Edite un formulaire
*/
FormAction.EditForm = function(id)
{
	var parameter = Array();
            parameter["idEntity"] = id;
            parameter['Title'] = "Form.Edit";

	DashBoard.OpenPopUp('Form','DetailForm', '','','', 'FormAction.RefreshForm();', serialization.Encode(parameter), '');
};

/*
* Supprime un formulaire
*/
FormAction.DeleteForm = function(id)
{
	if(DashBoard.ConfirmDelete())
	{
            var data = 'App=Form&Methode=DeleteForm';
                data += "&idEntity=" + id;
                
         DashBoard.LoadControl("dvDesktop", data, "" , "div", "Form");
         
               /// JAjax.GetRequest('Ajax.php');
     }
};

/*
* Charge les questions et les r�ponses
*/
FormAction.LoadQuestionReponse = function(control, idForm)
{
	var data = 'App=Form&Methode=LoadQuestionReponse';
            if(control != '')
            {
                data += "&idEntity=" + idForm;
                FormAction.FormId = idForm;
            }
            else
            {
                data += "&idEntity=" + idForm;
                FormAction.FormId = idForm;

            }

	 DashBoard.LoadControl("dvDesktop", data, "" , "div", "Form");
};

/*
* Edite un formulaire
*/
FormAction.DetailQuestion = function(id)
{
	var parameter = Array();
            parameter["idForm"] = id;
            parameter['Title'] = "FormQuestion.Edit";

	DashBoard.OpenPopUp('Form','DetailQuestion', '','','', 'FormAction.RefreshQuestion();', serialization.Encode(parameter), '');
};
/*
* Initialise le type de reponse
*/
FormAction.SelectResponseType = function()
{
	var lstType = document.getElementById("lstType");
	var dvResponse = document.getElementById("dvResponse", "div", "Form");

	switch(lstType.value)
	{
		case '0' :
			dvResponse.innerHTML = "<input type='text' disabled='disabled' />";
		break;
		case '1':
			dvResponse.innerHTML = "<textArea disabled='disabled' ></textarea>";
		break;
		case '2':
			var TextControl = "<div id='lstResponse'><input type='Radio'  name='rb'/>";
			TextControl += "<input type='text' id='tbResponseText' /></div>";
			TextControl += "<input type='button' id='btnAddResponse' class='btn btn-info' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"radio\")' />";

			dvResponse.innerHTML = TextControl;
		break;
		case '3':
			var TextControl = "<div id='lstResponse'><input type='checkbox'  name='cb'/>";
				TextControl += "<input type='text' id='tbResponseText' /></div>";
				TextControl += "<input type='button' class='btn btn-info'  id='btnAddResponse' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"check\")' />";

				dvResponse.innerHTML = TextControl;
			break;
		case '4' :
			var TextControl = "<div id='lstResponse'>";
				TextControl += "<input type='text' id='tbResponseText' /></div>";
				TextControl += "<input type='button' class='btn btn-info' id='btnAddResponse' value='Ajouter une r&eacute;ponse' onclick='FormAction.AddResponse(\"list\")' />";

				dvResponse.innerHTML = TextControl;
		break;
	}
};
/*
* Ajoute une r�ponse
*/
FormAction.AddResponse = function(type)
{
	var dvResponse = document.getElementById("lstResponse");

	switch(type)
	{
		case 'radio':
                    var span = document.createElement("div");
                    
                    var rb = document.createElement('input');
                        rb.type = 'radio';
                        rb.name = "rb";
                      span.appendChild(rb);  
                        
                    var tb = document.createElement('input');
                        tb.type = 'text';
                        tb.id = "tbResponseText";   
                        span.appendChild(tb);  
                      
                     var img = document.createElement('i');
                        img.className = 'icon-remove';
                        img.title = "Supprimer";
                        img.innerHTML = "&nbsp;";
                        DashBoard.AddEvent(img, "click", FormAction.DelResponse);
                        span.appendChild(img);  
 
                        dvResponse.appendChild(span);
		break;
		case 'check':
                    
                   var span = document.createElement("div");
                    
                    var rb = document.createElement('input');
                        rb.type = 'checkbox';
                        rb.name = "rb";
                      span.appendChild(rb);  
                        
                    var tb = document.createElement('input');
                        tb.type = 'text';
                        tb.id = "tbResponseText";   
                        span.appendChild(tb);  
                      
                    var img = document.createElement('i');
                        img.className = 'icon-remove';
                        img.tilte = "Supprimer";
                         img.innerHTML = "&nbsp;";
                        DashBoard.AddEvent(img, "click", FormAction.DelResponse);
                        span.appendChild(img);  
 
                        dvResponse.appendChild(span);
                        

		break;
		case 'list':
                    
                    var span = document.createElement("div");
                    
                    var rb = document.createElement('input');
                        rb.type = 'text';
                      span.appendChild(rb); 
                      
                       var img = document.createElement('i');
                        img.className = 'icon-remove';
                        img.tilte = "Supprimer";
                        img.innerHTML = "&nbsp;";
                        DashBoard.AddEvent(img, "click", FormAction.DelResponse);
                        span.appendChild(img);  
 
                        dvResponse.appendChild(span);
		break;
        }
};

/**
 * Supprime une réponse
 **/
FormAction.DelResponse = function(e)
{
    control = e.srcElement || e.target;
    FormAction.DeleteResponse(control);
};

/*
* Supprime la r�ponse
*
*/
FormAction.DeleteResponse = function(control)
{
	control.parentNode.parentNode.removeChild(control.parentNode);
};

/*
* Enregistre la question et les r�ponses
*/
FormAction.SaveQuestion = function(idForm, idEntite)
{
	//Recuperation des contr�les
	var Libelle = document.getElementById('Libelle');
	var Commentaire = document.getElementById('Commentaire');
	var lstType = document.getElementById('lstType');

        if(Libelle.value != "" && lstType.value != "" )
        {

	var responses = Array();

	//Recuperation des reponses
	if(lstType.value == '2' || lstType.value == '3' || lstType.value == '4')
	{
		var dvResponse = document.getElementById("lstResponse");
		var controls = dvResponse.getElementsByTagName('input');

		for(i = 0; i < controls.length; i++)
		{
			if(controls[i].type == 'text')
			{
				responses.push(controls[i].value + "!!" + controls[i].name);
			}
		}
	}

	var JAjax = new ajax();
    	JAjax.data = 'App=Form&Methode=SaveQuestion';
		JAjax.data += '&Libelle=' + Libelle.value;
		JAjax.data += '&Commentaire=' + Commentaire.value;
		JAjax.data += '&lstType=' + lstType.value;
		JAjax.data += "&idForm="+ idForm;
		JAjax.data += "&idEntite="+ idEntite;

	if(responses.length > 0)
	{
		JAjax.data += '&response=' + responses.join('_-');
	}
	//Resultat
	var	lbResultQuestion = document.getElementById('jbForm');
		lbResultQuestion.innerHTML = JAjax.GetRequest('Ajax.php');
        }
        else
        {
            alert(DashBoard.GetCode("Form.FieldError"));
        }
};

/*
* Rafraichit la liste des questions
*/
FormAction.RefreshQuestion = function()
{
	FormAction.LoadQuestionReponse('', FormAction.FormId);
};

/*
* Suprrime la question
*/
FormAction.DeleteQuestion = function(idQuestion)
{
	var JAjax = new ajax();
    	JAjax.data = 'App=Form&Methode=DeleteQuestion';
		JAjax.data += "&idEntite="+ idQuestion;

	JAjax.GetRequest('Ajax.php');

	FormAction.LoadQuestionReponse('', FormAction.FormId);
};

/**
* Permet  de tester le questrionnaire
*/
FormAction.TryForm = function(idForm)
{
	var parameter = Array();
	    parameter["idForm"] = idForm;
            parameter["Title"] = "Form.answer";

	DashBoard.OpenPopUp('Form','TryForm', '', '','', '', serialization.Encode(parameter), '');

};

/**
 * Affiche les réponses du forulaire groupé 
 * @param {type} formId
 * @returns {undefined}
 */
FormAction.ShowByGroup = function(formId)
{
    var data = "Class=Form&Methode=ShowByGroup&App=Form";
        data += "&FormId="+formId;
        
        DashBoard.LoadControl("jbResponse", data, "" , "div", "Form");

};

/**
 * Affiche les réponses du forulaire par utilisateur 
 * @param {type} formId
 * @returns {undefined}
 */
FormAction.ShowByUser = function(formId)
{
    var data = "Class=Form&Methode=ShowByUser&App=Form";
        data += "&FormId="+formId;
            
    DashBoard.LoadControl("jbResponse", data, "" , "div", "Form");
};

FormAction.SendForm = function()
{
alert('TODO');
};

