var AutoCompleteBox = new AutoCompleteBox();

function AutoCompleteBox()
{
	this.Search = function(control, classe, methode, startAt, sourceControl, parameter)
	{
		var span = document.getElementById('sp'+control.id);

		if(control.value.length >= startAt)
		{
		//determine les positions du control par rapport a ces parent
		var obj = span;
		var posX = obj.offsetLeft;
		var posY = obj.offsetTop;

		while(obj.offsetParent)
		{
			if(obj == document.getElementsByTagName('body')[0])
			{
			break
			}
		    else
		    {
				posX=posX+obj.offsetParent.offsetLeft;
				posY=posY+obj.offsetParent.offsetTop;
				obj=obj.offsetParent;
			}
	 	}

		//Definir la position en dessous de la textBox
		var divResult = document.getElementById("divResult");

		if(divResult == null)
		{
			//Creation de la div de resultat.
			var divResult = document.createElement('div');
			divResult.id = "divResult";
		    divResult.style.left = posX  + "px";

		    divResult.style.top = posY + 100 + "px";
		    divResult.style.width = "200px";

		    divResult.innerHTML = "<center><br /><br /><img src='../Images/loading/load.gif' alt='Wait' title='wait' /></center>";

			document.body.appendChild(divResult);
		}

		//Appele de la fonction ajax D'autocompletion
		 var JAjax = new ajax();
		 JAjax.data = "Class="+classe+"&Methode="+methode;
		 JAjax.data +="&sourceControl="+control.value;
		 JAjax.data +="&sourceControlId="+control.id;
		 JAjax.data +="&"+parameter;

		 //
		 if(sourceControl != "")
		 {
		 	var Control = document.getElementById(sourceControl);

		 	if(Control != null)
		 	 JAjax.data +="&source="+Control.value;
			else
			 JAjax.data +="&source="+sourceControl;

		 }

		 JAjax.mode = "A";
	  	 JAjax.Control = divResult;

 		return JAjax.GetRequest("Ajax.php");

		}
 		else
 		{
 			//fermeture de la div
 			var divResult = document.getElementById("divResult");
			if(divResult != null)
			{
				document.body.removeChild(divResult);
			}
 		}
	};

	this.SetResult = function(control, controlId)
	{
		//Recuperation de la textBox
		var ctr = document.getElementById(controlId);
		ctr.value = control.id;

		//Recuperation de la div
		var divResult = document.getElementById("divResult");

		if(divResult != null)
		{
			document.body.removeChild(divResult);
		}
		else
		{
		  ClosePopUp();
		}
	};
};